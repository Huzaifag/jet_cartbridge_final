@extends('manufacturer.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Employee Activities</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('manufacturer.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Employee Activities</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Summary Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <p class="text-truncate font-size-14 mb-2">Total Employees</p>
                            <h4 class="mb-2">{{ $employeeStats['total_employees'] ?? 0 }}</h4>
                            <p class="text-muted mb-0">
                                <span class="text-success fw-bold font-size-12 me-2">
                                    <i class="ri-arrow-right-up-line me-1 align-middle"></i>
                                    Active: {{ $employeeStats['active_employees'] ?? 0 }}
                                </span>
                            </p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-primary-subtle text-primary rounded-3">
                                <i class="fas fa-users font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <p class="text-truncate font-size-14 mb-2">Today's Activities</p>
                            <h4 class="mb-2">{{ $employeeStats['todays_activities'] ?? 0 }}</h4>
                            <p class="text-muted mb-0">
                                <span class="text-info fw-bold font-size-12 me-2">
                                    <i class="ri-arrow-right-up-line me-1 align-middle"></i>
                                    {{ $employeeStats['active_now'] ?? 0 }} active now
                                </span>
                            </p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-success-subtle text-success rounded-3">
                                <i class="fas fa-chart-line font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <p class="text-truncate font-size-14 mb-2">Orders Processed</p>
                            <h4 class="mb-2">{{ $employeeStats['orders_processed'] ?? 0 }}</h4>
                            <p class="text-muted mb-0">
                                <span class="text-success fw-bold font-size-12 me-2">
                                    <i class="ri-arrow-right-up-line me-1 align-middle"></i>
                                    Today: {{ $employeeStats['orders_today'] ?? 0 }}
                                </span>
                            </p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-warning-subtle text-warning rounded-3">
                                <i class="fas fa-tasks font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <p class="text-truncate font-size-14 mb-2">Performance Score</p>
                            <h4 class="mb-2">{{ $employeeStats['avg_performance'] ?? 0 }}%</h4>
                            <p class="text-muted mb-0">
                                <span class="text-success fw-bold font-size-12 me-2">
                                    <i class="ri-arrow-right-up-line me-1 align-middle"></i>
                                    +{{ $employeeStats['performance_change'] ?? 0 }}%
                                </span>
                            </p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-info-subtle text-info rounded-3">
                                <i class="fas fa-star font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Timeline -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Recent Employee Activities</h4>
                    <div class="card-header-actions">
                        <select class="form-select form-select-sm" id="employeeFilter">
                            <option value="">All Employees</option>
                            <option value="accountant">Accountants</option>
                            <option value="salesman">Salesmen</option>
                            <option value="warehouse">Warehouse Staff</option>
                            <option value="delivery">Delivery Staff</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="activity-timeline">
                        @forelse($activities ?? [] as $activity)
                            <div class="activity-item" data-employee-type="{{ $activity['employee_type'] ?? 'general' }}">
                                <div class="activity-avatar">
                                    <img src="{{ $activity['employee_avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($activity['employee_name'] ?? 'Employee') . '&background=007bff&color=ffffff&size=40' }}" 
                                         alt="{{ $activity['employee_name'] ?? 'Employee' }}" class="rounded-circle">
                                </div>
                                <div class="activity-content">
                                    <div class="activity-header">
                                        <h6 class="activity-title">{{ $activity['employee_name'] ?? 'Employee' }}</h6>
                                        <span class="activity-time">{{ $activity['time'] ?? now()->diffForHumans() }}</span>
                                    </div>
                                    <p class="activity-description">{{ $activity['description'] ?? 'Performed an activity' }}</p>
                                    <div class="activity-meta">
                                        <span class="badge bg-{{ $activity['type'] === 'order' ? 'success' : ($activity['type'] === 'product' ? 'primary' : 'info') }}-subtle text-{{ $activity['type'] === 'order' ? 'success' : ($activity['type'] === 'product' ? 'primary' : 'info') }}">
                                            {{ ucfirst($activity['type'] ?? 'General') }}
                                        </span>
                                        @if(isset($activity['status']))
                                            <span class="badge bg-light text-dark ms-1">{{ ucfirst($activity['status']) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No activities found</h5>
                                <p class="text-muted">Employee activities will appear here as they work.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.activity-timeline {
    position: relative;
}

.activity-item {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    border-left: 3px solid #007bff;
}

.activity-avatar img {
    width: 40px;
    height: 40px;
    object-fit: cover;
}

.activity-content {
    flex: 1;
}

.activity-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 5px;
}

.activity-title {
    margin: 0;
    font-size: 14px;
    font-weight: 600;
}

.activity-time {
    font-size: 12px;
    color: #6c757d;
}

.activity-description {
    margin: 0 0 10px 0;
    font-size: 13px;
    color: #495057;
}

.activity-meta {
    display: flex;
    gap: 5px;
    flex-wrap: wrap;
}

.search-box {
    position: relative;
}

.search-icon {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
}

.card-header-actions {
    margin-left: auto;
}
</style>

<script>
// Employee filter
document.getElementById('employeeFilter').addEventListener('change', function() {
    const filterValue = this.value;
    const activityItems = document.querySelectorAll('.activity-item');
    
    activityItems.forEach(item => {
        const employeeType = item.dataset.employeeType;
        
        if (!filterValue || employeeType === filterValue) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
});
</script>
@endpush
@endsection