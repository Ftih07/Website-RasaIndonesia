<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Validation\Rule;
use App\Models\Chat;
use App\Services\ChatService;
use Illuminate\Validation\ValidationException;

class OrderDashboardController extends Controller
{
    public function index()
    {
        $business = Auth::user()->business;

        if ($business->orders_status === 'not_requested') {
            return view('dashboard.orders.request', compact('business'));
        }

        if ($business->orders_status === 'pending') {
            return view('dashboard.orders.pending', compact('business'));
        }

        if ($business->orders_status === 'approved') {
            $ordersQuery = Order::with(['user', 'items.product', 'payment'])
                ->where('business_id', $business->id)
                ->whereHas('payment', function ($q) {
                    $q->whereNotIn('status', ['incomplete']);
                })
                ->latest();

            // ==== Apply Filters ====
            if ($status = request('status')) {
                $ordersQuery->where('delivery_status', $status);
            }

            if ($dateFrom = request('date_from')) {
                $ordersQuery->whereDate('created_at', '>=', $dateFrom);
            }

            if ($dateTo = request('date_to')) {
                $ordersQuery->whereDate('created_at', '<=', $dateTo);
            }

            if ($orderNumber = request('order_number')) {
                $ordersQuery->where('order_number', 'like', '%' . $orderNumber . '%');
            }

            if ($deliveryOption = request('delivery_option')) {
                $ordersQuery->where('delivery_option', $deliveryOption);
            }

            if ($productName = request('product')) {
                $ordersQuery->whereHas('items.product', function ($q) use ($productName) {
                    $q->where('name', 'like', '%' . $productName . '%');
                });
            }

            // Pagination
            $perPage = request('per_page', 10);
            $orders = $ordersQuery->paginate($perPage)->withQueryString();

            return view('dashboard.orders.index', compact('business', 'orders'));
        }

        if ($business->orders_status === 'rejected') {
            return view('dashboard.orders.rejected', compact('business'));
        }
    }

    public function show($id)
    {
        $business = Auth::user()->business;

        $order = Order::with([
            'user',
            'items.product',
        ])->where('business_id', $business->id)
            ->findOrFail($id);

        // Decode options dan ambil nama dari ProductOption, simpan di property baru untuk view
        foreach ($order->items as $item) {
            if (is_string($item->options)) {
                $options = json_decode($item->options, true);
            } else {
                $options = $item->options ?? [];
            }

            $processedOptions = [];

            foreach ($options as $group) {
                $groupItems = [];

                if (!empty($group['selected']) && is_array($group['selected'])) {
                    foreach ($group['selected'] as $selected) {
                        $option = ProductOption::find($selected['id']);
                        if ($option) {
                            $groupItems[] = [
                                'name'  => $option->name,
                                'price' => $selected['price'] ?? $option->price,
                            ];
                        }
                    }
                }

                $group['items'] = $groupItems;
                $processedOptions[] = $group;
            }

            // Simpan ke property baru untuk view
            $item->options_for_view = $processedOptions;
        }

        $allowedStatuses = ['assigned', 'on_delivery', 'delivered'];

        return view('dashboard.orders.show', compact('business', 'order', 'allowedStatuses'));
    }




    public function requestActivation(Request $request)
    {
        $business = Auth::user()->business;
        $business->update([
            'orders_status' => 'pending',
        ]);

        return redirect()->route('dashboard.orders')->with('success', 'Orders activation request has been submitted. Awaiting admin approval.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $business = Auth::user()->business;

        // Pastikan order ini punya business yang sama
        if ($order->business_id !== $business->id) {
            abort(403, 'Unauthorized action.');
        }

        // Status yang diizinkan untuk seller
        $allowedStatuses = ['assigned', 'on_delivery', 'delivered'];

        $validated = $request->validate([
            'delivery_status' => ['required', Rule::in($allowedStatuses)]
        ]);

        $order->update([
            'delivery_status' => $validated['delivery_status']
        ]);

        $statusText = ucfirst(str_replace('_', ' ', $validated['delivery_status']));

        // === Kirim pesan otomatis ke chat ===
        $chat = Chat::where(function ($q) use ($order) {
            $q->where('user_one_id', $order->user_id)
                ->where('user_two_id', $order->business->user_id);
        })->orWhere(function ($q) use ($order) {
            $q->where('user_two_id', $order->user_id)
                ->where('user_one_id', $order->business->user_id);
        })->first();

        if ($chat) {
            ChatService::sendMessage(
                $chat->id,
                auth()->id(),
                "Hey mate, order #{$order->order_number} just changed - it's now {$statusText}.",
                'system'
            );
            $chat->touch();
        }

        \App\Helpers\NotificationHelper::send(
            $order->user_id,
            'Order Status',
            "Good news! Order #{$order->order_number} is now: {$statusText}",
            route('orders.index', $order->id)
        );

        return redirect()->route('dashboard.orders')
            ->with('success', 'Order status updated successfully.');
    }

    public function approve(Order $order)
    {
        if ($order->payment->status === 'pending' && $order->delivery_status === 'waiting') {
            try {
                // ✅ 1. Cek stok dulu
                foreach ($order->items as $item) {
                    $product = $item->product;
                    if ($product->stock < $item->quantity) {
                        throw ValidationException::withMessages([
                            'stock' => "Product {$product->name} has only {$product->stock} stock left, which is not enough for the order."
                        ]);
                    }
                }

                // ✅ 2. Capture Stripe (kalau stok cukup)
                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $paymentIntent = \Stripe\PaymentIntent::retrieve($order->payment->transaction_id);
                $paymentIntent->capture();

                // ✅ 3. Kurangi stok
                foreach ($order->items as $item) {
                    $item->product->decrement('stock', $item->quantity);
                }

                // ✅ 4. Update status
                $order->payment->update(['status' => 'paid']);
                $order->update(['delivery_status' => 'confirmed']);

                // === Trigger Chat & Pesan ===
                $sellerId   = $order->business->user_id;
                $customerId = $order->user_id;
                $businessId = $order->business_id;

                $chat = ChatService::getOrCreateChat($customerId, $sellerId, $businessId);
                ChatService::sendMessage(
                    $chat->id,
                    $sellerId,
                    "Hi there! Thanks for your order. It's confirmed and we're working on it now.",
                    'system'
                );

                \App\Helpers\NotificationHelper::send(
                    $customerId,
                    'All Good!',
                    "Your order #{$order->order_number} is locked in and we're getting it sorted now.",
                    route('orders.index', $order->id)
                );

                return back()->with('success', 'Order received successfully and payment confirmed.');
            } catch (\Exception $e) {
                return back()->withErrors(['stripe' => 'Failed to confirm payment: ' . $e->getMessage()]);
            }
        }

        return back()->withErrors(['order' => 'The order is not valid for approval.']);
    }

    public function reject(Order $order)
    {
        if ($order->payment->status !== 'pending') {
            return back()->withErrors(['order' => 'The order is not valid for rejection.']);
        }

        try {
            // Stripe cancel
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $paymentIntent = \Stripe\PaymentIntent::retrieve($order->payment->transaction_id);
            $paymentIntent->cancel();

            // Update database
            $order->payment->update(['status' => 'failed']);
            $order->update(['delivery_status' => 'canceled']);

            try {
                \Log::info('DEBUG: About to send a notification to user_id=' . $order->user_id);
                \App\Helpers\NotificationHelper::send(
                    $order->user_id,
                    'Order Cancelled',
                    "Heads up - order #{$order->order_number} didn't go through. If you've paid, we'll refund you soon.",
                    route('orders.index')
                );
                \Log::info('DEBUG: NotificationHelper::send sukses');
            } catch (\Throwable $e) {
                \Log::error('DEBUG: NotificationHelper::send ERROR: ' . $e->getMessage());
            }

            // Balik dengan pesan sukses
            return back()->with('success', 'Payment canceled successfully!');
        } catch (\Exception $e) {
            // Kalau error
            return back()->withErrors(['stripe' => 'Failed to cancel payment: ' . $e->getMessage()]);
        }
    }

    public function shipping()
    {
        $business = auth()->user()->business;
        return view('dashboard.orders.shipping', compact('business'));
    }

    public function updateShipping(Request $request)
    {
        $request->validate([
            'shipping_type'     => 'required|in:flat,per_km,flat_plus_per_km',
            'flat_rate'         => 'nullable|numeric|min:0',
            'per_km_rate'       => 'nullable|numeric|min:0',
            'per_km_unit'       => 'nullable|numeric|min:1',
            'supports_delivery' => 'nullable|boolean',
            'supports_pickup'   => 'nullable|boolean',
        ]);

        $business = auth()->user()->business;
        $business->update([
            'shipping_type'     => $request->shipping_type,
            'flat_rate'         => $request->flat_rate,
            'per_km_rate'       => $request->per_km_rate,
            'per_km_unit'       => $request->per_km_unit,
            'supports_delivery' => $request->has('supports_delivery'),
            'supports_pickup'   => $request->has('supports_pickup'),
        ]);

        return redirect()->route('dashboard.orders.shipping')->with('success', 'Shipping settings updated successfully!');
    }
}
