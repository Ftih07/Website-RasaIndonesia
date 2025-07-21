@extends('layouts.app')

@section('content')
@include('dashboard.partials.navbar')

<div class="container-fluid px-3 px-md-4 py-4">
    <div class="row mb-4">
        <div class="col-12">
            <!-- ⚠️ Warning Info Box -->
            <div class="alert alert-warning mt-4 d-flex align-items-center shadow-sm" role="alert" style="background-color: rgba(255, 193, 7, 0.2); border-left: 5px solid #ffc107;">
                <i class="fas fa-exclamation-triangle me-3 fs-4 text-warning"></i>
                <div>
                    <strong>Note:</strong> All data displayed here is currently static and the dashboard is still under development. Some features may not function yet.
                </div>
            </div>
        </div>
    </div>

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
                            <h6 class="text-muted text-uppercase small fw-semibold mb-1">Total Revenue</h6>
                            <h3 class="text-dark fw-bold mb-1">$24,567</h3>
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill">
                                <i class="fas fa-arrow-up me-1"></i>+15.3%
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
                            <h3 class="text-dark fw-bold mb-1">1,247</h3>
                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">
                                <i class="fas fa-arrow-up me-1"></i>+8.2%
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
                            <h3 class="text-dark fw-bold mb-1">892</h3>
                            <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill">
                                <i class="fas fa-arrow-up me-1"></i>+12.1%
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
                            <h3 class="text-dark fw-bold mb-1">4.8</h3>
                            <span class="badge bg-info bg-opacity-10 text-info rounded-pill">
                                <i class="fas fa-arrow-up me-1"></i>+0.3%
                            </span>
                        </div>
                        <div class="rating-stars">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
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
                                2024
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">2024</a></li>
                                <li><a class="dropdown-item" href="#">2023</a></li>
                                <li><a class="dropdown-item" href="#">2022</a></li>
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
                    <h5 class="card-title mb-0 fw-bold">Best Selling Products</h5>
                    <p class="text-muted small mb-0">Top performers this month</p>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item border-0 px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="product-rank bg-gradient-orange text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                    1
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold">Nasi Gudeg Yogya</h6>
                                    <small class="text-muted">234 sold</small>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold text-success">$2,340</div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item border-0 px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="product-rank bg-gradient-yellow text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                    2
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold">Rendang Padang</h6>
                                    <small class="text-muted">198 sold</small>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold text-success">$1,980</div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item border-0 px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="product-rank bg-gradient-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                    3
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold">Soto Ayam Lamongan</h6>
                                    <small class="text-muted">176 sold</small>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold text-success">$1,760</div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item border-0 px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="product-rank bg-light text-dark rounded-circle d-flex align-items-center justify-content-center me-3">
                                    4
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold">Gado-Gado Jakarta</h6>
                                    <small class="text-muted">154 sold</small>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold text-success">$1,540</div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item border-0 px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="product-rank bg-light text-dark rounded-circle d-flex align-items-center justify-content-center me-3">
                                    5
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold">Bakso Malang</h6>
                                    <small class="text-muted">142 sold</small>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold text-success">$1,420</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light border-0 p-3">
                    <div class="text-center">
                        <a href="#" class="btn btn-outline-primary btn-sm">View All Products</a>
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
                        <div class="activity-item d-flex mb-4">
                            <div class="activity-icon bg-success bg-opacity-10 text-success rounded-circle p-2 me-3">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-semibold">New Order Received</h6>
                                <p class="text-muted small mb-1">Order #ORD-2024-001 for Nasi Gudeg Yogya</p>
                                <small class="text-muted">2 minutes ago</small>
                            </div>
                        </div>
                        <div class="activity-item d-flex mb-4">
                            <div class="activity-icon bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-semibold">Product Added</h6>
                                <p class="text-muted small mb-1">Nasi Liwet Solo added to menu</p>
                                <small class="text-muted">1 hour ago</small>
                            </div>
                        </div>
                        <div class="activity-item d-flex mb-4">
                            <div class="activity-icon bg-warning bg-opacity-10 text-warning rounded-circle p-2 me-3">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-semibold">New Review</h6>
                                <p class="text-muted small mb-1">5-star review for Rendang Padang</p>
                                <small class="text-muted">3 hours ago</small>
                            </div>
                        </div>
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
                        <a href="#" class="btn btn-outline-primary d-flex align-items-center">
                            <i class="fas fa-plus-circle me-2"></i>
                            Add New Product
                        </a>
                        <a href="#" class="btn btn-outline-success d-flex align-items-center">
                            <i class="fas fa-eye me-2"></i>
                            View All Orders
                        </a>
                        <a href="#" class="btn btn-outline-warning d-flex align-items-center">
                            <i class="fas fa-chart-bar me-2"></i>
                            Analytics Report
                        </a>
                        <a href="#" class="btn btn-outline-info d-flex align-items-center">
                            <i class="fas fa-cog me-2"></i>
                            Settings
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

<!-- Chart.js Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Monthly Sales Chart
        const salesCtx = document.getElementById('monthlySalesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Revenue ($)',
                    data: [1800, 2200, 1900, 2800, 2400, 3200, 2900, 3400, 3100, 3600, 3300, 3800],
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
                    data: [45, 55, 48, 70, 60, 80, 73, 85, 78, 90, 83, 95],
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

        // Mini Charts for Metric Cards
        const miniChartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    display: false
                },
                y: {
                    display: false
                }
            },
            elements: {
                point: {
                    radius: 0
                }
            }
        };

        // Revenue Mini Chart
        new Chart(document.getElementById('revenueChart'), {
            type: 'line',
            data: {
                labels: ['', '', '', '', '', ''],
                datasets: [{
                    data: [20, 35, 25, 45, 30, 55],
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: miniChartOptions
        });

        // Products Mini Chart
        new Chart(document.getElementById('productsChart'), {
            type: 'line',
            data: {
                labels: ['', '', '', '', '', ''],
                datasets: [{
                    data: [30, 25, 40, 35, 50, 45],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: miniChartOptions
        });

        // Orders Mini Chart
        new Chart(document.getElementById('ordersChart'), {
            type: 'line',
            data: {
                labels: ['', '', '', '', '', ''],
                datasets: [{
                    data: [15, 30, 20, 35, 25, 40],
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: miniChartOptions
        });
    });
</script>
@endsection