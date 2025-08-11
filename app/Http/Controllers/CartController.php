<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function getCart(Request $request)
    {
        $businessId = $request->query('business_id');

        $query = CartItem::with('product')
            ->whereHas('cart', function ($q) use ($businessId) {
                $q->where('user_id', Auth::id());
                if ($businessId) {
                    $q->where('business_id', $businessId);
                }
            });

        $items = $query->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'quantity' => $item->quantity,
                'total_price' => $item->total_price,
                'product' => [
                    'name' => $item->product->name,
                    'image_url' => $item->product->image
                        ? asset('storage/' . $item->product->image) // kalau disimpan di storage/app/public
                        : asset('assets/images/logo/logo.png'), // fallback kalau kosong
                ],
            ];
        });

        return response()->json([
            'success' => true,
            'cart' => $items,
            'cart_count' => $items->count(),
        ]);
    }

    public function add(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to add items to the cart.'
            ], 401);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'business_id' => 'required|exists:businesses,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'note' => 'nullable|string',
            'preference_if_unavailable' => 'nullable|string',
            'options' => 'nullable|json',
        ]);

        // Cek is_sell produk
        $product = Product::find($request->product_id);
        if (!$product || !$product->is_sell) {
            return response()->json([
                'success' => false,
                'message' => 'This product is not available for sale.'
            ], 400);
        }

        $cart = Cart::firstOrCreate([
            'user_id' => Auth::id(),
            'business_id' => $request->business_id,
        ]);

        $options = $request->input('options', null);

        $existingItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->where('options', $options)
            ->first();

        if ($existingItem) {
            $existingItem->quantity += $request->quantity;

            // Hitung total price dengan opsi
            $optionsArr = json_decode($existingItem->options, true) ?? [];
            $optionsPrice = 0;
            foreach ($optionsArr as $group) {
                foreach ($group['selected'] ?? [] as $opt) {
                    $optionsPrice += ($opt['price'] ?? 0) * $existingItem->quantity;
                }
            }
            $existingItem->total_price = ($existingItem->unit_price * $existingItem->quantity) + $optionsPrice;

            if ($request->note) {
                $existingItem->note = $request->note;
            }
            if ($request->preference_if_unavailable) {
                $existingItem->preference_if_unavailable = $request->preference_if_unavailable;
            }

            $existingItem->save();
            $existingItem->load('product');

            return response()->json([
                'success' => true,
                'message' => 'Cart item quantity updated.',
                'cart_count' => $cart->items()->count(),
                'item' => $existingItem,
            ]);
        }

        // Item baru
        $optionsArr = json_decode($options, true) ?? [];
        $optionsPrice = 0;
        foreach ($optionsArr as $group) {
            foreach ($group['selected'] ?? [] as $opt) {
                $optionsPrice += ($opt['price'] ?? 0) * $request->quantity;
            }
        }
        $totalPrice = ($request->unit_price * $request->quantity) + $optionsPrice;

        $item = CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'total_price' => $totalPrice,
            'note' => $request->note,
            'preference_if_unavailable' => $request->preference_if_unavailable,
            'options' => $options,
        ]);

        $item->load('product');

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart!',
            'cart_count' => $cart->items()->count(),
            'item' => $item,
        ]);
    }

    public function update(Request $request, $rowId)
    {
        $item = CartItem::findOrFail($rowId);

        if ($item->cart->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'note' => 'nullable|string',
            'preference_if_unavailable' => 'nullable|string',
            'options' => 'nullable|json',
            'quantity' => 'nullable|integer|min:1',
        ]);

        if (isset($validated['quantity'])) {
            $item->quantity = $validated['quantity'];
        }
        if (isset($validated['note'])) {
            $item->note = $validated['note'];
        }
        if (isset($validated['preference_if_unavailable'])) {
            $item->preference_if_unavailable = $validated['preference_if_unavailable'];
        }
        if (isset($validated['options'])) {
            $item->options = $validated['options'];
        }

        // Hitung ulang total_price
        $optionsArr = json_decode($item->options, true) ?? [];
        $optionsPrice = 0;
        foreach ($optionsArr as $group) {
            foreach ($group['selected'] ?? [] as $opt) {
                $optionsPrice += ($opt['price'] ?? 0) * $item->quantity;
            }
        }
        $item->total_price = ($item->unit_price * $item->quantity) + $optionsPrice;

        $item->save();

        return response()->json(['success' => true, 'message' => 'Cart item updated successfully']);
    }

    // Ambil 1 item cart lengkap dengan product-nya
    public function getCartItem($rowId)
    {
        $item = CartItem::with('product.optionGroups.options')->findOrFail($rowId);

        if ($item->cart->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $product = $item->product;

        // Tambahin URL gambar (fallback kalau kosong)
        $product->image_url = $product->image
            ? asset('storage/' . $product->image) // kalau disimpan di storage/app/public
            : asset('images/default-food.png');

        // Format all option groups with options sesuai kebutuhan frontend
        $allOptionGroups = $product->optionGroups->map(function ($group) {
            return [
                'group_id' => $group->id,
                'group_name' => $group->name,
                'max_selection' => $group->max_selection,
                'is_required' => (bool) $group->is_required,
                'options' => $group->options->map(function ($option) {
                    return [
                        'id' => $option->id,
                        'name' => $option->name,
                        'price' => $option->price ?? 0,
                    ];
                })->toArray(),
            ];
        })->toArray();

        return response()->json([
            'success' => true,
            'cart_item' => $item,
            'all_option_groups' => $allOptionGroups,
        ]);
    }

    public function remove($rowId)
    {
        $item = CartItem::findOrFail($rowId);

        if ($item->cart->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
            'cart_count' => CartItem::whereHas('cart', function ($q) {
                $q->where('user_id', Auth::id());
            })->count()
        ]);
    }
}
