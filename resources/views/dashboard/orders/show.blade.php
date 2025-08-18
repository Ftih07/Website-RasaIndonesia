<!-- resources/views/dashboard/orders/show.blade.php -->

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
                    @if($order->shipping_address)
                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($order->shipping_address) }}"
                        target="_blank"
                        class="btn btn-sm btn-primary">
                        📍 Lihat di Maps
                    </a>
                    @endif
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
                        <th>Preference if Unavailable</th>
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
                                    <strong>{{ $group['group_name'] ?? 'Unnamed Group' }}</strong>
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

                        <td>{{ $item->preference_if_unavailable ?? '-' }}</td>
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

    <!-- Update Delivery Status & Actions -->
    <div class="mb-4">
        <h5 class="fw-bold mb-2">Actions</h5>

        {{-- Status saat ini --}}
        <span class="inline-block mr-2">
            {{ ucfirst(str_replace('_', ' ', $order->delivery_status)) }}
        </span>

        {{-- Kalau masih waiting + payment pending → tampilkan tombol Terima/Tolak --}}
        @if($order->delivery_status === 'waiting' && $order->payment->status === 'pending')
        <form method="POST" action="{{ route('dashboard.orders.approve', $order->id) }}" class="inline-block ml-2">
            @csrf
            @method('PATCH')
            <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded">
                Terima
            </button>
        </form>

        <form method="POST" action="{{ route('dashboard.orders.reject', $order->id) }}" class="inline-block ml-2">
            @csrf
            @method('PATCH')
            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">
                Tolak
            </button>
        </form>

        {{-- Kalau order sudah diterima (confirmed, assigned, on_delivery) → tampilkan dropdown --}}
        @elseif(in_array($order->delivery_status, ['confirmed', 'assigned', 'on_delivery']))
        <form method="POST" action="{{ route('dashboard.orders.updateStatus', $order->id) }}" class="inline-block">
            @csrf
            @method('PATCH')
            <select name="delivery_status" class="border rounded px-2 py-1" onchange="this.form.submit()">
                <option value="" disabled selected>Update Status</option>
                @foreach($allowedStatuses as $status)
                <option value="{{ $status }}" {{ $order->delivery_status === $status ? 'selected' : '' }}>
                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                </option>
                @endforeach
            </select>
        </form>

        {{-- Kalau order ditolak / sudah selesai → hanya tampilkan status --}}
        @elseif(in_array($order->delivery_status, ['rejected', 'delivered', 'canceled']))
        <span class="ml-2 text-gray-500">(No further actions)</span>
        @endif
    </div>

</div>
@endsection