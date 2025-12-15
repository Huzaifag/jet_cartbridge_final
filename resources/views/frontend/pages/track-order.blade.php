@extends('frontend.layout.main')
@section('content')
<style>
    /* === Amazon-Style Live Tracking UI === */
    .order-tracking-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .order-tracking-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }

    .order-header {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        padding: 1.25rem 1.5rem;
        font-weight: 600;
        color: #495057;
    }

    .order-id {
        font-size: 1.25rem;
        font-weight: 700;
        color: #212529;
    }

    .payment-badge {
        font-size: 0.85rem;
        padding: 0.35em 0.7em;
    }

    /* === Progress Bar === */
    .progress-bar-container {
        height: 6px;
        background-color: #e9ecef;
        border-radius: 3px;
        margin: 1rem 0;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #198754, #20c997);
        border-radius: 3px;
        transition: width 0.6s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    /* === Status Timeline (Horizontal on lg+, vertical on smaller) === */
    .timeline {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin-top: 1.5rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        top: 24px;
        left: 0;
        right: 0;
        height: 2px;
        background: #dee2e6;
        z-index: 0;
    }

    .timeline-item {
        text-align: center;
        position: relative;
        z-index: 1;
        flex: 1;
        min-width: 120px;
    }

    .status-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.75rem;
        font-size: 1.2rem;
        background: #f8f9fa;
        color: #6c757d;
        border: 2px solid #dee2e6;
        transition: all 0.3s;
    }

    .status-icon.completed {
        background: #e6f4ea;
        color: #198754;
        border-color: #198754;
    }

    .status-icon.in-progress {
        background: #fff8e6;
        color: #ffc107;
        border-color: #ffc107;
        animation: pulse 2s infinite;
    }

    .status-icon.upcoming {
        opacity: 0.6;
    }

    .status-label {
        font-weight: 600;
        font-size: 0.9rem;
        color: #495057;
    }

    .status-time {
        font-size: 0.75rem;
        color: #6c757d;
        margin-top: 0.25rem;
    }

    .status-completed .status-label,
    .status-completed .status-time {
        color: #198754;
    }

    .status-in-progress .status-label {
        color: #d97706;
    }

    /* Mobile timeline */
    @media (max-width: 768px) {
        .timeline {
            flex-direction: column;
            align-items: flex-start;
        }

        .timeline::before {
            top: 24px;
            left: 24px;
            bottom: 0;
            width: 2px;
            height: auto;
        }

        .timeline-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .status-icon {
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .timeline-item-content {
            text-align: left;
        }
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.4); }
        70% { box-shadow: 0 0 0 8px rgba(255, 193, 7, 0); }
        100% { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0); }
    }

    /* Order Summary */
    .order-summary {
        background-color: #f9fafb;
        border-radius: 10px;
        padding: 1.25rem;
    }

    .product-list {
        max-height: 180px;
        overflow-y: auto;
    }

    .product-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .product-item img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 4px;
        margin-right: 0.75rem;
        border: 1px solid #eee;
    }

    /* CTA Buttons */
    .order-actions .btn {
        font-weight: 500;
    }
</style>

<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold text-dark">
            <i class="fas fa-truck-loading text-primary me-2"></i> Live Order Tracking
        </h1>
        <p class="text-muted">Real-time updates — just like Amazon</p>
    </div>

    @if ($orders->count())
        @foreach ($orders as $order)
            @php
                // Estimate delivery: +5 days from order (adjust logic as needed)
                $expectedDelivery = $order->created_at->addDays(5);
                $isDelivered = $order->statuses->contains('stage', 'delivered') && 
                               $order->statuses->firstWhere('stage', 'delivered')?->status === 'completed';
            @endphp

            <div class="row justify-content-center mb-5">
                <div class="col-lg-11">
                    <div class="card order-tracking-card">
                        <!-- Header -->
                        <div class="order-header d-flex flex-wrap justify-content-between align-items-center">
                            <div>
                                <span class="text-muted me-2">Order placed</span>
                                <strong>{{ $order->created_at->format('M d, Y') }}</strong>
                                @if (!$isDelivered)
                                    <span class="ms-3 badge bg-info text-dark">
                                        <i class="fas fa-clock me-1"></i> Expected {{ $expectedDelivery->format('M d') }}
                                    </span>
                                @else
                                    <span class="ms-3 badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i> Delivered {{ $order->statuses->firstWhere('stage', 'delivered')?->completed_at?->format('M d') }}
                                    </span>
                                @endif
                            </div>
                            <div class="mt-2 mt-md-0">
                                <span class="order-id">Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                                @if ($order->payment_status === 'pending')
                                    <span class="payment-badge bg-warning text-dark ms-2">Payment Pending</span>
                                @else
                                    <span class="payment-badge bg-success ms-2">Paid</span>
                                @endif
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <div class="row g-4">
                                <!-- Left: Order Summary -->
                                <div class="col-lg-4 order-summary">
                                    <h6 class="fw-bold text-dark mb-3">
                                        <i class="fas fa-shopping-cart me-2 text-primary"></i>
                                        Order Summary
                                    </h6>

                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Order Total</span>
                                        <strong class="text-primary">${{ number_format($order->total, 2) }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Payment Method</span>
                                        <span>{{ strtoupper($order->payment_method) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span>Sold by</span>
                                        <span class="fw-medium">{{ $order->seller->company_name ?? 'N/A' }}</span>
                                    </div>

                                    <hr class="my-3">

                                    <h6 class="fw-bold text-dark mb-2">
                                        <i class="fas fa-box me-2 text-info"></i>
                                        {{ $order->products->count() }} Item{{ $order->products->count() !== 1 ? 's' : '' }}
                                    </h6>

                                    <div class="product-list">
                                        @foreach ($order->products as $product)
                                            <div class="product-item">
                                                <img src="{{ $product->image ?? asset('assets/img/placeholder.jpg') }}" alt="{{ $product->name }}">
                                                <div>
                                                    <div class="fw-medium">{{ Str::limit($product->name, 30) }}</div>
                                                    <small class="text-muted">${{ number_format($product->price, 2) }}</small>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Right: Live Tracking -->
                                <div class="col-lg-8">
                                    <div class="d-flex justify-content-between align-items-baseline mb-3">
                                        <h5 class="fw-bold text-dark mb-0">
                                            <i class="fas fa-map-pin text-success me-2"></i> Live Tracking
                                        </h5>
                                        @if ($order->tracking_number)
                                            <a href="https://tools.usps.com/go/TrackConfirmAction?tLabels={{ $order->tracking_number }}"
                                               target="_blank"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-truck me-1"></i> Track Package
                                            </a>
                                        @endif
                                    </div>

                                    <!-- Progress Bar -->
                                    @php
                                        $stages = ['pending', 'confirmed', 'shipped', 'out_for_delivery', 'delivered'];
                                        $currentStageIndex = -1;
                                        foreach ($stages as $i => $stage) {
                                            $status = $order->statuses->firstWhere('stage', $stage);
                                            if ($status && $status->status === 'completed') {
                                                $currentStageIndex = $i;
                                            } elseif ($status && $status->status === 'in_progress') {
                                                $currentStageIndex = $i - 0.5;
                                                break;
                                            }
                                        }
                                        $progress = $currentStageIndex >= 0 ? min(100, (($currentStageIndex + 1) / count($stages)) * 100) : 0;
                                    @endphp

                                    <div class="progress-bar-container">
                                        <div class="progress-bar-fill" style="width: {{ $progress }}%"></div>
                                    </div>
                                    <p class="text-center text-muted small mb-4">
                                        {{ $progress == 100 ? 'Delivered!' : 'In transit — real-time updates' }}
                                    </p>

                                    <!-- Timeline -->
                                    <div class="timeline">
                                        @foreach ([
                                            ['stage' => 'confirmed', 'label' => 'Order Confirmed', 'icon' => 'fa-check-circle'],
                                            ['stage' => 'shipped', 'label' => 'Shipped', 'icon' => 'fa-truck'],
                                            ['stage' => 'out_for_delivery', 'label' => 'Out for Delivery', 'icon' => 'fa-truck-ramp-box'],
                                            ['stage' => 'delivered', 'label' => 'Delivered', 'icon' => 'fa-box-open']
                                        ] as $item)
                                            @php
                                                $statusRecord = $order->statuses->firstWhere('stage', $item['stage']);
                                                $status = $statusRecord ? $statusRecord->status : 'pending';
                                                $isCompleted = $status === 'completed';
                                                $isInProgress = $status === 'in_progress';
                                                $cssClass = $isCompleted ? 'completed' : ($isInProgress ? 'in-progress' : 'upcoming');
                                                $time = $statusRecord?->completed_at ?? $statusRecord?->started_at ?? null;
                                                $timeStr = $time ? \Carbon\Carbon::parse($time)->format('M d, h:i A') : '—';
                                            @endphp

                                            <div class="timeline-item">
                                                <div class="status-icon {{ $cssClass }}">
                                                    <i class="fas {{ $item['icon'] }}"></i>
                                                </div>
                                                <div class="timeline-item-content">
                                                    <div class="status-label">
                                                        {{ $item['label'] }}
                                                        @if ($isInProgress)
                                                            <span class="badge bg-warning text-dark ms-1">Now</span>
                                                        @elseif ($isCompleted)
                                                            <i class="fas fa-check-circle text-success ms-1"></i>
                                                        @endif
                                                    </div>
                                                    <div class="status-time">{{ $timeStr }}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="card-footer bg-light p-3 text-end">
                            <div class="order-actions">
                                <a href="#" class="btn btn-outline-secondary btn-sm me-2">
                                    <i class="fas fa-file-invoice me-1"></i> Invoice
                                </a>
                                <a href="#" class="btn btn-outline-primary btn-sm me-2">
                                    <i class="fas fa-comment-dots me-1"></i> Message Seller
                                </a>
                                <a href="{{ route('order.details', $order->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-info-circle me-1"></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Pagination -->
        @if ($orders->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $orders->links() }}
            </div>
        @endif

    @else
        <div class="text-center py-5">
            <div class="display-1 text-muted mb-3">
                <i class="fas fa-box-open"></i>
            </div>
            <h4 class="text-muted">No orders yet</h4>
            <p class="text-muted mb-4">Your tracked orders will appear here once placed.</p>
            <a href="{{ route('shop') }}" class="btn btn-primary px-4 py-2">
                <i class="fas fa-shopping-cart me-2"></i> Continue Shopping
            </a>
        </div>
    @endif
</div>
@endsection