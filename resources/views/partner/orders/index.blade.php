@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-6" style="background: linear-gradient(135deg, #fff7ed 0%, #fed7aa 100%); min-height: 100vh;">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="d-flex align-items-center">
                    <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                        <i class="fas fa-shopping-cart text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 mb-0">Partner Orders</h1>
                        <p class="text-gray-600 mb-0">Manage and track your orders efficiently</p>
                    </div>
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

                    {{-- Chat Support --}}
                    <a href="{{ route('chat.partner') }}"
                        class="btn text-white"
                        style="background-color:#ea580c; border-color:#ea580c;">
                        <i class="fas fa-comments me-2"></i>Chat Support
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Enhanced Filter Section --}}
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-lg" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 24px;">
                <div class="card-body p-4 p-lg-5">
                    <!-- Filter Header -->
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-gradient-to-br from-orange-400 to-orange-600 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-0">Filter Orders</h3>
                    </div>

                    <form method="GET" action="{{ route('partner.orders.index') }}">
                        <div class="row g-4">
                            {{-- Per Page --}}
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <label class="form-label fw-semibold text-gray-700">
                                    <i class="fas fa-list-ol me-2 text-orange-500"></i>Show per page
                                </label>
                                <select name="per_page" class="form-select border-2 rounded-3 shadow-sm"
                                    style="border-color: #fed7aa !important;">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>

                            {{-- Status Filter --}}
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <label class="form-label fw-semibold text-gray-700">
                                    <i class="fas fa-flag me-2 text-orange-500"></i>Status
                                </label>
                                <select name="status" class="form-select border-2 rounded-3 shadow-sm" style="border-color: #fed7aa !important; transition: all 0.3s ease;">
                                    <option value="">All Status</option>
                                    <option value="waiting" {{ request('status')=='waiting' ? 'selected' : '' }}>⏳ Waiting</option>
                                    <option value="confirmed" {{ request('status')=='confirmed' ? 'selected' : '' }}>✅ Confirmed</option>
                                    <option value="on_delivery" {{ request('status')=='on_delivery' ? 'selected' : '' }}>🚚 On Delivery</option>
                                    <option value="delivered" {{ request('status')=='delivered' ? 'selected' : '' }}>📦 Delivered</option>
                                    <option value="assigned" {{ request('status')=='assigned' ? 'selected' : '' }}>👨‍🍳 Assigned</option>
                                    <option value="canceled" {{ request('status')=='canceled' ? 'selected' : '' }}>❌ Canceled</option>
                                </select>
                            </div>

                            {{-- Date From --}}
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <label class="form-label fw-semibold text-gray-700">
                                    <i class="fas fa-calendar-alt me-2 text-orange-500"></i>From Date
                                </label>
                                <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control border-2 rounded-3 shadow-sm" style="border-color: #fed7aa !important;">
                            </div>

                            {{-- Date To --}}
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <label class="form-label fw-semibold text-gray-700">
                                    <i class="fas fa-calendar-check me-2 text-orange-500"></i>To Date
                                </label>
                                <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control border-2 rounded-3 shadow-sm" style="border-color: #fed7aa !important;">
                            </div>

                            <!-- Product Search -->
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <label class="form-label fw-semibold text-gray-700">
                                    <i class="fas fa-search me-2 text-orange-500"></i>Product Name
                                </label>
                                <input type="text" name="product" placeholder="Search product..." value="{{ request('product') }}" class="form-control border-2 rounded-3 shadow-sm" style="border-color: #fed7aa !important;">
                            </div>

                            <!-- Delivery Option -->
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <label class="form-label fw-semibold text-gray-700">
                                    <i class="fas fa-truck me-2 text-orange-500"></i>Delivery Option
                                </label>
                                <select name="delivery_option" class="form-select border-2 rounded-3 shadow-sm" style="border-color: #fed7aa !important;">
                                    <option value="">All Options</option>
                                    <option value="pickup" {{ request('delivery_option')=='pickup' ? 'selected' : '' }}>🏪 Pickup</option>
                                    <option value="delivery" {{ request('delivery_option')=='delivery' ? 'selected' : '' }}>🚚 Delivery</option>
                                </select>
                            </div>

                            {{-- Order Number --}}
                            <div class="col-md-6 col-lg-4 col-xl-3">
                                <label class="form-label fw-semibold text-gray-700">
                                    <i class="fas fa-hashtag me-2 text-orange-500"></i>Order Number
                                </label>
                                <input type="text" name="order_number" placeholder="Search order number..." value="{{ request('order_number') }}" class="form-control border-2 rounded-3 shadow-sm" style="border-color: #fed7aa !important;">
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-end pt-4 mt-4" style="border-top: 2px solid #fed7aa;">
                            <button type="submit" class="btn btn-lg px-4 py-2 fw-semibold rounded-3 shadow-sm" style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); color: white; border: none; transition: all 0.3s ease;">
                                <i class="fas fa-filter me-2"></i>Apply Filter
                            </button>
                            <a href="{{ route('partner.orders.index') }}" class="btn btn-lg px-4 py-2 fw-semibold rounded-3 shadow-sm" style="background-color: #f3f4f6; color: #374151; border: none; transition: all 0.3s ease;">
                                <i class="fas fa-refresh me-2"></i>Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Enhanced Orders Table --}}
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-lg" style="border-radius: 24px; overflow: hidden;">
                <div class="card-header text-white py-4" style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-list-alt me-3" style="font-size: 1.5rem;"></i>
                        <h4 class="mb-0 fw-bold">Order Management</h4>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" style="border: none;">
                            <thead style="background-color: #fff7ed;">
                                <tr>
                                    <th class="border-0 py-4 px-4 fw-bold text-gray-700">
                                        <i class="fas fa-hashtag me-2 text-orange-500"></i>Order ID
                                    </th>
                                    <th class="border-0 py-4 px-4 fw-bold text-gray-700">
                                        <i class="fas fa-user me-2 text-orange-500"></i>Customer
                                    </th>
                                    <th class="border-0 py-4 px-4 fw-bold text-gray-700">
                                        <i class="fas fa-shopping-bag me-2 text-orange-500"></i>Items
                                    </th>
                                    <th class="border-0 py-4 px-4 fw-bold text-gray-700">
                                        <i class="fas fa-dollar-sign me-2 text-orange-500"></i>Total
                                    </th>
                                    <th class="border-0 py-4 px-4 fw-bold text-gray-700">
                                        <i class="fas fa-shipping-fast me-2 text-orange-500"></i>Delivery Status
                                    </th>
                                    <th class="border-0 py-4 px-4 fw-bold text-gray-700">
                                        <i class="fas fa-cogs me-2 text-orange-500"></i>Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr class="border-bottom" style="border-color: #fed7aa !important; transition: all 0.3s ease;">
                                    <td class="py-4 px-4">
                                        <span class="badge rounded-pill px-3 py-2" style="background-color: #fff7ed; color: #ea580c; font-weight: 600;">
                                            {{ $order->order_number }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-gradient-to-r from-orange-400 to-orange-500 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                                <i class="fas fa-user text-white" style="font-size: 14px;"></i>
                                            </div>
                                            <span class="fw-semibold">{{ $order->customer_name ?? $order->user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 align-top">
                                        @foreach($order->items as $item)
                                        <div class="mb-3 p-3 rounded-3" style="background-color: #fff7ed; border-left: 4px solid #f97316;">
                                            <div class="fw-bold text-gray-800 mb-1">{{ $item->product->name ?? 'Product not found' }}</div>
                                            <small class="text-muted">
                                                <span class="badge bg-light text-dark me-2">{{ $item->quantity }}x</span>
                                                <span class="fw-semibold">A${{ number_format($item->unit_price, 2) }}</span>
                                            </small>

                                            {{-- Options --}}
                                            @if(!empty($item->options_for_view))
                                            <div class="mt-2">
                                                @foreach($item->options_for_view as $group)
                                                @foreach($group['items'] ?? [] as $opt)
                                                <small class="d-block text-muted">
                                                    <i class="fas fa-plus-circle me-1 text-orange-400"></i>
                                                    {{ $opt['name'] ?? 'Unnamed Option' }}
                                                    @if(isset($opt['price']) && $opt['price'] > 0)
                                                    <span class="text-success">(+A${{ number_format($opt['price'], 2) }})</span>
                                                    @endif
                                                </small>
                                                @endforeach
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                        @endforeach
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="fw-bold text-success" style="font-size: 1.1rem;">
                                            ${{ number_format($order->gross_price,2) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        @php
                                        $statusColors = [
                                        'waiting' => 'warning',
                                        'confirmed' => 'info',
                                        'on_delivery' => 'primary',
                                        'delivered' => 'success',
                                        'assigned' => 'secondary',
                                        'canceled' => 'danger'
                                        ];
                                        $statusIcons = [
                                        'waiting' => 'clock',
                                        'confirmed' => 'check',
                                        'on_delivery' => 'truck',
                                        'delivered' => 'box',
                                        'assigned' => 'user-check',
                                        'canceled' => 'times'
                                        ];
                                        $color = $statusColors[$order->delivery_status] ?? 'secondary';
                                        $icon = $statusIcons[$order->delivery_status] ?? 'question';
                                        @endphp
                                        <span class="badge bg-{{ $color }} px-3 py-2">
                                            <i class="fas fa-{{ $icon }} me-1"></i>
                                            {{ ucfirst($order->delivery_status) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <a href="{{ route('partner.orders.show', $order->id) }}" class="btn btn-sm px-3 py-2 fw-semibold rounded-3 shadow-sm" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); color: white; border: none; transition: all 0.3s ease;">
                                            <i class="fas fa-eye me-1"></i>View Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-inbox text-muted mb-3" style="font-size: 3rem; opacity: 0.5;"></i>
                                            <h5 class="text-muted mb-2">No orders found</h5>
                                            <p class="text-muted">Try adjusting your filters to see more results.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="p-4">
                            {{ $orders->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom hover effects */
    .table-hover tbody tr:hover {
        background-color: #fff7ed !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(249, 115, 22, 0.15) !important;
    }

    /* Focus states for form elements */
    .form-control:focus,
    .form-select:focus {
        border-color: #f97316 !important;
        box-shadow: 0 0 0 0.2rem rgba(249, 115, 22, 0.25) !important;
    }

    /* Button hover effects */
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15) !important;
    }

    /* Smooth transitions */
    * {
        transition: all 0.3s ease;
    }

    /* Responsive table adjustments */
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.875rem;
        }

        .card-body {
            padding: 1rem !important;
        }
    }

    /* Text utilities for consistent coloring */
    .text-orange-500 {
        color: #f97316 !important;
    }

    .text-gray-700 {
        color: #374151 !important;
    }

    .text-gray-800 {
        color: #1f2937 !important;
    }

    .text-gray-600 {
        color: #4b5563 !important;
    }

    /* Background utilities */
    .bg-gradient-to-r {
        background: linear-gradient(90deg, var(--tw-gradient-stops));
    }

    .from-orange-400 {
        --tw-gradient-from: #fb923c;
        --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(251, 146, 60, 0));
    }

    .to-orange-600 {
        --tw-gradient-to: #ea580c;
    }
</style>
@endsection