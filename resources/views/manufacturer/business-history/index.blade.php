@extends('manufacturer.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Business History</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('manufacturer.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Business History</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Date Range</label>
                            <select name="date_range" class="form-select">
                                <option value="7">Last 7 days</option>
                                <option value="30">Last 30 days</option>
                                <option value="90">Last 90 days</option>
                                <option value="365">Last year</option>
                                <option value="all">All time</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Activity Type</label>
                            <select name="activity_type" class="form-select">
                                <option value="">All Activities</option>
                                <option value="order">Orders</option>
                                <option value="product">Products</option>
                                <option value="inquiry">Inquiries</option>
                                <option value="customer">Customers</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="completed">Completed</option>
                                <option value="pending">Pending</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i> Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Business History Timeline -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Activity Timeline</h4>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @forelse($activities ?? [] as $activity)
                            <div class="timeline-item">
                                <div class="timeline-marker">
                                    <div class="timeline-marker-icon bg-{{ $activity['type'] === 'order' ? 'success' : ($activity['type'] === 'product' ? 'primary' : 'info') }}">
                                        <i class="fas fa-{{ $activity['type'] === 'order' ? 'shopping-cart' : ($activity['type'] === 'product' ? 'box' : 'comment') }}"></i>
                                    </div>
                                </div>
                                <div class="timeline-content">
                                    <div class="timeline-header">
                                        <h6 class="timeline-title">{{ $activity['title'] ?? 'Activity' }}</h6>
                                        <span class="timeline-date">{{ $activity['date'] ?? now()->format('M d, Y H:i') }}</span>
                                    </div>
                                    <p class="timeline-description">{{ $activity['description'] ?? 'No description available' }}</p>
                                    @if(isset($activity['details']))
                                        <div class="timeline-details">
                                            @foreach($activity['details'] as $key => $value)
                                                <span class="badge bg-light text-dark me-1">{{ $key }}: {{ $value }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No business history found</h5>
                                <p class="text-muted">Your business activities will appear here as you use the platform.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Statistics -->
    <div class="row">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h4 class="text-primary">{{ $summary['total_orders'] ?? 0 }}</h4>
                    <p class="card-text">Total Orders</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h4 class="text-success">{{ $summary['total_products'] ?? 0 }}</h4>
                    <p class="card-text">Products Listed</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h4 class="text-info">{{ $summary['total_customers'] ?? 0 }}</h4>
                    <p class="card-text">Unique Customers</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h4 class="text-warning">${{ number_format($summary['total_revenue'] ?? 0, 2) }}</h4>
                    <p class="card-text">Total Revenue</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-marker {
    position: absolute;
    left: -22px;
    top: 0;
}

.timeline-marker-icon {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 12px;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border-left: 3px solid #007bff;
}

.timeline-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.timeline-title {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
}

.timeline-date {
    font-size: 12px;
    color: #6c757d;
}

.timeline-description {
    margin: 0 0 10px 0;
    color: #495057;
}

.timeline-details .badge {
    font-size: 10px;
}
</style>
@endsection