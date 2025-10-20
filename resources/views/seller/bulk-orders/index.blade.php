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
            white-space: nowrap; /* Prevents buttons from wrapping */
        }
    </style>

@section('content')

    <div class="container-fluid py-4">
        
        <header class="mb-4 pb-3 border-bottom">
            <h1 class="fw-bolder mb-0 text-dark">Bulk Sales Orders</h1>
            <p class="text-muted mt-1">Track and manage all confirmed large volume orders placed by B2B customers.</p>
        </header>

        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="stat-card bg-primary-subtle border border-primary">
                    <div class="stat-label text-primary">Total Orders</div>
                    <div class="stat-value text-primary">25</div> {{-- Replace with actual count --}}
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-success-subtle border border-success">
                    <div class="stat-label text-success">Total Revenue (Est.)</div>
                    <div class="stat-value text-success">$15,450</div> {{-- Replace with actual sum --}}
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-warning-subtle border border-warning">
                    <div class="stat-label text-warning">Pending Shipments</div>
                    <div class="stat-value text-warning">8</div> {{-- Replace with actual count --}}
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-info-subtle border border-info">
                    <div class="stat-label text-info">Avg. Order Value</div>
                    <div class="stat-value text-info">$618</div> {{-- Replace with actual average --}}
                </div>
            </div>
        </div>
        
        <div class="card p-3 mb-4 shadow-sm">
            <form class="row g-3 align-items-center">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Search Order ID, Product Name, or Customer">
                </div>
                <div class="col-md-3">
                    <select class="form-select">
                        <option value="">Filter by Status</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select">
                        <option value="">Filter by Destination</option>
                        {{-- Populate dynamically based on $bulkOrders data --}}
                        <option value="CAN">Canada (CAN)</option>
                    </select>
                </div>
                <div class="col-md-2 text-end">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-1"></i> Apply Filters</button>
                </div>
            </form>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold py-3 border-bottom d-flex justify-content-between align-items-center">
                Orders List (Page {{ $bulkOrders['current_page'] }} of {{ $bulkOrders['last_page'] }})
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Product Details</th>
                            <th>Customer</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-end">Total Value</th>
                            <th>Status</th>
                            <th>Delivery By</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bulkOrders as $order)
                            <tr>
                                <td>
                                    <span class="fw-bold text-primary">#{{ $order['id'] }}</span>
                                    <div class="text-muted small">Inquiry #{{ $order['inquiry_id'] }}</div>
                                </td>
                                <td>
                                    <p class="fw-bold mb-0 text-dark">{{ Str::limit($order['product']['name'], 40) }}</p>
                                    <small class="text-muted">Unit Price: ${{ number_format($order['unit_price'], 2) }}</small>
                                </td>
                                <td>
                                    <p class="fw-bold mb-0">{{ $order['customer']['name'] }}</p>
                                    <small class="text-muted">{{ $order['customer']['email'] }}</small>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary-subtle text-secondary fs-6">{{ number_format($order['quantity']) }}</span>
                                </td>
                                <td class="text-end">
                                    <span class="fw-bold text-success fs-5">${{ number_format($order['total'], 2) }}</span>
                                </td>
                                <td>
                                    @php
                                        $badgeClass = [
                                            'pending' => 'warning',
                                            'processing' => 'info',
                                            'shipped' => 'primary',
                                            'delivered' => 'success',
                                            'cancelled' => 'danger'
                                        ][$order['status']] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $badgeClass }}">{{ ucfirst($order['status']) }}</span>
                                </td>
                                <td>
                                    <i class="fas fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($order['delivery_date'])->format('M d, Y') }}
                                    <div class="text-muted small mt-1">Dest: {{ $order['destination'] }}</div>
                                </td>
                                <td class="text-center">
                                    <div class="action-button-group">
                                        <a href="{{ route('seller.bulk-orders.show', $order['id']) }}" class="btn btn-sm btn-outline-info" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="" class="btn btn-sm btn-outline-warning" title="Update Status/Order">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-exclamation-circle me-2"></i> No bulk orders found matching your criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            

        </div>
    </div>

@endsection