<?php

namespace App\Filament\Widgets;

use App\Models\Business; // Import the Business Eloquent model.
use App\Models\Events;   // Import the Events Eloquent model.
use App\Models\FoodCategory; // Import the FoodCategory Eloquent model.
use App\Models\News;     // Import the News Eloquent model.
use App\Models\TrafficLog; // Import the TrafficLog Eloquent model.
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget; // Base class for Filament Stats Overview widgets.
use Filament\Widgets\StatsOverviewWidget\Stat; // Stat class to define individual statistics.
use Carbon\Carbon; // Carbon library for date and time manipulation.

/**
 * DashboardOverview
 *
 * This Filament Stats Overview Widget provides a snapshot of key metrics
 * for the application. It displays various statistics such as total businesses,
 * upcoming events, food categories, news articles, active users, and daily traffic,
 * often including growth comparisons with previous periods.
 */
class DashboardOverview extends BaseWidget
{
    /**
     * The polling interval for the widget data in seconds.
     * This defines how frequently the stats will automatically refresh.
     * Set to 30 seconds.
     *
     * @var string|null
     */
    protected static ?string $pollingInterval = '30s';

    /**
     * Retrieves the array of statistics to be displayed.
     * Each statistic is an instance of `Stat` and includes a value,
     * description, icon, color, and optional chart data.
     *
     * @return array An array of Stat objects.
     */
    protected function getStats(): array
    {
        // --- Business Statistics ---
        $totalBusinesses = Business::count();
        $businessesThisMonth = Business::whereMonth('created_at', now()->month)->count();
        $businessesLastMonth = Business::whereMonth('created_at', now()->subMonth()->month)->count();
        // Calculate business growth percentage. Handle division by zero.
        $businessGrowth = $businessesLastMonth > 0 ? (($businessesThisMonth - $businessesLastMonth) / $businessesLastMonth) * 100 : 0;

        // --- Event Statistics ---
        $upcomingEvents = Events::where('start_time', '>', now())->count(); // Events starting after the current time.
        $eventsThisMonth = Events::whereMonth('start_time', now()->month)->count(); // Events starting this month.

        // --- User Statistics ---
        $totalUsers = User::count();
        $usersThisMonth = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year) // biar nggak keambil bulan sama di tahun beda
            ->count();
        $usersLastMonth = User::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        // Calculate user growth percentage. Handle division by zero.
        $userGrowth = $usersLastMonth > 0
            ? (($usersThisMonth - $usersLastMonth) / $usersLastMonth) * 100
            : 0;

        // --- Traffic Statistics ---
        $todayTraffic = TrafficLog::whereDate('created_at', today())->count();
        $yesterdayTraffic = TrafficLog::whereDate('created_at', Carbon::yesterday())->count();
        // Calculate daily traffic growth percentage. Handle division by zero.
        $trafficGrowth = $yesterdayTraffic > 0 ? (($todayTraffic - $yesterdayTraffic) / $yesterdayTraffic) * 100 : 0;

        // Return the array of Stat objects to be rendered on the dashboard.
        return [
            // Stat for Total Businesses
            Stat::make('Total Businesses', number_format($totalBusinesses))
                // Dynamically set description based on business growth (positive or negative).
                ->description(
                    $businessGrowth >= 0 ?
                        // Add '+' prefix for positive growth.
                        '+' . number_format($businessGrowth, 1) . '% from last month' :
                        // No '+' prefix for negative growth.
                        number_format($businessGrowth, 1) . '% from last month'
                )
                // Set description icon based on growth direction (trending up/down).
                ->descriptionIcon($businessGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                // Example chart data (dummy data for visual representation).
                ->chart([7, 12, 8, 15, 20, 18, 25, 22, 30])
                // Main icon for the stat.
                ->icon('heroicon-o-building-storefront')
                // Set color of the stat (e.g., 'success' for positive growth, 'danger' for negative).
                ->color($businessGrowth >= 0 ? 'success' : 'danger')
                // Extra CSS attributes for custom styling.
                ->extraAttributes([
                    'class' => 'relative overflow-hidden bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-blue-900/20 dark:to-indigo-800/20 border-l-4 border-blue-500'
                ]),

            // Stat for Upcoming Events
            Stat::make('Upcoming Events', $upcomingEvents)
                // Description showing number of events this month.
                ->description($eventsThisMonth . ' events this month')
                // Icon for the description.
                ->descriptionIcon('heroicon-m-calendar-days')
                // Example chart data.
                ->chart([3, 5, 2, 8, 6, 4, 7])
                // Main icon for the stat.
                ->icon('heroicon-o-calendar')
                // Color for the stat.
                ->color('warning')
                // Extra CSS attributes for custom styling.
                ->extraAttributes([
                    'class' => 'relative overflow-hidden bg-gradient-to-br from-amber-50 to-orange-100 dark:from-amber-900/20 dark:to-orange-800/20 border-l-4 border-amber-500'
                ]),

            // Stat for Food Categories
            Stat::make('Food Categories', FoodCategory::count())
                // Description for total food categories available.
                ->description('Total food categories available')
                // Icon for the description.
                ->descriptionIcon('heroicon-m-squares-2x2')
                // Main icon for the stat.
                ->icon('heroicon-o-squares-2x2')
                // Color for the stat.
                ->color('info')
                // Extra CSS attributes for custom styling.
                ->extraAttributes([
                    'class' => 'relative overflow-hidden bg-gradient-to-br from-cyan-50 to-blue-100 dark:from-cyan-900/20 dark:to-blue-800/20 border-l-4 border-cyan-500'
                ]),

            // Stat for News Articles
            Stat::make('News Articles', News::count())
                // Description for total news articles.
                ->description('Total news articles')
                // Icon for the description.
                ->descriptionIcon('heroicon-m-newspaper')
                // Main icon for the stat.
                ->icon('heroicon-o-newspaper')
                // Color for the stat.
                ->color('gray')
                // Extra CSS attributes for custom styling.
                ->extraAttributes([
                    'class' => 'relative overflow-hidden bg-gradient-to-br from-gray-50 to-slate-100 dark:from-gray-900/20 dark:to-slate-800/20 border-l-4 border-gray-500'
                ]),

            // Stat for Active Users
            Stat::make('Active Users', number_format($totalUsers))
                // Dynamically set description based on user growth.
                ->description(
                    $userGrowth >= 0 ?
                        '+' . number_format($userGrowth, 1) . '% growth' :
                        number_format($userGrowth, 1) . '% growth'
                )
                // Set description icon based on growth direction.
                ->descriptionIcon($userGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                // Example chart data.
                ->chart([15, 20, 18, 25, 30, 28, 35, 32, 40])
                // Main icon for the stat.
                ->icon('heroicon-o-user-group')
                // Set color of the stat based on growth.
                ->color($userGrowth >= 0 ? 'success' : 'danger')
                // Extra CSS attributes for custom styling.
                ->extraAttributes([
                    'class' => 'relative overflow-hidden bg-gradient-to-br from-emerald-50 to-green-100 dark:from-emerald-900/20 dark:to-green-800/20 border-l-4 border-emerald-500'
                ]),

            // Stat for Daily Traffic
            Stat::make('Daily Traffic', number_format($todayTraffic))
                // Dynamically set description based on traffic growth.
                ->description(
                    $trafficGrowth >= 0 ?
                        '+' . number_format($trafficGrowth, 1) . '% from yesterday' :
                        number_format($trafficGrowth, 1) . '% from yesterday'
                )
                // Set description icon based on growth direction.
                ->descriptionIcon($trafficGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                // Example chart data.
                ->chart([45, 52, 48, 61, 58, 55, 67, 63, 71, 68, 75])
                // Main icon for the stat.
                ->icon('heroicon-o-chart-bar')
                // Set color of the stat based on growth.
                // Using 'warning' for negative traffic growth might be a design choice
                // to highlight, rather than 'danger' if it's less critical than user/business loss.
                ->color($trafficGrowth >= 0 ? 'success' : 'warning')
                // Extra CSS attributes for custom styling.
                ->extraAttributes([
                    'class' => 'relative overflow-hidden bg-gradient-to-br from-purple-50 to-pink-100 dark:from-purple-900/20 dark:to-pink-800/20 border-l-4 border-purple-500'
                ]),
        ];
    }

    /**
     * Defines the number of columns the stats overview should occupy.
     * This helps in creating a responsive layout for the widget.
     *
     * @return int The number of columns.
     */
    protected function getColumns(): int
    {
        return 3; // Displays 3 stats per row for a balanced layout.
    }
}
