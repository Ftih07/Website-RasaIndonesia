@extends('layouts.app')

@section('content')
@include('dashboard.partials.navbar')

<!-- Header Section -->
<div class="bg-gradient-to-r from-orange-500 to-amber-500 rounded-2xl p-6 mb-8 shadow-lg">
    <div class="flex items-center justify-between text-white">
        <div>
            <h1 class="text-3xl font-bold mb-2">Order Management</h1>
            <p class="text-orange-100 opacity-90">Manage all your customer orders efficiently</p>
        </div>
        <div class="bg-white bg-opacity-20 p-4 rounded-xl backdrop-blur-sm">
            <svg class="w-12 h-12 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
        </div>
    </div>
</div>

@if(session('success'))
<div class="bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 p-4 rounded-lg mb-6 shadow-sm">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="ml-3">
            <p class="text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    </div>
</div>
@endif

<!-- Quick Actions -->
<div class="flex flex-wrap gap-4 mb-6">
    <a href="{{ route('dashboard.orders.shipping') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-orange-500 to-amber-500 text-white rounded-lg hover:from-orange-600 hover:to-amber-600 transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        Shipping Settings
    </a>
</div>

<div class="container-fluid p-0">
    {{-- ================= Enhanced Filter Section ================= --}}
    <div class="row mb-6">
        <div class="col-12">
            <div class="card border-0 shadow-xl" style="background: linear-gradient(145deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 248, 240, 0.95) 100%); backdrop-filter: blur(15px); border-radius: 20px;">
                <div class="card-body p-6">
                    <!-- Enhanced Filter Header -->
                    <div class="d-flex align-items-center mb-5">
                        <div class="position-relative me-4">
                            <div class="bg-gradient-to-br from-orange-400 to-amber-500 rounded-circle d-flex align-items-center justify-content-center shadow-lg" style="width: 50px; height: 50px;">
                                <svg class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 24px; height: 24px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z"></path>
                                </svg>
                            </div>
                            <div class="position-absolute top-0 end-0 bg-orange-200 rounded-circle" style="width: 16px; height: 16px; transform: translate(25%, -25%);"></div>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-1">Advanced Filters</h3>
                            <p class="text-gray-600 mb-0">Filter orders by various criteria to find exactly what you need</p>
                        </div>
                    </div>

                    <form method="GET" action="{{ route('dashboard.orders') }}">
                        <div class="row g-4">
                            {{-- Per Page --}}
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <label class="form-label fw-bold text-gray-700 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-orange-100 rounded-circle p-2 me-2">
                                            <i class="fas fa-list-ol text-orange-600" style="font-size: 14px;"></i>
                                        </div>
                                        Show per page
                                    </div>
                                </label>
                                <select name="per_page" class="form-select border-2 rounded-xl shadow-sm transition-all duration-200 hover:border-orange-400 focus:border-orange-500 focus:ring-2 focus:ring-orange-200"
                                    style="border-color: #fed7aa; min-height: 48px;">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10 orders</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 orders</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 orders</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 orders</option>
                                </select>
                            </div>

                            {{-- Status Filter --}}
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <label class="form-label fw-bold text-gray-700 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-orange-100 rounded-circle p-2 me-2">
                                            <i class="fas fa-flag text-orange-600" style="font-size: 14px;"></i>
                                        </div>
                                        Order Status
                                    </div>
                                </label>
                                <select name="status" class="form-select border-2 rounded-xl shadow-sm transition-all duration-200 hover:border-orange-400 focus:border-orange-500 focus:ring-2 focus:ring-orange-200" 
                                    style="border-color: #fed7aa; min-height: 48px;">
                                    <option value="">🔍 All Status</option>
                                    <option value="waiting" {{ request('status')=='waiting' ? 'selected' : '' }}>⏳ Waiting for Approval</option>
                                    <option value="confirmed" {{ request('status')=='confirmed' ? 'selected' : '' }}>✅ Confirmed</option>
                                    <option value="on_delivery" {{ request('status')=='on_delivery' ? 'selected' : '' }}>🚚 On Delivery</option>
                                    <option value="delivered" {{ request('status')=='delivered' ? 'selected' : '' }}>📦 Delivered</option>
                                    <option value="assigned" {{ request('status')=='assigned' ? 'selected' : '' }}>👨‍🍳 Assigned to Chef</option>
                                    <option value="canceled" {{ request('status')=='canceled' ? 'selected' : '' }}>❌ Canceled</option>
                                </select>
                            </div>

                            {{-- Date From --}}
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <label class="form-label fw-bold text-gray-700 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-orange-100 rounded-circle p-2 me-2">
                                            <i class="fas fa-calendar-alt text-orange-600" style="font-size: 14px;"></i>
                                        </div>
                                        From Date
                                    </div>
                                </label>
                                <input type="date" name="date_from" value="{{ request('date_from') }}" 
                                    class="form-control border-2 rounded-xl shadow-sm transition-all duration-200 hover:border-orange-400 focus:border-orange-500 focus:ring-2 focus:ring-orange-200" 
                                    style="border-color: #fed7aa; min-height: 48px;">
                            </div>

                            {{-- Date To --}}
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <label class="form-label fw-bold text-gray-700 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-orange-100 rounded-circle p-2 me-2">
                                            <i class="fas fa-calendar-check text-orange-600" style="font-size: 14px;"></i>
                                        </div>
                                        To Date
                                    </div>
                                </label>
                                <input type="date" name="date_to" value="{{ request('date_to') }}" 
                                    class="form-control border-2 rounded-xl shadow-sm transition-all duration-200 hover:border-orange-400 focus:border-orange-500 focus:ring-2 focus:ring-orange-200" 
                                    style="border-color: #fed7aa; min-height: 48px;">
                            </div>

                            {{-- Product Search --}}
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <label class="form-label fw-bold text-gray-700 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-orange-100 rounded-circle p-2 me-2">
                                            <i class="fas fa-search text-orange-600" style="font-size: 14px;"></i>
                                        </div>
                                        Product Name
                                    </div>
                                </label>
                                <input type="text" name="product" placeholder="🍜 Search delicious products..." value="{{ request('product') }}" 
                                    class="form-control border-2 rounded-xl shadow-sm transition-all duration-200 hover:border-orange-400 focus:border-orange-500 focus:ring-2 focus:ring-orange-200" 
                                    style="border-color: #fed7aa; min-height: 48px;">
                            </div>

                            {{-- Delivery Option --}}
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <label class="form-label fw-bold text-gray-700 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-orange-100 rounded-circle p-2 me-2">
                                            <i class="fas fa-truck text-orange-600" style="font-size: 14px;"></i>
                                        </div>
                                        Delivery Option
                                    </div>
                                </label>
                                <select name="delivery_option" class="form-select border-2 rounded-xl shadow-sm transition-all duration-200 hover:border-orange-400 focus:border-orange-500 focus:ring-2 focus:ring-orange-200" 
                                    style="border-color: #fed7aa; min-height: 48px;">
                                    <option value="">🌍 All Options</option>
                                    <option value="pickup" {{ request('delivery_option')=='pickup' ? 'selected' : '' }}>🏪 Store Pickup</option>
                                    <option value="delivery" {{ request('delivery_option')=='delivery' ? 'selected' : '' }}>🚚 Home Delivery</option>
                                </select>
                            </div>

                            {{-- Order Number --}}
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <label class="form-label fw-bold text-gray-700 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-orange-100 rounded-circle p-2 me-2">
                                            <i class="fas fa-hashtag text-orange-600" style="font-size: 14px;"></i>
                                        </div>
                                        Order Number
                                    </div>
                                </label>
                                <input type="text" name="order_number" placeholder="🔢 Enter order number..." value="{{ request('order_number') }}" 
                                    class="form-control border-2 rounded-xl shadow-sm transition-all duration-200 hover:border-orange-400 focus:border-orange-500 focus:ring-2 focus:ring-orange-200" 
                                    style="border-color: #fed7aa; min-height: 48px;">
                            </div>
                        </div>

                        {{-- Enhanced Action Buttons --}}
                        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-end pt-5 mt-5" 
                            style="border-top: 3px solid #fed7aa; border-image: linear-gradient(to right, #fed7aa, #fdba74) 1;">
                            <button type="submit" class="btn btn-lg px-6 py-3 fw-bold rounded-xl shadow-lg transform transition-all duration-200 hover:scale-105 hover:shadow-xl" 
                                style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); color: white; border: none;">
                                <i class="fas fa-filter me-2"></i>Apply Filters
                                <div class="position-absolute top-0 start-0 w-100 h-100 bg-white opacity-0 hover:opacity-10 rounded-xl transition-opacity duration-200"></div>
                            </button>
                            <a href="{{ route('dashboard.orders') }}" class="btn btn-lg px-6 py-3 fw-bold rounded-xl shadow-lg transform transition-all duration-200 hover:scale-105 hover:shadow-xl" 
                                style="background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%); color: #374151; border: 2px solid #d1d5db;">
                                <i class="fas fa-refresh me-2"></i>Reset All
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= Enhanced Orders Cards Layout ================= --}}
    @if($orders->count() > 0)
    <div class="mb-4">
        <div class="d-flex align-items-center justify-content-between bg-gradient-to-r from-orange-500 to-amber-500 p-4 rounded-3xl shadow-lg mb-4">
            <h4 class="text-white font-bold mb-0 d-flex align-items-center">
                <svg class="w-6 h-6 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                Orders Overview
            </h4>
            <div class="badge bg-white text-orange-600 fs-6 px-3 py-2 rounded-pill fw-bold">
                {{ $orders->total() }} Total Orders
            </div>
        </div>
        
        {{-- Orders Cards Layout --}}
        <div class="row g-4">
            @foreach($orders as $order)
            <div class="col-12">
                <div class="card border-0 shadow-lg rounded-3xl overflow-hidden order-card" style="border-left: 5px solid #f97316;">
                    {{-- Order Header --}}
                    <div class="card-header bg-gradient-to-r from-orange-50 to-amber-50 border-0 py-3">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-gradient-to-br from-orange-400 to-amber-500 rounded-circle d-flex align-items-center justify-content-center me-3" 
                                        style="width: 45px; height: 45px;">
                                        <i class="fas fa-receipt text-white"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-gray-800 mb-0">#{{ $order->order_number }}</h6>
                                        <small class="text-gray-500">ID: {{ $order->id }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-gradient-to-br from-orange-400 to-amber-500 rounded-circle d-flex align-items-center justify-content-center me-3" 
                                        style="width: 35px; height: 35px;">
                                        <span class="text-white fw-bold fs-6">{{ substr($order->user->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-gray-800">{{ $order->user->name }}</div>
                                        <small class="text-gray-500">Customer</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-center">
                                    <div class="fw-bold text-gray-800 fs-5">AUD {{ number_format($order->gross_price, 2, '.', ',') }}</div>
                                    <small class="text-gray-500">Total Amount</small>
                                </div>
                            </div>
                            <div class="col-md-2">
                                @php
                                    $statusConfig = [
                                        'waiting' => ['class' => 'bg-yellow-100 text-yellow-800 border-yellow-200', 'icon' => '⏳'],
                                        'confirmed' => ['class' => 'bg-green-100 text-green-800 border-green-200', 'icon' => '✅'],
                                        'on_delivery' => ['class' => 'bg-blue-100 text-blue-800 border-blue-200', 'icon' => '🚚'],
                                        'delivered' => ['class' => 'bg-purple-100 text-purple-800 border-purple-200', 'icon' => '📦'],
                                        'assigned' => ['class' => 'bg-orange-100 text-orange-800 border-orange-200', 'icon' => '👨‍🍳'],
                                        'canceled' => ['class' => 'bg-red-100 text-red-800 border-red-200', 'icon' => '❌'],
                                    ];
                                    $config = $statusConfig[$order->delivery_status] ?? ['class' => 'bg-gray-100 text-gray-800 border-gray-200', 'icon' => '❓'];
                                @endphp
                                <div class="d-flex justify-content-center">
                                    <span class="badge {{ $config['class'] }} border px-3 py-2 rounded-pill fw-bold">
                                        {{ $config['icon'] }} {{ ucfirst($order->delivery_status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="text-end">
                                    <div class="fw-semibold text-gray-800">{{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y') }}</div>
                                    <small class="text-gray-500">{{ \Carbon\Carbon::parse($order->order_date)->format('h:i A') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Order Body --}}
                    <div class="card-body p-4">
                        {{-- Order Items --}}
                        @if($order->items->count() > 0)
                        <div class="mb-4">
                            <h6 class="fw-bold text-gray-800 mb-3 d-flex align-items-center">
                                <i class="fas fa-shopping-bag text-orange-500 me-2"></i>
                                Order Items ({{ $order->items->count() }} items)
                            </h6>
                            <div class="row g-3">
                                @foreach($order->items as $item)
                                <div class="col-md-6 col-lg-4">
                                    <div class="bg-gradient-to-r from-gray-50 to-orange-50 rounded-xl p-3 border border-orange-100">
                                        <div class="d-flex align-items-start">
                                            <div class="bg-gradient-to-br from-orange-400 to-amber-500 rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" 
                                                style="width: 35px; height: 35px;">
                                                <i class="fas fa-utensils text-white" style="font-size: 14px;"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="fw-bold text-gray-800 mb-1">{{ $item->product->name }}</div>
                                                <div class="text-sm text-gray-600 mb-1">
                                                    <span class="badge bg-orange-100 text-orange-800">{{ $item->quantity }}x</span>
                                                    AUD {{ number_format($item->unit_price, 2, '.', ',') }}
                                                </div>
                                                <div class="fw-bold text-orange-600">
                                                    = AUD {{ number_format($item->total_price, 2, '.', ',') }}
                                                </div>
                                                @if($item->note)
                                                <div class="text-xs text-gray-500 mt-2 p-2 bg-yellow-50 rounded border-l-3 border-yellow-400">
                                                    <i class="fas fa-sticky-note me-1"></i><strong>Note:</strong> {{ $item->note }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- Action Buttons --}}
                        <div class="border-top pt-3">
                            <div class="d-flex flex-wrap gap-2 justify-content-end">
                                {{-- View Details Button --}}
                                <a href="{{ route('dashboard.orders.show', $order->id) }}"
                                    class="btn btn-outline-secondary px-4 py-2 rounded-xl fw-semibold transition-all duration-200 hover:shadow-md transform hover:scale-105">
                                    <i class="fas fa-eye me-2"></i>View Full Details
                                </a>

                                {{-- Conditional Action Buttons --}}
                                @if($order->delivery_status === 'waiting' && $order->payment->status === 'pending')
                                    {{-- Accept Order --}}
                                    <form method="POST" action="{{ route('dashboard.orders.approve', $order->id) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn px-4 py-2 rounded-xl fw-semibold transition-all duration-200 hover:shadow-md transform hover:scale-105"
                                            style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none;">
                                            <i class="fas fa-check me-2"></i>Accept Order
                                        </button>
                                    </form>

                                    {{-- Reject Order --}}
                                    <form method="POST" action="{{ route('dashboard.orders.reject', $order->id) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn px-4 py-2 rounded-xl fw-semibold transition-all duration-200 hover:shadow-md transform hover:scale-105"
                                            style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; border: none;">
                                            <i class="fas fa-times me-2"></i>Reject Order
                                        </button>
                                    </form>
                                @elseif(in_array($order->delivery_status, ['confirmed','assigned','on_delivery']))
                                    {{-- Status Update Dropdown --}}
                                    <form method="POST" action="{{ route('dashboard.orders.updateStatus', $order->id) }}" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <div class="d-flex align-items-center gap-2">
                                            <label class="form-label mb-0 fw-semibold text-gray-700">Update Status:</label>
                                            <select name="delivery_status" class="form-select border-2 rounded-xl fw-semibold transition-all duration-200 hover:border-orange-400 focus:border-orange-500" 
                                                style="border-color: #fed7aa; min-width: 180px;" onchange="this.form.submit()">
                                                <option value="" disabled selected>Choose new status</option>
                                                <option value="assigned" {{ $order->delivery_status === 'assigned' ? 'selected' : '' }}>👨‍🍳 Assigned to Chef</option>
                                                <option value="on_delivery" {{ $order->delivery_status === 'on_delivery' ? 'selected' : '' }}>🚚 On Delivery</option>
                                                <option value="delivered" {{ $order->delivery_status === 'delivered' ? 'selected' : '' }}>📦 Delivered</option>
                                            </select>
                                        </div>
                                    </form>
                                @elseif(in_array($order->delivery_status, ['rejected','delivered','canceled']))
                                    <div class="text-gray-500 fst-italic fw-semibold d-flex align-items-center">
                                        <i class="fas fa-info-circle me-2"></i>Order completed - no further actions available
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Enhanced Pagination --}}
    <div class="d-flex justify-content-center mt-6">
        <div class="bg-white rounded-xl shadow-lg p-4">
            {{ $orders->links() }}
        </div>
    </div>
    @else
    {{-- Enhanced Empty State --}}
    <div class="text-center py-12">
        <div class="bg-gradient-to-br from-orange-100 to-amber-100 rounded-full mx-auto mb-4 d-flex align-items-center justify-content-center" 
            style="width: 120px; height: 120px;">
            <svg class="w-16 h-16 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-3">No Orders Found</h3>
        <p class="text-gray-600 mb-6 max-w-md mx-auto">
            You haven't received any orders yet for your Indonesian culinary business. 
            Orders will appear here once customers start placing them.
        </p>
        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
            <a href="{{ route('dashboard.products') }}" class="btn btn-lg px-6 py-3 fw-bold rounded-xl shadow-lg transform transition-all duration-200 hover:scale-105 hover:shadow-xl" 
                style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); color: white; border: none;">
                <i class="fas fa-plus me-2"></i>Add Products
            </a>
            <a href="{{ route('dashboard') }}" class="btn btn-lg px-6 py-3 fw-bold rounded-xl shadow-lg transform transition-all duration-200 hover:scale-105 hover:shadow-xl" 
                style="background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%); color: #374151; border: 2px solid #d1d5db;">
                <i class="fas fa-home me-2"></i>Back to Dashboard
            </a>
        </div>
    </div>
    @endif

</div>

<style>
    /* Custom hover effects and animations */
    .hover\:bg-orange-50:hover {
        background-color: #fff7ed;
    }
    
    .hover\:border-orange-400:hover {
        border-color: #fb923c;
    }
    
    .hover\:shadow-md:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    .hover\:shadow-lg:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    .hover\:shadow-xl:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    .hover\:scale-105:hover {
        transform: scale(1.05);
    }
    
    .hover\:-translate-y-0\.5:hover {
        transform: translateY(-2px);
    }
    
    .focus\:border-orange-500:focus {
        border-color: #f97316;
    }
    
    .focus\:ring-2:focus {
        box-shadow: 0 0 0 2px rgba(249, 115, 22, 0.2);
    }
    
    .focus\:ring-orange-200:focus {
        box-shadow: 0 0 0 2px rgba(254, 215, 170, 0.5);
    }
    
    /* Custom background gradients */
    .bg-gradient-to-r {
        background-image: linear-gradient(to right, var(--tw-gradient-stops));
    }
    
    .bg-gradient-to-br {
        background-image: linear-gradient(to bottom right, var(--tw-gradient-stops));
    }
    
    .from-orange-25 {
        --tw-gradient-from: #fffbf5;
        --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(255, 251, 245, 0));
    }
    
    .to-amber-25 {
        --tw-gradient-to: #fffdf7;
    }
    
    .from-orange-400 {
        --tw-gradient-from: #fb923c;
        --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(251, 146, 60, 0));
    }
    
    .to-amber-500 {
        --tw-gradient-to: #f59e0b;
    }
    
    .from-orange-500 {
        --tw-gradient-from: #f97316;
        --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(249, 115, 22, 0));
    }
    
    .to-amber-500 {
        --tw-gradient-to: #f59e0b;
    }
    
    /* Custom text colors */
    .text-orange-500 {
        color: #f97316;
    }
    
    .text-orange-600 {
        color: #ea580c;
    }
    
    .text-orange-100 {
        color: #ffedd5;
    }
    
    /* Custom background colors */
    .bg-orange-100 {
        background-color: #ffedd5;
    }
    
    .bg-orange-200 {
        background-color: #fed7aa;
    }
    
    .bg-yellow-100 {
        background-color: #fef3c7;
    }
    
    .bg-green-100 {
        background-color: #dcfce7;
    }
    
    .bg-blue-100 {
        background-color: #dbeafe;
    }
    
    .bg-purple-100 {
        background-color: #f3e8ff;
    }
    
    .bg-red-100 {
        background-color: #fee2e2;
    }
    
    .bg-gray-50 {
        background-color: #f9fafb;
    }
    
    /* Custom text colors for badges */
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
    
    .text-gray-500 {
        color: #6b7280;
    }
    
    .text-gray-600 {
        color: #4b5563;
    }
    
    .text-gray-700 {
        color: #374151;
    }
    
    .text-gray-800 {
        color: #1f2937;
    }
    
    /* Custom border colors */
    .border-orange-400 {
        border-color: #fb923c;
    }
    
    .border-orange-100 {
        border-color: #ffedd5;
    }
    
    .border-orange-200 {
        border-color: #fed7aa;
    }
    
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
    
    .border-gray-200 {
        border-color: #e5e7eb;
    }
    
    .border-yellow-400 {
        border-color: #fbbf24;
    }
    
    .border-l-3 {
        border-left-width: 3px;
    }
    
    /* Order card specific styles */
    .order-card {
        transition: all 0.3s ease;
        margin-bottom: 2rem;
    }
    
    .order-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }
    
    /* Custom gradient backgrounds */
    .from-gray-50 {
        --tw-gradient-from: #f9fafb;
        --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(249, 250, 251, 0));
    }
    
    .to-orange-50 {
        --tw-gradient-to: #fff7ed;
    }
    
    /* Custom background colors */
    .bg-yellow-50 {
        background-color: #fffbeb;
    }
    
    /* Custom rounded corners */
    .rounded-3xl {
        border-radius: 1.5rem;
    }
    
    /* Animation for smooth transitions */
    .transition-all {
        transition: all 0.2s ease-in-out;
    }
    
    .duration-200 {
        transition-duration: 200ms;
    }
    
    /* Custom spacing */
    .max-w-md {
        max-width: 28rem;
    }
    
    /* Custom positioning */
    .position-absolute {
        position: absolute;
    }
    
    /* Custom flex utilities */
    .flex-grow-1 {
        flex-grow: 1;
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
    
    .text-2xl {
        font-size: 1.5rem;
        line-height: 2rem;
    }
    
    .text-3xl {
        font-size: 1.875rem;
        line-height: 2.25rem;
    }
    
    /* Custom widths and heights */
    .w-4 {
        width: 1rem;
    }
    
    .h-4 {
        height: 1rem;
    }
    
    .w-5 {
        width: 1.25rem;
    }
    
    .h-5 {
        height: 1.25rem;
    }
    
    .w-6 {
        width: 1.5rem;
    }
    
    .h-6 {
        height: 1.5rem;
    }
    
    .w-12 {
        width: 3rem;
    }
    
    .h-12 {
        height: 3rem;
    }
    
    .w-16 {
        width: 4rem;
    }
    
    .h-16 {
        height: 4rem;
    }
</style>
@endsection