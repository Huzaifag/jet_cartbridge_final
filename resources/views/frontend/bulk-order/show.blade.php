@extends('frontend.layout.main')

@section('title', 'Bulk Order Details - ' . $bulkOrder->order_number)

@push('styles')
<style>
.order-details-container {
    min-height: 100vh;
    background: #f8f9fa;
    padding: 2rem 0;
}

.order-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 15px;
    margin-bottom: 2rem;
}

.order-status-timeline {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.timeline {
    position: relative;
    padding-left: 2rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 2rem;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -22px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #e9ecef;
}

.timeline-item.active::before {
    background: #007bff;
}

.timeline-item.completed::before {
    background: #28a745;
}

.order-info-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.seller-card {
    background: white;
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.seller-info {
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
}

.seller-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    margin-right: 1.5rem;
    object-fit: cover;
}

.items-table {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.table th {
    background: #f8f9fa;
    border: none;
    font-weight: 600;
    color: #2c3e50;
}

.product-info {
    display: flex;
    align-items: center;
}

.product-image {
    width: 50px;
    height: 50px;
    border-radius: 8px;
    margin-right: 1rem;
    object-fit: cover;
}

.total-summary {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1.5rem;
    margin-top: 2rem;
}

.total-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
}

.total-row.final {
    font-size: 1.25rem;
    font-weight: bold;
    color: #007bff;
    border-top: 2px solid #dee2e6;
    padding-top: 1rem;
    margin-top: 1rem;
}

.back-btn {
    background: #6c757d;
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    text-decoration: none;
    display: inline-block;
    margin-bottom: 2rem;
    transition: all 0.3s ease;
}

.back-btn:hover {
    background: #5a6268;
    color: white;
    text-decoration: none;
}

@media (max-width: 768px) {
    .seller-info {
        flex-direction: column;
        text-align: center;
    }
    
    .seller-avatar {
        margin-right: 0;
        margin-bottom: 1rem;
    }
    
    .product-info {
        flex-direction: column;
        text-align: center;
    }
    
    .product-image {
        margin-right: 0;
        margin-bottom: 0.5rem;
    }
}
</style>
@endpush

@section('content')
<div class="order-details-container">
    <div class="container">
        <a href="/bulk-order/my-orders" class="back-btn">
            <i class="fas fa-arrow-left me-2"></i>Back to My Orders
        </a>

        <!-- Order Header -->
        <div class="order-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="fas fa-receipt me-2"></i>{{ $bulkOrder->order_number }}</h1>
                    <p class="mb-0">Placed on {{ $bulkOrder->created_at->format('M d, Y \a\t H:i') }}</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <span class="badge bg-{{ $bulkOrder->status_color }}-subtle text-{{ $bulkOrder->status_color }} fs-6 px-3 py-2">
                        {{ $bulkOrder->formatted_status }}
                    </span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Order Status Timeline -->
                <div class="order-status-timeline">
                    <h5><i class="fas fa-clock me-2"></i>Order Status</h5>
                    <div class="timeline">
                        <div class="timeline-item {{ $bulkOrder->status === 'pending' ? 'active' : 'completed' }}">
                            <h6>Order Placed</h6>
                            <p class="text-muted mb-0">{{ $bulkOrder->created_at->format('M d, Y \a\t H:i') }}</p>
                        </div>
                        <div class="timeline-item {{ in_array($bulkOrder->status, ['accepted', 'processing', 'shipped', 'delivered']) ? 'completed' : ($bulkOrder->status === 'rejected' ? 'active' : '') }}">
                            <h6>{{ $bulkOrder->status === 'rejected' ? 'Order Rejected' : 'Order Accepted' }}</h6>
                            <p class="text-muted mb-0">
                                @if($bulkOrder->seller_response_date)
                                    {{ $bulkOrder->seller_response_date->format('M d, Y \a\t H:i') }}
                                @else
                                    Waiting for seller response
                                @endif
                            </p>
                        </div>
                        @if($bulkOrder->status !== 'rejected')
                            <div class="timeline-item {{ in_array($bulkOrder->status, ['processing', 'shipped', 'delivered']) ? 'completed' : ($bulkOrder->status === 'processing' ? 'active' : '') }}">
                                <h6>Processing</h6>
                                <p class="text-muted mb-0">Order is being prepared</p>
                            </div>
                            <div class="timeline-item {{ in_array($bulkOrder->status, ['shipped', 'delivered']) ? 'completed' : ($bulkOrder->status === 'shipped' ? 'active' : '') }}">
                                <h6>Shipped</h6>
                                <p class="text-muted mb-0">Order is on the way</p>
                            </div>
                            <div class="timeline-item {{ $bulkOrder->status === 'delivered' ? 'completed' : '' }}">
                                <h6>Delivered</h6>
                                <p class="text-muted mb-0">Order has been delivered</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Seller Information -->
                <div class="seller-card">
                    <h5><i class="fas fa-store me-2"></i>Seller Information</h5>
                    <div class="seller-info">
                        <img src="{{ $bulkOrder->seller->user->avatar ? asset('storage/' . $bulkOrder->seller->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($bulkOrder->seller->user->name ?? $bulkOrder->seller->company_name) . '&background=007bff&color=ffffff&size=80' }}" 
                             alt="{{ $bulkOrder->seller->user->name ?? $bulkOrder->seller->company_name }}" class="seller-avatar">
                        <div>
                            <h6>{{ $bulkOrder->seller->user->name ?? 'Seller' }}</h6>
                            <p class="text-muted mb-1">{{ $bulkOrder->seller->company_name ?? 'Company' }}</p>
                            <p class="text-muted mb-0">
                                <i class="fas fa-envelope me-1"></i>{{ $bulkOrder->seller->user->email ?? 'No email' }}
                            </p>
                        </div>
                    </div>
                    
                    @if($bulkOrder->seller_response)
                        <div class="alert alert-info">
                            <h6><i class="fas fa-comment me-2"></i>Seller Response:</h6>
                            <p class="mb-0">{{ $bulkOrder->seller_response }}</p>
                        </div>
                    @endif
                </div>

                <!-- Order Items -->
                <div class="items-table">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bulkOrder->items as $item)
                                    <tr>
                                        <td>
                                            <div class="product-info">
                                                <img src="{{ $item->product->images && count($item->product->images) > 0 ? asset('storage/' . $item->product->images[0]) : '/images/placeholder-product.jpg' }}" 
                                                     alt="{{ $item->product->name }}" class="product-image">
                                                <div>
                                                    <h6 class="mb-1">{{ $item->product->name }}</h6>
                                                    <small class="text-muted">{{ Str::limit($item->product->description, 50) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary-subtle text-primary">{{ $item->quantity }}</span>
                                        </td>
                                        <td>{{ $item->formatted_unit_price }}</td>
                                        <td><strong>{{ $item->formatted_total_price }}</strong></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Order Summary -->
                <div class="order-info-card">
                    <h5><i class="fas fa-calculator me-2"></i>Order Summary</h5>
                    <div class="total-summary">
                        <div class="total-row">
                            <span>Items:</span>
                            <span>{{ $bulkOrder->total_items }}</span>
                        </div>
                        <div class="total-row">
                            <span>Subtotal:</span>
                            <span>${{ number_format($bulkOrder->total_amount, 2) }}</span>
                        </div>
                        <div class="total-row final">
                            <span>Total Amount:</span>
                            <span>${{ number_format($bulkOrder->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Delivery Information -->
                <div class="order-info-card">
                    <h5><i class="fas fa-truck me-2"></i>Delivery Information</h5>
                    <div class="mb-3">
                        <strong>Address:</strong>
                        <p class="text-muted mb-0">{{ $bulkOrder->delivery_address }}</p>
                    </div>
                    @if($bulkOrder->delivery_date)
                        <div class="mb-3">
                            <strong>Requested Date:</strong>
                            <p class="text-muted mb-0">{{ $bulkOrder->delivery_date->format('M d, Y') }}</p>
                        </div>
                    @endif
                    @if($bulkOrder->notes)
                        <div>
                            <strong>Special Instructions:</strong>
                            <p class="text-muted mb-0">{{ $bulkOrder->notes }}</p>
                        </div>
                    @endif
                </div>

                <!-- Actions -->
                <div class="order-info-card">
                    <h5><i class="fas fa-cog me-2"></i>Actions</h5>
                    <div class="d-grid gap-2">
                        @if($bulkOrder->status === 'pending')
                            <button class="btn btn-outline-danger" onclick="cancelOrder()">
                                <i class="fas fa-times me-2"></i>Cancel Order
                            </button>
                        @endif
                        <button class="btn btn-outline-primary" onclick="contactSeller()">
                            <i class="fas fa-envelope me-2"></i>Contact Seller
                        </button>
                        <button class="btn btn-outline-secondary" onclick="downloadInvoice()">
                            <i class="fas fa-download me-2"></i>Download Invoice
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function cancelOrder() {
    if (confirm('Are you sure you want to cancel this order? This action cannot be undone.')) {
        // Implementation for canceling order
        alert('Order cancellation request sent to seller.');
    }
}

function contactSeller() {
    // Implementation for contacting seller
    alert('Opening chat with seller...');
}

function downloadInvoice() {
    // Implementation for downloading invoice
    alert('Downloading invoice...');
}
</script>
@endpush