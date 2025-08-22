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

        return redirect()->route('dashboard.orders')->with('success', 'Pengajuan aktivasi Orders telah dikirim. Menunggu persetujuan admin.');
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
            ->with('success', 'Status order berhasil diperbarui.');
    }

    public function approve(Order $order)
    {
        if ($order->payment->status === 'pending' && $order->delivery_status === 'waiting') {
            try {
                Stripe::setApiKey(env('STRIPE_SECRET'));
                $paymentIntent = PaymentIntent::retrieve($order->payment->transaction_id);
                $paymentIntent->capture();

                $order->payment->update(['status' => 'paid']);
                $order->update(['delivery_status' => 'confirmed']);

                // === Trigger Chat & Pesan ===
                $sellerId   = $order->business->user_id; // pemilik bisnis
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

                return back()->with('success', 'Pesanan berhasil diterima dan pembayaran dikonfirmasi.');
            } catch (\Exception $e) {
                return back()->withErrors(['stripe' => 'Gagal mengkonfirmasi pembayaran: ' . $e->getMessage()]);
            }
        }

        return back()->withErrors(['order' => 'Pesanan tidak valid untuk disetujui.']);
    }

    public function reject(Order $order)
    {
        if ($order->payment->status === 'pending' && $order->delivery_status === 'waiting') {
            try {
                Stripe::setApiKey(env('STRIPE_SECRET'));
                $paymentIntent = PaymentIntent::retrieve($order->payment->transaction_id);
                $paymentIntent->cancel();

                $order->payment->update(['status' => 'failed']);
                $order->update(['delivery_status' => 'canceled']);

                \App\Helpers\NotificationHelper::send(
                    $order->user_id,
                    'Order Cancelled',
                    "Heads up — order #{$order->order_number} didn't go through. No worries, if you've paid we'll shoot the refund back soon.",
                    route('orders.index', $order->id)
                );

                return back()->with('success', 'Pesanan berhasil ditolak dan pembayaran dibatalkan.');
            } catch (\Exception $e) {
                return back()->withErrors(['stripe' => 'Gagal membatalkan pembayaran: ' . $e->getMessage()]);
            }
        }

        return back()->withErrors(['order' => 'Pesanan tidak valid untuk ditolak.']);
    }

    public function shipping()
    {
        $business = auth()->user()->business;
        return view('dashboard.orders.shipping', compact('business'));
    }

    public function updateShipping(Request $request)
    {
        $request->validate([
            'shipping_type' => 'required|in:flat,per_km,flat_plus_per_km',
            'flat_rate'     => 'nullable|numeric|min:0',
            'per_km_rate'   => 'nullable|numeric|min:0',
            'per_km_unit'   => 'nullable|numeric|min:1',
        ]);

        $business = auth()->user()->business;
        $business->update($request->only('shipping_type', 'flat_rate', 'per_km_rate', 'per_km_unit'));

        return redirect()->route('dashboard.orders.shipping')->with('success', 'Shipping settings updated successfully!');
    }
}
