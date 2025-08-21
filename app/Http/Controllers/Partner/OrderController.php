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

        // Base query
        $ordersQuery = Order::with('items.product')
            ->where('partner_id', $partner->id)
            ->latest();

        // Apply filters
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
            $ordersQuery->where('order_number', $orderNumber);
        }

        if ($deliveryOption = request('delivery_option')) {
            $ordersQuery->where('delivery_option', $deliveryOption);
        }

        if ($productName = request('product')) {
            $ordersQuery->whereHas('items.product', function ($q) use ($productName) {
                $q->where('name', 'like', '%' . $productName . '%');
            });
        }

        $perPage = request('per_page', 10);

        $orders = $ordersQuery
            ->paginate($perPage)
            ->withQueryString();

        // Proses options sama seperti sebelumnya
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                $options = is_string($item->options) ? json_decode($item->options, true) : ($item->options ?? []);
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

    public function show($id)
    {
        $partner = Auth::user();

        $order = Order::with([
            'user',
            'items.product',
        ])->where('partner_id', $partner->id)
            ->findOrFail($id);

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

        return view('partner.orders.show', compact('order'));
    }
}
