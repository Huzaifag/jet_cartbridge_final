@extends('seller.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('seller.business-history.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <h2 class="fw-bold mb-1"><i class="fas fa-user-circle me-2"></i>{{ $customer->name }}</h2>
            <p class="text-muted mb-0">Complete business history and interactions</p>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Orders</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalOrders }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Spent</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">₹{{ number_format($totalSpent, 2) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Inquiries</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalInquiries }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
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
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Meetings</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalMeetings }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-video fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Time Period</label>
                    <select name="time" class="form-select" onchange="this.form.submit()">
                        <option value="all" {{ $timeFilter == 'all' ? 'selected' : '' }}>All Time</option>
                        <option value="7days" {{ $timeFilter == '7days' ? 'selected' : '' }}>Last 7 Days</option>
                        <option value="30days" {{ $timeFilter == '30days' ? 'selected' : '' }}>Last 30 Days</option>
                        <option value="90days" {{ $timeFilter == '90days' ? 'selected' : '' }}>Last 90 Days</option>
                        <option value="year" {{ $timeFilter == 'year' ? 'selected' : '' }}>Last Year</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Category</label>
                    <select name="category" class="form-select" onchange="this.form.submit()">
                        <option value="all" {{ $categoryFilter == 'all' ? 'selected' : '' }}>All Activities</option>
                        <option value="orders" {{ $categoryFilter == 'orders' ? 'selected' : '' }}>Orders Only</option>
                        <option value="inquiries" {{ $categoryFilter == 'inquiries' ? 'selected' : '' }}>Inquiries Only</option>
                        <option value="meetings" {{ $categoryFilter == 'meetings' ? 'selected' : '' }}>Meetings Only</option>
                        <option value="messages" {{ $categoryFilter == 'messages' ? 'selected' : '' }}>Messages Only</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="all" {{ $statusFilter == 'all' ? 'selected' : '' }}>All Status</option>
                        <option value="pending" {{ $statusFilter == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ $statusFilter == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Delivered" {{ $statusFilter == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Timeline -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-timeline me-2"></i>Activity Timeline</h6>
        </div>
        <div class="card-body">
            @forelse($timeline as $activity)
                @if($activity['type'] === 'order')
                    @php $order = $activity['data']; @endphp
                    <div class="timeline-item mb-4 pb-4 border-bottom">
                        <div class="d-flex">
                            <div class="timeline-icon bg-primary text-white rounded-circle me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h5 class="mb-1">Order #{{ $order->id }}</h5>
                                        <small class="text-muted">{{ $order->created_at->format('M d, Y h:i A') }}</small>
                                    </div>
                                    <span class="badge bg-{{ $order->status === 'Delivered' ? 'success' : 'warning' }}">
                                        {{ $order->status }}
                                    </span>
                                </div>
                                <p class="mb-2"><strong>Total:</strong> ₹{{ number_format($order->total, 2) }}</p>
                                <p class="mb-2"><strong>Payment:</strong> {{ $order->payment_status }}</p>
                                @if($order->orderItems && $order->orderItems->count() > 0)
                                <div class="mt-2">
                                    <strong>Items:</strong>
                                    <ul class="mb-0">
                                        @foreach($order->orderItems as $item)
                                        <li>{{ $item->product->name ?? 'Product' }} - Qty: {{ $item->quantity }} @ ₹{{ number_format($item->price, 2) }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @elseif($activity['type'] === 'inquiry')
                    @php $inquiry = $activity['data']; @endphp
                    <div class="timeline-item mb-4 pb-4 border-bottom">
                        <div class="d-flex">
                            <div class="timeline-icon bg-info text-white rounded-circle me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h5 class="mb-1">Inquiry / Quotation Request</h5>
                                        <small class="text-muted">{{ $inquiry->created_at->format('M d, Y h:i A') }}</small>
                                    </div>
                                    <span class="badge bg-{{ $inquiry->status === 'completed' ? 'success' : 'warning' }}">
                                        {{ ucfirst($inquiry->status) }}
                                    </span>
                                </div>
                                <p class="mb-2"><strong>Product:</strong> {{ $inquiry->product->name ?? 'N/A' }}</p>
                                <p class="mb-2"><strong>Quantity:</strong> {{ $inquiry->quantity }}</p>
                                @if($inquiry->message)
                                <p class="mb-0"><strong>Message:</strong> {{ Str::limit($inquiry->message, 150) }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @elseif($activity['type'] === 'meeting')
                    @php $meeting = $activity['data']; @endphp
                    <div class="timeline-item mb-4 pb-4 border-bottom">
                        <div class="d-flex">
                            <div class="timeline-icon bg-warning text-white rounded-circle me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-video"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h5 class="mb-1">Video Meeting</h5>
                                        <small class="text-muted">{{ $meeting->created_at->format('M d, Y h:i A') }}</small>
                                    </div>
                                    <span class="badge bg-{{ $meeting->status === 'completed' ? 'success' : 'info' }}">
                                        {{ ucfirst($meeting->status) }}
                                    </span>
                                </div>
                                @if($meeting->scheduled_at)
                                <p class="mb-2"><strong>Scheduled:</strong> {{ \Carbon\Carbon::parse($meeting->scheduled_at)->format('M d, Y h:i A') }}</p>
                                @endif
                                @if($meeting->topic)
                                <p class="mb-0"><strong>Topic:</strong> {{ $meeting->topic }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @elseif($activity['type'] === 'message')
                    @php $message = $activity['data']; @endphp
                    <div class="timeline-item mb-4 pb-4 border-bottom">
                        <div class="d-flex">
                            <div class="timeline-icon bg-secondary text-white rounded-circle me-3" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-comment"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h5 class="mb-1">Message</h5>
                                        <small class="text-muted">{{ $message->created_at->format('M d, Y h:i A') }}</small>
                                    </div>
                                </div>
                                <p class="mb-0">{{ Str::limit($message->message, 200) }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="text-center text-muted py-5">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <p>No activity found for the selected filters.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

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
.avatar-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.2rem;
}
</style>
@endsection
