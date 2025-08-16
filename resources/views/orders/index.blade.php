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
                    <th>Action</th>
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
                    <td>
                        @if($order->delivery_status === 'delivered')
                            @if(!$order->testimonial)
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#reviewModal-{{ $order->id }}">
                                    Berikan Ulasan
                                </button>
                            @else
                                <span class="badge bg-secondary">Sudah direview</span>
                            @endif
                        @endif
                    </td>
                </tr>

                {{-- Modal Review --}}
                @if($order->delivery_status === 'delivered' && !$order->testimonial)
                <div class="modal fade" id="reviewModal-{{ $order->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="{{ route('partner.orders.review.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <input type="hidden" name="business_id" value="{{ $order->business_id }}">

                                <div class="modal-header">
                                    <h5 class="modal-title">Berikan Ulasan untuk Order #{{ $order->id }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    {{-- Rating --}}
                                    <div class="mb-3">
                                        <label class="form-label">Rating</label>
                                        <select name="rating" class="form-control" required>
                                            <option value="">-- Pilih Rating --</option>
                                            <option value="5">⭐⭐⭐⭐⭐</option>
                                            <option value="4">⭐⭐⭐⭐</option>
                                            <option value="3">⭐⭐⭐</option>
                                            <option value="2">⭐⭐</option>
                                            <option value="1">⭐</option>
                                        </select>
                                    </div>

                                    {{-- Deskripsi --}}
                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi</label>
                                        <textarea name="description" class="form-control" rows="3" required></textarea>
                                    </div>

                                    {{-- Upload multiple images --}}
                                    <div class="mb-3">
                                        <label class="form-label">Foto Produk (opsional)</label>
                                        <input type="file" name="images[]" class="form-control" multiple>
                                    </div>

                                    {{-- List items --}}
                                    <div class="mb-3">
                                        <label class="form-label">Produk yang dipesan</label>
                                        <ul class="list-group">
                                            @foreach($order->items as $item)
                                                <li class="list-group-item">
                                                    {{ $item->product->name ?? 'Unknown Product' }} (x{{ $item->quantity }})
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-success">Kirim Ulasan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
                {{-- End Modal --}}
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
