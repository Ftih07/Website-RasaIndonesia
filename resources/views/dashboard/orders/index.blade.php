@extends('layouts.app')

@section('content')
<h4>Daftar Orders</h4>
<p>Fitur orders aktif. Anda bisa mengelola pesanan di sini.</p>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-2 rounded mb-4">
    {{ session('success') }}
</div>
@endif

<a href="{{ route('dashboard.orders.shipping') }}" class="block mt-2 text-blue-600">Shipping Settings</a>

@if($orders->count() > 0)
<table class="table-auto w-full border mt-4">
    <thead>
        <tr>
            <th class="border px-4 py-2">Order Number</th>
            <th class="border px-4 py-2">Customer</th>
            <th class="border px-4 py-2">Total</th>
            <th class="border px-4 py-2">Status</th>
            <th class="border px-4 py-2">Tanggal</th>
            <th class="border px-4 py-2">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td class="border px-4 py-2">{{ $order->order_number }}</td>
            <td class="border px-4 py-2">{{ $order->user->name }}</td>
            <td class="border px-4 py-2">AUD {{ number_format($order->gross_price, 2, '.', ',') }}</td>
            <td class="border px-4 py-2">{{ ucfirst($order->delivery_status) }}</td>
            <td class="border px-4 py-2">{{ $order->order_date }}</td>

            <td class="border px-4 py-2">
                {{-- Lihat detail --}}
                <a href="{{ route('dashboard.orders.show', $order->id) }}"
                    class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600">
                    Lihat Detail
                </a>

                {{-- Kondisi: Waiting + payment pending --}}
                @if($order->delivery_status === 'waiting' && $order->payment->status === 'pending')
                {{-- Terima pesanan --}}
                <form method="POST" action="{{ route('dashboard.orders.approve', $order->id) }}" class="inline-block ml-2">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded">
                        Terima
                    </button>
                </form>

                {{-- Tolak pesanan --}}
                <form method="POST" action="{{ route('dashboard.orders.reject', $order->id) }}" class="inline-block ml-2">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">
                        Tolak
                    </button>
                </form>

                {{-- Kondisi: order sedang jalan (confirmed/assigned/on_delivery) --}}
                @elseif(in_array($order->delivery_status, ['confirmed','assigned','on_delivery']))
                <form method="POST" action="{{ route('dashboard.orders.updateStatus', $order->id) }}" class="inline-block ml-2">
                    @csrf
                    @method('PATCH')
                    <select name="delivery_status" class="border rounded px-2 py-1" onchange="this.form.submit()">
                        <option value="" disabled selected>Update Status</option>
                        <option value="assigned" {{ $order->delivery_status === 'assigned' ? 'selected' : '' }}>Assigned</option>
                        <option value="on_delivery" {{ $order->delivery_status === 'on_delivery' ? 'selected' : '' }}>On Delivery</option>
                        <option value="delivered" {{ $order->delivery_status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                    </select>
                </form>

                {{-- Kondisi: sudah rejected / delivered / canceled --}}
                @elseif(in_array($order->delivery_status, ['rejected','delivered','canceled']))
                <span class="ml-2 text-gray-500">(No further actions)</span>
                @endif
            </td>
        </tr>

        {{-- Detail item pesanan --}}
        @if($order->items->count() > 0)
        <tr>
            <td colspan="6" class="border px-4 py-2 bg-gray-50">
                <strong>Pesanan:</strong>
                <ul class="list-disc list-inside">
                    @foreach($order->items as $item)
                    <li>
                        {{ $item->product->name }}
                        ({{ $item->quantity }} x AUD {{ number_format($item->unit_price, 2, '.', ',') }})
                        = AUD {{ number_format($item->total_price, 2, '.', ',') }}
                        @if($item->note)
                        <br><small>Catatan: {{ $item->note }}</small>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </td>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>
@else
<p class="mt-4">Belum ada order untuk bisnis Anda.</p>
@endif
@endsection