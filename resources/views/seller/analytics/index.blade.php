@extends('seller.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="fas fa-chart-line me-2"></i>Analytics Dashboard</h2>
            <p class="text-muted mb-0">Track your business performance and insights</p>
        </div>
        <div>
            <form method="GET" class="d-flex gap-2">
                <select name="period" class="form-select" onchange="this.form.submit()">
                    <option value="7" {{ $period == 7 ? 'selected' : '' }}>Last 7 Days</option>
                    <option value="30" {{ $period == 30 ? 'selected' : '' }}>Last 30 Days</option>
                    <option value="90" {{ $period == 90 ? 'selected' : '' }}>Last 90 Days</option>
                    <option value="365" {{ $period == 365 ? 'selected' : '' }}>Last Year</option>
                </select>
            </form>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Revenue</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">₹{{ number_format($totalRevenue, 2) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Orders</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalOrders) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Customers</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalCustomers) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Avg Order Value</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">₹{{ number_format($avgOrderValue, 2) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-bar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Revenue Trends Chart -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-chart-area me-2"></i>Revenue Trends</h6>
                </div>
                <div class="card-body">
                    <canvas id="revenueTrendsChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <!-- Review Engagement -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-star me-2"></i>Review Engagement</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h2 class="display-4 text-warning">{{ number_format($reviewEngagement->avg_rating ?? 0, 1) }}</h2>
                        <p class="text-muted">Average Rating</p>
                        <p class="mb-0"><strong>{{ $reviewEngagement->total_reviews ?? 0 }}</strong> Total Reviews</p>
                    </div>
                    <canvas id="reviewsChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Best-selling Products -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-trophy me-2"></i>Best-Selling Products</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Sold</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bestSellingProducts as $product)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                            @endif
                                            <div>
                                                <strong>{{ Str::limit($product->name, 30) }}</strong>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-info">{{ $product->total_sold }}</span></td>
                                    <td><strong>₹{{ number_format($product->total_revenue ?? 0, 2) }}</strong></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No sales data available</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Buyers -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-user-crown me-2"></i>Top Buyers</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Orders</th>
                                    <th>Total Spent</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($buyerBehavior as $buyer)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                                {{ strtoupper(substr($buyer->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <strong>{{ $buyer->name }}</strong><br>
                                                <small class="text-muted">{{ $buyer->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-info">{{ $buyer->total_orders }}</span></td>
                                    <td><strong>₹{{ number_format($buyer->total_spent ?? 0, 2) }}</strong></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">No buyer data available</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Peak Seasons -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-calendar-alt me-2"></i>Peak Seasons Analysis</h6>
                </div>
                <div class="card-body">
                    <canvas id="peakSeasonsChart" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
// Revenue Trends Chart
const revenueTrendsCtx = document.getElementById('revenueTrendsChart').getContext('2d');
new Chart(revenueTrendsCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($revenueTrends->pluck('date')->map(function($date) {
            return \Carbon\Carbon::parse($date)->format('M d');
        })) !!},
        datasets: [{
            label: 'Revenue (₹)',
            data: {!! json_encode($revenueTrends->pluck('revenue')) !!},
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                display: true
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Reviews Chart
const reviewsCtx = document.getElementById('reviewsChart').getContext('2d');
new Chart(reviewsCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($reviewsByRating->pluck('rating')->map(function($r) { return $r . ' Stars'; })) !!},
        datasets: [{
            data: {!! json_encode($reviewsByRating->pluck('count')) !!},
            backgroundColor: [
                'rgba(255, 206, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(153, 102, 255, 0.8)',
                'rgba(255, 99, 132, 0.8)'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true
    }
});

// Peak Seasons Chart
const peakSeasonsCtx = document.getElementById('peakSeasonsChart').getContext('2d');
new Chart(peakSeasonsCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($peakSeasons->map(function($season) {
            return \Carbon\Carbon::create($season->year, $season->month)->format('M Y');
        })) !!},
        datasets: [{
            label: 'Orders',
            data: {!! json_encode($peakSeasons->pluck('orders')) !!},
            backgroundColor: 'rgba(54, 162, 235, 0.8)',
            yAxisID: 'y'
        }, {
            label: 'Revenue (₹)',
            data: {!! json_encode($peakSeasons->pluck('revenue')) !!},
            backgroundColor: 'rgba(75, 192, 192, 0.8)',
            yAxisID: 'y1'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
            y: {
                type: 'linear',
                display: true,
                position: 'left',
                title: {
                    display: true,
                    text: 'Orders'
                }
            },
            y1: {
                type: 'linear',
                display: true,
                position: 'right',
                title: {
                    display: true,
                    text: 'Revenue (₹)'
                },
                grid: {
                    drawOnChartArea: false
                }
            }
        }
    }
});
</script>

<style>
.border-left-primary {
    border-left: 4px solid #4e73df !important;
}
.border-left-success {
    border-left: 4px solid #1cc88a !important;
}
.border-left-info {
    border-left: 4px solid #36b9cc !important;
}
.border-left-warning {
    border-left: 4px solid #f6c23e !important;
}
</style>
@endsection
