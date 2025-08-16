@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Order #{{ $order->id }}</h4>

    <!-- Order Summary -->
    <div class="card mb-4">
        <div class="card-header fw-bold">Order Summary</div>
        <div class="card-body">
            <table class="table table-sm">
                <tr>
                    <th>Subtotal</th>
                    <td>${{ number_format($order->subtotal, 2) }} AUD</td>
                </tr>
                <tr>
                    <th>Tax</th>
                    <td>${{ number_format($order->tax, 2) }} AUD</td>
                </tr>
                <tr>
                    <th>Delivery Fee</th>
                    <td>${{ number_format($order->delivery_fee, 2) }} AUD</td>
                </tr>
                <tr>
                    <th>Order Fee</th>
                    <td>${{ number_format($order->order_fee, 2) }} AUD</td>
                </tr>
                <tr class="fw-bold">
                    <th>Total Price</th>
                    <td>${{ number_format($order->gross_price, 2) }} AUD</td>
                </tr>
                <tr>
                    <th>Shipping Address</th>
                    <td>{{ $order->shipping_address ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Delivery Note</th>
                    <td>{{ $order->delivery_note ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Delivery Option</th>
                    <td>{{ ucfirst($order->delivery_option) }}</td>
                </tr>
                <tr>
                    <th>Order Date</th>
                    <td>{{ $order->order_date->format('d M Y H:i') }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge bg-primary">
                            {{ ucfirst(str_replace('_', ' ', $order->delivery_status)) }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Order Items -->
    <div class="card mb-4">
        <div class="card-header fw-bold">Order Items</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Options</th>
                        <th>Note</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name ?? 'Product not found' }}</td>

                        <td>
                            @if(!empty($item->options_for_view))
                            <ul class="mb-0">
                                @foreach($item->options_for_view as $group)
                                <li>
                                    <strong>{{ $group['group_name'] ?? 'Option' }}</strong>
                                    <ul>
                                        @foreach($group['items'] as $opt)
                                        <li>
                                            {{ $opt['name'] ?? 'Unnamed Option' }}
                                            @if(isset($opt['price']) && $opt['price'] > 0)
                                            (+${{ number_format($opt['price'], 2) }})
                                            @endif
                                        </li>
                                        @endforeach
                                    </ul>
                                </li>
                                @endforeach
                            </ul>
                            @else
                            -
                            @endif
                        </td>

                        <td>{{ $item->note ?? '-' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->unit_price, 2) }} AUD</td>
                        <td>${{ number_format($item->total_price, 2) }} AUD</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-3">
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">← Back to My Orders</a>
    </div>
</div>
@endsection
