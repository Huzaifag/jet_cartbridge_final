@extends('deliveryman.layouts.app')
@section('content')
<div class="container-fluid py-4">
    <header class="mb-4 pb-3 border-bottom">
        <h1 class="fw-bolder mb-0 text-dark">Delivery Dashboard</h1>
        <p class="text-muted mt-1">Manage your assigned delivery orders.</p>
    </header>

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="stat-card bg-primary-subtle border border-primary">
                <div class="stat-label text-primary">Total Assigned</div>
                <div class="stat-value text-primary">{{ $stats['total_assigned'] }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card bg-success-subtle border border-success">
                <div class="stat-label text-success">Delivered</div>
                <div class="stat-value text-success">{{ $stats['delivered'] }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card bg-warning-subtle border border-warning">
                <div class="stat-label text-warning">Pending Delivery</div>
                <div class="stat-value text-warning">{{ $stats['pending'] }}</div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold py-3 border-bottom d-flex justify-content-between align-items-center">
            Recent Assigned Orders
            <a href="{{ route('deliveryman.orders.index') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-list me-1"></i> View All Orders
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($assignedOrders as $order)
                        <tr>
                            <td>
                                <span class="fw-bold text-primary">#ORD{{ $order->id }}</span>
                            </td>
                            <td>
                                <p class="fw-bold mb-0">{{ $order->customer->name }}</p>
                                <small class="text-muted">{{ $order->customer->email }}</small>
                            </td>
                            <td>
                                @php
                                    $badgeClass = match ($order->status) {
                                        'Delivered' => 'success',
                                        'Dispatched' => 'warning',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $badgeClass }}">{{ $order->status }}</span>
                            </td>
                            <td class="fw-bold text-success">${{ number_format($order->total, 2) }}</td>
                            <td>
                                <a href="{{ route('deliveryman.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <i class="fas fa-truck me-2 text-muted"></i> No orders assigned yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($assignedOrders->hasPages())
            <div class="card-footer">
                {{ $assignedOrders->links() }}
            </div>
        @endif
    </div>
</div>

<style>
.stat-card {
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s ease;
    height: 100%;
}

.stat-card:hover {
    transform: translateY(-2px);
}

.stat-value {
    font-size: 2.25rem;
    font-weight: 700;
}

.stat-label {
    font-size: 0.9rem;
    color: #6c757d;
    font-weight: 500;
    text-transform: uppercase;
}
</style>
@endsection
