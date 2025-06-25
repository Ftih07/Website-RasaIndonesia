<?php

namespace App\Filament\Widgets;

use App\Models\TrafficLog; // Import the TrafficLog Eloquent model.
use Carbon\Carbon;          // Carbon library for date and time manipulation.
use Filament\Widgets\ChartWidget; // Base class for Filament chart widgets.

/**
 * TrafficChart
 *
 * This Filament Chart Widget displays the website traffic analytics,
 * specifically focusing on daily visitor counts over the last 7 days.
 * It uses a line chart to visualize trends and uses dynamic colors
 * to indicate traffic volume for each day.
 */
class TrafficChart extends ChartWidget
{
    /**
     * The heading for the chart widget displayed in the Filament dashboard.
     * Includes an emoji for visual appeal.
     *
     * @var string|null
     */
    protected static ?string $heading = '📊 Website Traffic Analytics';

    /**
     * A brief description displayed below the chart heading.
     *
     * @var string|null
     */
    protected static ?string $description = 'Website visitor analysis for the last 7 days.';

    /**
     * The sort order for this widget on the dashboard.
     * Lower numbers appear higher on the page.
     *
     * @var int|null
     */
    protected static ?int $sort = 2;

    /**
     * The polling interval for the chart data in seconds.
     * This defines how frequently the chart data will automatically refresh.
     * Set to 30 seconds.
     *
     * @var string|null
     */
    protected static ?string $pollingInterval = '30s';

    /**
     * Sets the maximum height for the chart container.
     * This helps control the layout on the dashboard.
     *
     * @var string|null
     */
    protected static ?string $maxHeight = '300px';

    /**
     * Retrieves the data for the chart.
     * This method fetches daily traffic counts for the last 7 days,
     * assigns dynamic colors based on traffic volume, and formats
     * the data and labels for a line chart.
     *
     * @return array An associative array containing 'datasets' and 'labels' for the chart.
     */
    protected function getData(): array
    {
        $data = [];             // Array to store the daily traffic counts.
        $labels = [];           // Array to store the day names and dates for the x-axis labels.
        $backgroundColors = []; // Array to store dynamic background colors for the chart area.
        $borderColors = [];     // Array to store dynamic border colors for the line.

        // Get current hour for potential future time-based visualization (though not used in this specific chart's data processing).
        $currentHour = now()->format('H');

        // Loop through the last 7 days (including today).
        // The loop runs from $i = 6 down to 0 to get data in chronological order.
        for ($i = 6; $i >= 0; $i--) {
            // Get the Carbon instance for the current day in the loop.
            $date = Carbon::today()->subDays($i);
            // Format the day name (e.g., "Mon", "Tue").
            // Using `locale('id')` was in the original, but changed to default for English consistency.
            // If localization is required, ensure 'id' locale is set globally or passed explicitly.
            $dayName = $date->format('D');
            // Format the date as day/month (e.g., "24/06").
            $dateFormatted = $date->format('d/m');
            // Combine day name and formatted date for the label, with a newline for multi-line labels.
            $labels[] = $dayName . "\n" . $dateFormatted;

            // Count the number of traffic logs for the specific date.
            $dailyTraffic = TrafficLog::whereDate('created_at', $date)->count();
            // Add the daily traffic count to the data array.
            $data[] = $dailyTraffic;

            // Assign dynamic colors based on traffic volume for visual indication.
            if ($dailyTraffic > 100) {
                $backgroundColors[] = 'rgba(34, 197, 94, 0.2)'; // Light green for high traffic
                $borderColors[] = 'rgb(34, 197, 94)';          // Solid green border
            } elseif ($dailyTraffic > 50) {
                $backgroundColors[] = 'rgba(59, 130, 246, 0.2)'; // Light blue for medium traffic
                $borderColors[] = 'rgb(59, 130, 246)';           // Solid blue border
            } else {
                $backgroundColors[] = 'rgba(249, 115, 22, 0.2)'; // Light orange for low traffic
                $borderColors[] = 'rgb(249, 115, 22)';           // Solid orange border
            }
        }

        // --- Additional Traffic Statistics (calculated but not directly displayed in the chart data structure) ---
        // These can be used for custom tooltips or other dashboard elements if needed.
        $totalTraffic = array_sum($data);             // Total traffic over the 7 days.
        $avgTraffic = round($totalTraffic / 7, 1);    // Average daily traffic.
        $maxTraffic = max($data);                     // Maximum daily traffic.
        $minTraffic = min($data);                     // Minimum daily traffic.

        // Return the chart data structure required by Filament/Chart.js.
        return [
            'datasets' => [
                [
                    'label' => 'Daily Visitors',      // Label for this dataset (e.g., in the legend).
                    'data' => $data,                  // The actual numerical data points (daily traffic counts).
                    'borderColor' => $borderColors,   // Dynamically assigned border colors for the line.
                    'backgroundColor' => $backgroundColors, // Dynamically assigned background colors for the filled area under the line.
                    'pointBackgroundColor' => $borderColors, // Background color of the data points.
                    'pointBorderColor' => '#ffffff',  // Border color of the data points.
                    'pointBorderWidth' => 2,          // Thickness of the point borders.
                    'pointRadius' => 6,               // Radius of the data points.
                    'pointHoverRadius' => 8,          // Radius of the data points on hover.
                    'fill' => true,                   // Fills the area under the line.
                    'tension' => 0.4,                 // Line tension (0 for straight lines, higher for more curve).
                    'borderWidth' => 3,               // Thickness of the line itself.
                ]
            ],
            'labels' => $labels, // Labels for the x-axis (day names and dates).
        ];
    }

    /**
     * Specifies the type of chart to display.
     * For this widget, it's a 'line' chart.
     *
     * @return string The chart type.
     */
    protected function getType(): string
    {
        return 'line'; // Indicates that this will be a line chart.
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
            'interaction' => [             // Configuration for user interaction (hover, click).
                'intersect' => false,      // Tooltips will show for points even if the mouse is not directly over them.
                'mode' => 'index',         // Tooltips will show data for all datasets at the same x-coordinate.
            ],
            'plugins' => [                 // Configuration for Chart.js plugins.
                'legend' => [              // Legend (dataset labels) configuration.
                    'display' => true,     // Show the legend.
                    'position' => 'top',   // Position the legend at the top of the chart.
                    'labels' => [
                        'usePointStyle' => true, // Use a small colored circle/square for each legend item.
                        'font' => [
                            'size' => 12,      // Font size for legend labels.
                            'weight' => 'bold' // Bold font for legend labels.
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
                    'displayColors' => true,                   // Show color box next to tooltip label.
                    'callbacks' => [                           // Custom formatting for tooltip labels.
                        'title' => "function(context) {
                            // The label context[0].label already contains the formatted 'Day\nDate'.
                            return 'Traffic Data - ' + context[0].label;
                        }",
                        'label' => "function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + ' visitors'; // Changed to 'visitors' for English consistency
                        }"
                    ]
                ]
            ],
            'scales' => [                  // Axis configuration.
                'x' => [                   // X-axis (horizontal) configuration.
                    'display' => true,     // Show the x-axis.
                    'grid' => [
                        'display' => false, // Do not display grid lines for the x-axis.
                    ],
                    'ticks' => [           // X-axis tick (label) configuration.
                        'font' => [
                            'size' => 11,     // Font size for x-axis labels.
                            'weight' => 'bold' // Bold font for x-axis labels.
                        ]
                    ]
                ],
                'y' => [                   // Y-axis (vertical) configuration.
                    'display' => true,     // Show the y-axis.
                    'beginAtZero' => true, // Ensure the Y-axis starts at zero.
                    'grid' => [
                        'color' => 'rgba(0, 0, 0, 0.1)', // Light gray color for Y-axis grid lines.
                        'borderDash' => [5, 5],          // Dashed grid lines for the Y-axis.
                    ],
                    'ticks' => [           // Y-axis tick (label) configuration.
                        'font' => [
                            'size' => 11      // Font size for y-axis labels.
                        ],
                        'callback' => "function(value) {
                            return value + ' visits'; // Append 'visits' to Y-axis tick values.
                        }"
                    ]
                ]
            ],
            'elements' => [                // Configuration for individual chart elements.
                'point' => [               // Data point specific configurations.
                    'hoverBackgroundColor' => '#ffffff', // White background when hovering over a point.
                ]
            ]
        ];
    }
}