{{--
    resources/views/filament/pages/business-stats.blade.php

    This Blade template is responsible for displaying a comprehensive dashboard
    of business statistics within the Filament admin panel. It calculates
    and presents various metrics such as business completeness, recent activity,
    and distribution by business type.

    The PHP logic at the top fetches and processes data from the database
    to prepare it for display in the HTML sections below.

    This file utilizes Tailwind CSS for styling and Heroicons for SVG icons.
--}}

@php
// Import necessary classes for Eloquent models and Carbon for date manipulation.
use App\Models\Business;
use Illuminate\Support\Carbon;
use App\Models\Type; // Assuming 'Type' model exists for business types
use App\Models\QrLink; // Assuming 'QrLink' model exists for QR codes

// --- Data Preparation ---
// Fetch all businesses from the database and eager-load the count of their products.
// withCount('products') efficiently gets the number of related products for each business.
$businesses = Business::withCount('products')
->with('qrLink') // Eager load qrLink to check for its existence
->get(); 

// Calculate total number of businesses for overall statistics.
$totalBusinesses = $businesses->count();

// --- 1. Business Profile Completeness Calculation ---
// Initializes an array to store counts for each completeness status.
$completenessStats = [
'Complete' => 0,
'Good' => 0,
'Incomplete' => 0,
'Needs Work' => 0,
];

// Iterates through each business to calculate its completeness score.
foreach ($businesses as $record) {
$score = 0; // Initialize score for the current business.
$total = 8; // Total number of criteria for a "complete" business profile.

// Check if each essential field is filled and increment the score.
if ($record->name) $score++;
if ($record->address) $score++;
if ($record->type_id) $score++;
// Check if 'contact' is not empty (assuming it's a JSON array/object field).
if ($record->contact && count($record->contact) > 0) $score++;
if ($record->logo) $score++;
if ($record->description) $score++;
// Check if 'open_hours' is not empty (assuming it's a JSON array/object field).
if ($record->open_hours && count($record->open_hours) > 0) $score++;
// Check if the business has at least one product using the products_count from withCount.
if ($record->products_count > 0) $score++;

// Calculate the percentage of completeness.
$percentage = ($score / $total) * 100;

// Assign the business to a completeness category based on its percentage.
if ($percentage >= 90) $completenessStats['Complete']++;
elseif ($percentage >= 70) $completenessStats['Good']++;
elseif ($percentage >= 50) $completenessStats['Incomplete']++;
else $completenessStats['Needs Work']++;
}

// Add Tailwind CSS color classes to each completeness status for visual representation.
// This makes it easy to render different colored indicators in the UI.
$completenessStats = collect($completenessStats)->map(function ($count, $status) {
$color = match ($status) {
'Complete' => 'bg-green-500',
'Good' => 'bg-blue-500',
'Incomplete' => 'bg-yellow-500',
'Needs Work' => 'bg-red-500',
default => 'bg-gray-500', // Fallback color
};
return ['count' => $count, 'color' => $color];
});

// --- 2. Calculate Businesses with QR Codes ---
// Filter the fetched businesses to count how many have an associated QR link.
// Assumes 'qrLink' is a relationship on the Business model.
$withQR = $businesses->filter(fn($business) => $business->qrLink !== null)->count();

// --- 3. Calculate Businesses with Products ---
// Directly use the products_count loaded via withCount for efficiency.
$withProducts = $businesses->filter(fn($business) => $business->products_count > 0)->count();

// --- 4. Business Types Breakdown Calculation ---
// Groups businesses by their associated type's title.
// If a business doesn't have a type, it will be grouped under 'No Type'.
// Eager loading `type` relationship on `Business` model is recommended for efficiency.
$byType = $businesses->groupBy(function ($business) {
return $business->type->title ?? 'No Type';
});


// --- 5. Recent Activity Statistics Calculation ---
// Calculates new and updated business counts for different time periods.
// `Carbon::today()`, `startOfWeek()`, `startOfMonth()`, `subDays()` are used
// to define the start of each period.

// Today
$todayStart = Carbon::today();
$recentTodayNew = Business::whereDate('created_at', $todayStart)->count();
$recentTodayUpdated = Business::whereDate('updated_at', $todayStart)->count();

// This Week (from start of the current week)
$weekStart = Carbon::now()->startOfWeek();
$recentWeekNew = Business::whereDate('created_at', '>=', $weekStart)->count();
$recentWeekUpdated = Business::whereDate('updated_at', '>=', $weekStart)->count();

// This Month (from start of the current month)
$monthStart = Carbon::now()->startOfMonth();
$recentMonthNew = Business::whereDate('created_at', '>=', $monthStart)->count();
$recentMonthUpdated = Business::whereDate('updated_at', '>=', $monthStart)->count();

// Last 30 Days (from 30 days ago up to now)
$days30 = Carbon::now()->subDays(30);
$recent30New = Business::whereDate('created_at', '>=', $days30)->count();
$recent30Updated = Business::whereDate('updated_at', '>=', $days30)->count();

// Consolidate recent activity stats into a structured array for easy display.
$recentStats = [
['period' => 'Today', 'new' => $recentTodayNew, 'updated' => $recentTodayUpdated],
['period' => 'This Week', 'new' => $recentWeekNew, 'updated' => $recentWeekUpdated],
['period' => 'This Month', 'new' => $recentMonthNew, 'updated' => $recentMonthUpdated],
['period' => 'Last 30 Days', 'new' => $recent30New, 'updated' => $recent30Updated],
];
@endphp

{{-- Main container for the statistics dashboard, with consistent padding and spacing --}}
<div class="p-6 space-y-6">
    {{-- Header Section: Page title and subtitle --}}
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Business Statistics</h2>
        <p class="text-gray-600 mt-2 dark:text-gray-400">Overview of all registered businesses</p>
    </div>

    {{-- Main Stats Cards Grid: Displays high-level aggregated numbers --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Total Businesses Card --}}
        <div class="rounded-lg p-6 shadow-lg bg-blue-100 text-blue-900 dark:bg-blue-900 dark:text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-700 dark:text-blue-200">Total Businesses</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($totalBusinesses) }}</p>
                </div>
                {{-- Icon for Total Businesses (Building/Storefront) --}}
                <div class="bg-blue-300 dark:bg-blue-700 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8 text-blue-700 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h2M7 21V5a2 2 0 012-2h5.586a1 1 0 01.707.293l2.414 2.414a1 1 0 01.293.707V21" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Businesses With QR Codes Card --}}
        <div class="rounded-lg p-6 shadow-lg bg-green-100 text-green-900 dark:bg-green-900 dark:text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-700 dark:text-green-200">With QR Codes</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($withQR) }}</p>
                    {{-- Percentage of businesses with QR codes out of total --}}
                    <p class="text-xs mt-1 text-green-600 dark:text-green-300">
                        {{ $totalBusinesses > 0 ? round(($withQR / $totalBusinesses) * 100, 1) : 0 }}% of total
                    </p>
                </div>
                {{-- Icon for QR Codes --}}
                <div class="bg-green-300 dark:bg-green-700 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8 text-green-700 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Businesses With Products Card --}}
        <div class="rounded-lg p-6 shadow-lg bg-orange-100 text-orange-900 dark:bg-orange-900 dark:text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-orange-700 dark:text-orange-200">With Products</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($withProducts) }}</p>
                    {{-- Percentage of businesses with products out of total --}}
                    <p class="text-xs mt-1 text-orange-600 dark:text-orange-300">
                        {{ $totalBusinesses > 0 ? round(($withProducts / $totalBusinesses) * 100, 1) : 0 }}% of total
                    </p>
                </div>
                {{-- Icon for Products (Box/Package) --}}
                <div class="bg-orange-300 dark:bg-orange-700 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8 text-orange-700 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Businesses That Need Work Card (from completeness calculation) --}}
        <div class="rounded-lg p-6 shadow-lg bg-yellow-100 text-yellow-900 dark:bg-yellow-900 dark:text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-yellow-700 dark:text-yellow-200">Businesses Need Work</p>
                    {{-- Displays the count of businesses marked as 'Needs Work' --}}
                    <p class="text-3xl font-bold mt-2">{{ number_format($completenessStats['Needs Work']['count'] ?? 0) }}</p>
                    <p class="text-xs mt-1 text-yellow-600 dark:text-yellow-300">Incomplete profiles & missing data</p>
                </div>
                {{-- Icon for Alert/Warning --}}
                <div class="bg-yellow-300 dark:bg-yellow-700 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8 text-yellow-700 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4
                            c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Business Types Breakdown Section --}}
    <div class="bg-white rounded-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        {{-- Section Header --}}
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Business Types Breakdown</h3>
            <p class="text-sm text-gray-600 mt-1 dark:text-gray-400">Distribution of businesses by type</p>
        </div>
        <div class="p-6">
            @if($byType->count() > 0)
            <div class="space-y-4">
                {{-- Loop through each business type and display its count and a progress bar --}}
                @foreach($byType as $typeName => $businessesGroup) {{-- Renamed $businesses to $businessesGroup to avoid conflict --}}
                @php
                $count = $businessesGroup->count(); // Count businesses in the current group.
                // Calculate percentage for the progress bar. Handle division by zero.
                $percentage = $totalBusinesses > 0 ? ($count / $totalBusinesses) * 100 : 0;
                // Define a rotating list of colors for the progress bars.
                $colors = [
                'bg-blue-500', 'bg-green-500', 'bg-yellow-500', 'bg-red-500', 'bg-purple-500', 'bg-indigo-500', 'bg-pink-500'
                ];
                // Assign a color based on the loop index to cycle through colors.
                $color = $colors[$loop->index % count($colors)];
                @endphp
                <div class="flex items-center space-x-4">
                    <div class="flex-1">
                        <div class="flex justify-between items-center mb-2">
                            {{-- Display type name (or 'No Type' if null) --}}
                            <span class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $typeName ?: 'No Type' }}
                            </span>
                            {{-- Display count and percentage --}}
                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                {{ $count }} ({{ number_format($percentage, 1) }}%)
                            </span>
                        </div>
                        {{-- Progress Bar --}}
                        <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                            <div class="{{ $color }} h-2 rounded-full transition-all duration-300"
                                style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            {{-- Message if no business types data is available --}}
            <div class="text-center py-8">
                {{-- Chart Icon (placeholder for no data) --}}
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                <p class="text-gray-500 dark:text-gray-400">No business types data available</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Additional Stats Grid: Contains Profile Completeness and Quick Actions --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Profile Completeness Section --}}
        <div class="bg-white rounded-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            {{-- Section Header --}}
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Profile Completeness</h3>
                <p class="text-sm text-gray-600 mt-1 dark:text-gray-400">Business profile completion status</p>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    {{-- Loop through each completeness status and display its count with a color indicator --}}
                    @foreach($completenessStats as $status => $data)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            {{-- Color dot indicator --}}
                            <div class="w-3 h-3 {{ $data['color'] }} rounded-full"></div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $status }}</span>
                        </div>
                        {{-- Display the count for each status --}}
                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $data['count'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Quick Actions Section --}}
        <div class="bg-white rounded-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
            {{-- Section Header --}}
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Quick Actions</h3>
                <p class="text-sm text-gray-600 mt-1 dark:text-gray-400">Common management tasks</p>
            </div>
            <div class="p-6 space-y-4">
                {{-- Link to Add New Business --}}
                <a href="#" class="flex items-center justify-between p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors dark:bg-blue-900 dark:bg-opacity-20 dark:hover:bg-blue-900 dark:hover:bg-opacity-40">
                    <div class="flex items-center space-x-3">
                        {{-- Add Icon --}}
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span class="text-sm font-medium text-blue-900 dark:text-blue-200">Add New Business</span>
                    </div>
                    {{-- Arrow Icon --}}
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                {{-- Link to Export All Business Data --}}
                <a href="{{ route('export-businesses') }}" class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors dark:bg-yellow-900 dark:bg-opacity-20 dark:hover:bg-yellow-900 dark:hover:bg-opacity-40">
                    <div class="flex items-center space-x-3">
                        {{-- Export Icon --}}
                        <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l2.414 2.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span class="text-sm font-medium text-yellow-900 dark:text-yellow-200">Export All Data Business</span>
                    </div>
                    {{-- Arrow Icon --}}
                    <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    {{-- Recent Activity Summary Section --}}
    <div class="bg-white rounded-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        {{-- Section Header --}}
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Activity Summary</h3>
            <p class="text-sm text-gray-600 mt-1 dark:text-gray-400">Latest business registrations and updates</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- Loop through recent activity stats for different periods --}}
                @foreach($recentStats as $stat)
                <div class="text-center p-4 bg-gray-50 rounded-lg dark:bg-gray-700">
                    <h4 class="text-sm font-medium text-gray-900 mb-2 dark:text-white">{{ $stat['period'] }}</h4>
                    <div class="space-y-1">
                        <p class="text-sm text-green-600 dark:text-green-400">
                            <span class="font-semibold">+{{ $stat['new'] }}</span> new {{-- Number of newly created businesses --}}
                        </p>
                        <p class="text-sm text-blue-600 dark:text-blue-400">
                            <span class="font-semibold">{{ $stat['updated'] }}</span> updated {{-- Number of updated businesses --}}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Footer Section: Timestamp for data generation --}}
    <div class="text-center text-sm text-gray-500 pt-6 border-t">
        <p>Statistics generated on {{ now()->format('F j, Y \a\t g:i A') }}</p>
        <p class="mt-1">Data refreshes automatically every hour</p>
    </div>
</div>