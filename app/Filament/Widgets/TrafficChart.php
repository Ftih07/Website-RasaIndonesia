<?php

namespace App\Filament\Widgets;

use App\Models\TrafficLog;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Forms\Components\Select;

/**
 * Enhanced TrafficChart
 *
 * This enhanced Filament Chart Widget displays comprehensive website traffic analytics
 * with period filtering (day, week, month), improved UI/UX, and detailed statistics.
 * Features dynamic colors, responsive design, and user-friendly interactions.
 */
class TrafficChart extends ChartWidget
{
    /**
     * The heading for the chart widget with enhanced visual appeal.
     */
    protected static ?string $heading = '📈 Traffic Analytics Dashboard';

    /**
     * Enhanced description with dynamic period information.
     */
    protected static ?string $description = 'Comprehensive website visitor analysis with customizable time periods';

    /**
     * Widget sort order on dashboard.
     */
    protected static ?int $sort = 2;

    /**
     * Auto-refresh interval for real-time updates.
     */
    protected static ?string $pollingInterval = '60s';

    /**
     * Responsive height for better mobile experience.
     */
    protected static ?string $maxHeight = '400px';

    /**
     * Available filter options for period selection.
     */
    protected function getFilters(): ?array
    {
        return [
            'day' => 'Today (24 Hours)',
            'week' => 'Last 7 Days',
            'month' => 'Last 30 Days',
            'quarter' => 'Last 90 Days',
        ];
    }

    /**
     * Enhanced data retrieval with period filtering and comprehensive statistics.
     */
    protected function getData(): array
    {
        $data = [];
        $labels = [];
        $backgroundColors = [];
        $borderColors = [];
        $pointColors = [];

        switch ($this->filter) {
            case 'day':
                return $this->getDayData();
            case 'week':
                return $this->getWeekData();
            case 'month':
                return $this->getMonthData();
            case 'quarter':
                return $this->getQuarterData();
            default:
                return $this->getWeekData();
        }
    }

    /**
     * Get hourly data for today (24 hours).
     */
    private function getDayData(): array
    {
        $data = [];
        $labels = [];
        $backgroundColors = [];
        $borderColors = [];

        for ($i = 23; $i >= 0; $i--) {
            $hour = Carbon::now()->subHours($i);
            $hourFormatted = $hour->format('H:00');
            $labels[] = $hourFormatted;

            $hourlyTraffic = TrafficLog::whereBetween('created_at', [
                $hour->startOfHour(),
                $hour->copy()->endOfHour()
            ])->count();

            $data[] = $hourlyTraffic;
            $colors = $this->getColorsByVolume($hourlyTraffic, 'hourly');
            $backgroundColors[] = $colors['background'];
            $borderColors[] = $colors['border'];
        }

        return $this->formatChartData($data, $labels, $backgroundColors, $borderColors, 'Hourly Visitors');
    }

    /**
     * Get daily data for the last 7 days (enhanced version).
     */
    private function getWeekData(): array
    {
        $data = [];
        $labels = [];
        $backgroundColors = [];
        $borderColors = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dayName = $date->format('D');
            $dateFormatted = $date->format('d/m');
            $labels[] = $dayName . "\n" . $dateFormatted;

            $dailyTraffic = TrafficLog::whereDate('created_at', $date)->count();
            $data[] = $dailyTraffic;

            $colors = $this->getColorsByVolume($dailyTraffic, 'daily');
            $backgroundColors[] = $colors['background'];
            $borderColors[] = $colors['border'];
        }

        return $this->formatChartData($data, $labels, $backgroundColors, $borderColors, 'Daily Visitors');
    }

    /**
     * Get daily data for the last 30 days.
     */
    private function getMonthData(): array
    {
        $data = [];
        $labels = [];
        $backgroundColors = [];
        $borderColors = [];

        // Group data by weeks for better readability
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);

            // Show only every 3rd day label to avoid crowding
            if ($i % 3 == 0) {
                $labels[] = $date->format('d/m');
            } else {
                $labels[] = '';
            }

            $dailyTraffic = TrafficLog::whereDate('created_at', $date)->count();
            $data[] = $dailyTraffic;

            $colors = $this->getColorsByVolume($dailyTraffic, 'daily');
            $backgroundColors[] = $colors['background'];
            $borderColors[] = $colors['border'];
        }

        return $this->formatChartData($data, $labels, $backgroundColors, $borderColors, 'Daily Visitors (30 Days)');
    }

    /**
     * Get weekly data for the last 90 days.
     */
    private function getQuarterData(): array
    {
        $data = [];
        $labels = [];
        $backgroundColors = [];
        $borderColors = [];

        for ($i = 12; $i >= 0; $i--) {
            $weekStart = Carbon::today()->subWeeks($i)->startOfWeek();
            $weekEnd = Carbon::today()->subWeeks($i)->endOfWeek();

            $labels[] = $weekStart->format('d/m') . '-' . $weekEnd->format('d/m');

            $weeklyTraffic = TrafficLog::whereBetween('created_at', [$weekStart, $weekEnd])->count();
            $data[] = $weeklyTraffic;

            $colors = $this->getColorsByVolume($weeklyTraffic, 'weekly');
            $backgroundColors[] = $colors['background'];
            $borderColors[] = $colors['border'];
        }

        return $this->formatChartData($data, $labels, $backgroundColors, $borderColors, 'Weekly Visitors (90 Days)');
    }

    /**
     * Get dynamic colors based on traffic volume and period type.
     */
    private function getColorsByVolume(int $volume, string $period): array
    {
        $thresholds = [
            'hourly' => ['high' => 20, 'medium' => 10],
            'daily' => ['high' => 100, 'medium' => 50],
            'weekly' => ['high' => 500, 'medium' => 200],
        ];

        $threshold = $thresholds[$period] ?? $thresholds['daily'];

        if ($volume > $threshold['high']) {
            return [
                'background' => 'rgba(16, 185, 129, 0.2)', // Emerald green
                'border' => 'rgb(16, 185, 129)'
            ];
        } elseif ($volume > $threshold['medium']) {
            return [
                'background' => 'rgba(59, 130, 246, 0.2)', // Blue
                'border' => 'rgb(59, 130, 246)'
            ];
        } elseif ($volume > 0) {
            return [
                'background' => 'rgba(245, 158, 11, 0.2)', // Amber
                'border' => 'rgb(245, 158, 11)'
            ];
        } else {
            return [
                'background' => 'rgba(156, 163, 175, 0.2)', // Gray
                'border' => 'rgb(156, 163, 175)'
            ];
        }
    }

    /**
     * Format chart data with enhanced styling and statistics.
     */
    private function formatChartData(array $data, array $labels, array $backgroundColors, array $borderColors, string $datasetLabel): array
    {
        // Calculate comprehensive statistics
        $totalTraffic = array_sum($data);
        $avgTraffic = $totalTraffic > 0 ? round($totalTraffic / count($data), 1) : 0;
        $maxTraffic = count($data) > 0 ? max($data) : 0;
        $minTraffic = count($data) > 0 ? min($data) : 0;
        $trend = $this->calculateTrend($data);

        return [
            'datasets' => [
                [
                    'label' => $datasetLabel,
                    'data' => $data,
                    'borderColor' => $borderColors,
                    'backgroundColor' => $backgroundColors,
                    'pointBackgroundColor' => $borderColors,
                    'pointBorderColor' => '#ffffff',
                    'pointBorderWidth' => 3,
                    'pointRadius' => 5,
                    'pointHoverRadius' => 8,
                    'pointHoverBorderWidth' => 4,
                    'fill' => true,
                    'tension' => 0.4,
                    'borderWidth' => 3,
                    'borderJoinStyle' => 'round',
                    'borderCapStyle' => 'round',
                ]
            ],
            'labels' => $labels,
            // Store statistics for potential use in custom tooltips or other components
            'statistics' => [
                'total' => $totalTraffic,
                'average' => $avgTraffic,
                'maximum' => $maxTraffic,
                'minimum' => $minTraffic,
                'trend' => $trend
            ]
        ];
    }

    /**
     * Calculate traffic trend (simplified).
     */
    private function calculateTrend(array $data): string
    {
        if (count($data) < 2) return 'stable';

        $firstHalf = array_slice($data, 0, ceil(count($data) / 2));
        $secondHalf = array_slice($data, floor(count($data) / 2));

        $firstAvg = array_sum($firstHalf) / count($firstHalf);
        $secondAvg = array_sum($secondHalf) / count($secondHalf);

        if ($secondAvg > $firstAvg * 1.1) return 'increasing';
        if ($secondAvg < $firstAvg * 0.9) return 'decreasing';
        return 'stable';
    }

    /**
     * Chart type specification.
     */
    protected function getType(): string
    {
        return 'line';
    }

    /**
     * Enhanced chart options with improved UI/UX.
     */
    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'interaction' => [
                'intersect' => false,
                'mode' => 'index',
            ],
            'animation' => [
                'duration' => 1000,
                'easing' => 'easeInOutQuart',
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                    'align' => 'center',
                    'labels' => [
                        'usePointStyle' => true,
                        'padding' => 20,
                        'font' => [
                            'size' => 13,
                            'weight' => 'bold',
                            'family' => "'Inter', sans-serif"
                        ],
                        'color' => '#374151'
                    ]
                ],
                'tooltip' => [
                    'enabled' => true,
                    'backgroundColor' => 'rgba(17, 24, 39, 0.95)',
                    'titleColor' => '#ffffff',
                    'bodyColor' => '#e5e7eb',
                    'borderColor' => '#3b82f6',
                    'borderWidth' => 2,
                    'cornerRadius' => 12,
                    'padding' => 12,
                    'displayColors' => true,
                    'titleFont' => [
                        'size' => 14,
                        'weight' => 'bold'
                    ],
                    'bodyFont' => [
                        'size' => 13,
                        'weight' => 'normal'
                    ],
                    'callbacks' => [
                        'title' => "function(context) {
                            const label = context[0].label;
                            const period = label.includes(':') ? 'Hour' : (label.includes('-') ? 'Week' : 'Day');
                            return period + ': ' + label;
                        }",
                        'label' => "function(context) {
                            const value = context.parsed.y;
                            const label = context.dataset.label;
                            const emoji = value > 100 ? '🔥' : value > 50 ? '📈' : value > 0 ? '📊' : '📉';
                            return emoji + ' ' + label + ': ' + value.toLocaleString() + ' visitors';
                        }",
                        'afterBody' => "function(context) {
                            const value = context[0].parsed.y;
                            if (value > 100) return '🎉 High traffic day!';
                            if (value > 50) return '✨ Good traffic';
                            if (value > 0) return '💡 Room for growth';
                            return '🔍 No visitors';
                        }"
                    ]
                ]
            ],
            'scales' => [
                'x' => [
                    'display' => true,
                    'grid' => [
                        'display' => false,
                        'drawBorder' => false,
                    ],
                    'ticks' => [
                        'font' => [
                            'size' => 11,
                            'weight' => '600',
                            'family' => "'Inter', sans-serif"
                        ],
                        'color' => '#6b7280',
                        'maxRotation' => 0,
                        'padding' => 10
                    ]
                ],
                'y' => [
                    'display' => true,
                    'beginAtZero' => true,
                    'grid' => [
                        'color' => 'rgba(156, 163, 175, 0.2)',
                        'borderDash' => [3, 3],
                        'drawBorder' => false,
                    ],
                    'ticks' => [
                        'font' => [
                            'size' => 11,
                            'family' => "'Inter', sans-serif"
                        ],
                        'color' => '#6b7280',
                        'padding' => 10,
                        'callback' => "function(value) {
                            if (value >= 1000) {
                                return (value / 1000).toFixed(1) + 'k';
                            }
                            return value;
                        }"
                    ]
                ]
            ],
            'elements' => [
                'point' => [
                    'hoverBackgroundColor' => '#ffffff',
                    'hoverBorderWidth' => 4,
                ],
                'line' => [
                    'borderJoinStyle' => 'round',
                    'borderCapStyle' => 'round',
                ]
            ],
            'layout' => [
                'padding' => [
                    'top' => 20,
                    'right' => 20,
                    'bottom' => 20,
                    'left' => 20
                ]
            ]
        ];
    }

    /**
     * Get header actions for additional functionality.
     */
    protected function getHeaderActions(): array
    {
        return [
            // You can add custom actions here like export, refresh, etc.
        ];
    }

    /**
     * Customize the widget's appearance and behavior.
     */
    public function getColumnSpan(): int | string | array
    {
        return 'full'; // Make widget span full width for better visibility
    }

    /**
     * Add custom CSS classes for enhanced styling.
     */
    protected function getExtraBodyAttributes(): array
    {
        return [
            'class' => 'traffic-chart-widget',
            'style' => 'background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-radius: 12px; padding: 1rem;'
        ];
    }
}
