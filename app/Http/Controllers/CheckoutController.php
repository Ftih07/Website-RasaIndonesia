<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Message;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Stripe\PaymentIntent;

class CheckoutController extends Controller
{
    public function showCheckout($businessId)
    {
        $cart = Cart::where('user_id', Auth::id())
            ->where('business_id', $businessId)
            ->with('items.product', 'business') // tambahkan relasi business
            ->firstOrFail();

        return view('checkout', [
            'cart' => $cart,
            'user' => Auth::user()
        ]);
    }

    public function calculateShipping(Request $request)
    {
        $request->validate([
            'business_id' => 'required|exists:businesses,id',
            'shipping_lat' => 'required|numeric',
            'shipping_lng' => 'required|numeric',
            'delivery_option' => 'required|in:pickup,delivery'
        ]);

        $business = \App\Models\Business::findOrFail($request->business_id);

        if ($request->delivery_option === 'pickup') {
            return response()->json([
                'distance_km' => 0,
                'delivery_fee' => 2
            ]);
        }

        $apiKey = env('GOOGLE_MAPS_API_KEY');
        $distance_url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins={$business->latitude},{$business->longitude}&destinations={$request->shipping_lat},{$request->shipping_lng}&units=metric&key={$apiKey}";
        $distance_data = json_decode(file_get_contents($distance_url), true);

        if (isset($distance_data['rows'][0]['elements'][0]['distance']['value'])) {
            $distance_km = $distance_data['rows'][0]['elements'][0]['distance']['value'] / 1000;
        } else {
            return response()->json(['error' => 'Tidak dapat menghitung jarak'], 422);
        }

        $delivery_fee = 2 + (ceil($distance_km / 3) * 4);

        return response()->json([
            'distance_km' => round($distance_km, 2),
            'delivery_fee' => $delivery_fee
        ]);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required_if:delivery_option,delivery|string|nullable',
            'shipping_lat'     => 'required_if:delivery_option,delivery|numeric|nullable',
            'shipping_lng'     => 'required_if:delivery_option,delivery|numeric|nullable',
            'delivery_note'    => 'nullable|string',
            'business_id'      => 'required|exists:businesses,id',
            'delivery_option'  => 'required|string|in:pickup,delivery'
        ]);

        $cart = Cart::where('user_id', Auth::id())
            ->where('business_id', $request->business_id)
            ->with('items.product', 'business')
            ->firstOrFail();

        // Hitung ongkir
        if ($request->delivery_option === 'pickup') {
            $delivery_fee = 2;
            $shipping_address = $cart->business->address;
        } else {
            $delivery_fee = 4; // sementara
            $shipping_address = $request->shipping_address;
        }

        $subtotal = $cart->items->sum('total_price');
        $tax = 0;
        $order_fee = 1;
        $total = $subtotal + $tax + $delivery_fee + $order_fee;

        // ===== Tambahan: Hitung total yang sudah include Stripe fee =====
        $targetNet = $total; // yang kamu mau bersih
        $stripePercentFee = 0.036 * 1.1; // 3.6% plus 10% GST
        $stripeFixedFee = 0.30;

        $grossAmount = ($targetNet + $stripeFixedFee) / (1 - $stripePercentFee);
        $grossAmount = round($grossAmount, 2); // bulatkan 2 decimal
        // ===================================

        // Set API key Stripe
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Buat PaymentIntent dengan manual capture
        $paymentIntent = PaymentIntent::create([
            'amount' => intval($grossAmount * 100), // pakai grossAmount di sini
            'currency' => 'aud',
            'capture_method' => 'manual', // tahan dana
            'automatic_payment_methods' => [
                'enabled' => true,
            ],
            'metadata' => [
                'user_id' => Auth::id(),
                'business_id' => $request->business_id,
                'shipping_address' => $shipping_address,
                'delivery_note' => $request->delivery_note,
                'delivery_option' => $request->delivery_option,
            ]
        ]);

        // Simpan Payment dan Order dengan status pending
        $payment = Payment::create([
            'payment_method' => 'stripe',
            'status' => 'pending',
            'transaction_id' => $paymentIntent->id,
        ]);

        $order = Order::create([
            'user_id' => Auth::id(),
            'payment_id' => $payment->id,
            'business_id' => $request->business_id,
            'order_number' => 'TOI-' . strtoupper(Str::random(8)),
            'subtotal' => $subtotal,
            'tax' => $tax,
            'delivery_fee' => $delivery_fee,
            'order_fee' => $order_fee,
            'total_price' => $total, // ini tetap net value
            'gross_price' => $grossAmount, // kalau mau simpan harga yang dibayar customer
            'shipping_address' => $shipping_address,
            'delivery_note' => $request->delivery_note,
            'delivery_option' => $request->delivery_option,
            'delivery_status' => 'waiting',
        ]);

        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price,
                'total_price' => $item->total_price,
                'note' => $item->note,
                'preference_if_unavailable' => $item->preference_if_unavailable,
                'options' => $item->options,
            ]);
        }

        $order->load('items.product');

        // Hapus cart
        $cart->items()->delete();
        $cart->delete();

        // Kirim client_secret ke view untuk frontend Stripe.js
        return view('checkout-payment', [
            'clientSecret' => $paymentIntent->client_secret,
            'order' => $order
        ]);
    }

    public function stripeSuccess(Request $request)
    {
        return view('stripe-success');
    }

    public function stripeCancel()
    {
        return view('stripe-cancel');
    }

    public function success(Order $order)
    {
        // Pastikan hanya owner order yg bisa lihat
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('order-success', compact('order'));
    }
}
