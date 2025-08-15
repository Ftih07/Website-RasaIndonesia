@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Partner Orders</h1>

    <table class="table-auto w-full border">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">Order ID</th>
                <th class="border px-4 py-2">Customer</th>
                <th class="border px-4 py-2">Items</th>
                <th class="border px-4 py-2">Total</th>
                <th class="border px-4 py-2">Delivery Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr class="border-t">
                <td class="border px-4 py-2">{{ $order->id }}</td>
                <td class="border px-4 py-2">{{ $order->customer_name ?? $order->user->name }}</td>

                <td class="border px-4 py-2 align-top">
                    @foreach($order->items as $item)
                    <div class="mb-2">
                        <strong>{{ $item->product->name ?? 'Product not found' }}</strong>
                        ({{ $item->quantity }} × A${{ number_format($item->unit_price, 2) }})<br>

                        @if(!empty($item->options_for_view) && is_array($item->options_for_view))
                        @foreach($item->options_for_view as $group)
                        @if(!empty($group['items']) && is_array($group['items']))
                        @foreach($group['items'] as $opt)
                        - {{ $opt['name'] ?? 'Unnamed Option' }}
                        @if(isset($opt['price']) && $opt['price'] > 0)
                        (+A${{ number_format($opt['price'], 2) }})
                        @endif
                        <br>
                        @endforeach
                        @endif
                        @endforeach
                        @endif

                        <hr class="my-1">
                    </div>
                    @endforeach
                </td>

                <td class="border px-4 py-2">${{ number_format($order->gross_price,2) }}</td>
                <td class="border px-4 py-2">{{ ucfirst($order->delivery_status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection