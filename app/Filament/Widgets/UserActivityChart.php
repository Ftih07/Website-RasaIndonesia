<?php

namespace App\Filament\Widgets;

use App\Models\TrafficLog;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

/**
 * Widget to display a heatmap-like scatter chart showing user activity distribution
 * across hours (x-axis) and days of the week (y-axis).
 */
class UserActivityChart extends ChartWidget
{
    protected static ?string $heading = '🔥 User Activity Heatmap';
    protected static ?string $description = 'User behavior pattern based on hour and day of the week';
    protected static ?int $sort = 6;
    protected static ?string $pollingInterval = '300s';

    /**
     * Returns the data for the chart in a heatmap-like format.
     */
    protected function getData(): array
    {
        // Define weekdays and hours
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $hours = range(0, 23);
        $heatmapData = [];

        // Loop through each day and hour to count traffic
        foreach ($days as $dayIndex => $dayName) {
            foreach ($hours as $hour) {
                $count = TrafficLog::whereRaw('DAYOFWEEK(created_at) = ?', [$dayIndex + 1])
                    ->whereRaw('HOUR(created_at) = ?', [$hour])
                    ->where('created_at', '>=', Carbon::now()->subWeeks(4))
                    ->count();

                $heatmapData[] = [
                    'x' => $hour,        // Hour of the day
                    'y' => $dayName,     // Day of the week
                    'v' => $count        // Activity count
                ];
            }
        }

        // Find the maximum value for scaling color intensity
        $maxValue = max(array_column($heatmapData, 'v'));

        return [
            'datasets' => [
                [
                    'label' => 'Activity Level',
                    'data' => $heatmapData,

                    // Dynamic background color based on activity intensity
                    'backgroundColor' => function ($context) use ($maxValue) {
                        $value = $context['parsed']['v'] ?? 0;
                        $intensity = $maxValue > 0 ? $value / $maxValue : 0;

                        if ($intensity > 0.8) return 'rgba(239, 68, 68, 0.9)';   // High - Red
                        if ($intensity > 0.6) return 'rgba(245, 158, 11, 0.8)'; // Medium-high - Orange
                        if ($intensity > 0.4) return 'rgba(34, 197, 94, 0.7)';  // Medium - Green
                        if ($intensity > 0.2) return 'rgba(59, 130, 246, 0.6)'; // Low-medium - Blue
                        if ($intensity > 0) return 'rgba(156, 163, 175, 0.4)';  // Low - Gray
                        return 'rgba(229, 231, 235, 0.2)';                      // No activity - Light Gray
                    },

                    // Visual styling for heatmap cells
                    'borderColor' => 'rgba(255, 255, 255, 0.1)',
                    'borderWidth' => 1,

                    // Dynamic sizing based on chart area
                    'width' => "function({ctx}) { return (ctx.chart.chartArea || {}).width / 24; }",
                    'height' => "function({ctx}) { return (ctx.chart.chartArea || {}).height / 7; }",
                ]
            ],
        ];
    }

    /**
     * Defines the type of chart. In this case, it's a scatter chart used to simulate a heatmap.
     */
    protected function getType(): string
    {
        return 'scatter';
    }

    /**
     * Returns chart display options including tooltips, axes, colors, and styles.
     */
    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                // Hide legend since we’re showing raw data points
                'legend' => [
                    'display' => false
                ],
                // Tooltip configuration
                'tooltip' => [
                    'backgroundColor' => 'rgba(0, 0, 0, 0.8)',
                    'titleColor' => '#ffffff',
                    'bodyColor' => '#ffffff',
                    'borderColor' => '#3b82f6',
                    'borderWidth' => 1,
                    'cornerRadius' => 8,
                    'callbacks' => [
                        'title' => "function() { return 'User Activity'; }",
                        'label' => "function(context) {
                            const data = context.raw;
                            return data.y + ' at ' + data.x + ':00 → ' + data.v + ' visits';
                        }"
                    ]
                ]
            ],
            'scales' => [
                // X-axis (Hour)
                'x' => [
                    'type' => 'linear',
                    'position' => 'bottom',
                    'title' => [
                        'display' => true,
                        'text' => 'Hour (24-hour format)',
                    ],
                    'min' => 0,
                    'max' => 23,
                    'ticks' => [
                        'stepSize' => 2,
                        'callback' => "function(value) {
                            return value + ':00';
                        }"
                    ]
                ],
                // Y-axis (Day of Week)
                'y' => [
                    'type' => 'category',
                    'labels' => ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                    'title' => [
                        'display' => true,
                        'text' => 'Day of the Week'
                    ]
                ]
            ],
            // Custom point appearance
            'elements' => [
                'point' => [
                    'radius' => 8,
                    'hoverRadius' => 10,
                ]
            ]
        ];
    }
}
