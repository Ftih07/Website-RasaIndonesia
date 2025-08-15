<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\ProductOption;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $partner = auth()->user();

        $orders = Order::with('items.product')
            ->where('partner_id', $partner->id)
            ->latest()
            ->get();

        // Proses options sama seperti di dashboard order show
        foreach ($orders as $order) {
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

                $item->options_for_view = $processedOptions;
            }
        }

        return view('partner.orders.index', compact('orders'));
    }
}
