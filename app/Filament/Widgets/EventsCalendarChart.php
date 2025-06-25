<?php

namespace App\Filament\Widgets;

use App\Models\Events; // Import the Events Eloquent model.
use Carbon\Carbon;     // Carbon library for date and time manipulation.
use Filament\Widgets\ChartWidget; // Base class for Filament chart widgets.

/**
 * EventsCalendarChart
 *
 * This Filament Chart Widget provides an overview of the upcoming event schedule
 * for the next 30 days. It uses a bar chart to show the number of events
 * scheduled for each day, with color coding to indicate daily event density.
 */
class EventsCalendarChart extends ChartWidget
{
    /**
     * The heading for the chart widget displayed in the Filament dashboard.
     * Includes an emoji for visual appeal.
     *
     * @var string|null
     */
    protected static ?string $heading = '📅 Events Schedule Overview';

    /**
     * A brief description displayed below the chart heading.
     *
     * @var string|null
     */
    protected static ?string $description = 'Event schedule for the next 30 days.';

    /**
     * The sort order for this widget on the dashboard.
     * Lower numbers appear higher on the page.
     *
     * @var int|null
     */
    protected static ?int $sort = 5;

    /**
     * The polling interval for the chart data in seconds.
     * This defines how frequently the chart data will automatically refresh.
     * Set to 300 seconds (5 minutes).
     *
     * @var string|null
     */
    protected static ?string $pollingInterval = '300s';

    /**
     * Retrieves the data for the chart.
     * This method iterates through the next 30 days, counts events for each day,
     * and assigns a color based on the event count, preparing the data for a bar chart.
     *
     * @return array An associative array containing 'datasets' and 'labels' for the chart.
     */
    protected function getData(): array
    {
        $data = [];              // Array to store the count of events per day.
        $labels = [];            // Array to store the day number for the x-axis labels.
        $backgroundColors = [];  // Array to store dynamic background colors for each bar.

        // Loop through the next 30 days, starting from today.
        for ($i = 0; $i < 30; $i++) {
            // Get the Carbon instance for the current day in the loop.
            $date = Carbon::today()->addDays($i);

            // Add the day number (e.g., '24') to the labels array.
            $labels[] = $date->format('d');

            // Count the number of events scheduled for this specific date.
            $eventsCount = Events::whereDate('start_time', $date)->count();
            // Add the event count to the data array.
            $data[] = $eventsCount;

            // Assign background color based on the number of events for the day.
            if ($eventsCount >= 3) {
                $backgroundColors[] = 'rgba(239, 68, 68, 0.8)';   // Red (busy days)
            } elseif ($eventsCount >= 2) {
                $backgroundColors[] = 'rgba(245, 158, 11, 0.8)';  // Orange (moderate days)
            } elseif ($eventsCount >= 1) {
                $backgroundColors[] = 'rgba(34, 197, 94, 0.8)';   // Green (light days)
            } else {
                $backgroundColors[] = 'rgba(156, 163, 175, 0.3)'; // Gray (no events)
            }
        }

        // Return the chart data structure required by Filament/Chart.js.
        return [
            'datasets' => [
                [
                    'label' => 'Events per Day',  // Label for this dataset (e.g., in the legend).
                    'data' => $data,              // The actual numerical data points (daily event counts).
                    'backgroundColor' => $backgroundColors, // Dynamically assigned background colors for bars.
                    'borderColor' => 'rgba(59, 130, 246, 0.8)', // Border color for the bars (Blue).
                    'borderWidth' => 1,           // Thickness of the bar borders.
                    'borderRadius' => 4,          // Rounded corners for the bars.
                ]
            ],
            'labels' => $labels, // Labels for the x-axis (day numbers).
        ];
    }

    /**
     * Specifies the type of chart to display.
     * For this widget, it's a 'bar' chart.
     *
     * @return string The chart type.
     */
    protected function getType(): string
    {
        return 'bar'; // Indicates that this will be a bar chart.
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
                'legend' => [              // Legend (dataset labels) configuration.
                    'display' => true,     // Show the legend.
                    'position' => 'top',   // Position the legend at the top of the chart.
                ],
                'tooltip' => [             // Tooltip (popup on hover) configuration.
                    'backgroundColor' => 'rgba(0, 0, 0, 0.8)', // Dark background for tooltips.
                    'titleColor' => '#ffffff',                 // White color for tooltip title.
                    'bodyColor' => '#ffffff',                  // White color for tooltip body text.
                    'borderColor' => '#3b82f6',                // Border color for tooltips (Blue).
                    'borderWidth' => 1,                        // Border width for tooltips.
                    'cornerRadius' => 8,                       // Rounded corners for tooltips.
                    'callbacks' => [                           // Custom formatting for tooltip labels.
                        'title' => "function(context) {
                            const dayIndex = context[0].dataIndex; // Get the index of the hovered bar.
                            const date = new Date(); // Create a new Date object for the current day.
                            date.setDate(date.getDate() + dayIndex); // Add the day index to get the actual date.
                            return 'Date: ' + date.toLocaleDateString('en-US'); // Changed to en-US for English consistency
                        }",
                        'label' => "function(context) {
                            const value = context.parsed.y; // Get the y-axis value (event count).
                            if (value === 0) return 'No events';     // Custom text for 0 events.
                            if (value === 1) return '1 event';       // Custom text for 1 event.
                            return value + ' events';                // Plural text for multiple events.
                        }"
                    ]
                ]
            ],
            'scales' => [                  // Axis configuration.
                'x' => [                   // X-axis (horizontal) configuration.
                    'display' => true,     // Show the x-axis.
                    'title' => [           // X-axis title configuration.
                        'display' => true, // Show the title.
                        'text' => 'Date (Next 30 Days)' // Title text.
                    ],
                    'grid' => [
                        'display' => false, // Do not display grid lines for the x-axis.
                    ],
                ],
                'y' => [                   // Y-axis (vertical) configuration.
                    'beginAtZero' => true, // Ensure the Y-axis starts at zero.
                    'title' => [           // Y-axis title configuration.
                        'display' => true, // Show the title.
                        'text' => 'Number of Events' // Title text.
                    ],
                    'ticks' => [
                        'stepSize' => 1,   // Ensure Y-axis ticks are whole numbers (for event counts).
                    ],
                    'grid' => [
                        'color' => 'rgba(0, 0, 0, 0.1)', // Light gray color for Y-axis grid lines.
                    ],
                ]
            ]
        ];
    }
}