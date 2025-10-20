@extends('seller.layouts.app')

    <style>
        .detail-card {
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }
        .status-timeline {
            position: relative;
            padding-left: 25px;
        }
        .status-timeline::before {
            content: '';
            position: absolute;
            left: 5px;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: #dee2e6;
        }
        .timeline-item {
            position: relative;
            padding-bottom: 20px;
        }
        .timeline-marker {
            position: relative;
            left: -10px;
            top: 0;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid #fff;
            background-color: #adb5bd; /* Default/Pending */
            z-index: 1;
        }
        .timeline-item.completed .timeline-marker {
            background-color: #28a745; /* Green for completed */
        }
        .timeline-item.in_progress .timeline-marker {
            background-color: #007bff; /* Blue for in progress */
        }
        .item-image-thumb {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
        }
    </style>

@section('content')

    @php
        // Accessing the passed order array data
        $order = $order->toArray(); 
        $customer = $order['customer'];
        $seller = $order['seller'];
        $orderItems = $order['order_items'];
        $products = $order['products'];
        $statuses = $order['statuses'];

        // Helper function to map product details to order items
        $getProductDetails = function($productId, $products) {
            foreach ($products as $product) {
                if ($product['id'] == $productId) {
                    return $product;
                }
            }
            return null;
        };

        // Get the current order status based on 'in_progress' or 'completed' stages
        $currentStatus = collect($statuses)->filter(function($s) {
            return $s['status'] === 'in_progress' || $s['status'] === 'completed';
        })->pluck('stage')->last() ?? 'Unknown';

    @endphp

    <div class="container-fluid py-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
            <h1 class="fw-bolder mb-0 text-dark">Order Details: <span class="text-primary">#ORD{{ $order['id'] }}</span></h1>
            <div>
                <a href="#" class="btn btn-success me-2">
                    <i class="fas fa-file-invoice-dollar me-2"></i> Generate Invoice
                </a>
                <a href="#" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i> Update Order
                </a>
            </div>
        </div>

        <div class="row g-4">
            
            <div class="col-lg-8">
                
                <div class="card detail-card">
                    <div class="card-header bg-white fw-bold py-3 border-bottom">
                        <i class="fas fa-boxes me-2 text-info"></i> Order Items ({{ count($orderItems) }})
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($orderItems as $item)
                            @php $product = $getProductDetails($item['product_id'], $products); @endphp
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('storage/' . ($product['images'][0] ?? 'default.png')) }}" alt="Product Image" class="item-image-thumb me-3">
                                    <div>
                                        <p class="mb-0 fw-bold">{{ $product['name'] ?? 'Product Deleted' }}</p>
                                        <small class="text-muted">Qty: {{ $item['quantity'] }} x ${{ number_format($item['price'], 2) }}</small>
                                    </div>
                                </div>
                                <span class="fw-bold text-dark">${{ number_format($item['quantity'] * $item['price'], 2) }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="card detail-card">
                    <div class="card-header bg-white fw-bold py-3 border-bottom">
                        <i class="fas fa-map-marker-alt me-2 text-warning"></i> Addresses
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="fw-bold text-muted mb-2">Shipping Address</h6>
                                <p class="mb-0">{{ $order['shipping_address'] ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold text-muted mb-2">Billing Address</h6>
                                <p class="mb-0">{{ $order['billing_address'] ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card detail-card">
                    <div class="card-header bg-white fw-bold py-3 border-bottom">
                        <i class="fas fa-sticky-note me-2 text-secondary"></i> Internal Notes
                    </div>
                    <div class="card-body bg-light rounded-bottom">
                        <p class="mb-0 text-muted small">{{ $order['notes'] ?: 'No internal notes recorded for this order.' }}</p>
                    </div>
                </div>

            </div>

            <div class="col-lg-4">
                
                <div class="card detail-card">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3"><i class="fas fa-user-circle me-2 text-primary"></i> Customer Information</h5>
                        <p class="mb-0 fw-bold">{{ $customer['name'] }}</p>
                        <small class="text-muted d-block mb-3">{{ $customer['email'] }}</small>

                        <hr>
                        
                        <h5 class="fw-bold mb-3"><i class="fas fa-money-bill-wave me-2 text-success"></i> Payment Summary</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Order Total</span>
                            <span class="fw-bold">${{ number_format($order['total'], 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Payment Status</span>
                            <span class="badge bg-{{ $order['payment_status'] == 'pending' ? 'warning' : 'success' }}">
                                {{ ucfirst($order['payment_status']) }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Payment Method</span>
                            <span class="fw-bold text-muted">{{ strtoupper($order['payment_method']) }}</span>
                        </div>
                        <div class="d-flex justify-content-between border-top pt-2 mt-2">
                            <span class="fs-4 fw-bold">Grand Total</span>
                            <span class="fs-4 fw-bold text-success">${{ number_format($order['total'], 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="card detail-card">
                    <div class="card-header bg-white fw-bold py-3 border-bottom">
                        <i class="fas fa-sync-alt me-2 text-secondary"></i> Order Process Timeline
                        <span class="float-end badge bg-info">{{ ucfirst(str_replace('_', ' ', $currentStatus)) }}</span>
                    </div>
                    <div class="card-body status-timeline">
                        @foreach ($statuses as $status)
                            @php
                                $isCompleted = $status['status'] === 'completed';
                                $isInProgress = $status['status'] === 'in_progress';
                                $timelineClass = $isCompleted ? 'completed' : ($isInProgress ? 'in_progress' : '');
                            @endphp
                            <div class="timeline-item {{ $timelineClass }}">
                                <span class="timeline-marker"></span>
                                <p class="mb-0 fw-bold text-capitalize">{{ str_replace('_', ' ', $status['stage']) }}</p>
                                <small class="text-muted">
                                    @if ($isCompleted)
                                        <i class="fas fa-check-circle text-success me-1"></i> Completed: {{ \Carbon\Carbon::parse($status['completed_at'])->format('M d, Y') }}
                                    @elseif ($isInProgress)
                                        <i class="fas fa-spinner fa-spin text-primary me-1"></i> Currently in Progress
                                    @else
                                        <i class="far fa-clock me-1"></i> Pending
                                    @endif
                                </small>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection