<?php

namespace App\Filament\Widgets;

use App\Models\FoodCategory; // Import the FoodCategory Eloquent model.
use Filament\Widgets\ChartWidget; // Base class for Filament chart widgets.

/**
 * CategoryDistributionChart
 *
 * This Filament Chart Widget displays the distribution of businesses
 * across different food categories. It uses a doughnut chart to visually
 * represent the proportion of businesses belonging to each category,
 * focusing on the top categories with the most associated businesses.
 */
class CategoryDistributionChart extends ChartWidget
{
    /**
     * The heading for the chart widget displayed in the Filament dashboard.
     * Includes an emoji for visual appeal.
     *
     * @var string|null
     */
    protected static ?string $heading = '🍽️ Food Category Distribution';

    /**
     * A brief description displayed below the chart heading.
     *
     * @var string|null
     */
    protected static ?string $description = 'Distribution of businesses by food category.';

    /**
     * The sort order for this widget on the dashboard.
     * Lower numbers appear higher on the page.
     *
     * @var int|null
     */
    protected static ?int $sort = 4;

    /**
     * The polling interval for the chart data in seconds.
     * This defines how frequently the chart data will automatically refresh.
     * Set to 120 seconds (2 minutes).
     *
     * @var string|null
     */
    protected static ?string $pollingInterval = '120s';

    /**
     * Retrieves the data for the chart.
     * This method fetches food categories, counts businesses associated with each,
     * sorts them, and prepares the data and labels for the doughnut chart.
     *
     * @return array An associative array containing 'datasets' and 'labels' for the chart.
     */
    protected function getData(): array
    {
        // Fetch all food categories and eager-load their associated businesses.
        // Eager loading `businesses` relationship on `FoodCategory` is crucial
        // for performance to avoid N+1 query problems when counting.
        $categories = FoodCategory::with('businesses')->get();

        // Sort the categories by the count of their associated businesses in descending order.
        // Then, take only the top 8 categories to keep the chart readable and prevent clutter.
        // `values()` re-indexes the collection to ensure continuous numeric keys.
        $categories = $categories
            ->sortByDesc(fn($cat) => $cat->businesses->count()) // Sort by the number of businesses
            ->take(8) // Limit to top 8 categories
            ->values(); // Reset array keys after sorting and taking a subset

        // Extract the 'title' of each category to use as labels for the chart slices.
        $labels = $categories->pluck('title')->toArray();

        // Map each category to the count of its associated businesses.
        $data = $categories->map(fn($cat) => $cat->businesses->count())->toArray();

        // Define a set of background colors for the doughnut chart slices.
        // These colors will be used sequentially for each category.
        $colors = [
            'rgba(255, 99, 132, 0.8)',  // Red with transparency
            'rgba(54, 162, 235, 0.8)',  // Blue with transparency
            'rgba(255, 205, 86, 0.8)',  // Yellow with transparency
            'rgba(75, 192, 192, 0.8)',  // Green with transparency
            'rgba(153, 102, 255, 0.8)', // Purple with transparency
            'rgba(255, 159, 64, 0.8)',  // Orange with transparency
            'rgba(199, 199, 199, 0.8)', // Gray with transparency
            'rgba(83, 102, 255, 0.8)',  // Indigo with transparency
        ];

        // Define corresponding border colors for the doughnut chart slices.
        $borderColors = [
            'rgb(255, 99, 132)',
            'rgb(54, 162, 235)',
            'rgb(255, 205, 86)',
            'rgb(75, 192, 192)',
            'rgb(153, 102, 255)',
            'rgb(255, 159, 64)',
            'rgb(199, 199, 199)',
            'rgb(83, 102, 255)',
        ];

        // Return the chart data structure required by Filament/Chart.js.
        return [
            'datasets' => [
                [
                    'data' => $data, // The numerical data for each slice (business counts).
                    // Apply only as many colors as there are data points to prevent errors
                    // if `count($data)` is less than `count($colors)`.
                    'backgroundColor' => array_slice($colors, 0, count($data)),
                    'borderColor' => array_slice($borderColors, 0, count($data)),
                    'borderWidth' => 2,        // Thickness of the border around each slice.
                    'hoverBorderWidth' => 3,   // Thicker border on hover.
                    'hoverOffset' => 10,       // Pushes the slice out slightly on hover for visual effect.
                ]
            ],
            'labels' => $labels, // Labels for each slice (food category titles).
        ];
    }

    /**
     * Specifies the type of chart to display.
     * For this widget, it's a 'doughnut' chart.
     *
     * @return string The chart type.
     */
    protected function getType(): string
    {
        return 'doughnut'; // Indicates that this will be a doughnut chart.
    }

    /**
     * Defines the options for the chart's appearance and behavior.
     * These options are passed directly to Chart.js for rendering.
     *
     * @return array An associative array of Chart.js options.
     */
    protected function getOptions(): array
    {
        return [
            'responsive' => true,          // Chart will resize to fit its container.
            'maintainAspectRatio' => false, // Allows the chart to fill the container without maintaining aspect ratio.
            'plugins' => [                 // Configuration for Chart.js plugins.
                'legend' => [              // Legend (category labels) configuration.
                    'display' => true,     // Show the legend.
                    'position' => 'bottom', // Position the legend at the bottom of the chart.
                    'labels' => [
                        'padding' => 20,       // Padding between legend items.
                        'usePointStyle' => true, // Use a small colored circle/square for each legend item.
                        'font' => [
                            'size' => 12       // Font size for legend labels.
                        ]
                    ]
                ],
                'tooltip' => [             // Tooltip (popup on hover) configuration.
                    'backgroundColor' => 'rgba(0, 0, 0, 0.8)', // Dark background for tooltips.
                    'titleColor' => '#ffffff',                 // White color for tooltip title.
                    'bodyColor' => '#ffffff',                  // White color for tooltip body text.
                    'borderColor' => '#3b82f6',                // Border color for tooltips (Blue).
                    'borderWidth' => 1,                        // Border width for tooltips.
                    'cornerRadius' => 8,                       // Rounded corners for tooltips.
                    'callbacks' => [                           // Custom formatting for tooltip labels.
                        'label' => "function(context) {
                            const label = context.label || ''; // Get the label (category name).
                            const value = context.parsed;      // Get the value (number of businesses).
                            // Calculate total businesses across all categories to get percentage.
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            // Calculate percentage and format to one decimal place.
                            const percentage = ((value / total) * 100).toFixed(1);
                            return label + ': ' + value + ' (' + percentage + '%)';
                        }"
                    ]
                ]
            ],
            'cutout' => '60%',             // Sets the size of the inner hole for the doughnut chart (60% of radius).
            'elements' => [                // Configuration for individual chart elements.
                'arc' => [                 // Arc (slice) specific configurations.
                    'borderWidth' => 2,    // Border width for each doughnut slice.
                ]
            ]
        ];
    }
}
