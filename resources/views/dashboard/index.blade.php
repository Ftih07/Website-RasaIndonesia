@extends('layouts.app')

@section('content')
@include('dashboard.partials.navbar')

<div class="container-fluid px-3 px-md-4 py-4">

    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-header p-4 rounded-3 position-relative overflow-hidden">
                <div class="position-relative z-index-2">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div>
                            <h1 class="text-white mb-2 fw-bold">Welcome to Your Dashboard</h1>
                            <p class="text-white opacity-90 mb-0">Monitor your business performance and manage your Indonesian culinary empire</p>
                        </div>
                        <div class="text-end d-none d-md-block">
                            <div class="text-white opacity-75 small">{{ date('l, F j, Y') }}</div>
                            <div class="text-white fw-semibold">{{ date('H:i A') }}</div>
                        </div>
                    </div>
                </div>
                <div class="position-absolute top-0 end-0 opacity-10">
                    <i class="fas fa-utensils" style="font-size: 8rem; transform: rotate(15deg);"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Key Metrics Cards -->
    <div class="row mb-4">
        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="metric-card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="metric-icon bg-success bg-opacity-10 text-success rounded-circle p-3 mb-3">
                                <i class="fas fa-dollar-sign fs-4"></i>
                            </div>
                            <h6 class="text-muted text-uppercase small fw-semibold mb-1">
                                Revenue (This Month)
                            </h6>
                            <h3 class="text-dark fw-bold mb-1">
                                A${{ number_format($currentMonthRevenue, 2) }}
                            </h3>
                            <span class="badge {{ $revenueGrowth >= 0 ? 'bg-success text-success' : 'bg-danger text-danger' }} bg-opacity-10 rounded-pill">
                                <i class="fas {{ $revenueGrowth >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} me-1"></i>
                                {{ number_format($revenueGrowth, 1) }}%
                            </span>
                        </div>
                        <div class="metric-chart">
                            <canvas id="revenueChart" width="80" height="40"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="metric-card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="metric-icon bg-primary bg-opacity-10 text-primary rounded-circle p-3 mb-3">
                                <i class="fas fa-shopping-bag fs-4"></i>
                            </div>
                            <h6 class="text-muted text-uppercase small fw-semibold mb-1">Products Sold</h6>
                            <h3 class="text-dark fw-bold mb-1">
                                {{ number_format($currentMonthProducts) }}
                            </h3>
                            <span class="badge {{ $productsGrowth >= 0 ? 'bg-primary text-primary' : 'bg-danger text-danger' }} bg-opacity-10 rounded-pill">
                                <i class="fas {{ $productsGrowth >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} me-1"></i>
                                {{ number_format($productsGrowth, 1) }}%
                            </span>
                        </div>
                        <div class="metric-chart">
                            <canvas id="productsChart" width="80" height="40"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="metric-card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="metric-icon bg-warning bg-opacity-10 text-warning rounded-circle p-3 mb-3">
                                <i class="fas fa-receipt fs-4"></i>
                            </div>
                            <h6 class="text-muted text-uppercase small fw-semibold mb-1">Total Orders</h6>
                            <h3 class="text-dark fw-bold mb-1">
                                {{ number_format($currentMonthOrders) }}
                            </h3>
                            <span class="badge {{ $ordersGrowth >= 0 ? 'bg-warning text-warning' : 'bg-danger text-danger' }} bg-opacity-10 rounded-pill">
                                <i class="fas {{ $ordersGrowth >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} me-1"></i>
                                {{ number_format($ordersGrowth, 1) }}%
                            </span>
                        </div>
                        <div class="metric-chart">
                            <canvas id="ordersChart" width="80" height="40"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3 mb-3">
            <div class="metric-card h-100 border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="metric-icon bg-info bg-opacity-10 text-info rounded-circle p-3 mb-3">
                                <i class="fas fa-star fs-4"></i>
                            </div>
                            <h6 class="text-muted text-uppercase small fw-semibold mb-1">Avg Rating</h6>
                            <h3 class="text-dark fw-bold mb-1">
                                {{ number_format($currentMonthRating, 1) ?: '0.0' }}
                            </h3>

                            <span class="badge {{ $ratingGrowth >= 0 ? 'bg-info text-info' : 'bg-danger text-danger' }} bg-opacity-10 rounded-pill">
                                <i class="fas {{ $ratingGrowth >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} me-1"></i>
                                {{ number_format($ratingGrowth, 1) }}%
                            </span>
                        </div>

                        {{-- Dynamic stars --}}
                        <div class="rating-stars">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= round($currentMonthRating) ? 'text-warning' : 'text-muted' }}"></i>
                                @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Best Sellers Row -->
    <div class="row mb-4">
        <!-- Sales Chart -->
        <div class="col-12 col-xl-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="card-title mb-0 fw-bold">Monthly Sales Performance</h5>
                            <p class="text-muted small mb-0">Track your sales trends over time</p>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                {{ $year }}
                            </button>
                            <ul class="dropdown-menu">
                                @foreach($years as $y)
                                <li>
                                    <a class="dropdown-item" href="{{ route('dashboard', ['year' => $y]) }}">
                                        {{ $y }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <canvas id="monthlySalesChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <!-- Best Sellers -->
        <div class="col-12 col-xl-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 p-4">
                    <h5 class="card-title mb-0 fw-bold">Top 5 Best Selling Products</h5>
                    <p class="text-muted small mb-0">Top performers this month</p>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($bestSellers as $index => $item)
                        <div class="list-group-item border-0 px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="product-rank {{ $index < 3 ? 'bg-gradient-'.(['orange','yellow','secondary'][$index]).' text-white' : 'bg-light text-dark' }} rounded-circle d-flex align-items-center justify-content-center me-3">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold">{{ $item->product->name ?? 'Unknown Product' }}</h6>
                                    <small class="text-muted">{{ $item->total_sold }} sold</small>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold text-success">A${{ number_format($item->revenue, 2) }}</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Quick Actions -->
    <div class="row">
        <!-- Recent Activity -->
        <div class="col-12 col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 p-4">
                    <h5 class="card-title mb-0 fw-bold">Recent Activity</h5>
                    <p class="text-muted small mb-0">Latest updates from your business</p>
                </div>
                <div class="card-body p-4">
                    <div class="activity-timeline">
                        @forelse($activities as $activity)
                        <div class="activity-item d-flex mb-4">
                            <div class="activity-icon 
                @if($activity->type == 'order') bg-success text-success
                @elseif($activity->type == 'product') bg-primary text-primary
                @elseif($activity->type == 'review') bg-warning text-warning
                @else bg-secondary text-muted
                @endif
                bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="fas 
                    @if($activity->type == 'order') fa-shopping-cart
                    @elseif($activity->type == 'product') fa-plus-circle
                    @elseif($activity->type == 'review') fa-star
                    @else fa-info-circle
                    @endif"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-semibold">{{ $activity->title }}</h6>
                                <p class="text-muted small mb-1">{{ $activity->description }}</p>
                                <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted small">No recent activity yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-12 col-lg-4 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 p-4">
                    <h5 class="card-title mb-0 fw-bold">Quick Actions</h5>
                    <p class="text-muted small mb-0">Manage your business efficiently</p>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-3">
                        <a href="{{ route('dashboard.product.store') }}" class="btn btn-outline-primary d-flex align-items-center">
                            <i class="fas fa-plus-circle me-2"></i>
                            Add New Product
                        </a>
                        <a href="{{ route('dashboard.orders') }}" class="btn btn-outline-success d-flex align-items-center">
                            <i class="fas fa-eye me-2"></i>
                            View All Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    /* Welcome Header Gradient */
    .welcome-header {
        background: linear-gradient(135deg, #f97316 0%, #eab308 50%, #f59e0b 100%);
        position: relative;
    }

    .z-index-2 {
        z-index: 2;
    }

    /* Metric Cards */
    .metric-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .metric-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    }

    .metric-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Product Rankings */
    .product-rank {
        width: 32px;
        height: 32px;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .bg-gradient-orange {
        background: linear-gradient(135deg, #f97316, #ea580c);
    }

    .bg-gradient-yellow {
        background: linear-gradient(135deg, #eab308, #ca8a04);
    }

    .bg-gradient-secondary {
        background: linear-gradient(135deg, #6b7280, #4b5563);
    }

    /* Activity Timeline */
    .activity-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
    }

    /* Charts Responsiveness */
    .metric-chart {
        opacity: 0.6;
    }

    /* Responsive Design */
    @media (max-width: 767.98px) {
        .welcome-header {
            text-align: center;
        }

        .welcome-header h1 {
            font-size: 1.75rem;
        }

        .metric-card .card-body {
            padding: 1.5rem !important;
        }

        .product-rank {
            width: 28px;
            height: 28px;
            font-size: 0.75rem;
        }
    }

    @media (max-width: 575.98px) {
        .d-grid.gap-3 .btn {
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
        }

        .activity-timeline .activity-item {
            align-items: flex-start;
        }
    }

    /* Chart Container */
    #monthlySalesChart {
        max-height: 300px;
    }

    /* Loading States */
    .card.loading {
        opacity: 0.7;
        pointer-events: none;
    }

    /* Hover Effects for Cards */
    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
    }

    /* Rating Stars */
    .rating-stars {
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    /* Custom Badge Colors */
    .badge.bg-success.bg-opacity-10 {
        background-color: rgba(25, 135, 84, 0.1) !important;
    }

    .badge.bg-primary.bg-opacity-10 {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }

    .badge.bg-warning.bg-opacity-10 {
        background-color: rgba(255, 193, 7, 0.1) !important;
    }

    .badge.bg-info.bg-opacity-10 {
        background-color: rgba(13, 202, 240, 0.1) !important;
    }

    /* Quick Actions Buttons */
    .btn-outline-primary:hover,
    .btn-outline-success:hover,
    .btn-outline-warning:hover,
    .btn-outline-info:hover {
        transform: translateX(5px);
        transition: all 0.3s ease;
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const labels = @json($monthLabels);
        const revenueData = @json($revenueData);
        const ordersData = @json($ordersData);

        const salesCtx = document.getElementById('monthlySalesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Revenue (A$)',
                    data: revenueData,
                    borderColor: '#f97316',
                    backgroundColor: 'rgba(249, 115, 22, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#f97316',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6
                }, {
                    label: 'Orders',
                    data: ordersData,
                    borderColor: '#eab308',
                    backgroundColor: 'rgba(234, 179, 8, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#eab308',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                if (context.dataset.label.includes('Revenue')) {
                                    return 'A$ ' + context.formattedValue.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                }
                                return context.formattedValue + ' orders';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#6b7280'
                        }
                    },
                    y: {
                        grid: {
                            color: 'rgba(0,0,0,0.1)'
                        },
                        ticks: {
                            color: '#6b7280'
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
    });
</script>
@endsection