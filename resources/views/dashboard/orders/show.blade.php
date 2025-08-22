@extends('layouts.app')

@section('content')
@include('dashboard.partials.navbar')

<!-- Header Section with Order Info -->
<div class="bg-gradient-to-r from-orange-500 to-amber-500 rounded-3xl p-6 mb-8 shadow-xl">
    <div class="row align-items-center text-white">
        <div class="col-md-8">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-white bg-opacity-20 p-3 rounded-xl me-4">
                    <i class="fas fa-receipt fa-2x text-black"></i>
                </div>
                <div>
                    <h1 class="text-4xl font-bold mb-1">Order #{{ $order->order_number }}</h1>
                    <p class="text-orange-100 opacity-90 mb-0">ID: {{ $order->id }} • {{ $order->order_date->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-end">
            <div class="bg-black bg-opacity-20 p-4 rounded-xl backdrop-blur-sm">
                <div class="fs-3 fw-bold mb-1">${{ number_format($order->gross_price, 2) }} AUD</div>
                <div class="text-orange-100 opacity-90">Total Amount</div>
            </div>
        </div>
    </div>
</div>

<!-- Order Status Flow -->
<div class="card border-0 shadow-xl rounded-3xl mb-6 overflow-hidden">
    <div class="card-header bg-gradient-to-r from-orange-50 to-amber-50 border-0 p-4">
        <h5 class="fw-bold text-gray-800 mb-0 d-flex align-items-center">
            <i class="fas fa-route text-orange-500 me-2"></i>
            Order Status Progress
        </h5>
    </div>
    <div class="card-body p-5">
        @php
        $statusFlow = [
        'waiting' => ['icon' => 'fas fa-clock', 'label' => 'Waiting', 'color' => '#f59e0b'],
        'confirmed' => ['icon' => 'fas fa-check-circle', 'label' => 'Confirmed', 'color' => '#10b981'],
        'assigned' => ['icon' => 'fas fa-user-chef', 'label' => 'Assigned', 'color' => '#3b82f6'],
        'on_delivery' => ['icon' => 'fas fa-truck', 'label' => 'On Delivery', 'color' => '#8b5cf6'],
        'delivered' => ['icon' => 'fas fa-box', 'label' => 'Delivered', 'color' => '#06b6d4']
        ];

        $currentStatus = $order->delivery_status;
        $isCanceled = $currentStatus === 'canceled';
        $isRejected = $currentStatus === 'rejected';

        // Determine which steps are completed
        $statusOrder = ['waiting', 'confirmed', 'assigned', 'on_delivery', 'delivered'];
        $currentIndex = array_search($currentStatus, $statusOrder);
        @endphp

        @if($isCanceled)
        <!-- Canceled Status Display -->
        <div class="text-center p-4">
            <div class="bg-red-100 rounded-full mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                <i class="fas fa-times-circle fa-3x text-red-500"></i>
            </div>
            <h4 class="text-red-600 fw-bold mb-2">Order Canceled</h4>
            <p class="text-gray-600">This order has been canceled and cannot proceed further.</p>
        </div>
        @elseif($isRejected)
        <!-- Rejected Status Display -->
        <div class="text-center p-4">
            <div class="bg-red-100 rounded-full mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                <i class="fas fa-ban fa-3x text-red-500"></i>
            </div>
            <h4 class="text-red-600 fw-bold mb-2">Order Rejected</h4>
            <p class="text-gray-600">This order has been rejected and cannot proceed further.</p>
        </div>
        @else
        <!-- Normal Status Flow -->
        <div class="row justify-content-center">
            @foreach($statusFlow as $status => $config)
            @php
            $isActive = $status === $currentStatus;
            $isCompleted = $currentIndex !== false && array_search($status, $statusOrder) <= $currentIndex;
                $isPending=!$isCompleted && !$isActive;
                @endphp

                <div class="col-auto d-flex flex-column align-items-center position-relative">
                <!-- Status Circle -->
                <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 status-circle
                            {{ $isActive ? 'active' : ($isCompleted ? 'completed' : 'pending') }}"
                    style="width: 80px; height: 80px; 
                            background: {{ $isActive ? 'linear-gradient(135deg, ' . $config['color'] . ', ' . $config['color'] . 'cc)' : 
                                          ($isCompleted ? 'linear-gradient(135deg, #10b981, #059669)' : '#e5e7eb') }};
                            border: 4px solid {{ $isActive ? $config['color'] : ($isCompleted ? '#10b981' : '#d1d5db') }};
                            box-shadow: {{ $isActive ? '0 0 20px ' . $config['color'] . '40' : 'none' }};">

                    @if($isCompleted && !$isActive)
                    <i class="fas fa-check fa-xl text-white"></i>
                    @else
                    <i class="{{ str_replace('fa-user-chef', 'fas fa-user-tie', $config['icon']) }} fa-xl 
                                    {{ $isActive || $isCompleted ? 'text-white' : 'text-gray-500' }}"></i>
                    @endif
                </div>

                <!-- Status Label -->
                <div class="text-center">
                    <div class="fw-bold mb-1 {{ $isActive ? 'text-' . $config['color'] : ($isCompleted ? 'text-green-600' : 'text-gray-500') }}">
                        {{ $config['label'] }}
                    </div>
                    @if($isActive)
                    <small class="badge bg-gradient-to-r from-orange-500 to-amber-500 text-white px-3 py-1 rounded-pill">
                        Current Status
                    </small>
                    @elseif($isCompleted)
                    <small class="text-green-600">✓ Complete</small>
                    @else
                    <small class="text-gray-400">Pending</small>
                    @endif
                </div>

                <!-- Connection Arrow -->
                @if(!$loop->last)
                <div class="position-absolute status-arrow" style="right: -60px; top: 35px;">
                    <i class="fas fa-arrow-right fa-lg {{ $isCompleted ? 'text-green-500' : 'text-gray-300' }}"></i>
                </div>
                @endif
        </div>
        @endforeach
    </div>
    @endif
</div>
</div>

<!-- Customer & Order Info -->
<div class="row g-4 mb-6">
    <div class="col-md-6">
        <div class="card border-0 shadow-lg rounded-3xl h-100">
            <div class="card-header bg-gradient-to-r from-blue-50 to-indigo-50 border-0 p-4">
                <h5 class="fw-bold text-gray-800 mb-0 d-flex align-items-center">
                    <i class="fas fa-user-circle text-blue-500 me-2"></i>
                    Customer Information
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-gradient-to-br from-blue-400 to-indigo-500 rounded-circle d-flex align-items-center justify-content-center me-3"
                        style="width: 60px; height: 60px;">
                        <span class="text-white fw-bold fs-4">{{ substr($order->user->name ?? 'N/A', 0, 1) }}</span>
                    </div>
                    <div>
                        <h6 class="fw-bold text-gray-800 mb-1">{{ $order->user->name ?? 'Unknown Customer' }}</h6>
                        <small class="text-gray-500">Customer ID: {{ $order->user->id ?? 'N/A' }}</small>
                    </div>
                </div>

                <div class="border-top pt-3">
                    <div class="mb-3">
                        <label class="fw-semibold text-gray-700 mb-1">Delivery Option:</label>
                        <div class="d-flex align-items-center">
                            <i class="fas {{ $order->delivery_option === 'delivery' ? 'fa-truck' : 'fa-store' }} text-orange-500 me-2"></i>
                            <span class="badge bg-orange-100 text-orange-800 px-3 py-2 rounded-pill">
                                {{ ucfirst($order->delivery_option) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-lg rounded-3xl h-100">
            <div class="card-header bg-gradient-to-r from-green-50 to-emerald-50 border-0 p-4">
                <h5 class="fw-bold text-gray-800 mb-0 d-flex align-items-center">
                    <i class="fas fa-map-marker-alt text-green-500 me-2"></i>
                    Delivery Information
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <label class="fw-semibold text-gray-700 mb-2">Shipping Address:</label>
                    <div class="bg-gray-50 p-3 rounded-xl">
                        <p class="text-gray-800 mb-2">{{ $order->shipping_address ?? 'No address provided' }}</p>

                        @if($order->shipping_lat && $order->shipping_lng)
                        <a href="https://www.google.com/maps/search/?api=1&query={{ $order->shipping_lat }},{{ $order->shipping_lng }}"
                            target="_blank"
                            class="btn btn-sm btn-outline-primary rounded-pill">
                            <i class="fas fa-map-marked-alt me-1"></i>View on Google Maps
                        </a>
                        @elseif($order->shipping_address)
                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($order->shipping_address) }}"
                            target="_blank"
                            class="btn btn-sm btn-outline-primary rounded-pill">
                            <i class="fas fa-map-marked-alt me-1"></i>Search on Google Maps
                        </a>
                        @endif
                    </div>
                </div>

                @if($order->delivery_note)
                <div>
                    <label class="fw-semibold text-gray-700 mb-2">Delivery Note:</label>
                    <div class="bg-yellow-50 p-3 rounded-xl border-l-4 border-yellow-400">
                        <p class="text-gray-800 mb-0">{{ $order->delivery_note }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Order Summary -->
<div class="card border-0 shadow-xl rounded-3xl mb-6 overflow-hidden">
    <div class="card-header bg-gradient-to-r from-purple-50 to-pink-50 border-0 p-4">
        <h5 class="fw-bold text-gray-800 mb-0 d-flex align-items-center">
            <i class="fas fa-calculator text-purple-500 me-2"></i>
            Order Summary
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-sm mb-0" style="font-size: 16px;">
                <tbody>
                    <tr class="border-bottom">
                        <td class="px-4 py-3 fw-semibold text-gray-700">
                            <i class="fas fa-shopping-cart text-orange-500 me-2"></i>Subtotal
                        </td>
                        <td class="px-4 py-3 text-end fw-bold">${{ number_format($order->subtotal, 2) }} AUD</td>
                    </tr>
                    <tr class="border-bottom">
                        <td class="px-4 py-3 fw-semibold text-gray-700">
                            <i class="fas fa-percentage text-orange-500 me-2"></i>Tax
                        </td>
                        <td class="px-4 py-3 text-end fw-bold">${{ number_format($order->tax, 2) }} AUD</td>
                    </tr>
                    <tr class="border-bottom">
                        <td class="px-4 py-3 fw-semibold text-gray-700">
                            <i class="fas fa-truck text-orange-500 me-2"></i>Delivery Fee
                        </td>
                        <td class="px-4 py-3 text-end fw-bold">${{ number_format($order->delivery_fee, 2) }} AUD</td>
                    </tr>
                    <tr class="border-bottom">
                        <td class="px-4 py-3 fw-semibold text-gray-700">
                            <i class="fas fa-receipt text-orange-500 me-2"></i>Order Fee
                        </td>
                        <td class="px-4 py-3 text-end fw-bold">${{ number_format($order->order_fee, 2) }} AUD</td>
                    </tr>
                    <tr class="bg-gradient-to-r from-orange-50 to-amber-50">
                        <td class="px-4 py-4 fw-bold text-gray-800 fs-5">
                            <i class="fas fa-money-bill-wave text-orange-500 me-2"></i>Total Price
                        </td>
                        <td class="px-4 py-4 text-end fw-bold text-orange-600 fs-4">${{ number_format($order->gross_price, 2) }} AUD</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Order Items -->
<div class="card border-0 shadow-xl rounded-3xl mb-6 overflow-hidden">
    <div class="card-header bg-gradient-to-r from-orange-50 to-amber-50 border-0 p-4">
        <h5 class="fw-bold text-gray-800 mb-0 d-flex align-items-center">
            <i class="fas fa-utensils text-orange-500 me-2"></i>
            Order Items ({{ $order->items->count() }} items)
        </h5>
    </div>
    <div class="card-body p-4">
        <div class="row g-4">
            @foreach($order->items as $item)
            <div class="col-12">
                <div class="border rounded-3xl p-4 bg-gradient-to-r from-gray-50 to-orange-25 hover:shadow-md transition-all duration-200">
                    <div class="row align-items-start">
                        <div class="col-md-3">
                            <div class="d-flex align-items-center mb-2">
                                <div class="bg-gradient-to-br from-orange-400 to-amber-500 rounded-circle d-flex align-items-center justify-content-center me-3"
                                    style="width: 50px; height: 50px;">
                                    <i class="fas fa-utensils text-white"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-gray-800 mb-1">{{ $item->product->name ?? 'Product not found' }}</h6>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-orange-100 text-orange-800">{{ $item->quantity }}x</span>
                                        <span class="text-gray-600">${{ number_format($item->unit_price, 2) }} each</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            @if(!empty($item->options_for_view))
                            <div class="mb-2">
                                <label class="fw-semibold text-gray-700 mb-1">Options:</label>
                                @foreach($item->options_for_view as $group)
                                <div class="bg-white p-2 rounded-lg mb-2 border">
                                    <div class="fw-semibold text-sm text-gray-800">{{ $group['group_name'] ?? 'Unnamed Group' }}</div>
                                    @foreach($group['items'] as $opt)
                                    <div class="text-xs text-gray-600 ms-2">
                                        • {{ $opt['name'] ?? 'Unnamed Option' }}
                                        @if(isset($opt['price']) && $opt['price'] > 0)
                                        <span class="text-green-600">(+${{ number_format($opt['price'], 2) }})</span>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>

                        <div class="col-md-2">
                            @if($item->preference_if_unavailable)
                            <div class="mb-2">
                                <label class="fw-semibold text-gray-700 mb-1">If Unavailable:</label>
                                <div class="bg-blue-50 p-2 rounded-lg border-l-3 border-blue-400">
                                    <small class="text-blue-800">{{ $item->preference_if_unavailable }}</small>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="col-md-2">
                            @if($item->note)
                            <div class="mb-2">
                                <label class="fw-semibold text-gray-700 mb-1">Special Note:</label>
                                <div class="bg-yellow-50 p-2 rounded-lg border-l-3 border-yellow-400">
                                    <small class="text-yellow-800">{{ $item->note }}</small>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="col-md-2 text-end">
                            <div class="fw-bold text-orange-600 fs-5">${{ number_format($item->total_price, 2) }} AUD</div>
                            <small class="text-gray-500">Total</small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Actions Section -->
<div class="card border-0 shadow-xl rounded-3xl mb-6 overflow-hidden">
    <div class="card-header bg-gradient-to-r from-indigo-50 to-purple-50 border-0 p-4">
        <h5 class="fw-bold text-gray-800 mb-0 d-flex align-items-center">
            <i class="fas fa-cogs text-indigo-500 me-2"></i>
            Order Actions
        </h5>
    </div>
    <div class="card-body p-4">
        <div class="d-flex flex-wrap gap-3 align-items-center">
            <!-- Current Status Display -->
            <div class="me-4">
                <label class="fw-semibold text-gray-700 mb-2 d-block">Current Status:</label>
                @php
                $statusConfig = [
                'waiting' => ['class' => 'bg-yellow-100 text-yellow-800 border-yellow-200', 'icon' => '⏳'],
                'confirmed' => ['class' => 'bg-green-100 text-green-800 border-green-200', 'icon' => '✅'],
                'on_delivery' => ['class' => 'bg-blue-100 text-blue-800 border-blue-200', 'icon' => '🚚'],
                'delivered' => ['class' => 'bg-purple-100 text-purple-800 border-purple-200', 'icon' => '📦'],
                'assigned' => ['class' => 'bg-orange-100 text-orange-800 border-orange-200', 'icon' => '👨‍🍳'],
                'canceled' => ['class' => 'bg-red-100 text-red-800 border-red-200', 'icon' => '❌'],
                'rejected' => ['class' => 'bg-red-100 text-red-800 border-red-200', 'icon' => '🚫'],
                ];
                $config = $statusConfig[$order->delivery_status] ?? ['class' => 'bg-gray-100 text-gray-800 border-gray-200', 'icon' => '❓'];
                @endphp
                <span class="badge {{ $config['class'] }} border px-4 py-2 fs-6 fw-bold">
                    {{ $config['icon'] }} {{ ucfirst(str_replace('_', ' ', $order->delivery_status)) }}
                </span>
            </div>

            <!-- Action Buttons -->
            @if($order->delivery_status === 'waiting' && $order->payment->status === 'pending')
            <div class="d-flex gap-3">
                <form method="POST" action="{{ route('dashboard.orders.approve', $order->id) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-lg px-5 py-3 fw-bold rounded-xl shadow-lg transition-all duration-200 hover:shadow-xl transform hover:scale-105"
                        style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none;">
                        <i class="fas fa-check me-2"></i>Accept Order
                    </button>
                </form>

                <form method="POST" action="{{ route('dashboard.orders.reject', $order->id) }}">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-lg px-5 py-3 fw-bold rounded-xl shadow-lg transition-all duration-200 hover:shadow-xl transform hover:scale-105"
                        style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border: none;">
                        <i class="fas fa-times me-2"></i>Reject Order
                    </button>
                </form>
            </div>
            @elseif(in_array($order->delivery_status, ['confirmed', 'assigned', 'on_delivery']))
            <form method="POST" action="{{ route('dashboard.orders.updateStatus', $order->id) }}">
                @csrf
                @method('PATCH')
                <div class="d-flex align-items-center gap-3">
                    <label class="fw-semibold text-gray-700 mb-0">Update Status:</label>
                    <select name="delivery_status" class="form-select form-select-lg border-2 rounded-xl fw-semibold transition-all duration-200 hover:border-orange-400 focus:border-orange-500"
                        style="border-color: #fed7aa; min-width: 200px;" onchange="this.form.submit()">
                        <option value="" disabled selected>Choose new status</option>
                        @foreach($allowedStatuses as $status)
                        <option value="{{ $status }}" {{ $order->delivery_status === $status ? 'selected' : '' }}>
                            @switch($status)
                            @case('assigned') 👨‍🍳 Assigned to Chef @break
                            @case('on_delivery') 🚚 On Delivery @break
                            @case('delivered') 📦 Delivered @break
                            @default {{ ucfirst(str_replace('_', ' ', $status)) }}
                            @endswitch
                        </option>
                        @endforeach
                    </select>
                </div>
            </form>
            @elseif(in_array($order->delivery_status, ['rejected', 'delivered', 'canceled']))
            <div class="text-gray-500 fst-italic fw-semibold d-flex align-items-center">
                <i class="fas fa-info-circle me-2"></i>
                Order {{ $order->delivery_status }} - No further actions available
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Back Button -->
<div class="text-center">
    <a href="{{ route('dashboard.orders') }}" class="btn btn-lg px-6 py-3 fw-bold rounded-xl shadow-lg transition-all duration-200 hover:shadow-xl transform hover:scale-105"
        style="background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%); color: white; border: none;">
        <i class="fas fa-arrow-left me-2"></i>Back to Orders List
    </a>
</div>

<style>
    /* Status Flow Styles */
    .status-circle {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .status-circle.active {
        animation: pulse-glow 2s infinite;
    }

    .status-circle.completed {
        background: linear-gradient(135deg, #10b981, #059669) !important;
        border-color: #10b981 !important;
    }

    .status-circle.pending {
        background: #e5e7eb !important;
        border-color: #d1d5db !important;
    }

    @keyframes pulse-glow {

        0%,
        100% {
            box-shadow: 0 0 20px rgba(249, 115, 22, 0.4);
        }

        50% {
            box-shadow: 0 0 30px rgba(249, 115, 22, 0.6);
        }
    }

    .status-arrow {
        z-index: 1;
    }

    /* Custom gradient backgrounds */
    .from-gray-50 {
        --tw-gradient-from: #f9fafb;
        --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(249, 250, 251, 0));
    }

    .to-orange-25 {
        --tw-gradient-to: #fffbf5;
    }

    .from-blue-50 {
        --tw-gradient-from: #eff6ff;
        --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(239, 246, 255, 0));
    }

    .to-indigo-50 {
        --tw-gradient-to: #eef2ff;
    }

    .from-green-50 {
        --tw-gradient-from: #f0fdf4;
        --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(240, 253, 244, 0));
    }

    .to-emerald-50 {
        --tw-gradient-to: #ecfdf5;
    }

    .from-purple-50 {
        --tw-gradient-from: #faf5ff;
        --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(250, 245, 255, 0));
    }

    .to-pink-50 {
        --tw-gradient-to: #fdf2f8;
    }

    .from-indigo-50 {
        --tw-gradient-from: #eef2ff;
        --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(238, 242, 255, 0));
    }

    .to-purple-50 {
        --tw-gradient-to: #faf5ff;
    }

    /* Custom colors */
    .text-blue-500 {
        color: #3b82f6;
    }

    .text-green-500 {
        color: #10b981;
    }

    .text-purple-500 {
        color: #8b5cf6;
    }

    .text-indigo-500 {
        color: #6366f1;
    }

    .text-green-600 {
        color: #059669;
    }

    .bg-blue-50 {
        background-color: #eff6ff;
    }

    .bg-yellow-50 {
        background-color: #fffbeb;
    }

    .bg-blue-100 {
        background-color: #dbeafe;
    }

    .bg-yellow-100 {
        background-color: #fef3c7;
    }

    .bg-green-100 {
        background-color: #dcfce7;
    }

    .bg-purple-100 {
        background-color: #f3e8ff;
    }

    .bg-red-100 {
        background-color: #fee2e2;
    }

    .bg-orange-100 {
        background-color: #ffedd5;
    }

    .bg-gray-100 {
        background-color: #f3f4f6;
    }

    /* Custom text colors */
    .text-yellow-800 {
        color: #92400e;
    }

    .text-green-800 {
        color: #166534;
    }

    .text-blue-800 {
        color: #1e40af;
    }

    .text-purple-800 {
        color: #6b21a8;
    }

    .text-red-800 {
        color: #991b1b;
    }

    .text-orange-800 {
        color: #9a3412;
    }

    .text-gray-800 {
        color: #1f2937;
    }

    .text-gray-700 {
        color: #374151;
    }

    .text-gray-600 {
        color: #4b5563;
    }

    .text-gray-500 {
        color: #6b7280;
    }

    .text-gray-400 {
        color: #9ca3af;
    }

    /* Custom border colors */
    .border-yellow-200 {
        border-color: #fde68a;
    }

    .border-green-200 {
        border-color: #bbf7d0;
    }

    .border-blue-200 {
        border-color: #bfdbfe;
    }

    .border-purple-200 {
        border-color: #e9d5ff;
    }

    .border-red-200 {
        border-color: #fecaca;
    }

    .border-orange-200 {
        border-color: #fed7aa;
    }

    .border-gray-200 {
        border-color: #e5e7eb;
    }

    .border-blue-400 {
        border-color: #60a5fa;
    }

    .border-yellow-400 {
        border-color: #fbbf24;
    }

    /* Custom border utilities */
    .border-l-3 {
        border-left-width: 3px;
    }

    .border-l-4 {
        border-left-width: 4px;
    }

    /* Custom font sizes */
    .text-xs {
        font-size: 0.75rem;
        line-height: 1rem;
    }

    .text-sm {
        font-size: 0.875rem;
        line-height: 1.25rem;
    }

    .text-4xl {
        font-size: 2.25rem;
        line-height: 2.5rem;
    }

    /* Hover effects */
    .hover\:shadow-md:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .hover\:shadow-xl:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .hover\:scale-105:hover {
        transform: scale(1.05);
    }

    /* Transition utilities */
    .transition-all {
        transition: all 0.2s ease-in-out;
    }

    .duration-200 {
        transition-duration: 200ms;
    }

    /* Custom spacing */
    .gap-3 {
        gap: 1rem;
    }

    .gap-4 {
        gap: 1.5rem;
    }

    /* Custom width utilities */
    .min-width-200 {
        min-width: 200px;
    }

    /* Focus styles */
    .focus\:border-orange-500:focus {
        border-color: #f97316;
    }

    .hover\:border-orange-400:hover {
        border-color: #fb923c;
    }

    /* Custom rounded corners */
    .rounded-3xl {
        border-radius: 1.5rem;
    }

    .rounded-xl {
        border-radius: 0.75rem;
    }

    .rounded-lg {
        border-radius: 0.5rem;
    }

    .rounded-pill {
        border-radius: 50rem;
    }

    /* Responsive utilities */
    @media (max-width: 768px) {
        .status-circle {
            width: 60px !important;
            height: 60px !important;
        }

        .status-arrow {
            display: none;
        }

        .text-4xl {
            font-size: 1.875rem;
            line-height: 2.25rem;
        }
    }
</style>
@endsection