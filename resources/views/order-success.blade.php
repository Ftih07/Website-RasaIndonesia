@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Terima kasih, pesananmu berhasil dibuat!</h1>
    <p>Nomor pesanan: <strong>{{ $order->order_number }}</strong></p>
    <p>Total: ${{ number_format($order->total_price, 2) }}</p>
    <p>Status: {{ ucfirst($order->delivery_status) }}</p>

    <a href="{{ route('home') }}" class="btn btn-primary mt-3">Kembali ke beranda</a>
</div>
@endsection
