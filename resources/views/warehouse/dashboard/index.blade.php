@extends('warehouse.layouts.app')
@section('content')
<div class="container-fluid py-4">
    <header class="mb-4 pb-3 border-bottom">
        <h1 class="fw-bolder mb-0 text-dark">Warehouse Dashboard</h1>
        <p class="text-muted mt-1">Manage order dispatch and warehouse operations.</p>
    </header>

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="stat-card bg-primary-subtle border border-primary">
                <div class="stat-label text-primary">Total Orders</div>
                <div class="stat-value text-primary">{{ $stats['total_orders'] }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-success-subtle border border-success">
                <div class="stat-label text-success">Dispatched Orders</div>
                <div class="stat-value text-success">{{ $stats['dispatched_orders'] }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-warning-subtle border border-warning">
                <div class="stat-label text-warning">Ready for Dispatch</div>
                <div class="stat-value text-warning">{{ $stats['ready_for_dispatch'] }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card bg-info-subtle border border-info">
                <div class="stat-label text-info">Dispatched Revenue</div>
                <div class="stat-value text-info">${{ number_format($stats['total_revenue'], 2) }}</div>
            </div>
        </div>
    </div>

    <!-- Orders Ready for Dispatch -->
    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold py-3 border-bottom d-flex justify-content-between align-items-center">
            Orders Ready for Dispatch
            <a href="{{ route('warehouse.orders.index') }}" class="btn btn-primary btn-sm">
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
                    @forelse ($ordersReadyForDispatch as $order)
                        <tr>
                            <td>
                                <span class="fw-bold text-primary">#ORD{{ $order->id }}</span>
                            </td>
                            <td>
                                <p class="fw-bold mb-0">{{ $order->customer->name }}</p>
                                <small class="text-muted">{{ $order->customer->email }}</small>
                            </td>
                            <td>
                                <span class="badge bg-warning">{{ $order->status }}</span>
                            </td>
                            <td class="fw-bold text-success">${{ number_format($order->total, 2) }}</td>
                            <td>
                                <a href="{{ route('warehouse-orders.edit', $order) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-truck"></i> Dispatch
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <i class="fas fa-box me-2 text-muted"></i> No orders ready for dispatch.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($ordersReadyForDispatch->hasPages())
            <div class="card-footer">
                {{ $ordersReadyForDispatch->links() }}
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
