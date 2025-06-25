<?php

namespace App\Filament\Widgets;

use App\Models\Business;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

/**
 * BusinessGrowthChart
 *
 * This Filament Chart Widget displays the growth of business registrations
 * over the last six months as a bar chart. It is designed to provide a
 * quick visual insight into the rate at which new businesses are being added
 * to the system.
 */
class BusinessGrowthChart extends ChartWidget
{
    /**
     * The heading for the chart widget displayed in the Filament dashboard.
     * Includes an emoji for visual appeal.
     *
     * @var string|null
     */
    protected static ?string $heading = '🚀 Business Registration Growth';

    /**
     * A brief description displayed below the chart heading.
     *
     * @var string|null
     */
    protected static ?string $description = 'Business registration growth over the last 6 months.';

    /**
     * The sort order for this widget on the dashboard.
     * Lower numbers appear higher on the page.
     *
     * @var int|null
     */
    protected static ?int $sort = 3;

    /**
     * The polling interval for the chart data in seconds.
     * This defines how frequently the chart data will automatically refresh.
     *
     * @var string|null
     */
    protected static ?string $pollingInterval = '60s';

    /**
     * Retrieves the data for the chart.
     * This method fetches the monthly counts of new business registrations
     * for the past six months and formats them for the chart.
     *
     * @return array An associative array containing 'datasets' and 'labels' for the chart.
     */
    protected function getData(): array
    {
        $data = []; // Array to store the count of new businesses per month.
        $labels = []; // Array to store the month-year labels for the x-axis.

        // Loop through the last 6 months (from 5 months ago up to the current month).
        // The loop runs from $i = 5 down to 0 to get data in chronological order.
        for ($i = 5; $i >= 0; $i--) {
            // Get the Carbon instance for the current month in the loop.
            $date = Carbon::now()->subMonths($i);

            // Format the month and year for the label (e.g., "Jan 2023").
            // Changed locale from 'id' to a default/en-US for consistency.
            // If specific locale formatting is needed, ensure 'id' is supported or passed.
            $labels[] = $date->format('M Y');

            // Count the number of businesses created in the specific year and month.
            $monthlyCount = Business::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            // Add the monthly count to the data array.
            $data[] = $monthlyCount;
        }

        // Return the chart data structure required by Filament/Chart.js.
        return [
            'datasets' => [
                [
                    'label' => 'New Businesses', // Label for this dataset (e.g., in the legend).
                    'data' => $data,             // The actual numerical data points (monthly counts).
                    'backgroundColor' => [       // Colors for the bars in the chart (with transparency).
                        'rgba(99, 102, 241, 0.8)',  // Indigo
                        'rgba(59, 130, 246, 0.8)',  // Blue
                        'rgba(16, 185, 129, 0.8)',  // Emerald Green
                        'rgba(245, 158, 11, 0.8)',  // Amber
                        'rgba(239, 68, 68, 0.8)',   // Red
                        'rgba(139, 92, 246, 0.8)',  // Violet
                    ],
                    'borderColor' => [           // Border colors for the bars.
                        'rgb(99, 102, 241)',
                        'rgb(59, 130, 246)',
                        'rgb(16, 185, 129)',
                        'rgb(245, 158, 11)',
                        'rgb(239, 68, 68)',
                        'rgb(139, 92, 246)',
                    ],
                    'borderWidth' => 2,          // Thickness of the bar borders.
                    'borderRadius' => 8,         // Rounded corners for the bars.
                    'borderSkipped' => false,    // Prevents borders from being skipped on certain sides of bars.
                ]
            ],
            'labels' => $labels, // Labels for the x-axis (e.g., "Jan 2023", "Feb 2023").
        ];
    }

    /**
     * Specifies the type of chart to display.
     * This can be 'line', 'bar', 'doughnut', 'pie', etc., depending on Chart.js capabilities.
     *
     * @return string The chart type.
     */
    protected function getType(): string
    {
        return 'bar'; // Indicates that this will be a bar chart.
    }

    /**
     * Defines the options for the chart's appearance and behavior.
     * These options are passed directly to Chart.js.
     *
     * @return array An associative array of Chart.js options.
     */
    protected function getOptions(): array
    {
        return [
            'responsive' => true,          // Chart will resize to fit its container.
            'maintainAspectRatio' => false, // Allows the chart to fill the container without maintaining aspect ratio.
            'plugins' => [                 // Configuration for Chart.js plugins.
                'legend' => [              // Legend (dataset labels) configuration.
                    'display' => true,     // Show the legend.
                    'position' => 'top',   // Position the legend at the top of the chart.
                ],
                'tooltip' => [             // Tooltip (popup on hover) configuration.
                    'backgroundColor' => 'rgba(0, 0, 0, 0.8)', // Dark background for tooltips.
                    'titleColor' => '#ffffff',                 // White color for tooltip title.
                    'bodyColor' => '#ffffff',                  // White color for tooltip body text.
                    'borderColor' => '#6366f1',                // Border color for tooltips (Indigo).
                    'borderWidth' => 1,                        // Border width for tooltips.
                    'cornerRadius' => 8,                       // Rounded corners for tooltips.
                ]
            ],
            'scales' => [                  // Axis configuration.
                'x' => [                   // X-axis (horizontal) configuration.
                    'grid' => [
                        'display' => false, // Do not display grid lines for the x-axis.
                    ],
                ],
                'y' => [                   // Y-axis (vertical) configuration.
                    'beginAtZero' => true, // Ensure the Y-axis starts at zero.
                    'grid' => [
                        'color' => 'rgba(0, 0, 0, 0.1)', // Light gray color for Y-axis grid lines.
                    ],
                ]
            ]
        ];
    }
}
