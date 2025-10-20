@extends('seller.layouts.app')

@section('styles')
    <style>
        .inquiry-card {
            border-radius: 14px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #e9ecef;
            overflow: hidden;
        }

        .inquiry-card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        }

        .card-header {
            border-bottom: 1px solid #f1f3f5;
            padding: 1rem 1.25rem;
        }

        .card-header h5 {
            font-weight: 600;
            color: #212529;
        }

        .product-thumb {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        .info-label {
            font-size: 0.8rem;
            color: #6c757d;
            text-transform: uppercase;
            font-weight: 500;
            margin-bottom: 2px;
        }

        .info-value {
            font-weight: 600;
            color: #212529;
        }

        .detail-box {
            background: #f8f9fa;
            border-radius: 6px;
            padding: 0.75rem;
            font-size: 0.9rem;
        }

        .detail-box small {
            display: block;
            color: #6c757d;
        }

        .card-footer {
            background: #f9fafb;
            border-top: 1px solid #f1f3f5;
            padding: 0.75rem 1.25rem;
        }

        .btn-action {
            border-radius: 8px;
            font-size: 0.9rem;
        }
    </style>
@endsection

@section('content')

    <div class="container-fluid py-4">
        <h2 class="fw-bold mb-2" style="color: var(--primary-color);">Bulk Inquiries</h2>
        <p class="text-muted mb-4">Review and respond to bulk purchase requests from customers.</p>

        @if ($inquiries->isEmpty())
            <div class="alert alert-info text-center shadow-sm">
                <i class="fas fa-search me-2"></i>No new bulk inquiries found.
            </div>
        @else
            <div class="row g-4">
                @foreach ($inquiries as $inquiry)
                    <div class="col-lg-12">
                        <div class="card inquiry-card">
                            <!-- HEADER -->
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5><i class="fas fa-clipboard-list me-2 text-primary"></i> Inquiry #{{ $inquiry['id'] }}
                                </h5>
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ \Carbon\Carbon::parse($inquiry['created_at'])->format('M d, Y h:i A') }}
                                </span>
                            </div>

                            <!-- BODY -->
                            <div class="card-body">
                                <div class="row g-4">
                                    <!-- PRODUCT -->
                                    <div class="col-md-4 border-end">
                                        <h6 class="info-label mb-2">Product Details</h6>
                                        <div class="row g-2 align-items-center">
                                            <div class="col-4">
                                                @php
                                                    $firstImage = $inquiry['product']['images'][0] ?? 'default.png';
                                                @endphp
                                                <img src="{{ asset('storage/' . $firstImage) }}"
                                                    class="img-fluid rounded product-thumb"
                                                    alt="{{ $inquiry['product']['name'] }}">
                                            </div>
                                            <div class="col-8">
                                                <div class="info-value">{{ $inquiry['product']['name'] }}</div>
                                                <small class="text-muted d-block">
                                                    B2B Price: ${{ number_format($inquiry['product']['b2b_price'], 2) }}
                                                </small>
                                            </div>
                                        </div>

                                        <hr class="my-3">

                                        <div class="row text-center">
                                            <div class="col-6">
                                                <div class="info-label">Quantity</div>
                                                <div class="info-value text-success">
                                                    {{ number_format($inquiry['quantity']) }}</div>
                                            </div>
                                            <div class="col-6">
                                                <div class="info-label">Target Price</div>
                                                <div class="info-value">
                                                    ${{ number_format($inquiry['target_price'] ?? 0, 2) }}</div>
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <div class="info-label">Required By</div>
                                            <div class="info-value">
                                                @if ($inquiry['deadline'])
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    {{ \Carbon\Carbon::parse($inquiry['deadline'])->format('F d, Y') }}
                                                @else
                                                    N/A
                                                @endif
                                            </div>
                                        </div>
                                    </div>


                                    <!-- CUSTOMER -->
                                    <div class="col-md-4 border-end">
                                        <h6 class="info-label mb-2">Customer & Contact</h6>
                                        <div class="mb-3">
                                            <div class="info-value">{{ $inquiry['customer']['name'] }}
                                                ({{ $inquiry['customer']['role'] }})
                                            </div>
                                            <small>{{ $inquiry['customer']['email'] }}</small>
                                        </div>
                                        <div class="detail-box">
                                            <div class="info-label">Contact</div>
                                            <div class="fw-semibold"><i
                                                    class="fas fa-user-tie me-1"></i>{{ $inquiry['contact']['name'] }}
                                            </div>
                                            <small><i
                                                    class="fas fa-envelope me-1"></i>{{ $inquiry['contact']['email'] }}</small>
                                            <small><i
                                                    class="fas fa-phone me-1"></i>{{ $inquiry['contact']['mobile'] }}</small>
                                            <small><i
                                                    class="fas fa-map-marker-alt me-1"></i>{{ $inquiry['contact']['city'] }},
                                                {{ $inquiry['contact']['state'] }}</small>
                                        </div>
                                    </div>

                                    <!-- MESSAGE -->
                                    <div class="col-md-4">
                                        <h6 class="info-label mb-2">Requirements</h6>
                                        <div class="mb-3">
                                            <div class="info-label">Destination</div>
                                            <div class="info-value"><i
                                                    class="fas fa-globe me-1"></i>{{ $inquiry['destination'] }}</div>
                                        </div>
                                        <div class="info-label">Message</div>
                                        <div class="detail-box">
                                            {{ Str::limit($inquiry['message'], 120) }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- FOOTER -->
                            <div class="card-footer d-flex justify-content-end gap-2">
                                <a href="{{ route('seller.inquiries.response.create', $inquiry['id']) }}"
                                    class="btn btn-success btn-action">
                                    <i class="fas fa-file-invoice-dollar me-1"></i> Quote
                                </a>
                                <a href="#" class="btn btn-outline-primary btn-action">
                                    <i class="fas fa-comments me-1"></i> Chat
                                </a>
                                <a href="{{ route('seller.inquiries.bulk-order.create', $inquiry['id']) }}"
                                    class="btn btn-outline-secondary btn-action">
                                    <i class="fas fa-box-open me-2"></i> Generate Bulk Order
                                </a>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

@endsection

@section('scripts')
    <script>
        function markAsProcessed(inquiryId) {
            if (confirm('Mark Inquiry #' + inquiryId + ' as processed?')) {
                console.log('Marked ' + inquiryId);
                // AJAX call here
            }
        }
    </script>
@endsection
