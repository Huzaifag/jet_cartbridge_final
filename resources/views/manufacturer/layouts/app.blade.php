<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - Manufacturer Dashboard</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom CSS -->
    @include('seller.assets.css')
    @stack('styles')
</head>

<body>
    <!-- Overlay for Mobile -->
    <div class="overlay"></div>

    @include('manufacturer.component.sidebar')

    @include('manufacturer.component.navbar')

    <!-- Main Content -->
    <div class="main-content">
        <div class="content-wrapper animate-fadeIn">
            @yield('content')
        </div>
    </div>



    <!-- Order Tracking Modal -->
    <div class="modal fade" id="orderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order #ORD-2023-105 Tracking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-7">
                            <!-- Order Timeline -->
                            <div class="tracking-timeline">
                                <div class="timeline-progress">
                                    <div class="progress-bar" style="width: 60%;"></div>
                                </div>
                                <div class="timeline-steps">
                                    <div class="timeline-step step-completed">
                                        <div class="step-icon">
                                            <i class="fas fa-receipt"></i>
                                        </div>
                                        <div class="step-title">Order Placed</div>
                                        <div class="step-date">Oct 15, 2023</div>
                                    </div>
                                    <div class="timeline-step step-completed">
                                        <div class="step-icon">
                                            <i class="fas fa-calculator"></i>
                                        </div>
                                        <div class="step-title">With Accountant</div>
                                        <div class="step-date">Oct 16, 2023</div>
                                    </div>
                                    <div class="timeline-step step-completed">
                                        <div class="step-icon">
                                            <i class="fas fa-file-invoice"></i>
                                        </div>
                                        <div class="step-title">Invoice Stage</div>
                                        <div class="step-date">Oct 18, 2023</div>
                                    </div>
                                    <div class="timeline-step step-active">
                                        <div class="step-icon">
                                            <i class="fas fa-cogs"></i>
                                        </div>
                                        <div class="step-title">In Production</div>
                                        <div class="step-date">In progress</div>
                                    </div>
                                    <div class="timeline-step">
                                        <div class="step-icon">
                                            <i class="fas fa-truck"></i>
                                        </div>
                                        <div class="step-title">Delivery</div>
                                        <div class="step-date">Pending</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Delivery Information -->
                            <div class="delivery-info">
                                <h6><i class="fas fa-truck me-2"></i>Delivery Information</h6>
                                <p class="mb-1">Estimated Delivery: <strong>Nov 5, 2023</strong></p>
                                <p class="mb-0">Carrier: <strong>GlobalExpress Logistics</strong></p>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <!-- Order Summary -->
                            <div class="order-details">
                                <h6 class="mb-3">Order Summary</h6>
                                <div class="detail-row">
                                    <span class="detail-label">Order ID:</span>
                                    <span class="detail-value">#ORD-2023-105</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">Order Date:</span>
                                    <span class="detail-value">Oct 15, 2023</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">Status:</span>
                                    <span class="detail-value"><span class="order-status status-production">In
                                            Production</span></span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">Seller:</span>
                                    <span class="detail-value">AudioTech Manufacturers</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">Items:</span>
                                    <span class="detail-value">2</span>
                                </div>
                                <div class="detail-row">
                                    <span class="detail-label">Total Amount:</span>
                                    <span class="detail-value">$897.50</span>
                                </div>
                            </div>

                            <!-- Support Information -->
                            <div class="mt-3">
                                <h6>Need Help?</h6>
                                <p class="small">Contact our support team for assistance with your order.</p>
                                <button class="btn btn-outline-primary w-100">
                                    <i class="fas fa-headset me-1"></i> Contact Support
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="{{ asset('js/jquery-3.7.1.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom JS -->
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Mobile sidebar toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('show');
            document.querySelector('.overlay').classList.toggle('show');
        });

        // Close sidebar when clicking overlay
        document.querySelector('.overlay').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.remove('show');
            this.classList.remove('show');
        });

        // Setup AJAX CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Add animation to cards on page load
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });

            // Filter button functionality
            document.querySelectorAll('.filter-btn').forEach(button => {
                button.addEventListener('click', function() {
                    document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove(
                        'active'));
                    this.classList.add('active');
                    // Here you would typically reload data based on the selected range
                });
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
