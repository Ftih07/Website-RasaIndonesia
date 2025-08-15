<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Validation\Rule;

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
            $orders = Order::with(['user', 'items'])
                ->where('business_id', $business->id)
                ->latest()
                ->get();

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

        return redirect()->route('dashboard.orders')
            ->with('success', 'Status order berhasil diperbarui.');
    }

    public function approve(Order $order)
    {
        if ($order->payment->status === 'pending' && $order->delivery_status === 'waiting') {
            try {
                Stripe::setApiKey(env('STRIPE_SECRET'));

                // Ambil payment intent dari Stripe
                $paymentIntent = PaymentIntent::retrieve($order->payment->transaction_id);

                // Capture pembayaran
                $paymentIntent->capture();

                // Update status di database
                $order->payment->update(['status' => 'paid']);
                $order->update(['delivery_status' => 'confirmed']);

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

                // Ambil payment intent dari Stripe
                $paymentIntent = PaymentIntent::retrieve($order->payment->transaction_id);

                // Cancel pembayaran
                $paymentIntent->cancel();

                // Update status di database
                $order->payment->update(['status' => 'failed']);
                $order->update(['delivery_status' => 'canceled']);

                return back()->with('success', 'Pesanan berhasil ditolak dan pembayaran dibatalkan.');
            } catch (\Exception $e) {
                return back()->withErrors(['stripe' => 'Gagal membatalkan pembayaran: ' . $e->getMessage()]);
            }
        }

        return back()->withErrors(['order' => 'Pesanan tidak valid untuk ditolak.']);
    }
}
