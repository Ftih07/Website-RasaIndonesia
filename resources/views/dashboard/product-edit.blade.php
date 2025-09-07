@extends('layouts.app')

@section('content')
@include('dashboard.partials.navbar')

<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<div class="min-h-screen bg-gray-50 py-6">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-orange-500 to-yellow-500 px-6 py-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h1 class="text-2xl font-bold text-white">Edit Product</h1>
                            <p class="text-orange-100">{{ $product->name }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Section -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="px-6 py-8">
                    <form action="{{ route('dashboard.product.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Product Name -->
                        <div class="form-group">
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                <span class="flex items-center">
                                    <svg class="h-4 w-4 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Product Name
                                </span>
                            </label>
                            <input type="text" name="name" id="name"
                                class="form-control block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200"
                                value="{{ $product->name }}"
                                required
                                placeholder="Enter product name">
                        </div>

                        <!-- Product Image -->
                        <div class="form-group">
                            <label for="image" class="block text-sm font-semibold text-gray-700 mb-2">
                                <span class="flex items-center">
                                    <svg class="h-4 w-4 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Product Image <span class="text-gray-500 font-normal">(Optional)</span>
                                </span>
                            </label>

                            @if($product->image)
                            <div class="mb-4 p-4 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                                <img src="{{ asset('storage/' . $product->image) }}"
                                    class="h-24 w-24 object-cover rounded-lg border border-gray-300 shadow-sm"
                                    alt="Current product image">
                            </div>
                            @endif

                            <div class="relative">
                                <input type="file" name="image" id="image"
                                    class="form-control block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200"
                                    accept="image/*">
                            </div>
                        </div>

                        <!-- Price and Serving Row -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <span class="flex items-center">
                                        <svg class="h-4 w-4 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                        Price (AUD)
                                    </span>
                                </label>
                                <input type="number" name="price" id="price" step="0.01"
                                    class="form-control block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200"
                                    value="{{ $product->price }}"
                                    placeholder="0.00">
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="serving" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <span class="flex items-center">
                                        <svg class="h-4 w-4 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        Serving Size
                                    </span>
                                </label>
                                <input type="text" name="serving" id="serving"
                                    class="form-control block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200"
                                    value="{{ $product->serving }}"
                                    placeholder="e.g., 1-2 people, 500g">
                            </div>
                        </div>

                        <!-- Stock -->
                        <div class="form-group mb-4">
                            <label for="stock" class="block text-sm font-semibold text-gray-700 mb-2">
                                <span class="flex items-center">
                                    <svg class="h-4 w-4 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v4H3V3zm0 6h18v12H3V9z"></path>
                                    </svg>
                                    Stock
                                </span>
                            </label>
                            <input type="number" name="stock" id="stock" min="0"
                                class="form-control block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200"
                                value="{{ old('stock', $product->stock) }}"
                                placeholder="Enter stock quantity">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="weight" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Weight (gr)
                                </label>
                                <input type="number" name="weight" id="weight" step="0.01" min="0"
                                    class="form-control block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200"
                                    value="{{ old('weight', $product->weight) }}"
                                    placeholder="e.g., 500">
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="length" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Length (cm)
                                </label>
                                <input type="number" name="length" id="length" step="0.01" min="0"
                                    class="form-control block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200"
                                    value="{{ old('length', $product->length) }}"
                                    placeholder="e.g., 10">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="width" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Width (cm)
                                </label>
                                <input type="number" name="width" id="width" step="0.01" min="0"
                                    class="form-control block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200"
                                    value="{{ old('width', $product->width) }}"
                                    placeholder="e.g., 15">
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="height" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Height (cm)
                                </label>
                                <input type="number" name="height" id="height" step="0.01" min="0"
                                    class="form-control block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200"
                                    value="{{ old('height', $product->height) }}"
                                    placeholder="e.g., 8">
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="desc" class="block text-sm font-semibold text-gray-700 mb-2">
                                <span class="flex items-center">
                                    <svg class="h-4 w-4 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Description
                                </span>
                            </label>
                            <textarea name="desc" id="desc" rows="4"
                                class="form-control block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200 resize-none"
                                placeholder="Describe your delicious Indonesian dish...">{{ $product->desc }}</textarea>
                        </div>

                        <!-- Max Distance -->
                        <div class="form-group">
                            <label for="max_distance" class="block text-sm font-semibold text-gray-700 mb-2">
                                <span class="flex items-center">
                                    <svg class="h-4 w-4 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Maximum Delivery Distance (km)
                                </span>
                            </label>
                            <input type="number" name="max_distance" id="max_distance" min="1"
                                class="form-control block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200"
                                value="{{ $product->max_distance }}"
                                placeholder="e.g., 15">
                        </div>

                        <!-- Option Groups and Categories Row -->
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="option_groups" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <span class="flex items-center">
                                        <svg class="h-4 w-4 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                                        </svg>
                                        Option Groups
                                    </span>
                                </label>
                                <select name="option_groups[]" id="option_groups" multiple
                                    class="form-control block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200"
                                    style="min-height: 120px;">
                                    @foreach($optionGroups as $group)
                                    <option value="{{ $group->id }}" {{ $product->optionGroups->contains($group->id) ? 'selected' : '' }}>
                                        {{ $group->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Hold Ctrl/Cmd to select multiple options</p>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="categories" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <span class="flex items-center">
                                        <svg class="h-4 w-4 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                        Categories
                                    </span>
                                </label>
                                <select name="categories[]" id="categories" multiple
                                    class="form-control block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition duration-200"
                                    style="min-height: 120px;">
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $product->categories->contains($cat->id) ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Hold Ctrl/Cmd to select multiple categories</p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                            <button type="submit"
                                class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-gradient-to-r from-orange-500 to-yellow-500 hover:from-orange-600 hover:to-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition duration-200 shadow-lg">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                Update Product
                            </button>

                            <a href="{{ route('dashboard.product') }}"
                                class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-200">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Help Section -->
            <div class="mt-6 bg-gradient-to-r from-orange-50 to-yellow-50 rounded-lg border border-orange-200 p-6">
                <div class="flex items-start">
                    <svg class="h-6 w-6 text-orange-500 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-orange-800">Need Help?</h3>
                        <p class="mt-1 text-sm text-orange-700">
                            Make sure to upload high-quality images of your Indonesian dishes.
                            Include detailed descriptions to help customers understand what makes your food special!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Additional responsive styles for mobile optimization */
    @media (max-width: 640px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .form-control {
            font-size: 16px;
            /* Prevents zoom on iOS */
        }

        select[multiple] {
            min-height: 100px;
        }
    }

    /* Enhanced select styling */
    select[multiple] option {
        padding: 8px 12px;
        margin: 2px 0;
    }

    select[multiple] option:checked {
        background: linear-gradient(to right, #f97316, #eab308);
        color: white;
    }

    /* Custom focus styles */
    .form-control:focus {
        box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
        border-color: #f97316;
    }

    /* Loading animation for form submission */
    button[type="submit"]:active {
        transform: scale(0.98);
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
    new TomSelect('#option_groups', {
        plugins: ['remove_button'],
        create: false,
        maxItems: null,
        placeholder: "Select option groups...",
    });

    new TomSelect('#categories', {
        plugins: ['remove_button'],
        create: false,
        maxItems: null,
        placeholder: "Select categories...",
    });
</script>
@endsection