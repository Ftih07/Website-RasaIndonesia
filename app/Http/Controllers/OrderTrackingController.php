<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\ProductOption;

class OrderTrackingController extends Controller
{
    // semua order user
    public function index()
    {
        $orders = Auth::user()->orders()->latest()->get();

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
}
