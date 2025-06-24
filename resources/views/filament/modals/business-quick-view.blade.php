{{--
    resources/views/filament/modals/business-quick-view.blade.php

    This Blade template is used to display a quick overview of a business
    within a Filament modal. It provides a concise summary of key business
    details, contact information, services, and opening hours.

    The `$business` variable is passed into this view, which is an Eloquent
    model instance of the Business.

    This file uses Tailwind CSS for styling.
--}} 

{{-- Main container for the modal content --}}
<div class="p-4 sm:p-6 space-y-6 bg-white dark:bg-gray-900 transition-colors duration-200">
    {{--
        Header Section: Displays the business logo, name, type, QR status, and location.
        Uses flexbox for responsive layout (column on small screens, row on larger).
    --}}
    <div class="flex flex-col sm:flex-row items-start space-y-4 sm:space-y-0 sm:space-x-4">
        {{-- Logo Section: Displays the business logo or a placeholder icon if no logo exists. --}}
        <div class="flex-shrink-0 mx-auto sm:mx-0">
            @if($business->logo)
            {{-- If a logo path exists, display the image. --}}
            <img src="{{ asset('storage/' . $business->logo) }}"
                alt="{{ $business->name }}"
                class="w-20 h-20 sm:w-16 sm:h-16 rounded-full object-cover border-2 border-gray-200 dark:border-gray-700 shadow-md">
            @else
            {{-- If no logo, display a placeholder icon. --}}
            <div class="w-20 h-20 sm:w-16 sm:h-16 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center shadow-md border border-gray-200 dark:border-gray-700">
                <svg class="w-10 h-10 sm:w-8 sm:h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h2M7 21V5a2 2 0 012-2h5.586a1 1 0 01.707.293l2.414 2.414a1 1 0 01.293.707V21" />
                </svg>
            </div>
            @endif
        </div>

        {{-- Business Info: Displays the business name, type badge, QR status badge, and location. --}}
        <div class="flex-1 min-w-0 text-center sm:text-left">
            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white truncate mb-3 sm:mb-2">
                {{ $business->name }}
            </h3>
            <br> {{-- Line break for spacing --}}
            {{-- Badges: Displays business type and QR code status as visually distinct labels. --}}
            <div class="flex flex-wrap justify-center sm:justify-start items-center gap-2 mb-3">
                @if($business->type)
                {{-- Business Type Badge --}}
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 border border-blue-200 dark:border-blue-800">
                    {{ $business->type->title }}
                </span>
                @endif

                @if($business->qrLink)
                {{-- QR Code Active Badge (if qrLink relationship exists) --}}
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 border border-green-200 dark:border-green-800">
                    {{-- QR Code Icon --}}
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                    QR Code Active
                </span>
                @endif
            </div>
            <br> {{-- Line break for spacing --}}
            {{-- Location: Displays city and country if available. --}}
            @if($business->city || $business->country)
            <p class="text-sm text-gray-600 dark:text-gray-400 flex items-center justify-center sm:justify-start">
                {{-- Map Pin Icon --}}
                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                {{-- Combines city and country, filtering out empty values. --}}
                {{ collect([$business->city, $business->country])->filter()->implode(', ') }}
            </p>
            @endif
        </div>
    </div>

    {{-- Description Section --}}
    @if($business->description)
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
        <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-2 flex items-center">
            {{-- Description Icon --}}
            <svg class="w-4 h-4 mr-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l2.414 2.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Description
        </h4>
        <p class="text-sm text-gray-300 dark:text-gray-300 leading-relaxed">{{ $business->description }}</p>
    </div>
    @endif

    {{-- Main Content Grid: Arranges Contact Information and Business Details side-by-side on larger screens. --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Contact Information Card --}}
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700 space-y-4">
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2 flex items-center">
                {{-- Contact Icon --}}
                <svg class="w-5 h-5 mr-2 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                Contact Information
            </h4>

            {{-- Address Field --}}
            @if($business->address)
            <div class="flex items-start space-x-3 p-3 bg-white dark:bg-gray-900 rounded-md border border-gray-100 dark:border-gray-600">
                {{-- Address Icon --}}
                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Address</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 break-words">{{ $business->address }}</p>
                </div>
            </div>
            @endif

            {{-- Contact Methods Field --}}
            @if($business->contact && count($business->contact) > 0)
            <div class="flex items-start space-x-3 p-3 bg-white dark:bg-gray-900 rounded-md border border-gray-100 dark:border-gray-600">
                {{-- Phone Icon --}}
                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Contact Methods</p>
                    <div class="space-y-1 mt-1">
                        {{-- Loop through each contact method --}}
                        @foreach($business->contact as $contact)
                        @if(is_array($contact))
                        {{-- If contact is an associative array (e.g., ['type' => 'Phone', 'value' => '123-456-7890']) --}}
                        <p class="text-sm text-gray-700 dark:text-gray-300 break-words">
                            <span class="font-medium text-gray-900 dark:text-white">{{ ucfirst($contact['type'] ?? 'Other') }}:</span>
                            {{ $contact['value'] ?? '-' }}
                        </p>
                        @else
                        {{-- If contact is a simple string (fallback for older/different formats) --}}
                        <p class="text-sm text-gray-700 dark:text-gray-300 break-words">{{ $contact }}</p>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- Social Media Field --}}
            @if($business->media_social && count($business->media_social) > 0)
            <div class="flex items-start space-x-3 p-3 bg-white dark:bg-gray-900 rounded-md border border-gray-100 dark:border-gray-600">
                {{-- Share Icon --}}
                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z" />
                </svg>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Social Media</p>
                    <div class="space-y-1 mt-1">
                        {{-- Loop through each social media entry --}}
                        @foreach($business->media_social as $social)
                        @if(is_array($social))
                        {{-- If social media is an associative array (e.g., ['platform' => 'Facebook', 'link' => 'https://facebook.com/biz']) --}}
                        <p class="text-sm break-words">
                            <span class="font-medium text-gray-900 dark:text-white">{{ ucfirst($social['platform'] ?? 'Media') }}:</span>
                            <a href="{{ $social['link'] ?? '#' }}" class="text-blue-600 dark:text-blue-400 underline" target="_blank">
                                {{ $social['link'] ?? '-' }}
                            </a>
                        </p>
                        @else
                        {{-- If social media is a simple string (fallback for older/different formats) --}}
                        <p class="text-sm text-blue-600 dark:text-blue-400 break-words">{{ $social }}</p>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        {{-- Business Details Card --}}
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700 space-y-4">
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2 flex items-center">
                {{-- Business Icon --}}
                <svg class="w-5 h-5 mr-2 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h2M7 21V5a2 2 0 012-2h5.586a1 1 0 01.707.293l2.414 2.414a1 1 0 01.293.707V21" />
                </svg>
                Business Details
            </h4>

            {{-- Food Categories Field --}}
            @if($business->food_categories && $business->food_categories->count() > 0)
            <div class="flex items-start space-x-3 p-3 bg-white dark:bg-gray-900 rounded-md border border-gray-100 dark:border-gray-600">
                {{-- Tag Icon --}}
                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white mb-2">Food Categories</p>
                    <div class="flex flex-wrap gap-1">
                        {{-- Loop through each food category and display as a badge --}}
                        @foreach($business->food_categories as $category)
                        <span class="inline-block px-2 py-1 text-xs bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200 rounded border border-orange-200 dark:border-orange-800">
                            {{ $category->title }}
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            {{-- Services Field --}}
            @if($business->services)
            <div class="flex items-start space-x-3 p-3 bg-white dark:bg-gray-900 rounded-md border border-gray-100 dark:border-gray-600">
                {{-- Checkmark Icon --}}
                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
                <div class="min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white mb-2">Services</p>
                    <div class="flex flex-wrap gap-1">
                        {{-- Check if services is an array, then loop and display each service as a badge. --}}
                        @if(is_array($business->services))
                        @foreach($business->services as $service)
                        <span class="inline-block px-2 py-1 text-xs bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 rounded border border-purple-200 dark:border-purple-800">
                            {{ $service }}
                        </span>
                        @endforeach
                        @else
                        {{-- If services is a single string (fallback). --}}
                        <span class="inline-block px-2 py-1 text-xs bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 rounded border border-purple-200 dark:border-purple-800">
                            {{ $business->services }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            {{-- Products Count Field --}}
            <div class="flex items-start space-x-3 p-3 bg-white dark:bg-gray-900 rounded-md border border-gray-100 dark:border-gray-600">
                {{-- Products Icon --}}
                <svg class="w-5 h-5 text-gray-400 dark:text-gray-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <div>
                    <p class="text-sm font-medium text-gray-900 dark:text-white">Products</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $business->products_count ?? 0 }}</span> product(s) available
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Opening Hours Section --}}
    @if($business->open_hours && count($business->open_hours) > 0)
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
        <h4 class="text-lg font-semibold text-gray-900 dark:text-white border-b border-gray-200 dark:border-gray-700 pb-2 mb-4 flex items-center">
            {{-- Clock Icon --}}
            <svg class="w-5 h-5 mr-2 text-indigo-500 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Opening Hours
        </h4>
        {{-- Grid for opening hours, responsive columns --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            {{-- Loop through each day's opening hours --}}
            @foreach($business->open_hours as $day => $hours)
            <div class="flex justify-between items-center py-3 px-4 bg-white dark:bg-gray-900 rounded-md border border-gray-100 dark:border-gray-600 hover:shadow-sm transition-shadow duration-200">
                <span class="text-sm font-medium text-gray-900 dark:text-white capitalize">{{ $day }}</span>
                <span class="text-sm text-gray-600 dark:text-gray-400 font-mono">{{ $hours }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Footer Info: Displays creation date and unique code (if available). --}}
    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 flex flex-col sm:flex-row justify-between items-center gap-2 text-xs text-gray-500 dark:text-gray-400">
        <div class="flex items-center space-x-2">
            {{-- Calendar Icon --}}
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h6m-6 0l1 12a2 2 0 002 2h2a2 2 0 002-2l1-12" />
            </svg>
            <span>Created: {{ $business->created_at->format('M j, Y') }}</span>
        </div>
        @if($business->unique_code)
        <div class="flex items-center space-x-2">
            {{-- Barcode Icon --}}
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
            </svg>
            <span class="bg-gray-200 dark:bg-gray-700 px-2 py-1 rounded font-mono text-gray-400">
                {{ $business->unique_code }}
            </span>
        </div>
        @endif
    </div>
</div>