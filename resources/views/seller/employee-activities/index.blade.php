@extends('seller.layouts.app')

@section('title', 'Employee Activities')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Employee Activities</h2>
            <p class="text-muted mb-0">Track all employee actions and performance</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle p-3" style="background: rgba(40, 167, 69, 0.1);">
                                <i class="fas fa-chart-line" style="color: #28a745; font-size: 24px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Total Activities</h6>
                            <h3 class="mb-0">{{ number_format($stats['total_activities']) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle p-3" style="background: rgba(0, 123, 255, 0.1);">
                                <i class="fas fa-user-tie" style="color: #007bff; font-size: 24px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Salesman</h6>
                            <h3 class="mb-0">{{ number_format($stats['salesman_activities']) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle p-3" style="background: rgba(255, 193, 7, 0.1);">
                                <i class="fas fa-calculator" style="color: #ffc107; font-size: 24px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Accountant</h6>
                            <h3 class="mb-0">{{ number_format($stats['accountant_activities']) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle p-3" style="background: rgba(220, 53, 69, 0.1);">
                                <i class="fas fa-truck" style="color: #dc3545; font-size: 24px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-muted mb-1">Warehouse & Delivery</h6>
                            <h3 class="mb-0">{{ number_format($stats['warehouse_activities'] + $stats['deliveryman_activities']) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('seller.employee-activities.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Employee Type</label>
                    <select name="employee_type" class="form-select" onchange="this.form.submit()">
                        <option value="all" {{ $employeeType == 'all' ? 'selected' : '' }}>All Employees</option>
                        <option value="salesman" {{ $employeeType == 'salesman' ? 'selected' : '' }}>Salesman</option>
                        <option value="accountant" {{ $employeeType == 'accountant' ? 'selected' : '' }}>Accountant</option>
                        <option value="warehouse" {{ $employeeType == 'warehouse' ? 'selected' : '' }}>Warehouse Manager</option>
                        <option value="deliveryman" {{ $employeeType == 'deliveryman' ? 'selected' : '' }}>Delivery Man</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Specific Employee</label>
                    <select name="employee_id" class="form-select" onchange="this.form.submit()">
                        <option value="">All</option>
                        @if($employeeType == 'all' || $employeeType == 'salesman')
                            <optgroup label="Salesmen">
                                @foreach($salesmen as $salesman)
                                    <option value="{{ $salesman->id }}" {{ $employeeId == $salesman->id ? 'selected' : '' }}>
                                        {{ $salesman->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                        @if($employeeType == 'all' || $employeeType == 'accountant')
                            <optgroup label="Accountants">
                                @foreach($accountants as $accountant)
                                    <option value="{{ $accountant->id }}" {{ $employeeId == $accountant->id ? 'selected' : '' }}>
                                        {{ $accountant->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                        @if($employeeType == 'all' || $employeeType == 'warehouse')
                            <optgroup label="Warehouse Managers">
                                @foreach($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}" {{ $employeeId == $warehouse->id ? 'selected' : '' }}>
                                        {{ $warehouse->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                        @if($employeeType == 'all' || $employeeType == 'deliveryman')
                            <optgroup label="Delivery Men">
                                @foreach($deliverymen as $deliveryman)
                                    <option value="{{ $deliveryman->id }}" {{ $employeeId == $deliveryman->id ? 'selected' : '' }}>
                                        {{ $deliveryman->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endif
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Date Range</label>
                    <select name="date_range" class="form-select" onchange="this.form.submit()">
                        <option value="today" {{ $dateRange == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="yesterday" {{ $dateRange == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                        <option value="week" {{ $dateRange == 'week' ? 'selected' : '' }}>This Week</option>
                        <option value="month" {{ $dateRange == 'month' ? 'selected' : '' }}>This Month</option>
                        <option value="quarter" {{ $dateRange == 'quarter' ? 'selected' : '' }}>This Quarter</option>
                        <option value="year" {{ $dateRange == 'year' ? 'selected' : '' }}>This Year</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Activity Type</label>
                    <select name="activity_type" class="form-select" onchange="this.form.submit()">
                        <option value="">All Activities</option>
                        <option value="order_created">Order Created</option>
                        <option value="invoice_generated">Invoice Generated</option>
                        <option value="product_dispatched">Product Dispatched</option>
                        <option value="delivery_completed">Delivery Completed</option>
                        <option value="lead_converted">Lead Converted</option>
                        <option value="lead_assigned">Lead Assigned</option>
                        <option value="payment_processed">Payment Processed</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Activities List -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Activity Log</h5>
        </div>
        <div class="card-body p-0">
            @if($activities->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Employee</th>
                                <th>Type</th>
                                <th>Activity</th>
                                <th>Description</th>
                                <th>Reference</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activities as $activity)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @php
                                                $employeeClass = 'App\\Models\\' . ucfirst($activity->employee_type);
                                                $employee = $employeeClass::find($activity->employee_id);
                                            @endphp
                                            @if($employee && $employee->avatar)
                                                <img src="{{ asset('storage/' . $employee->avatar) }}" 
                                                     class="rounded-circle me-2" 
                                                     width="32" height="32" 
                                                     alt="{{ $employee->name }}">
                                            @else
                                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-2" 
                                                     style="width: 32px; height: 32px;">
                                                    {{ substr($employee->name ?? 'U', 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-medium">{{ $employee->name ?? 'Unknown' }}</div>
                                                <small class="text-muted">{{ ucfirst($activity->employee_type) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $badges = [
                                                'salesman' => ['bg' => 'primary', 'icon' => 'user-tie'],
                                                'accountant' => ['bg' => 'warning', 'icon' => 'calculator'],
                                                'warehouse' => ['bg' => 'info', 'icon' => 'warehouse'],
                                                'deliveryman' => ['bg' => 'danger', 'icon' => 'truck'],
                                            ];
                                            $badge = $badges[$activity->employee_type] ?? ['bg' => 'secondary', 'icon' => 'user'];
                                        @endphp
                                        <span class="badge bg-{{ $badge['bg'] }}">
                                            <i class="fas fa-{{ $badge['icon'] }} me-1"></i>
                                            {{ ucfirst($activity->employee_type) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            {{ str_replace('_', ' ', ucwords($activity->activity_type)) }}
                                        </span>
                                    </td>
                                    <td>{{ $activity->description }}</td>
                                    <td>
                                        @if($activity->reference_type)
                                            <small class="text-muted">
                                                {{ class_basename($activity->reference_type) }} #{{ $activity->reference_id }}
                                            </small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $activity->created_at->diffForHumans() }}
                                        </small>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer bg-white">
                    {{ $activities->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No activities found for the selected filters.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Employee Performance Summary -->
    <div class="row mt-4">
        @foreach(['salesman', 'accountant', 'warehouse', 'deliveryman'] as $type)
            @if(isset($activitySummary[$type]) && count($activitySummary[$type]) > 0)
                <div class="col-md-6 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h6 class="mb-0">{{ ucfirst($type) }} Performance</h6>
                        </div>
                        <div class="card-body">
                            @foreach($activitySummary[$type] as $employeeData)
                                <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                                    <div class="d-flex align-items-center">
                                        @if($employeeData['avatar'])
                                            <img src="{{ asset('storage/' . $employeeData['avatar']) }}" 
                                                 class="rounded-circle me-3" 
                                                 width="40" height="40" 
                                                 alt="{{ $employeeData['name'] }}">
                                        @else
                                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 40px; height: 40px;">
                                                {{ substr($employeeData['name'], 0, 1) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-medium">{{ $employeeData['name'] }}</div>
                                            @if($employeeData['recent_activity'])
                                                <small class="text-muted">
                                                    Last: {{ $employeeData['recent_activity']->created_at->diffForHumans() }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <h5 class="mb-0">{{ $employeeData['activities'] }}</h5>
                                        <small class="text-muted">activities</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
@endsection
