@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">My Orders</h2>

    @if($orders->isEmpty())
        <p>You have no orders yet.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Placed At</th>
                    <th>Tracking</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $order->delivery_status)) }}</td>
                    <td>${{ number_format($order->gross_price, 2) }}</td>
                    <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                    <td>
                        <a href="{{ route('orders.tracking', $order) }}" class="btn btn-primary btn-sm">
                            View Tracking
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
