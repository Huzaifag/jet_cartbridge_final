@extends('salesman.layouts.app')

@section('title', 'My Leads')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-users-cog"></i> Lead Management
        </h1>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Leads</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">In Progress</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['in_progress'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tasks fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Converted</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['converted'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Leads</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('salesman.leads.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="converted" {{ request('status') == 'converted' ? 'selected' : '' }}>Converted</option>
                                <option value="lost" {{ request('status') == 'lost' ? 'selected' : '' }}>Lost</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Priority</label>
                            <select name="priority" class="form-control">
                                <option value="">All Priorities</option>
                                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                                <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Search</label>
                            <input type="text" name="search" class="form-control" placeholder="Search by name, email..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-search"></i> Filter
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Leads Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">My Leads ({{ $leads->total() }})</h6>
        </div>
        <div class="card-body">
            @if($leads->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Buyer Name</th>
                                <th>Phone/Email</th>
                                <th>Product</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Assigned</th>
                                <th>Last Follow-up</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leads as $lead)
                                <tr>
                                    <td>#{{ $lead->id }}</td>
                                    <td>
                                        <strong>{{ $lead->buyer_name ?? $lead->buyer->name ?? 'N/A' }}</strong>
                                        @if($lead->inquiry_id)
                                            <br><small class="badge badge-info">B2B Inquiry</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($lead->buyer_phone)
                                            <div><i class="fas fa-phone"></i> {{ $lead->buyer_phone }}</div>
                                        @endif
                                        <div><i class="fas fa-envelope"></i> {{ $lead->email }}</div>
                                    </td>
                                    <td>
                                        {{ $lead->product->name ?? 'General Inquiry' }}
                                        @if($lead->quantity)
                                            <br><small class="text-muted">Qty: {{ $lead->quantity }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $priorityColors = [
                                                'low' => 'secondary',
                                                'medium' => 'info',
                                                'high' => 'warning',
                                                'urgent' => 'danger'
                                            ];
                                        @endphp
                                        <span class="badge badge-{{ $priorityColors[$lead->priority] ?? 'secondary' }}">
                                            {{ ucfirst($lead->priority) }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'pending' => 'warning',
                                                'in_progress' => 'info',
                                                'converted' => 'success',
                                                'lost' => 'danger'
                                            ];
                                        @endphp
                                        <span class="badge badge-{{ $statusColors[$lead->status] ?? 'secondary' }}">
                                            {{ ucfirst(str_replace('_', ' ', $lead->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($lead->assigned_to_salesman_id)
                                            <small class="text-muted">
                                                <i class="fas fa-user-arrow-right"></i> {{ $lead->assignedToSalesman->user->name }}
                                            </small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($lead->followed_up_at)
                                            <small>{{ $lead->followed_up_at->diffForHumans() }}</small>
                                        @else
                                            <span class="text-danger">Never</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('salesman.leads.show', $lead->id) }}" class="btn btn-sm btn-info" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#splitModal{{ $lead->id }}" title="Split Lead">
                                            <i class="fas fa-share-nodes"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Split Modal -->
                                <div class="modal fade" id="splitModal{{ $lead->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('salesman.leads.split', $lead->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Split Lead to Team Member</h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Assign To Salesman</label>
                                                        <select name="assigned_to_salesman_id" class="form-control" required>
                                                            <option value="">Select Salesman</option>
                                                            @foreach($teamSalesmen as $salesman)
                                                                <option value="{{ $salesman->id }}">{{ $salesman->user->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Notes (Optional)</label>
                                                        <textarea name="split_notes" class="form-control" rows="3" placeholder="Add any notes for the assigned salesman..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Assign Lead</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $leads->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5>No Leads Found</h5>
                    <p class="text-muted">You don't have any leads yet. They will appear here when customers make inquiries.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
