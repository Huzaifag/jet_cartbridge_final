@extends('frontend.layout.main')
@section('content')
<style>
    /* Custom Styles for Modern Look */
    .order-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s;
    }

    .order-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    }

    .order-header {
        background-color: #f8f9fa;
        /* Light background for header */
        border-bottom: 1px solid #eee;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    /* Tracking Timeline Styles */
    .tracking-timeline {
        list-style: none;
        padding: 0;
        margin: 0;
        position: relative;
    }

    .tracking-timeline:before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 10px;
        width: 2px;
        background-color: #dee2e6;
        /* Gray line */
    }

    .timeline-item {
        position: relative;
        padding-left: 30px;
        margin-bottom: 20px;
    }

    .timeline-item .status-icon {
        position: absolute;
        top: 0;
        left: 0;
        width: 20px;
        height: 20px;
        background-color: #fff;
        border-radius: 50%;
        border: 2px solid #dee2e6;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #dee2e6;
    }

    /* Completed Status */
    .timeline-item.completed .status-icon {
        border-color: #198754;
        /* Green */
        background-color: #198754;
        color: #fff;
    }

    /* In Progress Status */
    .timeline-item.in-progress .status-icon {
        border-color: #ffc107;
        /* Yellow */
        background-color: #ffc107;
        color: #fff;
    }

    .timeline-item.in-progress .status-icon i {
        /* Makes the pulse effect */
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.4);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(255, 193, 7, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(255, 193, 7, 0);
        }
    }
</style>


<div class="container py-5">
    <h1 class="mb-4 text-center">
        <i class="fas fa-shipping-fast me-2 text-primary"></i> Track Your Orders
    </h1>
    <hr class="mb-5">
    @if ($orders->count())
        @foreach ($orders as $order)
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">
                    <div class="card order-card mb-5">
                        <div class="card-header order-header p-3 d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-dark">
                                Order #{{ $order->id }}
                                @if ($order->payment_status === 'pending')
                                    <span class="badge bg-warning text-dark ms-2">Payment Pending</span>
                                @else
                                    <span class="badge bg-success ms-2">Paid</span>
                                @endif
                            </h5>
                            <span class="text-muted">
                                Placed on: {{ $order->created_at->format('M d, Y') }}
                            </span>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                {{-- Order Summary --}}
                                <div class="col-lg-4 mb-4 mb-lg-0 border-end">
                                    <h6 class="text-muted mb-3">Order Details</h6>
                                    <p class="mb-1">
                                        <i class="fas fa-wallet me-2 text-secondary"></i>
                                        <strong>Total:</strong>
                                        <span class="text-primary fw-bold">${{ number_format($order->total, 2) }}</span>
                                    </p>
                                    <p class="mb-1">
                                        <i class="fas fa-hand-holding-usd me-2 text-secondary"></i>
                                        <strong>Method:</strong> {{ strtoupper($order->payment_method) }}
                                    </p>
                                    <p class="mb-3">
                                        <i class="fas fa-store me-2 text-secondary"></i>
                                        <strong>Seller:</strong> {{ $order->seller->company_name ?? 'N/A' }}
                                    </p>

                                    <h6 class="text-muted mb-3">
                                        Items Purchased ({{ $order->products->count() }})
                                    </h6>
                                    <ul class="list-unstyled small">
                                        @foreach ($order->products as $product)
                                            <li>
                                                <i class="fas fa-tag me-1 text-info"></i>
                                                {{ $product->name }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                {{-- Tracking Timeline --}}
                                <div class="col-lg-8">
                                    <h5 class="text-dark mb-4">
                                        <i class="fas fa-map-marked-alt me-2"></i>Tracking Status
                                    </h5>
                                    <ul class="tracking-timeline">
                                        @foreach ($order->statuses as $status_item)
                                            @php
                                                $status_class = '';
                                                $status_icon = 'fa-circle';
                                                $status_text = ucwords(str_replace('_', ' ', $status_item->stage));
                                                $status_time = $status_item->started_at
                                                    ? \Carbon\Carbon::parse($status_item->started_at)->format(
                                                        'h:i A, M d',
                                                    )
                                                    : 'Awaiting action';

                                                if ($status_item->status === 'completed') {
                                                    $status_class = 'completed';
                                                    $status_icon = 'fa-check';
                                                    $status_time = \Carbon\Carbon::parse(
                                                        $status_item->completed_at,
                                                    )->format('h:i A, M d');
                                                } elseif ($status_item->status === 'in_progress') {
                                                    $status_class = 'in-progress';
                                                    $status_icon = 'fa-spinner fa-spin';
                                                }
                                            @endphp

                                            <li class="timeline-item {{ $status_class }}">
                                                <div class="status-icon">
                                                    <i class="fas {{ $status_icon }}"></i>
                                                </div>
                                                <div class="fw-bold">
                                                    {{ $status_text }}
                                                    @if ($status_item->status === 'in_progress')
                                                        <span class="badge bg-warning text-dark ms-2">In
                                                            Progress</span>
                                                    @elseif ($status_item->status === 'completed')
                                                        <span class="badge bg-success ms-2">Completed</span>
                                                    @else
                                                        <span class="badge bg-light text-muted ms-2">Pending</span>
                                                    @endif
                                                </div>
                                                <small class="text-muted">{{ $status_time }}</small>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end p-3 bg-light">
                            <a href="#" class="btn btn-outline-dark btn-sm me-2"><i
                                    class="fas fa-file-pdf me-1"></i> Download Invoice</a>
                            <a href="#" class="btn btn-primary btn-sm"><i class="fas fa-comment me-1"></i>
                                Contact
                                Seller</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-info text-center" role="alert">
            <i class="fas fa-box-open me-2"></i> No orders found.
        </div>
    @endif

</div>
@endsection
