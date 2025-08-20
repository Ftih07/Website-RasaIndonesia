@extends('layouts.app')

@section('content')
<div class="min-h-screen" style="background: linear-gradient(135deg, #FFF8E1 0%, #FFE0B2 50%, #FFCC80 100%);">
    <div class="container mx-auto px-4 py-8">
        <!-- Enhanced Header Section -->
        <div class="text-center mb-8 lg:mb-12">
            <div class="relative inline-block w-full max-w-4xl">
                <!-- Background Decoration -->
                <div class="absolute -inset-2 lg:-inset-4 bg-gradient-to-r from-orange-400 via-orange-500 to-orange-600 rounded-2xl lg:rounded-3xl opacity-20 blur-xl"></div>

                <!-- Main Header -->
                <div class="relative bg-white bg-opacity-90 backdrop-blur-sm rounded-2xl lg:rounded-3xl px-6 py-6 lg:px-12 lg:py-8 shadow-2xl border border-orange-200">
                    <div class="flex flex-col sm:flex-row items-center justify-center mb-4">
                        <div class="w-12 h-12 lg:w-16 lg:h-16 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center mb-4 sm:mb-0 sm:mr-4 shadow-lg">
                            <svg class="w-6 h-6 lg:w-8 lg:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold bg-gradient-to-r from-orange-600 to-orange-800 bg-clip-text text-transparent text-center sm:text-left">
                            My Orders
                        </h1>
                    </div>

                    <!-- Decorative Elements - Hidden on mobile -->
                    <div class="hidden sm:flex justify-center items-center space-x-2 mb-4">
                        <div class="w-3 h-3 bg-orange-400 rounded-full animate-pulse"></div>
                        <div class="w-16 h-1 bg-gradient-to-r from-orange-400 to-orange-600 rounded-full"></div>
                        <div class="w-4 h-4 bg-orange-500 rounded-full animate-pulse delay-100"></div>
                        <div class="w-16 h-1 bg-gradient-to-r from-orange-500 to-orange-700 rounded-full"></div>
                        <div class="w-3 h-3 bg-orange-600 rounded-full animate-pulse delay-200"></div>
                    </div>

                    <p class="text-gray-600 text-base lg:text-lg">Track your delicious Indonesian cuisine orders</p>
                </div>

                <!-- Floating Elements - Hidden on mobile -->
                <div class="hidden lg:block absolute -top-2 -right-2 w-6 h-6 bg-orange-400 rounded-full opacity-60 animate-bounce"></div>
                <div class="hidden lg:block absolute -bottom-2 -left-2 w-4 h-4 bg-orange-500 rounded-full opacity-40 animate-bounce delay-300"></div>
            </div>
        </div>

        @if($orders->isEmpty())
        @if(request()->hasAny(['status', 'date_from', 'date_to', 'product', 'delivery_option', 'payment_status', 'order_number']))
        <!-- No Results Found (Empty because of filters) -->
        <div class="text-center py-20">
            <div class="relative max-w-md mx-auto">
                <!-- Background Glow -->
                <div class="absolute inset-0 bg-gradient-to-r from-orange-200 to-orange-300 rounded-3xl opacity-30 blur-2xl"></div>

                <div class="relative bg-white rounded-3xl shadow-2xl p-12 border border-orange-100 backdrop-blur-sm">
                    <!-- Animated Icon Container -->
                    <div class="relative w-32 h-32 mx-auto mb-8">
                        <div class="absolute inset-0 bg-gradient-to-br from-orange-100 to-orange-200 rounded-full animate-pulse"></div>
                        <div class="relative w-full h-full bg-gradient-to-br from-orange-200 to-orange-300 rounded-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17l-5-5m0 0l5-5m-5 5h16"></path>
                            </svg>
                        </div>
                        <!-- Floating Particles -->
                        <div class="absolute -top-2 -right-2 w-3 h-3 bg-orange-400 rounded-full animate-ping"></div>
                        <div class="absolute -bottom-2 -left-2 w-2 h-2 bg-orange-300 rounded-full animate-ping delay-150"></div>
                    </div>

                    <h3 class="text-2xl font-bold text-gray-800 mb-4">No Orders Found</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">We couldn’t find any orders matching your current filters. Try adjusting them or clear all filters to see more results.</p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('orders.index') }}" class="bg-gradient-to-r from-gray-200 to-gray-300 hover:from-gray-300 hover:to-gray-400 text-gray-800 px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow">
                            Clear All Filters
                        </a>
                        <a href="{{ url()->previous() }}" class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                            Go Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Default Empty State (No orders at all) -->
        <div class="text-center py-20">
            <div class="relative max-w-md mx-auto">
                <!-- Background Glow -->
                <div class="absolute inset-0 bg-gradient-to-r from-orange-200 to-orange-300 rounded-3xl opacity-30 blur-2xl"></div>

                <div class="relative bg-white rounded-3xl shadow-2xl p-12 border border-orange-100 backdrop-blur-sm">
                    <!-- Animated Icon Container -->
                    <div class="relative w-32 h-32 mx-auto mb-8">
                        <div class="absolute inset-0 bg-gradient-to-br from-orange-100 to-orange-200 rounded-full animate-pulse"></div>
                        <div class="relative w-full h-full bg-gradient-to-br from-orange-200 to-orange-300 rounded-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <!-- Floating Particles -->
                        <div class="absolute -top-2 -right-2 w-3 h-3 bg-orange-400 rounded-full animate-ping"></div>
                        <div class="absolute -bottom-2 -left-2 w-2 h-2 bg-orange-300 rounded-full animate-ping delay-150"></div>
                    </div>

                    <h3 class="text-2xl font-bold text-gray-800 mb-4">No Orders Yet</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">You haven't placed any orders yet. Start exploring our delicious Indonesian cuisine and create your first culinary adventure!</p>

                    <a href="{{ route('products.index') }}" class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Start Ordering
                    </a>
                </div>
            </div>
        </div>
        @endif
        @else
        <!-- Enhanced Filter Section -->
        <div class="relative mb-8">
            <div class="absolute inset-0 bg-gradient-to-r from-orange-50 to-orange-100 rounded-2xl lg:rounded-3xl opacity-60"></div>
            <div class="relative bg-white bg-opacity-95 backdrop-blur-sm p-4 lg:p-8 rounded-2xl lg:rounded-3xl shadow-xl border border-orange-200">
                <div class="flex flex-col sm:flex-row sm:items-center mb-4 lg:mb-6">
                    <div class="w-8 h-8 lg:w-10 lg:h-10 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center mb-3 sm:mb-0 sm:mr-4">
                        <svg class="w-4 h-4 lg:w-5 lg:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg lg:text-xl font-bold text-gray-800">Filter Orders</h3>
                </div>

                <form method="GET" action="{{ route('orders.index') }}" class="space-y-4 lg:space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 lg:gap-6">
                        <!-- Status Filter -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Status
                            </label>
                            <select name="status" class="w-full border-2 border-orange-200 rounded-xl px-3 py-2 lg:px-4 lg:py-3 text-sm lg:text-base focus:border-orange-400 focus:ring-2 focus:ring-orange-200 transition-all duration-300 bg-white">
                                <option value="">All Status</option>
                                <option value="waiting" {{ request('status')=='waiting' ? 'selected' : '' }}>⏳ Waiting</option>
                                <option value="confirmed" {{ request('status')=='confirmed' ? 'selected' : '' }}>✅ Confirmed</option>
                                <option value="on_delivery" {{ request('status')=='on_delivery' ? 'selected' : '' }}>🚚 On Delivery</option>
                                <option value="delivered" {{ request('status')=='delivered' ? 'selected' : '' }}>📦 Delivered</option>
                                <option value="assigned" {{ request('status')=='assigned' ? 'selected' : '' }}>👨‍🍳 Assigned</option>
                                <option value="canceled" {{ request('status')=='canceled' ? 'selected' : '' }}>❌ Canceled</option>
                            </select>
                        </div>

                        <!-- Date From -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                From Date
                            </label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full border-2 border-orange-200 rounded-xl px-3 py-2 lg:px-4 lg:py-3 text-sm lg:text-base focus:border-orange-400 focus:ring-2 focus:ring-orange-200 transition-all duration-300">
                        </div>

                        <!-- Date To -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                To Date
                            </label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full border-2 border-orange-200 rounded-xl px-3 py-2 lg:px-4 lg:py-3 text-sm lg:text-base focus:border-orange-400 focus:ring-2 focus:ring-orange-200 transition-all duration-300">
                        </div>

                        <!-- Product Search -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Product Name
                            </label>
                            <input type="text" name="product" placeholder="Search product..." value="{{ request('product') }}" class="w-full border-2 border-orange-200 rounded-xl px-3 py-2 lg:px-4 lg:py-3 text-sm lg:text-base focus:border-orange-400 focus:ring-2 focus:ring-orange-200 transition-all duration-300">
                        </div>

                        <!-- Delivery Option -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                🚚 Delivery Option
                            </label>
                            <select name="delivery_option" class="w-full border-2 border-orange-200 rounded-xl px-3 py-2 lg:px-4 lg:py-3 text-sm lg:text-base focus:border-orange-400 focus:ring-2 focus:ring-orange-200 transition-all duration-300 bg-white">
                                <option value="">All Options</option>
                                <option value="pickup" {{ request('delivery_option')=='pickup' ? 'selected' : '' }}>🏪 Pickup</option>
                                <option value="delivery" {{ request('delivery_option')=='delivery' ? 'selected' : '' }}>🚚 Delivery</option>
                            </select>
                        </div>

                        <!-- Payment Status -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                💳 Payment Status
                            </label>
                            <select name="payment_status" class="w-full border-2 border-orange-200 rounded-xl px-3 py-2 lg:px-4 lg:py-3 text-sm lg:text-base focus:border-orange-400 focus:ring-2 focus:ring-orange-200 transition-all duration-300 bg-white">
                                <option value="">All Payments</option>
                                <option value="paid" {{ request('payment_status')=='paid' ? 'selected' : '' }}>✅ Paid</option>
                                <option value="unpaid" {{ request('payment_status')=='pending' ? 'selected' : '' }}>⏳ Pending</option>
                                <option value="refund" {{ request('payment_status')=='failed' ? 'selected' : '' }}>💸 Failed</option>
                            </select>
                        </div>

                        <!-- Order Number Search -->
                        <div class="space-y-2 sm:col-span-2 lg:col-span-1">
                            <label class="block text-sm font-semibold text-gray-700">
                                🔎 Order Number
                            </label>
                            <input type="text" name="order_number" placeholder="Search by order number..." value="{{ request('order_number') }}" class="w-full border-2 border-orange-200 rounded-xl px-3 py-2 lg:px-4 lg:py-3 text-sm lg:text-base focus:border-orange-400 focus:ring-2 focus:ring-orange-200 transition-all duration-300">
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 lg:gap-4 justify-end pt-4 border-t border-orange-200">
                        <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 lg:px-8 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z"></path>
                            </svg>
                            Apply Filter
                        </button>
                        <a href="{{ route('orders.index') }}" class="w-full sm:w-auto bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 lg:px-8 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg text-center">
                            <svg class="inline w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
        @endif

        <!-- Orders Summary Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-2xl border border-blue-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-blue-600 font-medium">Pending</p>
                        <p class="text-2xl font-bold text-blue-800">{{ $orders->where('delivery_status', 'waiting')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-6 rounded-2xl border border-yellow-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-yellow-600 font-medium">Processing</p>
                        <p class="text-2xl font-bold text-yellow-800">{{ $orders->whereIn('delivery_status', ['confirmed', 'assigned'])->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-2xl border border-purple-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-purple-600 font-medium">On Delivery</p>
                        <p class="text-2xl font-bold text-purple-800">{{ $orders->where('delivery_status', 'on_delivery')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-2xl border border-green-200">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-green-600 font-medium">Delivered</p>
                        <p class="text-2xl font-bold text-green-800">{{ $orders->where('delivery_status', 'delivered')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Orders Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 lg:gap-8">
            @foreach($orders as $order)
            <div class="relative group h-fit">
                <!-- Background Glow Effect -->
                <div class="absolute -inset-1 bg-gradient-to-r from-orange-200 via-orange-300 to-orange-200 rounded-3xl opacity-0 group-hover:opacity-30 blur-xl transition-all duration-500"></div>

                <div class="relative bg-white rounded-3xl shadow-xl border border-orange-200 overflow-hidden transition-all duration-300 group-hover:shadow-2xl group-hover:-translate-y-2">
                    <!-- Enhanced Order Header -->
                    <div class="bg-gradient-to-r from-orange-500 via-orange-600 to-orange-700 p-4 lg:p-8 relative overflow-hidden">
                        <!-- Background Pattern -->
                        <div class="absolute inset-0 opacity-10">
                            <div class="absolute top-0 left-0 w-20 h-20 lg:w-32 lg:h-32 bg-white rounded-full transform -translate-x-10 -translate-y-10 lg:-translate-x-16 lg:-translate-y-16"></div>
                            <div class="absolute bottom-0 right-0 w-16 h-16 lg:w-24 lg:h-24 bg-white rounded-full transform translate-x-8 translate-y-8 lg:translate-x-12 lg:translate-y-12"></div>
                        </div>

                        <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between">

                            <div class="flex flex-col sm:flex-row sm:items-center mb-4 lg:mb-0">
                                <!-- Enhanced Icon -->
                                <div class=",t-10 w-12 h-12 lg:w-16 lg:h-16 bg-white bg-opacity-20 backdrop-blur-sm rounded-xl lg:rounded-2xl flex items-center justify-center mb-4 sm:mb-0 sm:mr-4 lg:mr-6 shadow-lg mx-auto sm:mx-0">
                                    <svg class="w-6 h-6 lg:w-8 lg:h-8 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                </div>
                                <div class="text-center sm:text-left">
                                    <h3 class="text-lg font-bold text-white mb-1 lg:mb-2">Order {{ $order->order_number }}</h3>
                                    <div class="flex items-center justify-center sm:justify-start text-orange-100 text-sm">
                                        <svg class="w-3 h-3 lg:w-4 lg:h-4 mr-1 lg:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $order->created_at->format('d M Y H:i') }}
                                    </div>
                                </div>
                            </div>

                            <div class="text-center lg:text-right">
                                <div class="text-2xl font-bold text-white mb-2 lg:mb-3">${{ number_format($order->gross_price, 2) }}</div>
                                @php
                                $statusConfig = [
                                'waiting' => ['bg' => 'bg-yellow-500', 'icon' => '⏳', 'pulse' => true],
                                'confirmed' => ['bg' => 'bg-blue-500', 'icon' => '✅', 'pulse' => true],
                                'assigned' => ['bg' => 'bg-indigo-500', 'icon' => '👨‍🍳', 'pulse' => true],
                                'on_delivery' => ['bg' => 'bg-purple-500', 'icon' => '🚚', 'pulse' => true],
                                'delivered' => ['bg' => 'bg-green-500', 'icon' => '📦', 'pulse' => false],
                                'canceled' => ['bg' => 'bg-red-500', 'icon' => '❌', 'pulse' => false]
                                ];
                                $config = $statusConfig[$order->delivery_status] ?? ['bg' => 'bg-gray-500', 'icon' => '❓', 'pulse' => false];
                                @endphp
                                <div class="inline-flex items-center px-4 py-2 lg:px-6 lg:py-3 rounded-xl lg:rounded-2xl text-xs lg:text-sm font-bold text-white {{ $config['bg'] }} shadow-lg">
                                    <span class="text-sm lg:text-lg mr-1 lg:mr-2">{{ $config['icon'] }}</span>
                                    @if($config['pulse'])
                                    <span class="w-1.5 h-1.5 lg:w-2 lg:h-2 bg-white rounded-full mr-2 lg:mr-3 animate-pulse"></span>
                                    @endif
                                    <span class="text-xs lg:text-sm">{{ ucfirst(str_replace('_', ' ', $order->delivery_status)) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Order Content -->
                    <div class="p-8">
                        <!-- Order Items Preview -->
                        <div class="mb-6 lg:mb-8">
                            <h4 class="text-lg lg:text-xl font-bold text-gray-800 mb-4 lg:mb-6 flex items-center">
                                <div class="w-6 h-6 lg:w-8 lg:h-8 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center mr-2 lg:mr-3">
                                    <svg class="w-3 h-3 lg:w-4 lg:h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                                Ordered Items
                            </h4>

                            <div class="grid gap-3 lg:gap-4">
                                @foreach($order->items as $item)
                                <div class="flex items-center justify-between p-3 lg:p-5 bg-gradient-to-r from-orange-50 to-orange-100 rounded-xl lg:rounded-2xl border border-orange-200 transition-all duration-300 hover:shadow-md hover:scale-[1.02]">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 lg:w-12 lg:h-12 bg-gradient-to-br from-orange-400 to-orange-600 rounded-lg lg:rounded-xl flex items-center justify-center mr-3 lg:mr-4">
                                            <svg class="w-5 h-5 lg:w-6 lg:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="font-bold text-gray-800 text-sm lg:text-lg block">{{ $item->product->name ?? 'Unknown Product' }}</span>
                                            <p class="text-gray-600 text-xs lg:text-sm">
                                                {{ $order->business->name ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-3 py-1.5 lg:px-4 lg:py-2 rounded-lg lg:rounded-xl text-xs lg:text-sm font-bold shadow-lg">
                                            x{{ $item->quantity }}
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Enhanced Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 lg:gap-4">
                            <a href="{{ route('orders.tracking', $order) }}" class="flex-1 group/btn relative overflow-hidden bg-gradient-to-r from-orange-500 to-orange-600 text-white px-6 py-3 lg:px-8 lg:py-4 rounded-xl lg:rounded-2xl font-bold text-center transition-all duration-300 hover:from-orange-600 hover:to-orange-700 transform hover:scale-[1.02] shadow-lg hover:shadow-2xl">
                                <div class="absolute inset-0 bg-gradient-to-r from-white to-transparent opacity-0 group-hover/btn:opacity-20 transition-opacity duration-300"></div>
                                <div class="relative flex items-center justify-center">
                                    <svg class="w-4 h-4 lg:w-5 lg:h-5 mr-2 lg:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="text-sm">View Tracking</span>
                                </div>
                            </a>

                            @if($order->delivery_status === 'delivered')
                            @if(!$order->testimonial)
                            <button class="flex-1 group/btn relative overflow-hidden bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-3 lg:px-8 lg:py-4 rounded-xl lg:rounded-2xl font-bold text-center transition-all duration-300 hover:from-green-600 hover:to-green-700 transform hover:scale-[1.02] shadow-lg hover:shadow-2xl" data-bs-toggle="modal" data-bs-target="#reviewModal-{{ $order->id }}">
                                <div class="absolute inset-0 bg-gradient-to-r from-white to-transparent opacity-0 group-hover/btn:opacity-20 transition-opacity duration-300"></div>
                                <div class="relative flex items-center justify-center">
                                    <svg class="w-4 h-4 lg:w-5 lg:h-5 mr-2 lg:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                    </svg>
                                    <span class="text-sm">Give Review</span>
                                </div>
                            </button>
                            @else
                            <div class="flex-1 bg-gradient-to-r from-gray-100 to-gray-200 text-gray-600 px-6 py-3 lg:px-8 lg:py-4 rounded-xl lg:rounded-2xl font-bold text-center border-2 border-gray-300">
                                <div class="flex items-center justify-center">
                                    <svg class="w-4 h-4 lg:w-5 lg:h-5 mr-2 lg:mr-3" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm">Already Reviewed</span>
                                </div>
                            </div>
                            @endif
                            @endif
                        </div>

                    </div>
                </div>

                {{-- Enhanced Review Modal --}}
                @if($order->delivery_status === 'delivered' && !$order->testimonial)
                <div class="modal fade" id="reviewModal-{{ $order->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content border-0 shadow-2xl" style="border-radius: 2rem; overflow: hidden;">
                            <form action="{{ route('partner.orders.review.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <input type="hidden" name="business_id" value="{{ $order->business_id }}">

                                <!-- Ultra Enhanced Modal Header -->
                                <div class="modal-header border-0 p-0 position-relative overflow-hidden" style="background: linear-gradient(135deg, #f97316 0%, #ea580c 50%, #dc2626 100%);">
                                    <!-- Background Pattern -->
                                    <div class="position-absolute w-100 h-100 opacity-10">
                                        <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: white; border-radius: 50%; opacity: 0.1;"></div>
                                        <div style="position: absolute; bottom: -30px; left: -30px; width: 120px; height: 120px; background: white; border-radius: 50%; opacity: 0.1;"></div>
                                    </div>

                                    <div class="position-relative p-4 w-100">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex align-items-center justify-content-center me-4" style="width: 4rem; height: 4rem; background: rgba(255,255,255,0.2); border-radius: 1.5rem; backdrop-filter: blur(10px);">
                                                    <svg style="width: 2rem; height: 2rem;" class="text-white" fill="currentColor" viewBox="0 0 24 24">
                                                        <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h5 class="text-white fw-bold mb-2 fs-3">Share Your Experience</h5>
                                                    <p class="text-white opacity-75 mb-0 fs-6">Order #{{ $order->order_number }} Review</p>
                                                </div>
                                            </div>
                                            <button type="button" class="btn-close btn-close-white fs-4" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Ultra Enhanced Modal Body -->
                                <div class="modal-body p-5" style="background: linear-gradient(135deg, #fefefe 0%, #f8fafc 100%);">
                                    {{-- Rating Section --}}
                                    <div class="mb-5">
                                        <label class="form-label fw-bold text-dark mb-3 d-flex align-items-center fs-5">
                                            <div class="d-flex align-items-center justify-content-center me-3" style="width: 2.5rem; height: 2.5rem; background: linear-gradient(135deg, #f97316, #ea580c); border-radius: 0.75rem;">
                                                <svg style="width: 1.25rem; height: 1.25rem;" class="text-white" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                                </svg>
                                            </div>
                                            Rating
                                        </label>
                                        <select name="rating" class="form-select form-select-lg border-2 border-orange-200" required style="border-radius: 1rem; padding: 1.25rem; font-size: 1.1rem; background: white; transition: all 0.3s;">
                                            <option value="">Choose your rating...</option>
                                            <option value="5">⭐⭐⭐⭐⭐ - Outstanding! Exceeded expectations</option>
                                            <option value="4">⭐⭐⭐⭐ - Very Good! Highly satisfied</option>
                                            <option value="3">⭐⭐⭐ - Good! Met expectations</option>
                                            <option value="2">⭐⭐ - Fair! Room for improvement</option>
                                            <option value="1">⭐ - Poor! Needs significant improvement</option>
                                        </select>
                                    </div>

                                    {{-- Description Section --}}
                                    <div class="mb-5">
                                        <label class="form-label fw-bold text-dark mb-3 d-flex align-items-center fs-5">
                                            <div class="d-flex align-items-center justify-content-center me-3" style="width: 2.5rem; height: 2.5rem; background: linear-gradient(135deg, #10b981, #059669); border-radius: 0.75rem;">
                                                <svg style="width: 1.25rem; height: 1.25rem;" class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                                </svg>
                                            </div>
                                            Your Review
                                        </label>
                                        <textarea name="description" class="form-control border-2 border-orange-200" rows="5" required placeholder="Share your detailed experience with this order. What did you love? What could be improved? Your feedback helps us serve you better!" style="border-radius: 1rem; padding: 1.25rem; font-size: 1rem; resize: vertical; background: white; transition: all 0.3s;"></textarea>
                                        <small class="text-muted mt-2 d-block">
                                            <svg class="me-1" style="width: 1rem; height: 1rem;" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Minimum 20 characters recommended for a helpful review
                                        </small>
                                    </div>

                                    {{-- Image Upload Section --}}
                                    <div class="mb-5">
                                        <label class="form-label fw-bold text-dark mb-3 d-flex align-items-center fs-5">
                                            <div class="d-flex align-items-center justify-content-center me-3" style="width: 2.5rem; height: 2.5rem; background: linear-gradient(135deg, #8b5cf6, #7c3aed); border-radius: 0.75rem;">
                                                <svg style="width: 1.25rem; height: 1.25rem;" class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                            Photos <span class="text-muted fw-normal">(optional)</span>
                                        </label>
                                        <div class="position-relative">
                                            <input type="file" name="images[]" class="form-control form-control-lg border-2 border-orange-200" multiple accept="image/*" style="border-radius: 1rem; padding: 1.25rem; background: white; transition: all 0.3s;">
                                            <div class="position-absolute top-50 end-0 translate-middle-y pe-4">
                                                <svg style="width: 1.5rem; height: 1.5rem;" class="text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <small class="text-muted mt-2 d-block">
                                            <svg class="me-1" style="width: 1rem; height: 1rem;" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Upload multiple photos of your food (JPG, PNG - max 5MB each)
                                        </small>
                                    </div>

                                    {{-- Order Summary Card --}}
                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-dark mb-3 d-flex align-items-center fs-5">
                                            <div class="d-flex align-items-center justify-content-center me-3" style="width: 2.5rem; height: 2.5rem; background: linear-gradient(135deg, #3b82f6, #1d4ed8); border-radius: 0.75rem;">
                                                <svg style="width: 1.25rem; height: 1.25rem;" class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                </svg>
                                            </div>
                                            Order Summary
                                        </label>
                                        <div class="p-4 rounded-3xl border-2 border-orange-200" style="background: linear-gradient(135deg, #fef3e2 0%, #fed7aa 100%);">
                                            @foreach($order->items as $item)
                                            <div class="d-flex justify-content-between align-items-center py-3 {{ !$loop->last ? 'border-bottom border-orange-300' : '' }}">
                                                <div class="d-flex align-items-center">
                                                    <div class="d-flex align-items-center justify-content-center me-3" style="width: 2.5rem; height: 2.5rem; background: linear-gradient(135deg, #f97316, #ea580c); border-radius: 0.75rem;">
                                                        <svg style="width: 1.25rem; height: 1.25rem;" class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12z"></path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <span class="fw-bold text-dark fs-5">{{ $item->product->name ?? 'Unknown Product' }}</span>
                                                        <p class="text-muted mb-0 small">Indonesian Delicacy</p>
                                                    </div>
                                                </div>
                                                <span class="badge fs-6 fw-bold px-3 py-2 rounded-pill" style="background: linear-gradient(135deg, #f97316, #ea580c); color: white;">x{{ $item->quantity }}</span>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Ultra Enhanced Modal Footer -->
                                <div class="modal-footer border-0 p-4" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); display: flex; justify-content: flex-end; gap: 1rem;">
                                    <!-- Cancel -->
                                    <button type="button" data-bs-dismiss="modal"
                                        style="
                                            display: inline-flex; align-items: center; justify-content: center; gap: .5rem;
                                            background: linear-gradient(135deg, #6b7280, #4b5563);
                                            border: none; border-radius: 1rem;
                                            padding: .75rem 2rem; font-size: 1rem; font-weight: 500;
                                            color: white; transition: all .3s ease; transform: translateY(0);
                                        "
                                        onmouseover="this.style.transform='translateY(-2px)'"
                                        onmouseout="this.style.transform='translateY(0)'">
                                        <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Cancel
                                    </button>

                                    <!-- Submit Review -->
                                    <button type="submit"
                                        style="
                                            display: inline-flex; align-items: center; justify-content: center; gap: .5rem;
                                            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
                                            border: none; border-radius: 1rem;
                                            padding: .75rem 2rem; font-size: 1rem; font-weight: 500;
                                            color: white; transition: all .3s ease; transform: translateY(0);
                                            box-shadow: 0 8px 20px -4px rgba(16, 185, 129, 0.4);
                                        "
                                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 14px 28px -4px rgba(16, 185, 129, 0.5)'"
                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 20px -4px rgba(16, 185, 129, 0.4)'">
                                        <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                        Submit Review
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                @endif
                {{-- End Enhanced Modal --}}
            </div>
            @endforeach
        </div>

        <!-- Enhanced Pagination -->
        @if($orders->hasPages())
        <div class="mt-12">
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-r from-orange-100 to-orange-200 rounded-3xl opacity-30"></div>
                <div class="relative bg-white bg-opacity-90 backdrop-blur-sm rounded-3xl p-8 shadow-xl border border-orange-200">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Page Navigation</h3>
                                <p class="text-gray-600 text-sm">Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} orders</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg md:text-2xl font-bold bg-gradient-to-r from-orange-600 to-orange-800 bg-clip-text text-transparent">
                                {{ $orders->currentPage() }} / {{ $orders->lastPage() }}
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap justify-center items-center gap-2">
                        {{-- Previous Page Link --}}
                        @if ($orders->onFirstPage())
                        <span class="px-3 py-2 lg:px-4 lg:py-3 bg-gray-100 text-gray-400 rounded-lg lg:rounded-xl font-medium cursor-not-allowed text-sm lg:text-base">
                            <svg class="w-3 h-3 lg:w-4 lg:h-4 inline mr-1 lg:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            <span class="hidden sm:inline">Previous</span>
                            <span class="sm:hidden">Prev</span>
                        </span>
                        @else
                        <a href="{{ $orders->previousPageUrl() }}" class="px-3 py-2 lg:px-4 lg:py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-lg lg:rounded-xl font-medium hover:from-orange-600 hover:to-orange-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-sm lg:text-base">
                            <svg class="w-3 h-3 lg:w-4 lg:h-4 inline mr-1 lg:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            <span class="hidden sm:inline">Previous</span>
                            <span class="sm:hidden">Prev</span>
                        </a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($orders->getUrlRange(max(1, $orders->currentPage() - 1), min($orders->lastPage(), $orders->currentPage() + 1)) as $page => $url)
                        @if ($page == $orders->currentPage())
                        <span class="px-3 py-2 lg:px-4 lg:py-3 bg-gradient-to-r from-orange-600 to-orange-700 text-white rounded-lg lg:rounded-xl font-bold shadow-lg transform scale-105 lg:scale-110 text-sm lg:text-base">{{ $page }}</span>
                        @else
                        <a href="{{ $url }}" class="px-3 py-2 lg:px-4 lg:py-3 bg-white text-gray-700 rounded-lg lg:rounded-xl font-medium border-2 border-orange-200 hover:bg-orange-50 hover:border-orange-300 transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg text-sm lg:text-base">{{ $page }}</a>
                        @endif
                        @endforeach

                        {{-- Show dots and last page if needed --}}
                        @if($orders->currentPage() < $orders->lastPage() - 2)
                            <span class="px-2 py-2 lg:py-3 text-gray-500 text-sm lg:text-base">...</span>
                            <a href="{{ $orders->url($orders->lastPage()) }}" class="px-3 py-2 lg:px-4 lg:py-3 bg-white text-gray-700 rounded-lg lg:rounded-xl font-medium border-2 border-orange-200 hover:bg-orange-50 hover:border-orange-300 transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg text-sm lg:text-base">{{ $orders->lastPage() }}</a>
                            @endif

                            {{-- Next Page Link --}}
                            @if ($orders->hasMorePages())
                            <a href="{{ $orders->nextPageUrl() }}" class="px-3 py-2 lg:px-4 lg:py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-lg lg:rounded-xl font-medium hover:from-orange-600 hover:to-orange-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-sm lg:text-base">
                                <span class="hidden sm:inline">Next</span>
                                <span class="sm:hidden">Next</span>
                                <svg class="w-3 h-3 lg:w-4 lg:h-4 inline ml-1 lg:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                            @else
                            <span class="px-3 py-2 lg:px-4 lg:py-3 bg-gray-100 text-gray-400 rounded-lg lg:rounded-xl font-medium cursor-not-allowed text-sm lg:text-base">
                                <span class="hidden sm:inline">Next</span>
                                <span class="sm:hidden">Next</span>
                                <svg class="w-3 h-3 lg:w-4 lg:h-4 inline ml-1 lg:ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                            @endif
                    </div>

                    <!-- Quick Jump -->
                    <div class="mt-6 pt-6 border-t border-orange-200">
                        <form method="GET" action="{{ route('orders.index') }}" class="flex items-center justify-center gap-4">
                            <input type="hidden" name="status" value="{{ request('status') }}">
                            <input type="hidden" name="date_from" value="{{ request('date_from') }}">
                            <input type="hidden" name="date_to" value="{{ request('date_to') }}">
                            <input type="hidden" name="product" value="{{ request('product') }}">

                            <label for="page-jump" class="text-sm font-medium text-gray-700">Quick Jump to Page:</label>
                            <input type="number" name="page" id="page-jump" min="1" max="{{ $orders->lastPage() }}" value="{{ $orders->currentPage() }}" class="w-20 border-2 border-orange-200 rounded-lg px-3 py-2 text-center focus:border-orange-400 focus:ring-2 focus:ring-orange-200 transition-all duration-300">
                            <button type="submit" class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-4 py-2 rounded-lg font-medium hover:from-orange-600 hover:to-orange-700 transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg">
                                Go
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    .modal-content {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
    }

    .form-control:focus {
        border-color: #f97316 !important;
        box-shadow: 0 0 0 0.2rem rgba(249, 115, 22, 0.25) !important;
    }

    .btn:hover {
        transform: translateY(-1px) !important;
    }

    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.6) !important;
    }

    /* Responsive improvements */
    @media (max-width: 768px) {
        .modal-dialog {
            margin: 0.5rem !important;
        }

        .modal-header,
        .modal-body,
        .modal-footer {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }

        .container {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }

        /* Ensure buttons don't overflow */
        .btn,
        .form-control,
        .form-select {
            min-height: 2.75rem;
        }

        /* Adjust spacing for mobile */
        .space-y-8>*+* {
            margin-top: 1.5rem !important;
        }

        .space-y-6>*+* {
            margin-top: 1rem !important;
        }

        /* Make pagination more compact on mobile */
        .pagination-container {
            font-size: 0.875rem;
        }
    }

    @media (max-width: 640px) {
        .text-5xl {
            font-size: 2.25rem !important;
        }

        .text-3xl {
            font-size: 1.875rem !important;
        }

        .text-2xl {
            font-size: 1.5rem !important;
        }

        /* Hide decorative elements on very small screens */
        .animate-bounce,
        .animate-pulse {
            animation: none;
        }
    }

    /* Improve touch targets */
    @media (hover: none) and (pointer: coarse) {

        .btn,
        .form-control,
        .form-select,
        button,
        input,
        select {
            min-height: 44px;
        }
    }
</style>
@endsection