@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Terima kasih, pesananmu berhasil dibuat!</h1>
    <p>Nomor pesanan: <strong>{{ $order->order_number }}</strong></p>

    <h4>Order Summary</h4>
    <ul class="list-group mb-3">
        @foreach($order->items as $item)
        <li class="list-group-item d-flex justify-content-between">
            <div>
                <strong>{{ $item->product->name }}</strong>

                {{-- Qty dan harga unit --}}
                <div style="font-size: 12px; color: #555;">
                    Qty {{ $item->quantity }} × A${{ number_format($item->unit_price, 2) }}
                </div>

                {{-- Options --}}
                @if(!empty($item->options_for_view))
                <ul style="font-size: 12px; color: #555; margin: 4px 0 0 0; padding-left: 16px;">
                    @foreach($item->options_for_view as $group)
                    @foreach($group['items'] as $opt)
                    <li>
                        {{ $opt['name'] }}
                        @if(isset($opt['price']) && $opt['price'] > 0)
                        (+A${{ number_format($opt['price'], 2) }})
                        @endif
                    </li>
                    @endforeach
                    @endforeach
                </ul>
                @endif
            </div>

            <span>A${{ number_format($item->total_price, 2) }}</span>
        </li>
        @endforeach

        <li class="list-group-item d-flex justify-content-between">
            <span>Subtotal</span>
            <span>A${{ number_format($order->items->sum('total_price'), 2) }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Delivery Fee</span>
            <span>A${{ number_format($order->delivery_fee, 2) }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Service Fee</span>
            <span>A${{ number_format($order->order_fee, 2) }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between">
            <span>Gross Value (before Stripe fee)</span>
            <span>A${{ number_format($order->total_price, 2) }}</span>
        </li>
        <li class="list-group-item d-flex justify-content-between fw-bold">
            <span>Total Paid</span>
            <span>A${{ number_format($order->gross_price, 2) }}</span>
        </li>
    </ul>

    <p>Status: {{ ucfirst($order->delivery_status) }}</p>

    <a href="{{ route('home') }}" class="btn btn-primary mt-3">Kembali ke beranda</a>
</div>
@endsection