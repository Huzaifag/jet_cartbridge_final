@extends('seller.layouts.app')
    <style>
        /* Card for stats */
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

        /* Table Styling */
        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e9ecef;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }

        .action-button-group {
            white-space: nowrap;
            /* Prevents buttons from wrapping */
        }
    </style>

@section('content')
    <div class="container-fluid py-4">

        <header class="mb-4 pb-3 border-bottom">
            <h1 class="fw-bolder mb-0 text-dark">Customer Orders (B2C)</h1>
            <p class="text-muted mt-1">Track and manage all confirmed orders placed by B2C customers.</p>
        </header>

        <div class="row g-4 mb-5">
            @php
                // If you calculated totals in controller, use them directly (recommended).
                // But if not, do it here safely:

                $totalOrders = $orders->total(); // total across all pages
                $totalRevenue = $orders->sum('total'); // sum of orders on current page only
                $pendingCount = $orders->where('payment_status', 'pending')->count();
            @endphp

            <div class="col-md-3">
                <div class="stat-card bg-primary-subtle border border-primary">
                    <div class="stat-label text-primary">Total Orders</div>
                    <div class="stat-value text-primary">{{ $totalOrders }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-success-subtle border border-success">
                    <div class="stat-label text-success">Total Revenue (Est.)</div>
                    <div class="stat-value text-success">${{ number_format($totalRevenue, 2) }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-warning-subtle border border-warning">
                    <div class="stat-label text-warning">Pending Payment</div>
                    <div class="stat-value text-warning">{{ $pendingCount }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-info-subtle border border-info">
                    <div class="stat-label text-info">Avg. Order Value</div>
                    <div class="stat-value text-info">
                        ${{ $totalOrders > 0 ? number_format($totalRevenue / $totalOrders, 2) : '0.00' }}
                    </div>
                </div>
            </div>
        </div>


        <div class="card p-3 mb-4 shadow-sm">
            <form method="GET" class="row g-3 align-items-center">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search Order ID or Customer ID"
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="payment_status" class="form-select">
                        <option value="">Filter by Payment Status</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending
                        </option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="payment_method" class="form-select">
                        <option value="">Filter by Method</option>
                        <option value="cod" {{ request('payment_method') == 'cod' ? 'selected' : '' }}>Cash on Delivery
                            (COD)</option>
                        <option value="card" {{ request('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                    </select>
                </div>
                <div class="col-md-2 text-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-1"></i> Apply Filters
                    </button>
                </div>
            </form>

        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold py-3 border-bottom d-flex justify-content-between align-items-center">
                Orders List (Page {{ $orders['current_page'] }} of {{ $orders['last_page'] }})
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer ID</th>
                            <th>Order Date</th>
                            <th class="text-end">Total Value</th>
                            <th>Payment Method</th>
                            <th>Payment Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>
                                    <span class="fw-bold text-primary">#ORD{{ $order['id'] }}</span>
                                </td>
                                <td>
                                    <p class="fw-bold mb-0">Customer #{{ $order['customer_id'] }}</p>
                                    {{-- NOTE: To display name/email, the 'customer' relation MUST be loaded in the controller. --}}
                                    {{-- <small class="text-muted">{{ $order['customer']['name'] ?? 'N/A' }}</small> --}}
                                </td>
                                <td>
                                    <i class="far fa-calendar-alt me-1 text-muted"></i>
                                    {{ \Carbon\Carbon::parse($order['created_at'])->format('M d, Y') }}
                                    <div class="text-muted small">
                                        {{ \Carbon\Carbon::parse($order['created_at'])->format('h:i A') }}</div>
                                </td>
                                <td class="text-end">
                                    <span class="fw-bold text-success fs-5">${{ number_format($order->total, 2) }}</span>
                                </td>
                                <td>
                                    <span
                                        class="badge bg-secondary-subtle text-secondary">{{ strtoupper($order['payment_method']) }}</span>
                                </td>
                                <td>
                                    @php
                                        $badgeClass =
                                            [
                                                'pending' => 'warning',
                                                'paid' => 'success',
                                                'failed' => 'danger',
                                                'cod' => 'info',
                                            ][$order['payment_status']] ?? 'secondary';
                                    @endphp
                                    <span
                                        class="badge bg-{{ $badgeClass }}">{{ ucfirst($order['payment_status']) }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="action-button-group">
                                        <a href="{{ route('seller.orders.show', $order) }}"
                                            class="btn btn-sm btn-outline-info" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#"
                                            class="btn btn-sm btn-outline-success" title="Generate Invoice">
                                            <i class="fas fa-file-invoice-dollar"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-exclamation-circle me-2"></i> No B2C orders found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div>
                {{ $orders->links() }}
            </div>

        </div>
    </div>
@endsection
