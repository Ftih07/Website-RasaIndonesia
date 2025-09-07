<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Business;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Message;
use App\Models\OrderItem;
use App\Models\ProductOption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Stripe\PaymentIntent;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function showCheckout($businessId)
    {
        $cart = Cart::where('user_id', Auth::id())
            ->where('business_id', $businessId)
            ->with('items.product', 'business')
            ->firstOrFail();

        // mapping product_id => { name, max_distance }
        $maxDistances = $cart->items->mapWithKeys(function ($item) {
            return [
                $item->product_id => [
                    'name' => $item->product->name,
                    'max_distance' => $item->product->max_distance
                ]
            ];
        });

        // 🔹 Hitung total berat, volume, volumetric
        $totalWeight = 0; // kg
        $totalVolume = 0; // cm³
        $totalWeightVolumetric = 0; // kg

        foreach ($cart->items as $item) {
            $product = $item->product;

            // konversi gram ke kg
            $weightKg = ($product->weight ?? 0) / 1000;

            // volume cm³
            $volumeCm3 = $product->volume ?? ($product->length * $product->width * $product->height);

            // berat volumetrik (kg)
            $weightVolumetricKg = $volumeCm3 / 6000;

            $totalWeight += $weightKg * $item->quantity;
            $totalVolume += $volumeCm3 * $item->quantity;
            $totalWeightVolumetric += $weightVolumetricKg * $item->quantity;
        }

        // chargeable weight
        $chargeableWeight = max($totalWeight, $totalWeightVolumetric);

        // tarif per kg dari bisnis
        $business = $cart->business;
        $pricePerKg = $business->price_per_kg ?? 0;

        // ongkir berdasarkan berat
        $shippingCost = $pricePerKg * $chargeableWeight;

        // total price (subtotal + shipping cost)
        $subtotal = $cart->items->sum('total_price');
        $totalPrice = $subtotal + $shippingCost;

        return view('checkout', [
            'cart' => $cart,
            'user' => Auth::user(),
            'business' => $business,
            'maxDistances' => $maxDistances,

            // lempar variabel tambahan ke view
            'totalWeight' => $totalWeight,
            'totalVolume' => $totalVolume,
            'chargeableWeight' => $chargeableWeight,
            'shippingCost' => $shippingCost,
            'totalPrice' => $totalPrice,
        ]);
    }

    private function calculateBusinessShippingFee($business, $deliveryOption, $distanceKm)
    {
        // Pickup (bebas diatur per bisnis, bisa flat_rate = 0 atau custom)
        if ($deliveryOption === 'pickup') {
            return 0;
        }

        switch ($business->shipping_type) {
            case 'flat':
                return $business->flat_rate;

            case 'per_km':
                $unitCount = ceil($distanceKm / $business->per_km_unit);
                return $unitCount * $business->per_km_rate;

            case 'flat_plus_per_km':
                $unitCount = ceil($distanceKm / $business->per_km_unit);
                return $business->flat_rate + ($unitCount * $business->per_km_rate);

            default:
                return 0;
        }
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

        // 🔹 kalau virtual, langsung balikin flat ongkir aja
        if ($business->is_virtual) {
            return response()->json([
                'distance_km' => 0,
                'delivery_fee' => $business->flat_rate ?? 0,
            ]);
        }

        if ($request->delivery_option === 'pickup' && !$business->supports_pickup) {
            return response()->json(['error' => 'Pickup is not available for this business.'], 422);
        }

        if ($request->delivery_option === 'delivery' && !$business->supports_delivery) {
            return response()->json(['error' => 'Delivery is not available for this business.'], 422);
        }

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
            return response()->json(['error' => 'Unable to calculate distance'], 422);
        }

        $delivery_fee = $this->calculateBusinessShippingFee($business, $request->delivery_option, $distance_km);

        return response()->json([
            'distance_km' => round($distance_km, 2),
            'delivery_fee' => $delivery_fee
        ]);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'shipping_address'   => 'required_if:delivery_option,delivery|string|nullable',
            'shipping_lat'       => 'required_if:delivery_option,delivery|numeric|nullable',
            'shipping_lng'       => 'required_if:delivery_option,delivery|numeric|nullable',
            'delivery_note'      => 'nullable|string',
            'business_id'        => 'required|exists:businesses,id',
            'delivery_option'    => 'required|string|in:pickup,delivery',
            'pickup_business_id' => 'nullable|exists:businesses,id', // 🔹 tambahan
        ]);

        $cart = Cart::where('user_id', Auth::id())
            ->where('business_id', $request->business_id)
            ->with('items.product', 'business')
            ->firstOrFail();

        $business = $cart->business;

        // 3. ✅ Validasi apakah bisnis support opsi delivery yang dipilih
        if ($request->delivery_option === 'pickup' && !$business->supports_pickup) {
            throw ValidationException::withMessages([
                'delivery_option' => 'Pickup is not available for this business.',
            ]);
        }

        if ($request->delivery_option === 'delivery' && !$business->supports_delivery) {
            throw ValidationException::withMessages([
                'delivery_option' => 'Delivery is not available for this business.',
            ]);
        }

        // Hitung ongkir
        if ($request->delivery_option === 'pickup') {
            if ($business->is_virtual) {
                // ✅ Virtual store, ambil lokasi pickup dari request
                $pickupBusiness = Business::findOrFail($request->pickup_business_id);

                $delivery_fee = 0; // pickup = gratis
                $shipping_address = $pickupBusiness->address;
                $shipping_lat = $pickupBusiness->latitude;
                $shipping_lng = $pickupBusiness->longitude;
                $distance_km = 0;
            } else {
                // ✅ Normal business pickup
                $delivery_fee = $this->calculateBusinessShippingFee($cart->business, 'pickup', 0);
                $shipping_address = $cart->business->address;
                $shipping_lat = $cart->business->latitude;   // 🔹 ambil dari bisnis
                $shipping_lng = $cart->business->longitude;  // 🔹 ambil dari bisnis
                $distance_km = 0;
            }
        } elseif ($business->is_virtual) {
            // ✅ Virtual store, delivery flat rate
            $delivery_fee = $business->flat_rate;
            $shipping_address = $request->shipping_address ?? 'Virtual Store';

            // wajib ada koordinat
            $shipping_lat = $request->shipping_lat ?? null;
            $shipping_lng = $request->shipping_lng ?? null;

            if (!$shipping_lat || !$shipping_lng) {
                throw new \Exception('Delivery location has not been selected');
            }

            $distance_km = 0;
        } else {
            // ✅ Normal delivery
            $apiKey = env('GOOGLE_MAPS_API_KEY');
            $distance_url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins={$cart->business->latitude},{$cart->business->longitude}&destinations={$request->shipping_lat},{$request->shipping_lng}&units=metric&key={$apiKey}";
            $distance_data = json_decode(file_get_contents($distance_url), true);

            if (!isset($distance_data['rows'][0]['elements'][0]['distance']['value'])) {
                throw new \Exception('Unable to calculate distance');
            }

            $distance_km = $distance_data['rows'][0]['elements'][0]['distance']['value'] / 1000;
            $delivery_fee = $this->calculateBusinessShippingFee($cart->business, 'delivery', $distance_km);

            $shipping_address = $request->shipping_address;
            $shipping_lat = $request->shipping_lat;
            $shipping_lng = $request->shipping_lng;
        }

        // ✅ Validasi stok produk sebelum checkout
        foreach ($cart->items as $item) {
            $product = $item->product;

            if ($product->stock < $item->quantity) {
                throw ValidationException::withMessages([
                    'cart' => "Product {$product->name} has only {$product->stock} stock left, which is not enough for the order of {$item->quantity}."
                ]);
            }
        }

        // ✅ Validasi max_distance tiap produk
        foreach ($cart->items as $item) {
            if ($item->product->max_distance && $distance_km > $item->product->max_distance) {
                throw ValidationException::withMessages([
                    'shipping_address' => "The product {$item->product->name} cannot be shipped (maximum {$item->product->max_distance} km)"
                ]);
            }
        }

        $totalWeightActual = 0;
        $totalVolume = 0;
        $totalWeightVolumetric = 0;

        foreach ($cart->items as $item) {
            $product = $item->product;

            $weightKg = ($product->weight ?? 0) / 1000; // per unit
            $volumeCm3 = $product->volume ?? ($product->length * $product->width * $product->height);
            $weightVolumetricKg = $volumeCm3 / 6000; // per unit

            // total untuk order
            $totalWeightActual += $weightKg * $item->quantity;
            $totalVolume += $volumeCm3 * $item->quantity;
            $totalWeightVolumetric += $weightVolumetricKg * $item->quantity;

            // simpan per item (sudah dikali quantity)
            $item->calculated_weightKg = $weightKg * $item->quantity;
            $item->calculated_volumeCm3 = $volumeCm3 * $item->quantity;
            $item->calculated_weightVolumetricKg = $weightVolumetricKg * $item->quantity;
        }

        // 1️⃣ Hitung chargeable weight
        $chargeableWeight = max($totalWeightActual, $totalWeightVolumetric);

        // 2️⃣ Ambil tarif per kg bisnis
        $business = \App\Models\Business::findOrFail($request->business_id);
        $pricePerKg = $business->price_per_kg ?? 0;

        // 3️⃣ Hitung shipping cost (ongkir berdasar berat)
        $shipping_cost = $pricePerKg * $chargeableWeight;

        // 5️⃣ Biaya administrasi platform (misalnya 1 AUD)
        $order_fee = 1;

        // 6️⃣ Hitung subtotal & total
        $subtotal = $cart->items->sum('total_price');
        $tax = 0;

        $total = $subtotal + $tax + $delivery_fee + $shipping_cost + $order_fee;

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
            'status' => 'incomplete',
            'transaction_id' => $paymentIntent->id,
        ]);

        $order = Order::create([
            'user_id'            => Auth::id(),
            'payment_id'         => $payment->id,
            'business_id'        => $request->business_id,
            'pickup_business_id' => $request->pickup_business_id,
            'order_number'       => 'TOI-' . strtoupper(Str::random(8)),
            'subtotal'           => $subtotal,
            'tax'                => $tax,
            'delivery_fee'       => $delivery_fee,
            'shipping_cost'      => $shipping_cost, // 🔹 kolom baru di tabel orders
            'order_fee'          => $order_fee,
            'total_price'        => $total,
            'gross_price'        => $grossAmount,
            'shipping_address'   => $shipping_address,
            'shipping_lat'       => $shipping_lat ?? $request->shipping_lat, // 🔹 fallback ke request kalau bukan virtual pickup
            'shipping_lng'       => $shipping_lng ?? $request->shipping_lng, // 🔹 sama
            'delivery_note'      => $request->delivery_note,
            'delivery_option'    => $request->delivery_option,
            'delivery_status'    => 'waiting',

            // tambahan berat/volume
            'total_weight_actual'     => $totalWeightActual,
            'total_volume'            => $totalVolume,
            'total_weight_volumetric' => $totalWeightVolumetric,
            'chargeable_weight'       => $chargeableWeight,
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

                // Tambahan — pakai yang sudah dikali quantity
                'weight_actual'     => $item->calculated_weightKg,
                'volume'            => $item->calculated_volumeCm3,
                'weight_volumetric' => $item->calculated_weightVolumetricKg,
            ]);
        }

        $order->load('items.product');

        // Kirim client_secret ke view untuk frontend Stripe.js
        return view('checkout-payment', [
            'clientSecret' => $paymentIntent->client_secret,
            'order' => $order,
            'maxDistances' => [],
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

        // --- Update status payment ke pending ---
        if ($order->payment) {
            $order->payment->update(['status' => 'pending']);
        }

        // Decode options dan ambil nama dari ProductOption
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

        // ✅ Tambahin Activity buat seller
        Activity::create([
            'business_id' => $order->business_id,
            'type'        => 'order',
            'title'       => 'New Order Received',
            'description' => "Order #{$order->order_number} received with " . $order->items->count() . " item(s).",
        ]);

        // ✅ Hapus cart setelah payment sukses
        $cart = Cart::where('user_id', Auth::id())->first();
        if ($cart) {
            $cart->items()->delete();
            $cart->delete();
        }

        return view('order-success', compact('order'));
    }
}
