@extends('seller.layouts.app')

@section('content')
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --light-bg: #f8f9fa;
            --dark-bg: #343a40;
            --border-color: #dee2e6;
        }

        body {
            background-color: #f5f7f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .page-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        .page-header {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .stat-content {
            flex-grow: 1;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            color: #2c3e50;
        }

        .stat-title {
            font-size: 0.9rem;
            color: #7f8c8d;
            font-weight: 500;
        }

        .nav-tabs .nav-link {
            border: none;
            padding: 12px 20px;
            color: #6c757d;
            font-weight: 500;
            border-radius: 8px 8px 0 0;
        }

        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            background-color: white;
            border-bottom: 3px solid var(--primary-color);
        }

        .tab-content {
            background: white;
            border-radius: 0 10px 10px 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .table-container {
            overflow: hidden;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-top: none;
            font-weight: 600;
            color: #495057;
            padding: 15px;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
        }

        .badge {
            padding: 0.5rem 0.75rem;
            border-radius: 0.5rem;
            font-weight: 500;
        }

        .action-buttons .btn {
            padding: 0.35rem 0.5rem;
            margin-right: 0.25rem;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: white;
            font-size: 1rem;
        }

        .product-thumb {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
        }

        .filter-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .search-form {
            position: relative;
        }

        .search-form .form-control {
            padding-left: 2.5rem;
            border-radius: 0.5rem;
        }

        .search-form i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .filter-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .filter-tag {
            background: #e9ecef;
            padding: 0.35rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-tag .close {
            font-size: 1.25rem;
            line-height: 1;
            cursor: pointer;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #dee2e6;
        }

        .history-timeline {
            position: relative;
            padding-left: 30px;
        }

        .history-timeline::before {
            content: '';
            position: absolute;
            left: 10px;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: #e9ecef;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 20px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -25px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: var(--primary-color);
            border: 2px solid white;
        }

        .team-selector {
            position: relative;
        }

        .team-members {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .team-member {
            display: flex;
            align-items: center;
            background: #f8f9fa;
            padding: 8px 12px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .team-member:hover {
            background: #e9ecef;
        }

        .team-member.active {
            background: var(--primary-color);
            color: white;
        }

        .team-member-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.8rem;
            background: #ddd;
        }

        .team-member.active .team-member-avatar {
            background: rgba(255, 255, 255, 0.2);
        }

        @media (max-width: 768px) {
            .stats-cards {
                grid-template-columns: 1fr 1fr;
            }

            .nav-tabs .nav-link {
                padding: 10px 15px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .stats-cards {
                grid-template-columns: 1fr;
            }

            .nav-tabs {
                flex-wrap: nowrap;
                overflow-x: auto;
            }
        }
    </style>


    <div class="page-container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Leads Management</h1>
                    <p class="text-muted mb-0">Manage and track your customer inquiries and leads</p>
                </div>
                <div class="d-flex">
                    <button class="btn btn-outline-secondary me-2" data-bs-toggle="modal" data-bs-target="#filterModal">
                        <i class="fas fa-filter me-2"></i>Filters
                    </button>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exportModal">
                        <i class="fas fa-download me-2"></i>Export
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-cards">
            <div class="stat-card">
                <div class="stat-icon" style="background-color: rgba(67, 97, 238, 0.1); color: #4361ee;">
                    <i class="fas fa-inbox"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $leads->count() }}</div>
                    <div class="stat-title">Total Leads</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background-color: rgba(40, 167, 69, 0.1); color: #28a745;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $leads->where('status', 'converted')->count() }}</div>
                    <div class="stat-title">Converted</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background-color: rgba(255, 193, 7, 0.1); color: #ffc107;">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $leads->where('status', 'contacted')->count() }}</div>
                    <div class="stat-title">In Progress</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background-color: rgba(220, 53, 69, 0.1); color: #dc3545;">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $leads->where('status', 'lost')->count() }}</div>
                    <div class="stat-title">Not Interested</div>
                </div>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs" id="leadsTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="inbox-tab" data-bs-toggle="tab" data-bs-target="#inbox" type="button"
                    role="tab">
                    <i class="fas fa-inbox me-2"></i>Lead Inbox
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="assignment-tab" data-bs-toggle="tab" data-bs-target="#assignment"
                    type="button" role="tab">
                    <i class="fas fa-users me-2"></i>Lead Assignment
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button"
                    role="tab">
                    <i class="fas fa-history me-2"></i>Lead History
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="leadsTabsContent">
            <!-- Lead Inbox Tab -->
            <div class="tab-pane fade show active" id="inbox" role="tabpanel">
                <!-- Filter Section -->
                <div class="filter-section">
                    <form>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="search-form">
                                    <i class="fas fa-search"></i>
                                    <input type="text" class="form-control" name="search" placeholder="Search leads..."
                                        value="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" name="status">
                                    <option value="">All Status</option>
                                    <option value="new">New</option>
                                    <option value="contacted">Contacted</option>
                                    <option value="qualified">Qualified</option>
                                    <option value="converted">Converted</option>
                                    <option value="not_interested">Not Interested</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" name="product">
                                    <option value="">All Products</option>
                                    <option value="1">Premium Burger</option>
                                    <option value="2">Special Pizza</option>
                                    <option value="3">Deluxe Ice Cream</option>
                                    <option value="4">Premium Coffee</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-filter me-2"></i>Apply
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Leads Table -->
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Buyer</th>
                                    <th>Email</th>
                                    <th>Product</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <th>Received</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($leads as $lead)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar" style="background-color: #3a5ee7;">
                                                        {{ $lead->customer->name[0] }}
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <div class="fw-bold">{{ $lead->customer->name }}</div>
                                                    <div class="small text-muted">{{ $lead->customer->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $lead->customer->email }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="product-thumb">
                                                        <i class="fas fa-hamburger"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <div class="fw-medium">{{ $lead->product->name }}</div>
                                                    <div class="small text-muted">{{ $lead->product->price }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="message-preview">
                                                {{ $lead->message }}
                                                <a href="#" class="text-primary read-more" data-bs-toggle="modal"
                                                    data-bs-target="#messageModal">Read more</a>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $lead->status }}</span>
                                        </td>
                                        <td>
                                            <div class="text-muted small">{{ $lead->created_at->diffForHumans() }}</div>
                                            <div class="small">{{ $lead->created_at->format('M d, Y') }}</div>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button type="button" class="btn btn-sm btn-info view-lead"
                                                    data-bs-toggle="modal" data-bs-target="#leadDetailModal">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <div class="btn-group">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                        data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <!-- Fix the dropdown by adding data-bs-offset="-8" to the dropdown toggle -->
                                                    <ul class="dropdown-menu" data-bs-offset="-8">
                                                        <li><a class="dropdown-item" href="#"><i
                                                                    class="fas fa-edit me-2"></i>Edit</a></li>
                                                        <li><a class="dropdown-item" href="#"><i
                                                                    class="fas fa-user-check me-2"></i>Mark as
                                                                Contacted</a>
                                                        </li>
                                                        <li><a class="dropdown-item" href="#"><i
                                                                    class="fas fa-check-circle me-2"></i>Mark as
                                                                Converted</a></li>
                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>
                                                        <li><a class="dropdown-item text-danger" href="#"><i
                                                                    class="fas fa-trash me-2"></i>Delete</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No leads found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center p-3 border-top">
                        <div class="text-muted">
                            Showing 1 to 10 of 142 entries
                        </div>
                        <div>
                            <ul class="pagination mb-0">
                                <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lead Assignment Tab -->
            <div class="tab-pane fade" id="assignment" role="tabpanel">
                <div class="row">
                    <div class="col-md-5">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Assign to Team Member</h5>
                            </div>
                            <div class="card-body">
                                <form action="#" method="POST">
                                    @csrf
                                    @if ($errors->any())
                                        <div class="alert alert-danger mb-3">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="mb-3">
                                        <label class="form-label">Select Lead</label>
                                        <select class="form-select @error('lead_id') is-invalid @enderror" name="lead_id">
                                            @forelse ($leads as $lead)
                                                <option value="{{ $lead->id }}"
                                                    @if (old('lead_id') == $lead->id) selected @endif>
                                                    {{ $lead->customer->name }} - {{ $lead->product->name }}</option>
                                            @empty
                                                <option>No leads available</option>
                                            @endforelse
                                        </select>
                                        @error('lead_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Assign To</label>
                                        <div class="team-selector">
                                            <select class="form-select mb-2 @error('employee_id') is-invalid @enderror"
                                                name="employee_id">
                                                <option selected>Select team member</option>
                                                @forelse ($salesmen as $employee)
                                                    <option value="{{ $employee->id }}"
                                                        @if (old('employee_id') == $employee->id) selected @endif>
                                                        {{ $employee->name }} ({{ $employee->position }})</option>
                                                @empty
                                                    <option>No employees available</option>
                                                @endforelse
                                            </select>
                                        </div>
                                        @error('employee_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Priority</label>
                                        <select class="form-select @error('priority') is-invalid @enderror"
                                            name="priority">
                                            <option @if (old('priority') == 'Low') selected @endif>Low</option>
                                            <option @if (old('priority') == 'Medium') selected @endif selected>Medium
                                            </option>
                                            <option @if (old('priority') == 'High') selected @endif>High</option>
                                            <option @if (old('priority') == 'Urgent') selected @endif>Urgent</option>
                                        </select>
                                        @error('priority')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Notes (Optional)</label>
                                        <textarea class="form-control @error('notes') is-invalid @enderror" rows="3"
                                            placeholder="Add any specific instructions..." name="notes">{{ old('notes') }}</textarea>
                                        @error('notes')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <button class="btn btn-primary w-100" type="submit">
                                        <i class="fas fa-user-check me-2"></i>Assign Lead
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    

                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Team Performance</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Team Member</th>
                                                <th>Assigned Leads</th>
                                                <th>Converted</th>
                                                <th>Conversion Rate</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <div class="avatar" style="background-color: #4361ee;">
                                                                DW
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <div class="fw-bold">David Wilson</div>
                                                            <div class="small text-muted">Sales Manager</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>42</td>
                                                <td>18</td>
                                                <td>42.9%</td>
                                                <td><span class="badge bg-success">Available</span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <div class="avatar" style="background-color: #e91e63;">
                                                                LA
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <div class="fw-bold">Lisa Anderson</div>
                                                            <div class="small text-muted">Account Executive</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>38</td>
                                                <td>15</td>
                                                <td>39.5%</td>
                                                <td><span class="badge bg-success">Available</span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <div class="avatar" style="background-color: #00bcd4;">
                                                                RT
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <div class="fw-bold">Robert Taylor</div>
                                                            <div class="small text-muted">Business Development</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>35</td>
                                                <td>12</td>
                                                <td>34.3%</td>
                                                <td><span class="badge bg-warning">Busy</span></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0">
                                                            <div class="avatar" style="background-color: #ff9800;">
                                                                MG
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1 ms-3">
                                                            <div class="fw-bold">Maria Garcia</div>
                                                            <div class="small text-muted">Customer Success</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>27</td>
                                                <td>10</td>
                                                <td>37.0%</td>
                                                <td><span class="badge bg-danger">Away</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Leads</th>
                                        <th>Priority</th>
                                        <th>Notes</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($employees) && $employees->isNotEmpty())
                                        @foreach ($employees as $employee)
                                            <tr>
                                                <td>{{ $employee->name }}</td>
                                                <td>
                                                    @if ($employee->leadAssignments->isNotEmpty())
                                                        @foreach ($employee->leadAssignments as $lead)
                                                            <span class="badge bg-primary">
                                                                {{ $lead->lead->customer->name }} -
                                                                {{ $lead->lead->product->name }}
                                                            </span>
                                                        @endforeach
                                                    @else
                                                        <span>No leads assigned</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($employee->leadAssignments->isNotEmpty())
                                                        {{ $employee->leadAssignments->first()->priority }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($employee->leadAssignments->isNotEmpty())
                                                        {{ $employee->leadAssignments->first()->notes }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($employee->leadAssignments->isNotEmpty())
                                                        {{ $employee->leadAssignments->first()->status }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="2"><span>No employees found</span></td>
                                        </tr>
                                    @endif
                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Lead History Tab -->
            <div class="tab-pane fade" id="history" role="tabpanel">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Select Lead</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <select class="form-select">
                                        <option selected>John Smith - Premium Burger</option>
                                        <option>Sarah Johnson - Special Pizza</option>
                                        <option>Michael Brown - Deluxe Ice Cream</option>
                                        <option>Emily Davis - Premium Coffee</option>
                                    </select>
                                </div>

                                <div class="lead-info">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar me-3"
                                            style="background-color: #3a5ee7; width: 50px; height: 50px;">J</div>
                                        <div>
                                            <h5 class="mb-0">John Smith</h5>
                                            <p class="text-muted mb-0">john.smith@example.com</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <small class="text-muted">Phone</small>
                                            <p class="mb-0">+1 (555) 123-4567</p>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Status</small>
                                            <p class="mb-0"><span class="badge bg-primary">New</span></p>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <small class="text-muted">Product</small>
                                        <p class="mb-0">Premium Burger - $12.99</p>
                                    </div>

                                    <div class="mb-3">
                                        <small class="text-muted">Last Contact</small>
                                        <p class="mb-0">2 hours ago</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Interaction History</h5>
                            </div>
                            <div class="card-body">
                                <div class="history-timeline">
                                    <div class="timeline-item">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h6 class="mb-0">Lead Created</h6>
                                                    <span class="text-muted small">2 hours ago</span>
                                                </div>
                                                <p class="mb-0 text-muted">Lead was created from website contact form.
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="timeline-item">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h6 class="mb-0">Initial Review</h6>
                                                    <span class="text-muted small">1 hour ago</span>
                                                </div>
                                                <p class="mb-0">Lead was reviewed by <strong>David Wilson</strong> and
                                                    marked as qualified.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="timeline-item">
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h6 class="mb-0">Email Sent</h6>
                                                    <span class="text-muted small">45 minutes ago</span>
                                                </div>
                                                <p class="mb-0">Initial follow-up email was sent to the lead.</p>
                                                <div class="mt-2 p-2 bg-light rounded">
                                                    <small class="text-muted">Subject: Thank you for your inquiry about
                                                        Premium Burger</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="timeline-item">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <h6 class="mb-0">Assigned to Team Member</h6>
                                                    <span class="text-muted small">30 minutes ago</span>
                                                </div>
                                                <p class="mb-0">Lead was assigned to <strong>Lisa Anderson</strong> for
                                                    follow-up.</p>
                                                <div class="mt-2">
                                                    <small class="text-muted"><i class="fas fa-tag me-1"></i> Priority:
                                                        Medium</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Message Modal -->
    <div class="modal fade" id="messageModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Full Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Hello, I'm interested in placing bulk orders for our company event next month. We're expecting
                        around 100 attendees and would like to know about your catering options for the Premium Burger.
                        Could you please send me information about pricing, delivery options, and any discounts for
                        large orders? Thank you!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Team member selection
            const teamMembers = document.querySelectorAll('.team-member');
            teamMembers.forEach(member => {
                member.addEventListener('click', function() {
                    teamMembers.forEach(m => m.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Tab persistence
            const leadsTabs = document.getElementById('leadsTabs');
            if (leadsTabs) {
                leadsTabs.addEventListener('click', function(e) {
                    if (e.target.tagName === 'BUTTON') {
                        const tabId = e.target.getAttribute('data-bs-target');
                        localStorage.setItem('activeLeadTab', tabId);
                    }
                });

                // Activate saved tab
                const activeTabId = localStorage.getItem('activeLeadTab');
                if (activeTabId) {
                    const tabTrigger = document.querySelector(`[data-bs-target="${activeTabId}"]`);
                    if (tabTrigger) {
                        new bootstrap.Tab(tabTrigger).show();
                    }
                }
            }
        });
    </script>
@endsection
