<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\ProductOption;
use App\Models\Testimonial;
use App\Models\TestimonialImage;

class OrderTrackingController extends Controller
{
    // semua order user
    public function index()
    {
        $orders = Auth::user()->orders()
            ->whereHas('payment', function ($q) {
                $q->where('status', '!=', 'incomplete');
            })
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    // tracking spesifik order
    public function tracking(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // decode options sama kayak sebelumnya...
        foreach ($order->items as $item) {
            $options = is_string($item->options)
                ? json_decode($item->options, true)
                : ($item->options ?? []);

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

            $item->options_for_view = $processedOptions;
        }

        return view('orders.tracking', compact('order'));
    }

    public function storeReview(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'business_id' => 'required|exists:businesses,id',
            'rating' => 'required|integer|min:1|max:5',
            'description' => 'required|string',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $order = Order::with('testimonial')->findOrFail($request->order_id);

        // Cegah review ganda
        if ($order->testimonial) {
            return back()->with('error', 'Order ini sudah pernah direview.');
        }

        $testimonial = Testimonial::create([
            'order_id' => $request->order_id,
            'business_id' => $request->business_id,
            'user_id' => auth()->id(),
            'name' => auth()->user()->name,
            'description' => $request->description,
            'rating' => $request->rating,
            'publishedAtDate' => now(),
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('testimonials', 'public');
                TestimonialImage::create([
                    'testimonial_id' => $testimonial->id,
                    'image_path' => $path,
                ]);
            }
        }

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil dikirim.');
    }
}
