@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h2 class="fw-bold text-dark mb-1">Order #{{ $order->order_number }}</h2>
                    <p class="text-muted mb-0">Track your delicious Indonesian food order</p>
                </div>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Orders
                </a>
            </div>
        </div>
    </div>

    <!-- Order Status Timeline -->
    <div class="card shadow-sm border-0 mb-4" style="background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);">
        <div class="card-body p-4">
            <h5 class="text-white mb-4 fw-bold">
                <i class="fas fa-shipping-fast me-2"></i>Delivery Status
            </h5>

            @php
            $statuses = ['waiting', 'confirmed', 'assigned', 'on_delivery', 'delivered'];
            $statusLabels = [
            'waiting' => 'Order Placed',
            'confirmed' => 'Confirmed',
            'assigned' => 'Preparing',
            'on_delivery' => 'On Delivery',
            'delivered' => 'Delivered'
            ];
            $statusIcons = [
            'waiting' => 'fas fa-clock',
            'confirmed' => 'fas fa-check-circle',
            'assigned' => 'fas fa-utensils',
            'on_delivery' => 'fas fa-motorcycle',
            'delivered' => 'fas fa-home'
            ];

            $currentStatusIndex = array_search($order->delivery_status, $statuses);
            $isCanceled = $order->delivery_status === 'canceled';
            @endphp

            @if($isCanceled)
            <!-- Canceled Status -->
            <div class="d-flex align-items-center justify-content-center">
                <div class="text-center">
                    <div class="bg-danger rounded-circle p-3 mb-3 mx-auto" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-times-circle text-white" style="font-size: 2rem;"></i>
                    </div>
                    <h5 class="text-white fw-bold">Order Canceled</h5>
                    <p class="text-white-50 mb-0">This order has been canceled</p>
                </div>
            </div>
            @else
            <!-- Normal Status Timeline -->
            <div class="row">
                @foreach($statuses as $index => $status)
                <div class="col position-relative">
                    <!-- Status Item -->
                    <div class="text-center">
                        <!-- Icon Circle -->
                        <div class="mx-auto mb-2 rounded-circle d-flex align-items-center justify-content-center
                                    {{ $index <= $currentStatusIndex ? 'bg-white text-warning' : 'bg-white-50 text-muted' }}"
                            style="width: 50px; height: 50px;">
                            <i class="{{ $statusIcons[$status] }}"></i>
                        </div>

                        <!-- Status Label -->
                        <h6 class="fw-bold mb-1 {{ $index <= $currentStatusIndex ? 'text-white' : 'text-white-50' }}">
                            {{ $statusLabels[$status] }}
                        </h6>

                        @if($index == $currentStatusIndex)
                        <small class="badge bg-warning text-dark fw-bold">Current</small>
                        @endif
                    </div>

                    <!-- Connection Line -->
                    @if($index < count($statuses) - 1)
                        <div class="position-absolute top-50 translate-middle-y"
                        style="left: 75%; right: -75%; height: 3px; z-index: 1;">
                        <div class="w-100 h-100 {{ $index < $currentStatusIndex ? 'bg-white' : 'bg-white-25' }}"></div>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

<div class="row">
    <!-- Order Summary -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-receipt me-2 text-warning"></i>Order Summary
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <!-- Financial Details -->
                    <div class="col-md-6">
                        <div class="bg-light rounded p-3 h-100">
                            <h6 class="fw-bold text-dark mb-3">
                                <i class="fas fa-calculator me-2 text-warning"></i>Price Breakdown
                            </h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Subtotal:</span>
                                <span class="fw-semibold">A${{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Tax:</span>
                                <span class="fw-semibold">A${{ number_format($order->tax, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Shipping Cost:</span>
                                <span class="fw-semibold">A${{ number_format($order->shipping_cost, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Delivery Fee:</span>
                                <span class="fw-semibold">A${{ number_format($order->delivery_fee, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Order Fee:</span>
                                <span class="fw-semibold">A${{ number_format($order->order_fee, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Gross Value:</span>
                                <span class="fw-semibold">A${{ number_format($order->total_price, 2) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span class="fw-bold text-dark">Total:</span>
                                <span class="fw-bold text-warning fs-5">A${{ number_format($order->gross_price, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Order Details -->
                    <div class="col-md-6">
                        <div class="bg-light rounded p-3 h-100">
                            <h6 class="fw-bold text-dark mb-3">
                                <i class="fas fa-info-circle me-2 text-warning"></i>Order Details
                            </h6>

                            <div class="mb-3">
                                <small class="text-muted d-block">Delivery Option</small>
                                <span class="badge bg-warning text-dark px-3 py-2">
                                    <i class="fas fa-truck me-1"></i>{{ ucfirst($order->delivery_option) }}
                                </span>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block">Order Date</small>
                                <span class="fw-semibold text-dark">
                                    <i class="fas fa-calendar me-1 text-muted"></i>
                                    {{ $order->created_at->format('d M Y H:i') }}
                                </span>
                            </div>

                            <div class="mb-3">
                                <small class="text-muted d-block">Shipping Address</small>
                                <span class="text-dark">
                                    <i class="fas fa-map-marker-alt me-1 text-muted"></i>
                                    {{ $order->shipping_address ?? 'Not specified' }}
                                </span>
                            </div>

                            @if($order->delivery_note)
                            <div class="mb-3">
                                <small class="text-muted d-block">Delivery Note</small>
                                <span class="text-dark">
                                    <i class="fas fa-sticky-note me-1 text-muted"></i>
                                    {{ $order->delivery_note }}
                                </span>
                            </div>
                            @endif

                            {{-- Tambahan total weight & volume --}}
                            @php
                            $totalWeight = 0;
                            $totalVolume = 0;
                            foreach ($order->items as $item) {
                            $w = $item->product->weight ?? 0;
                            $v = $item->product->volume ?? 0;
                            $totalWeight += $w * $item->quantity;
                            $totalVolume += $v * $item->quantity;
                            }
                            @endphp

                            <div class="mt-4">
                                <small class="text-muted d-block mb-2">Order Weight & Volume</small>
                                <div class="bg-white rounded p-3 shadow-sm">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-weight text-muted me-2"></i>
                                        <span class="text-gray-800">Total Weight:</span>
                                        <span class="fw-bold ms-auto">
                                            {{ $totalWeight > 0 ? number_format($totalWeight, 2).' gr' : '-' }}
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-cube text-muted me-2"></i>
                                        <span class="text-gray-800">Total Volume:</span>
                                        <span class="fw-bold ms-auto">
                                            {{ $totalVolume > 0 ? number_format($totalVolume, 0).' cm³' : '-' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-headset me-2 text-warning"></i>Need Help?
                </h5>
            </div>
            <div class="card-body d-flex flex-column">
                <div class="text-center mb-4">
                    <i class="fas fa-phone-alt text-warning" style="font-size: 3rem;"></i>
                    <h6 class="mt-3 mb-2">Contact Support</h6>
                    <p class="text-muted small mb-0">Have questions about your order?</p>
                </div>
                <div class="mt-auto">
                    <button class="btn w-100 mb-2" style="background-color: #ff6b35; border-color: #ff6b35; color: white;">
                        <i class="fas fa-phone me-2"></i>Call Support
                    </button>
                    <button onclick="window.location.href='{{ route('chat.customer') }}'"
                        class="btn btn-outline-warning w-100">
                        <i class="fas fa-comments me-2"></i> Live Chat
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Items -->
<div class="card shadow-sm border-0">
    <div class="card-header bg-white border-bottom py-3">
        <h5 class="mb-0 fw-bold text-dark">
            <i class="fas fa-utensils me-2 text-warning"></i>Order Items
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="border-0 py-3 px-4 fw-bold text-dark">Product</th>
                        <th class="border-0 py-3 fw-bold text-dark">Options</th>
                        <th class="border-0 py-3 fw-bold text-dark">Note</th>
                        <th class="border-0 py-3 fw-bold text-dark text-center">Qty</th>
                        <th class="border-0 py-3 fw-bold text-dark text-end">Unit Price</th>
                        <th class="border-0 py-3 fw-bold text-dark text-end px-4">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    @php
                    $unitWeight = $item->product->weight ?? 0;
                    $unitVolume = $item->product->volume ?? 0;
                    $totalWeight = $unitWeight * $item->quantity;
                    $totalVolume = $unitVolume * $item->quantity;
                    @endphp
                    <tr class="border-bottom">
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                    <i class="fas fa-bowl-rice text-warning"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-semibold text-dark">{{ $item->product->name ?? 'Product not found' }}</h6>
                                    <small class="text-muted d-block mt-1">
                                        <i class="fas fa-weight me-1"></i>
                                        {{ $unitWeight > 0 ? number_format($unitWeight, 2).' gr' : '-' }} per unit
                                        &nbsp;|&nbsp;
                                        <i class="fas fa-cube me-1"></i>
                                        {{ $unitVolume > 0 ? number_format($unitVolume, 0).' cm³' : '-' }} per unit
                                    </small>
                                    <small class="text-muted d-block">
                                        <i class="fas fa-weight me-1"></i>
                                        {{ $totalWeight > 0 ? number_format($totalWeight, 2).' gr' : '-' }} total
                                        &nbsp;|&nbsp;
                                        <i class="fas fa-cube me-1"></i>
                                        {{ $totalVolume > 0 ? number_format($totalVolume, 0).' cm³' : '-' }} total
                                    </small>
                                </div>
                            </div>
                        </td>

                        <td class="py-3" style="max-width: 250px;">
                            @if(!empty($item->options_for_view))
                            <div class="small">
                                @foreach($item->options_for_view as $group)
                                <div class="mb-1">
                                    <span class="fw-semibold text-dark">{{ $group['group_name'] ?? 'Option' }}:</span>
                                    <div class="ms-2">
                                        @foreach($group['items'] as $opt)
                                        <div class="text-muted">
                                            • {{ $opt['name'] ?? 'Unnamed Option' }}
                                            @if(isset($opt['price']) && $opt['price'] > 0)
                                            <span class="text-success">(+${{ number_format($opt['price'], 2) }})</span>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <span class="text-muted">No options</span>
                            @endif
                        </td>

                        <td class="py-3">
                            @if($item->note)
                            <div class="small">
                                <i class="fas fa-comment-alt text-muted me-1"></i>
                                <span class="text-muted">{{ $item->note }}</span>
                            </div>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>

                        <td class="py-3 text-center">
                            <span class="badge bg-light text-dark px-3 py-2 fw-semibold">{{ $item->quantity }}</span>
                        </td>

                        <td class="py-3 text-end">
                            <span class="fw-semibold text-dark">A${{ number_format($item->unit_price, 2) }}</span>
                        </td>

                        <td class="py-3 text-end px-4">
                            <span class="fw-bold text-warning fs-6">A${{ number_format($item->total_price, 2) }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<style>
    .bg-white-50 {
        background-color: rgba(255, 255, 255, 0.5) !important;
    }

    .bg-white-25 {
        background-color: rgba(255, 255, 255, 0.25) !important;
    }

    .text-white-50 {
        color: rgba(255, 255, 255, 0.5) !important;
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .table-hover tbody tr:hover {
        background-color: #fff8f0;
    }

    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.875rem;
        }

        .card-body {
            padding: 1rem;
        }
    }
</style>

@endsection