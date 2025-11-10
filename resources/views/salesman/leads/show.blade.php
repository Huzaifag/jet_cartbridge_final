@extends('salesman.layouts.app')

@section('title', 'Lead Details')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Lead #{{ $lead->id }} Details</h1>
        <a href="{{ route('salesman.leads.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Leads
        </a>
    </div>

    <div class="row">
        <!-- Lead Information -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Buyer Information</h6>
                </div>
                <div class="card-body">
                    @if($lead->inquiry_id)
                        <div class="alert alert-info mb-3">
                            <i class="fas fa-info-circle"></i> This lead was generated from a B2B inquiry
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name:</strong> {{ $lead->buyer_name ?? $lead->buyer->name ?? 'N/A' }}</p>
                            <p><strong>Email:</strong> {{ $lead->email }}</p>
                            <p><strong>Phone:</strong> {{ $lead->buyer_phone ?? $lead->buyer->phone ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Product:</strong> {{ $lead->product->name ?? 'General Inquiry' }}</p>
                            @if($lead->quantity)
                                <p><strong>Quantity:</strong> {{ number_format($lead->quantity) }} units</p>
                            @endif
                            @if($lead->target_price)
                                <p><strong>Target Price:</strong> ${{ number_format($lead->target_price, 2) }}</p>
                            @endif
                            <p><strong>Created:</strong> {{ $lead->created_at->format('M d, Y h:i A') }}</p>
                            <p><strong>Last Follow-up:</strong> {{ $lead->followed_up_at ? $lead->followed_up_at->diffForHumans() : 'Never' }}</p>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h6 class="font-weight-bold">Requirement/Message:</h6>
                    <p class="bg-light p-3 rounded">{{ $lead->message ?? 'No message provided' }}</p>

                    @if($lead->split_notes)
                        <h6 class="font-weight-bold mt-3">Split Notes:</h6>
                        <p class="bg-warning p-3 rounded">{{ $lead->split_notes }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions Sidebar -->
        <div class="col-lg-4">
            <!-- Status Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Lead Status</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('salesman.leads.update-status', $lead->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control" onchange="this.form.submit()">
                                <option value="pending" {{ $lead->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ $lead->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="converted" {{ $lead->status == 'converted' ? 'selected' : '' }}>Converted</option>
                                <option value="lost" {{ $lead->status == 'lost' ? 'selected' : '' }}>Lost</option>
                            </select>
                        </div>
                    </form>

                    <form action="{{ route('salesman.leads.update-priority', $lead->id) }}" method="POST" class="mt-3">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Priority</label>
                            <select name="priority" class="form-control" onchange="this.form.submit()">
                                <option value="low" {{ $lead->priority == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ $lead->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ $lead->priority == 'high' ? 'selected' : '' }}>High</option>
                                <option value="urgent" {{ $lead->priority == 'urgent' ? 'selected' : '' }}>Urgent</option>
                            </select>
                        </div>
                    </form>

                    <form action="{{ route('salesman.leads.follow-up', $lead->id) }}" method="POST" class="mt-3">
                        @csrf
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-phone"></i> Mark as Followed Up
                        </button>
                    </form>
                </div>
            </div>

            <!-- Split Lead Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Split Lead</h6>
                </div>
                <div class="card-body">
                    @if($lead->assigned_to_salesman_id)
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> This lead is assigned to <strong>{{ $lead->assignedToSalesman->user->name }}</strong>
                        </div>
                    @endif

                    <form action="{{ route('salesman.leads.split', $lead->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Assign To</label>
                            <select name="assigned_to_salesman_id" class="form-control" required>
                                <option value="">Select Salesman</option>
                                @foreach($teamSalesmen as $salesman)
                                    <option value="{{ $salesman->id }}">{{ $salesman->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Notes</label>
                            <textarea name="split_notes" class="form-control" rows="3" placeholder="Add notes..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-warning btn-block">
                            <i class="fas fa-share-nodes"></i> Assign Lead
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
