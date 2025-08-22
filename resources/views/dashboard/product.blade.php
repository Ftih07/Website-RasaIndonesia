@extends('layouts.app')

@section('content')
@include('dashboard.partials.navbar')

<!-- Tambahkan di <head> -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-orange-100 p-6 mb-8">
            <div class="flex items-center space-x-3">
                <div class="p-3 bg-orange-100 rounded-full">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Product Management</h1>
                    <p class="text-gray-600 mt-1">Manage your Indonesian culinary offerings</p>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ session('success') }}
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Product List -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <svg class="w-6 h-6 text-orange-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Product List
                        </h2>
                    </div>

                    <!-- Filter Section -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                        <form method="GET" action="{{ route('dashboard.product') }}" class="p-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Name Search -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                                <input type="text" id="name" name="name"
                                    value="{{ request('name') }}"
                                    placeholder="Search by name..."
                                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                                <select id="category" name="category"
                                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Option Group -->
                            <div>
                                <label for="option_group" class="block text-sm font-medium text-gray-700">Option Group</label>
                                <select id="option_group" name="option_group"
                                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                                    <option value="">All Option Groups</option>
                                    @foreach($optionGroups as $og)
                                    <option value="{{ $og->id }}" {{ request('option_group') == $og->id ? 'selected' : '' }}>
                                        {{ $og->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Stock Filter -->
                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                                <select id="stock" name="stock"
                                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                                    <option value="">All</option>
                                    <option value="in" {{ request('stock') == 'in' ? 'selected' : '' }}>In Stock</option>
                                    <option value="out" {{ request('stock') == 'out' ? 'selected' : '' }}>Out of Stock</option>
                                </select>
                            </div>

                            <!-- Is Sell Filter -->
                            <div>
                                <label for="is_sell" class="block text-sm font-medium text-gray-700">Selling Status</label>
                                <select id="is_sell" name="is_sell"
                                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                                    <option value="">All</option>
                                    <option value="1" {{ request('is_sell') === '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ request('is_sell') === '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <!-- Filter Button -->
                            <div class="flex items-end">
                                <button type="submit"
                                    class="w-full inline-flex justify-center px-4 py-2 bg-orange-600 text-white rounded-lg shadow hover:bg-orange-700 transition">
                                    Filter
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="p-6">
                        @forelse($products as $product)
                        <div class="bg-gray-50 rounded-lg p-4 mb-4 hover:shadow-md transition-shadow border border-gray-100">
                            <div class="flex flex-col md:flex-row gap-4">
                                <!-- Product Image -->
                                <div class="flex-shrink-0">
                                    @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                        class="w-24 h-24 object-cover rounded-lg shadow-sm"
                                        alt="{{ $product->name }}">
                                    @else
                                    <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    @endif
                                </div>

                                <!-- Product Info -->
                                <div class="flex-grow">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $product->name }}</h3>

                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 mb-3">
                                        <div class="flex items-center text-sm text-gray-600">
                                            <span class="text-orange-600 font-medium">$</span>
                                            <span class="ml-1">{{ $product->price }}</span>
                                        </div>
                                        @if($product->serving)
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            {{ $product->serving }}
                                        </div>
                                        @endif
                                        @if($product->max_distance)
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ $product->max_distance }} km
                                        </div>
                                        @endif
                                        {{-- ✅ Stok Produk --}}
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 3h18v18H3V3z"></path>
                                            </svg>
                                            Stok: <span class="ml-1 font-medium text-gray-800">{{ $product->stock }}</span>
                                        </div>
                                    </div>

                                    @if($product->desc)
                                    <p class="text-gray-600 text-sm mb-3">{{ $product->desc }}</p>
                                    @endif

                                    <!-- Categories and Options -->
                                    <div class="space-y-2">
                                        @if($product->categories->count())
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span class="text-xs font-medium text-gray-500">Categories:</span>
                                            @foreach($product->categories as $category)
                                            <span class="px-2 py-1 bg-orange-100 text-orange-700 text-xs rounded-full">
                                                {{ $category->name }}
                                            </span>
                                            @endforeach
                                        </div>
                                        @endif

                                        @if($product->optionGroups->count())
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span class="text-xs font-medium text-gray-500">Options:</span>
                                            @foreach($product->optionGroups as $group)
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full">
                                                {{ $group->name }}
                                            </span>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex flex-row md:flex-col gap-2 justify-end">
                                    <a href="{{ route('dashboard.product.edit', $product->id) }}"
                                        class="inline-flex items-center justify-center px-3 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('dashboard.product.destroy', $product->id) }}" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center justify-center px-3 py-2 bg-red-50 text-red-700 rounded-lg hover:bg-red-100 transition-colors"
                                            onclick="return confirm('Are you sure you want to delete this product?')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                    <!-- Toggle Sell Status -->
                                    <label class="inline-flex items-center cursor-pointer"
                                        title="{{ $product->business->orders_status !== 'approved' ? 'Your business must be approved before selling this product.' : '' }}">
                                        <input
                                            type="checkbox"
                                            class="toggle-sell-status sr-only"
                                            data-product-id="{{ $product->id }}"
                                            {{ $product->is_sell ? 'checked' : '' }}
                                            {{ $product->business->orders_status !== 'approved' ? 'disabled' : '' }}>
                                        <div class="w-10 h-5 bg-gray-200 rounded-full p-1 flex items-center transition {{ $product->is_sell ? 'bg-green-500' : '' }}">
                                            <div class="bg-white w-4 h-4 rounded-full shadow transform transition {{ $product->is_sell ? 'translate-x-5' : '' }}"></div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <p class="text-gray-500">No products added yet</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Add Product Form -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add New Product
                        </h2>
                    </div>

                    <div class="p-6">
                        <form action="{{ route('dashboard.product.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
                                    <input type="text" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Price ($)</label>
                                    <input type="number" name="price" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                </div>
                            </div>

                            <!-- ✅ New field for Stock -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Stock</label>
                                <input type="number" name="stock" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" required>
                                <p class="text-xs text-gray-500 mt-1">Available quantity of this product.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Product Image</label>
                                <input type="file" name="image" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Serving Size</label>
                                    <input type="text" name="serving" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Max Distance (km)</label>
                                    <input type="number" name="max_distance" min="1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <textarea name="desc" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"></textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Categories -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Food Categories</label>
                                    <select id="food-categories" name="categories[]" multiple class="w-full">
                                        @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-xs text-gray-500 mt-1">You can type to search & hold Ctrl/Cmd to select multiple</p>
                                </div>

                                <!-- Option Groups -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Option Groups</label>
                                    <select id="option-groups" name="option_groups[]" multiple class="w-full">
                                        @foreach($optionGroups as $group)
                                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                                        @endforeach
                                    </select>
                                    <p class="text-xs text-gray-500 mt-1">You can type to search & hold Ctrl/Cmd to select multiple</p>
                                </div>
                            </div>


                            <div class="flex justify-end">
                                <button type="submit" class="px-6 py-3 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors font-medium flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add Product
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Categories Management -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Categories
                        </h2>
                    </div>

                    <div class="p-6">
                        <form action="{{ route('dashboard.product.category.store') }}" method="POST" class="mb-6">
                            @csrf
                            <div class="flex gap-2">
                                <input type="text" name="name" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500" placeholder="Category name" required>
                                <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                            </div>
                        </form>

                        <div class="space-y-2">
                            @foreach($categories as $cat)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                @if(request('edit') == $cat->id)
                                <form action="{{ route('dashboard.product.category.update', $cat->id) }}" method="POST" class="flex-1 flex gap-2">
                                    @csrf @method('PUT')
                                    <input type="text" name="name" value="{{ $cat->name }}" class="flex-1 px-2 py-1 border border-gray-300 rounded focus:ring-1 focus:ring-yellow-500" required>
                                    <button type="submit" class="px-2 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </button>
                                    <a href="{{ route('dashboard.product') }}" class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </a>
                                </form>
                                @else
                                <span class="flex-1 text-sm font-medium text-gray-700">{{ $cat->name }}</span>
                                <div class="flex gap-1">
                                    <a href="{{ route('dashboard.product', ['edit' => $cat->id]) }}" class="p-1 text-blue-600 hover:bg-blue-50 rounded">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('dashboard.product.category.destroy', $cat->id) }}" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-1 text-red-600 hover:bg-red-50 rounded" onclick="return confirm('Delete this category?')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Option Groups Management -->
                <div id="option-groups" class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                            <svg class="w-5 h-5 text-orange-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                            Option Groups
                        </h2>
                    </div>

                    <div class="p-6">
                        <form action="{{ route('dashboard.product.optionGroup.store') }}" method="POST" class="space-y-4 mb-6">
                            @csrf

                            <div>
                                <input type="text" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" placeholder="Group name" required>
                            </div>

                            <div class="flex items-center space-x-4">
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_required" class="rounded text-orange-600 focus:ring-orange-500">
                                    <span class="ml-2 text-sm text-gray-700">Required</span>
                                </label>
                                <div class="flex-1">
                                    <input type="number" name="max_selection" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500" placeholder="Max selection">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Options</label>
                                <div id="option-container" class="space-y-2">
                                    <div class="option-row flex gap-2">
                                        <input type="text" name="options[0][name]" placeholder="Option name" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg" required>
                                        <input type="number" name="options[0][price]" step="0.01" placeholder="Price" class="w-24 px-3 py-2 border border-gray-300 rounded-lg">
                                    </div>
                                </div>
                                <button type="button" onclick="addOption()" class="mt-2 text-sm text-orange-600 hover:text-orange-700 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Add Option
                                </button>
                            </div>

                            <button type="submit" class="w-full px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                                Save Group
                            </button>
                        </form>

                        <div class="space-y-3">
                            @foreach($optionGroups as $group)
                            <div class="border border-gray-200 rounded-lg p-3">
                                @if(request('edit_option') == $group->id)
                                <form action="{{ route('dashboard.product.optionGroup.update', $group->id) }}" method="POST" class="space-y-4">
                                    @csrf @method('PUT')

                                    <input type="text" name="name" value="{{ $group->name }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>

                                    <div class="flex items-center space-x-4">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="is_required" class="rounded text-orange-600" {{ $group->is_required ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm">Required</span>
                                        </label>
                                        <input type="number" name="max_selection" value="{{ $group->max_selection }}" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg" placeholder="Max selection">
                                    </div>

                                    <div>
                                        <div id="edit-option-container" class="space-y-2">
                                            @foreach($group->options as $i => $opt)
                                            <div class="option-row flex gap-2">
                                                <input type="hidden" name="options[{{ $i }}][id]" value="{{ $opt->id }}">
                                                <input type="text" name="options[{{ $i }}][name]" value="{{ $opt->name }}" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg" required>
                                                <input type="number" name="options[{{ $i }}][price]" value="{{ $opt->price }}" step="0.01" class="w-24 px-3 py-2 border border-gray-300 rounded-lg">
                                                <button type="button" onclick="removeOptionRow(this)" class="px-2 py-2 text-red-600 hover:bg-red-50 rounded">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            @endforeach
                                        </div>
                                        <button type="button" onclick="addEditOption()" class="mt-2 text-sm text-orange-600 hover:text-orange-700 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Add Option
                                        </button>
                                    </div>

                                    <div class="flex gap-2">
                                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Update
                                        </button>
                                        <a href="{{ route('dashboard.product') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                                            Cancel
                                        </a>
                                    </div>
                                </form>
                                @else
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="font-medium text-gray-800">{{ $group->name }}</h4>
                                        <p class="text-sm text-gray-600">
                                            {{ $group->is_required ? 'Required' : 'Optional' }}
                                            @if($group->max_selection) | Max: {{ $group->max_selection }} @endif
                                        </p>
                                    </div>
                                    <div class="flex gap-1">
                                        <a href="{{ route('dashboard.product', ['edit_option' => $group->id]) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('dashboard.product.optionGroup.destroy', $group->id) }}" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded" onclick="return confirm('Delete this group?')">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.toggle-sell-status').forEach((checkbox) => {
        checkbox.addEventListener('change', function() {
            const productId = this.dataset.productId;
            const currentState = this.checked;

            fetch('{{ route("dashboard.product.toggle-sell") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) {
                        alert(data.message || 'Gagal mengubah status');
                        this.checked = !currentState; // Balikin ke posisi awal
                    } else {
                        // Optional: ubah warna switch langsung
                        const wrapper = this.nextElementSibling;
                        wrapper.classList.toggle('bg-green-500', data.is_sell);
                        wrapper.querySelector('div').classList.toggle('translate-x-5', data.is_sell);
                    }
                })
                .catch(() => {
                    alert('Terjadi kesalahan koneksi');
                    this.checked = !currentState;
                });
        });
    });
</script>

<script>
    let optionIndex = 1;

    function addOption() {
        const container = document.getElementById('option-container');
        const div = document.createElement('div');
        div.className = 'option-row flex gap-2';
        div.innerHTML = `
            <input type="text" name="options[${optionIndex}][name]" placeholder="Option name" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg" required>
            <input type="number" name="options[${optionIndex}][price]" step="0.01" placeholder="Price" class="w-24 px-3 py-2 border border-gray-300 rounded-lg">
            <button type="button" onclick="removeOptionRow(this)" class="px-2 py-2 text-red-600 hover:bg-red-50 rounded">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        `;
        container.appendChild(div);
        optionIndex++;
    }

    function removeOptionRow(button) {
        const row = button.closest('.option-row');
        row.remove();
    }

    function addEditOption() {
        const container = document.getElementById('edit-option-container');
        const index = container.children.length;

        const div = document.createElement('div');
        div.classList.add('option-row', 'flex', 'gap-2');
        div.innerHTML = `
            <input type="text" name="options[${index}][name]" placeholder="Option name" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg" required>
            <input type="number" name="options[${index}][price]" step="0.01" placeholder="Price" class="w-24 px-3 py-2 border border-gray-300 rounded-lg">
            <button type="button" onclick="removeOptionRow(this)" class="px-2 py-2 text-red-600 hover:bg-red-50 rounded">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        `;
        container.appendChild(div);
    }

    // Mobile-friendly interactions
    document.addEventListener('DOMContentLoaded', function() {
        // Add touch-friendly hover states for mobile
        const buttons = document.querySelectorAll('button, a');
        buttons.forEach(button => {
            button.addEventListener('touchstart', function() {
                this.style.transform = 'scale(0.95)';
            });
            button.addEventListener('touchend', function() {
                this.style.transform = 'scale(1)';
            });
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<script>
    new TomSelect('#food-categories', {
        plugins: ['remove_button'],
        create: false,
        maxItems: null,
        placeholder: "Select food categories...",
    });

    new TomSelect('#option-groups', {
        plugins: ['remove_button'],
        create: false,
        maxItems: null,
        placeholder: "Select option groups...",
    });
</script>

<!-- Tambahkan sebelum </body> -->

@endsection