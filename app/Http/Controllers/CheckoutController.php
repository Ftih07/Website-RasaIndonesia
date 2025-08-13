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

        // Set API key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Prepare line items untuk Stripe Checkout Session
        $lineItems = [];
        foreach ($cart->items as $item) {
            // hitung harga per unit termasuk option
            $unitAmount = $item->total_price / $item->quantity;

            // siapkan product_data
            $productData = [
                'name' => $item->product->name,
            ];

            // tambahkan description hanya kalau ada options
            if (!empty($item->options)) {
                $optionsArray = collect(json_decode($item->options, true))->pluck('name')->toArray();
                $desc = implode(', ', $optionsArray);
                if (!empty($desc)) {
                    $productData['description'] = $desc;
                }
            }

            // tambahkan ke lineItems
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'aud',
                    'product_data' => $productData,
                    'unit_amount' => intval($unitAmount * 100),
                ],
                'quantity' => $item->quantity,
            ];
        }


        // Tambah ongkir & fees sebagai line item terpisah (boleh optional)
        $lineItems[] = [
            'price_data' => [
                'currency' => 'aud',
                'product_data' => [
                    'name' => 'Delivery Fee',
                ],
                'unit_amount' => intval($delivery_fee * 100),
            ],
            'quantity' => 1,
        ];
        $lineItems[] = [
            'price_data' => [
                'currency' => 'aud',
                'product_data' => [
                    'name' => 'Order Fee',
                ],
                'unit_amount' => intval($order_fee * 100),
            ],
            'quantity' => 1,
        ];

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => url('/stripe/success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => url('/stripe/cancel'),
            'metadata' => [
                'user_id' => Auth::id(),
                'business_id' => $request->business_id,
                'shipping_address' => $shipping_address,
                'delivery_note' => $request->delivery_note,
                'delivery_option' => $request->delivery_option,
            ],
        ]);

        // Simpan Payment & Order dulu dengan status pending, dan simpan session ID sebagai transaction_id
        $payment = Payment::create([
            'payment_method' => 'stripe',
            'status' => 'pending',
            'transaction_id' => $session->id,
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
            'total_price' => $total,
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

        // Hapus cart
        $cart->items()->delete();
        $cart->delete();

        // Redirect ke Stripe checkout URL
        return redirect($session->url);
    }

    public function stripeSuccess(Request $request)
    {
        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            abort(400, 'Session ID not found.');
        }

        $payment = Payment::where('transaction_id', $sessionId)->first();

        if (!$payment) {
            abort(404, 'Payment not found.');
        }

        $payment->update(['status' => 'paid']);

        if ($payment->order) {
            $payment->order->update(['delivery_status' => 'confirmed']);
        }

        return view('stripe-success', ['order' => $payment->order]);
    }

    public function stripeCancel(Request $request)
    {
        // Bisa tampilkan pesan pembatalan pembayaran
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
