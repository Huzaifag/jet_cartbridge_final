@extends('seller.layouts.app')


<style>
    .detail-card {
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        margin-bottom: 25px;
    }

    .summary-box {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
    }

    .summary-total-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #28a745;
    }

    .product-image-thumb {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .status-badge {
        font-size: 1rem;
        padding: 8px 12px;
        border-radius: 8px;
        font-weight: 600;
    }

    .detail-item strong {
        display: inline-block;
        min-width: 140px;
        /* Aligns key details nicely */
        color: #495057;
    }
</style>


@section('content')
    @php
        // Accessing the passed bulkOrder array data
        $order = $bulkOrder->toArray();
        $product = $order['product'];
        $customer = $order['customer'];
        $inquiry = $order['inquiry'];

        $statusClass =
            [
                'pending' => 'warning',
                'processing' => 'info',
                'shipped' => 'primary',
                'delivered' => 'success',
                'cancelled' => 'danger',
            ][$order['status']] ?? 'secondary';
    @endphp

    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
            <h1 class="fw-bolder mb-0 text-dark">Bulk Order: <span class="text-primary">#BULK-ORD{{ $order['id'] }}</span>
            </h1>
            <span class="badge bg-{{ $statusClass }} status-badge">
                <i class="fas fa-box me-2"></i> {{ ucfirst($order['status']) }}
            </span>
        </div>

        <div class="row g-4">

            <div class="col-lg-8">

                <div class="card detail-card">
                    <div class="card-header bg-white fw-bold py-3 border-bottom">
                        <i class="fas fa-cubes me-2 text-info"></i> Product & Quantity
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('storage/' . ($product['images'][0] ?? 'default.png')) }}"
                                alt="{{ $product['name'] }}" class="product-image-thumb me-4">
                            <div>
                                <h4 class="mb-1 fw-bold">{{ $product['name'] }}</h4>
                                <p class="mb-0 text-muted">SKU: {{ $product['id'] }} | Brand: {{ $product['brand'] }}</p>
                            </div>
                        </div>

                        <hr class="my-3">

                        <div class="row">
                            <div class="col-md-4 detail-item">
                                <strong>Quantity:</strong> <span
                                    class="fw-bold fs-5 text-primary">{{ number_format($order['quantity']) }}</span> units
                            </div>
                            <div class="col-md-4 detail-item">
                                <strong>Unit Price:</strong> <span
                                    class="fw-bold text-success">${{ number_format($order['unit_price'], 2) }}</span>
                            </div>
                            <div class="col-md-4 detail-item">
                                <strong>B2B MOQ:</strong> {{ $product['b2b_moq'] }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card detail-card">
                    <div class="card-header bg-white fw-bold py-3 border-bottom">
                        <i class="fas fa-truck-loading me-2 text-warning"></i> Logistics & Payment Terms
                    </div>
                    <div class="card-body row g-3">
                        <div class="col-md-6 detail-item">
                            <strong>Destination:</strong> <span class="fw-bold">{{ $order['destination'] }}</span>
                        </div>
                        <div class="col-md-6 detail-item">
                            <strong>Delivery Deadline:</strong> <span
                                class="fw-bold">{{ \Carbon\Carbon::parse($order['delivery_date'])->format('M d, Y') }}</span>
                        </div>
                        <div class="col-md-6 detail-item">
                            <strong>Payment Terms:</strong> <span
                                class="fw-bold text-primary">{{ $order['payment_terms'] }}</span>
                        </div>
                        <div class="col-md-6 detail-item">
                            <strong>Shipping Cost:</strong> <span
                                class="fw-bold">${{ number_format($order['shipping_cost'], 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="card detail-card">
                    <div class="card-header bg-white fw-bold py-3 border-bottom">
                        <i class="fas fa-sticky-note me-2 text-secondary"></i> Order Notes & Inquiry
                    </div>
                    <div class="card-body">
                        <h6 class="fw-bold text-muted mb-2">Internal Order Notes</h6>
                        <p class="alert alert-light p-3 small mb-3">
                            {{ $order['order_notes'] ?: 'No specific notes recorded for this order.' }}</p>

                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                            <div class="detail-item">
                                <strong>Original Inquiry:</strong> <span class="text-muted">#{{ $order['inquiry_id'] }}
                                    (Requested on
                                    {{ \Carbon\Carbon::parse($inquiry['created_at'])->format('M d, Y') }})</span>
                            </div>
                            <a href=""
                                class="btn btn-sm btn-outline-primary">
                                View Inquiry <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-lg-4">

                <div class="card detail-card sticky-top" style="top: 20px;">
                    <div class="card-body summary-box">
                        <h4 class="fw-bold mb-3 text-primary"><i class="fas fa-calculator me-2"></i> Financial Summary</h4>

                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Subtotal ({{ $order['quantity'] }} x
                                ${{ $order['unit_price'] }})</span>
                            <span class="fw-bold">${{ number_format($order['quantity'] * $order['unit_price'], 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Shipping & Handling</span>
                            <span class="fw-bold">${{ number_format($order['shipping_cost'], 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between pt-3">
                            <span class="fw-bold fs-6">GRAND TOTAL (USD)</span>
                            <span class="summary-total-value">${{ number_format($order['total'], 2) }}</span>
                        </div>
                    </div>

                    <div class="card-body border-top">
                        <h5 class="fw-bold mb-3"><i class="fas fa-user-circle me-2 text-dark"></i> Customer</h5>
                        <p class="mb-0 fw-bold">{{ $customer['name'] }}</p>
                        <small class="text-muted d-block">{{ $customer['email'] }}</small>
                        <small class="text-muted d-block mt-2">Account Role: {{ strtoupper($customer['role']) }}</small>
                    </div>

                    <div class="card-footer bg-white d-grid gap-2">
                        <a href="" class="btn btn-warning btn">
                            <i class="fas fa-pen-square me-2"></i> Update Order Status
                        </a>
                        <button type="button" class="btn btn-outline-danger"
                            onclick="confirmCancelOrder({{ $order['id'] }})">
                            <i class="fas fa-times-circle me-2"></i> Cancel Order
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection


<script>
    function confirmCancelOrder(orderId) {
        if (confirm('Are you sure you want to cancel Bulk Order #' + orderId + '? This action cannot be undone.')) {
            // Implement AJAX or form submission here to send cancellation request
            alert('Order ' + orderId + ' cancellation submitted.');
        }
    }
</script>
