@extends('layouts.app')

@section('content')
@include('dashboard.partials.navbar')

<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-orange-50 to-orange-100 rounded-xl p-6 mb-8 border-l-4 border-orange-400">
        <div class="flex items-center space-x-3">
            <div class="bg-orange-400 p-3 rounded-full">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m4 0a2 2 0 01-2-2V9a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H8z" />
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Shipping Settings</h1>
                <p class="text-gray-600 text-lg">Easily set up delivery fees for your business – quick and flexible.</p>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-r-lg">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Main Form Card -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
            <h2 class="text-xl font-semibold text-white flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4" />
                </svg>
                Delivery Configuration
            </h2>
        </div>

        <form method="POST" action="{{ route('dashboard.orders.shipping.update') }}" class="p-6">
            @csrf
            @method('PATCH')

            <!-- Delivery Options -->
            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17a1 1 0 11-2 0 1 1 0 012 0zm10 0a1 1 0 11-2 0 1 1 0 012 0zm-4-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v11h2a3 3 0 006 0h4a3 3 0 006 0h2v-5a1 1 0 00-1-1h-3l-3-4H7" />
                    </svg>
                    Delivery Options
                </label>

                <div class="grid grid-cols-2 gap-6">
                    <label class="flex items-center space-x-3 bg-orange-50 p-4 rounded-lg border border-orange-200 cursor-pointer">
                        <input type="checkbox" name="supports_delivery" value="1" {{ old('supports_delivery', $business->supports_delivery) ? 'checked' : '' }} class="h-5 w-5 text-orange-600 rounded focus:ring-orange-500">
                        <span class="text-gray-800 font-medium">Enable Delivery</span>
                    </label>

                    <label class="flex items-center space-x-3 bg-blue-50 p-4 rounded-lg border border-blue-200 cursor-pointer">
                        <input type="checkbox" name="supports_pickup" value="1" {{ old('supports_pickup', $business->supports_pickup) ? 'checked' : '' }} class="h-5 w-5 text-blue-600 rounded focus:ring-blue-500">
                        <span class="text-gray-800 font-medium">Enable Pickup</span>
                    </label>
                </div>

                <p class="text-sm text-gray-600 mt-2">💡 Choose which order methods you want to support.</p>
            </div>

            <!-- Shipping Type Selection -->
            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    <svg class="w-4 h-4 inline mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Shipping Type
                </label>
                <div class="relative">
                    <select name="shipping_type" class="form-select block w-full px-4 py-3 text-base border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200">
                        <option value="flat" {{ $business->shipping_type === 'flat' ? 'selected' : '' }}>
                            🎯 Flat Rate
                        </option>
                        <option value="per_km" {{ $business->shipping_type === 'per_km' ? 'selected' : '' }}>
                            📏 Per Kilometre
                        </option>
                        <option value="flat_plus_per_km" {{ $business->shipping_type === 'flat_plus_per_km' ? 'selected' : '' }}>
                            🎯📏 Flat Rate + Per Kilometre
                        </option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Flat Rate Field -->
            <div id="flat-rate-field" class="mb-8" style="display: none;">
                <div class="bg-orange-50 rounded-lg p-6 border border-orange-200">
                    <div class="flex items-center mb-4">
                        <div class="bg-orange-100 p-2 rounded-full mr-3">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Flat Rate</h3>
                    </div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Flat Rate (IDR)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">A$</span>
                        </div>
                        <input type="number" step="0.01" name="flat_rate" value="{{ old('flat_rate', $business->flat_rate) }}"
                            class="form-input block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200"
                            placeholder="0.00">
                    </div>
                    <p class="text-sm text-gray-600 mt-2">💡 A flat fee applies to all deliveries.</p>
                </div>
            </div>

            <!-- Per Km Fields -->
            <div id="per-km-field" class="mb-8" style="display: none;">
                <div class="bg-blue-50 rounded-lg p-6 border border-blue-200">
                    <div class="flex items-center mb-4">
                        <div class="bg-blue-100 p-2 rounded-full mr-3">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Per Kilometre Rate</h3>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rate per Distance Unit (IDR)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">A$</span>
                                </div>
                                <input type="number" step="0.01" name="per_km_rate" value="{{ old('per_km_rate', $business->per_km_rate) }}"
                                    class="form-input block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200"
                                    placeholder="0.00">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Distance Unit (km)</label>
                            <div class="relative">
                                <input type="number" name="per_km_unit" value="{{ old('per_km_unit', $business->per_km_unit) }}"
                                    class="form-input block w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200"
                                    min="1" placeholder="1">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">km</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-100 rounded-lg p-4 mt-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <p class="text-sm text-blue-700 font-medium">Example:</p>
                                <p class="text-sm text-blue-600 mt-1">If you set this to 2, every 2 km is counted as 1 unit of shipping. For example, 5 km = 3 units (rounded up).</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Weight-based Rate -->
            <div id="per-kg-field" class="mb-8">
                <div class="bg-green-50 rounded-lg p-6 border border-green-200">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-100 p-2 rounded-full mr-3">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v18H3V3z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Shipping Price per Kg</h3>
                    </div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price per Kg (A$)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">A$</span>
                        </div>
                        <input type="number" step="0.01" name="price_per_kg"
                            value="{{ old('price_per_kg', $business->price_per_kg) }}"
                            class="form-input block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200"
                            placeholder="0.00">
                    </div>
                    <p class="text-sm text-gray-600 mt-2">💡 Leave empty or 0 to disable weight-based pricing.</p>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-6 border-t border-gray-200">
                <button type="submit" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold rounded-lg shadow-md hover:from-orange-600 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Save Settings
                </button>
            </div>
        </form>
    </div>

    <!-- Help Section -->
    <div class="mt-8 bg-gray-50 rounded-xl p-6 border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Help & Tips
        </h3>
        <div class="grid md:grid-cols-3 gap-4">
            <div class="bg-white rounded-lg p-4 border border-gray-100">
                <h4 class="font-medium text-gray-800 mb-2">🎯 Flat Rate</h4>
                <p class="text-sm text-gray-600">Perfect for businesses with a limited delivery area or who want to keep shipping fees simple.</p>
            </div>
            <div class="bg-white rounded-lg p-4 border border-gray-100">
                <h4 class="font-medium text-gray-800 mb-2">📏 Per Kilometre</h4>
                <p class="text-sm text-gray-600">Great for longer-distance deliveries where fees are based on the actual distance.</p>
            </div>
            <div class="bg-white rounded-lg p-4 border border-gray-100">
                <h4 class="font-medium text-gray-800 mb-2">🎯📏 Combination</h4>
                <p class="text-sm text-gray-600">Mixes a fixed base fee with an extra per-kilometre charge for maximum flexibility.</p>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleFields() {
        const type = document.querySelector('[name="shipping_type"]').value;
        const flatField = document.getElementById('flat-rate-field');
        const perKmField = document.getElementById('per-km-field');

        // Add smooth transitions
        flatField.style.transition = 'all 0.3s ease';
        perKmField.style.transition = 'all 0.3s ease';

        if (type === 'flat' || type === 'flat_plus_per_km') {
            flatField.style.display = 'block';
            setTimeout(() => {
                flatField.style.opacity = '1';
                flatField.style.transform = 'translateY(0)';
            }, 10);
        } else {
            flatField.style.opacity = '0';
            flatField.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                flatField.style.display = 'none';
            }, 300);
        }

        if (type === 'per_km' || type === 'flat_plus_per_km') {
            perKmField.style.display = 'block';
            setTimeout(() => {
                perKmField.style.opacity = '1';
                perKmField.style.transform = 'translateY(0)';
            }, 10);
        } else {
            perKmField.style.opacity = '0';
            perKmField.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                perKmField.style.display = 'none';
            }, 300);
        }
    }

    document.querySelector('[name="shipping_type"]').addEventListener('change', toggleFields);
    window.onload = function() {
        toggleFields();
        // Initialize opacity for smooth transitions
        document.getElementById('flat-rate-field').style.opacity = '0';
        document.getElementById('per-km-field').style.opacity = '0';
        setTimeout(toggleFields, 100);
    };
</script>
@endsection