<!-- resources/views/dashboard/orders/show.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header Section -->
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Order #{{ $order->order_number }}</h4>
            <p class="text-muted mb-0">Track your delicious Indonesian food order</p>
        </div>
        <div class="d-flex gap-2">
            {{-- Notifications Button --}}
            <a href="{{ route('notifications.index') }}" class="btn btn-outline-secondary position-relative">
                <i class="fas fa-bell me-2"></i>Notifications

                @php
                $unread = 0;
                $unreadMessages = 0;
                $activeOrders = 0;

                if (auth()->check()) {
                // unread notifications
                $unread = auth()->user()->notifications()->where('is_read', false)->count();

                // unread messages
                $unreadMessages = \App\Models\Message::where('is_read', false)
                ->whereHas('chat', function ($query) {
                $query->where('user_one_id', auth()->id())
                ->orWhere('user_two_id', auth()->id());
                })
                ->where('sender_id', '!=', auth()->id())
                ->count();

                // active orders
                $activeOrders = \App\Models\Order::where('user_id', auth()->id())
                ->whereIn('delivery_status', ['waiting', 'confirmed', 'assigned', 'on_delivery'])
                ->count();
                }

                $totalNotif = $unread + $unreadMessages + $activeOrders;
                @endphp

                @if ($totalNotif > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $totalNotif }}
                </span>
                @endif
            </a>
            <a href="{{ route('chat.partner') }}" class="btn btn-warning text-white">
                <i class="fas fa-comments me-2"></i>Chat Support
            </a>
            <button class="btn btn-outline-secondary" onclick="window.history.back()">
                <i class="fas fa-arrow-left me-2"></i>Back to Orders
            </button>
        </div>
    </div>

    <!-- Delivery Status -->
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
                    <div class="bg-danger rounded-circle p-3 mb-3 mx-auto"
                        style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
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
                    <div class="text-center">
                        <!-- Icon Circle -->
                        <div class="mx-auto mb-2 rounded-circle d-flex align-items-center justify-content-center
                                {{ $index <= $currentStatusIndex ? 'bg-white text-warning' : 'bg-white bg-opacity-50 text-white-50' }}"
                            style="width: 50px; height: 50px;">
                            <i class="{{ $statusIcons[$status] }}"></i>
                        </div>

                        <!-- Label -->
                        <h6 class="fw-bold mb-1 {{ $index <= $currentStatusIndex ? 'text-white' : 'text-white-50' }}">
                            {{ $statusLabels[$status] }}
                        </h6>

                        @if($index == $currentStatusIndex)
                        <small class="badge bg-warning text-dark fw-bold">Current</small>
                        @endif
                    </div>

                    <!-- Connector Line -->
                    @if($index < count($statuses) - 1)
                        <div class="position-absolute top-50 translate-middle-y"
                        style="left: 75%; right: -75%; height: 3px; z-index: 1;">
                        <div class="w-100 h-100 {{ $index < $currentStatusIndex ? 'bg-white' : 'bg-white bg-opacity-25' }}"></div>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>


<div class="row g-4">
    <!-- Order Summary -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="fw-bold mb-0">
                <i class="fas fa-receipt text-warning me-2"></i>Order Summary
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-bold text-warning mb-3">
                        <i class="fas fa-calculator me-1"></i>Price Breakdown
                    </h6>
                    <div class="bg-light rounded p-3">
                        <div class="d-flex justify-content-between py-2">
                            <span>Subtotal:</span>
                            <span class="fw-medium">A${{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-2">
                            <span>Tax:</span>
                            <span class="fw-medium">A${{ number_format($order->tax, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-2">
                            <span>Shipping Cost:</span>
                            <span class="fw-medium">A${{ number_format($order->shipping_cost, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-2">
                            <span>Delivery Fee:</span>
                            <span class="fw-medium">A${{ number_format($order->delivery_fee, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-2">
                            <span>Order Fee:</span>
                            <span class="fw-medium">A${{ number_format($order->order_fee, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-2">
                            <span>Customer Paid (Gross Value + Stripe Fee):</span>
                            <span class="fw-medium">A${{ number_format($order->gross_price, 2) }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between py-2">
                            <span class="fw-bold">Net Payout:</span>
                            <span class="fw-bold text-warning fs-5">A${{ number_format($order->total_price - $order->order_fee, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <h6 class="fw-bold text-warning mb-3">
                        <i class="fas fa-info-circle me-1"></i>Order Details
                    </h6>
                    <div class="mb-3">
                        <label class="small text-muted fw-bold mb-1">Delivery Option</label>
                        <div>
                            <span class="badge bg-warning text-dark px-3 py-2">
                                <i class="fas fa-truck me-1"></i>{{ ucfirst($order->delivery_option) }}
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="small text-muted fw-bold mb-1">Order Date</label>
                        <div class="fw-medium">
                            <i class="fas fa-calendar-alt text-muted me-2"></i>{{ $order->created_at->format('d M Y H:i') }}
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="small text-muted fw-bold mb-1">Shipping Address</label>
                        <div class="fw-medium">
                            <i class="fas fa-map-marker-alt text-muted me-2"></i>{{ $order->shipping_address ?? 'No address provided' }}
                        </div>
                        @if($order->shipping_lat && $order->shipping_lng)
                        <a href="https://www.google.com/maps/search/?api=1&query={{ $order->shipping_lat }},{{ $order->shipping_lng }}"
                            target="_blank"
                            class="btn btn-sm btn-outline-warning mt-2">
                            <i class="fas fa-external-link-alt me-1"></i>View on Maps
                        </a>
                        @elseif($order->shipping_address)
                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($order->shipping_address) }}"
                            target="_blank"
                            class="btn btn-sm btn-outline-warning mt-2">
                            <i class="fas fa-external-link-alt me-1"></i>View on Maps
                        </a>
                        @endif
                    </div>
                    @if($order->delivery_note)
                    <div class="mb-0">
                        <label class="small text-muted fw-bold mb-1">Delivery Note</label>
                        <div class="bg-light rounded p-2">
                            <small>{{ $order->delivery_note }}</small>
                        </div>
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
                    <div class="mb-3">
                        <label class="small text-muted fw-bold mb-1">Order Weight & Volume</label>
                        <div class="bg-light rounded p-3">
                            <div class="fw-medium text-gray-800 mb-1">
                                <i class="fas fa-weight text-muted me-2"></i>Total Weight:
                                <span class="fw-bold">{{ $totalWeight > 0 ? number_format($totalWeight, 2).' gr' : '-' }}</span>
                            </div>
                            <div class="fw-medium text-gray-800">
                                <i class="fas fa-cube text-muted me-2"></i>Total Volume:
                                <span class="fw-bold">{{ $totalVolume > 0 ? number_format($totalVolume, 0).' cm³' : '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="fw-bold mb-0">
                <i class="fas fa-utensils text-warning me-2"></i>Order Items
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 py-3 px-4">Product</th>
                            {{-- Kolom baru --}}
                            <th class="border-0 py-3 px-4">Weight / Volume</th>
                            <th class="border-0 py-3 px-4">Options</th>
                            <th class="border-0 py-3 px-4">Note</th>
                            <th class="border-0 py-3 px-4">Preference</th>
                            <th class="border-0 py-3 px-4 text-center">Qty</th>
                            <th class="border-0 py-3 px-4 text-end">Unit Price</th>
                            <th class="border-0 py-3 px-4 text-end">Total</th>
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
                        <tr>
                            <td class="py-3 px-4">
                                <div class="d-flex align-items-center">
                                    <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                        <i class="fas fa-bowl-food text-white"></i>
                                    </div>
                                    <div class="fw-medium">{{ $item->product->name ?? 'Product not found' }}</div>
                                </div>
                            </td>

                            {{-- Kolom baru Weight/Volume --}}
                            <td class="py-3 px-4">
                                <small class="d-block text-muted">
                                    <strong>Per Unit:</strong>
                                    {{ $unitWeight > 0 ? number_format($unitWeight,2).' gr' : '-' }} /
                                    {{ $unitVolume > 0 ? number_format($unitVolume,0).' cm³' : '-' }}
                                </small>
                                <small class="d-block text-muted">
                                    <strong>Total ({{ $item->quantity }}x):</strong>
                                    {{ $totalWeight > 0 ? number_format($totalWeight,2).' gr' : '-' }} /
                                    {{ $totalVolume > 0 ? number_format($totalVolume,0).' cm³' : '-' }}
                                </small>
                            </td>

                            <td class="py-3 px-4">
                                @if(!empty($item->options_for_view))
                                <div class="small">
                                    @foreach($item->options_for_view as $group)
                                    <div class="mb-1">
                                        <strong class="text-warning">{{ $group['group_name'] ?? 'Unnamed Group' }}</strong>
                                        @if(count($group['items']) == 1)
                                        <span class="text-muted">:</span>
                                        @endif
                                        <br>
                                        @foreach($group['items'] as $opt)
                                        <span class="text-muted">
                                            • {{ $opt['name'] ?? 'Unnamed Option' }}
                                            @if(isset($opt['price']) && $opt['price'] > 0)
                                            <span class="text-success">(+${{ number_format($opt['price'], 2) }})</span>
                                            @endif
                                        </span><br>
                                        @endforeach
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td class="py-3 px-4">
                                @if($item->note)
                                <small class="text-muted">{{ $item->note }}</small>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                @if($item->preference_if_unavailable)
                                <small class="text-info">{{ $item->preference_if_unavailable }}</small>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="badge bg-warning text-dark">{{ $item->quantity }}</span>
                            </td>
                            <td class="py-3 px-4 text-end">
                                A${{ number_format($item->unit_price, 2) }}
                            </td>
                            <td class="py-3 px-4 text-end fw-bold text-warning">
                                A${{ number_format($item->total_price, 2) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Custom Styles -->
<style>
    .card {
        border-radius: 12px !important;
    }

    .btn {
        border-radius: 8px;
        font-weight: 500;
    }

    .btn-warning {
        background: linear-gradient(45deg, #f59e0b, #f97316);
        border: none;
    }

    .btn-warning:hover {
        background: linear-gradient(45deg, #d97706, #ea580c);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
    }

    .text-warning {
        color: #f59e0b !important;
    }

    .bg-warning {
        background-color: #f59e0b !important;
    }

    .badge.bg-warning {
        background-color: #f59e0b !important;
    }

    .table th {
        font-weight: 600;
        color: #6b7280;
    }

    .table td {
        vertical-align: middle;
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .row.text-center .col {
            font-size: 0.875rem;
        }

        .table-responsive {
            font-size: 0.875rem;
        }
    }
</style>
@endsection