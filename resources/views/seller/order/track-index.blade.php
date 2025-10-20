@extends('seller.layouts.app')

@section('content')
    <style>
        :root {
            --primary: #3a77ff;
            --secondary: #ff6b01;
            --light-bg: #f8f9fa;
            --dark-text: #2d333a;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --gradient-primary: linear-gradient(135deg, #3a77ff 0%, #2a5dff 100%);
        }
        
        
        
        
        .tracking-container {
            max-width: 1200px;
            margin: 2rem auto;
        }
        
        .page-title {
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--dark-text);
        }
        
        .card {
            background: #ffffff;
            border: none;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background: white;
            border-bottom: 1px solid #e9ecef;
            padding: 1rem 1.5rem;
            font-weight: 600;
            color: var(--dark-text);
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .order-card {
            border-left: 4px solid var(--primary);
            transition: all 0.3s;
            margin-bottom: 1rem;
        }
        
        .order-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .order-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-accountant {
            background-color: #e8f4ff;
            color: #0d6efd;
        }
        
        .status-invoice {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-production {
            background-color: #d1e7dd;
            color: #0f5132;
        }
        
        .status-delivery {
            background-color: #d63384;
            color: white;
        }
        
        .status-delivered {
            background-color: #198754;
            color: white;
        }
        
        .order-amount {
            font-weight: 600;
            font-size: 1.2rem;
            color: var(--dark-text);
        }
        
        .order-date {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .seller-info {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }
        
        .seller-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }
        
        .filter-section {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            margin-bottom: 1.5rem;
        }
        
        .stats-card {
            text-align: center;
            padding: 1.5rem;
            border-radius: 12px;
            background: white;
            box-shadow: var(--card-shadow);
            margin-bottom: 1.5rem;
        }
        
        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
        }
        
        .stats-label {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .tracking-timeline {
            margin: 2rem 0;
            position: relative;
        }
        
        .timeline-progress {
            height: 6px;
            background: #e9ecef;
            border-radius: 3px;
            margin: 20px 0;
            position: relative;
        }
        
        .progress-bar {
            height: 100%;
            border-radius: 3px;
            background: var(--primary);
            transition: width 0.5s ease;
        }
        
        .timeline-steps {
            display: flex;
            justify-content: space-between;
            position: relative;
        }
        
        .timeline-step {
            text-align: center;
            position: relative;
            width: 20%;
        }
        
        .step-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: white;
            border: 3px solid #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            position: relative;
            z-index: 2;
        }
        
        .step-active .step-icon {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }
        
        .step-completed .step-icon {
            background: #198754;
            color: white;
            border-color: #198754;
        }
        
        .step-title {
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        
        .step-date {
            font-size: 0.8rem;
            color: #6c757d;
        }
        
        .btn-view {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            color: var(--dark-text);
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.9rem;
        }
        
        .btn-view:hover {
            background: #e9ecef;
        }
        
        .order-details {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            margin-top: 1.5rem;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }
        
        .detail-row:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            color: #6c757d;
        }
        
        .detail-value {
            font-weight: 500;
        }
        
        .table-items {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table-items th {
            background: #f8f9fa;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #495057;
        }
        
        .table-items td {
            padding: 12px;
            border-bottom: 1px solid #e9ecef;
        }
        
        .delivery-info {
            background: #e7f5ff;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
        }
        
        @media (max-width: 768px) {
            .seller-info {
                margin-bottom: 1rem;
            }
            
            .order-actions {
                margin-top: 1rem;
            }
            
            .timeline-steps {
                flex-wrap: wrap;
            }
            
            .timeline-step {
                width: 50%;
                margin-bottom: 1rem;
            }
        }
    </style>

    <!-- Main Content -->
    <div class="container tracking-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title">Order Tracking</h1>
            <button class="btn btn-primary">
                <i class="fas fa-download me-1"></i> Export Orders
            </button>
        </div>
        
        <!-- Stats Overview -->
        <div class="row mb-4">
            <div class="col-md-2 mb-3">
                <div class="stats-card">
                    <div class="stats-number">8</div>
                    <div class="stats-label">Total Orders</div>
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <div class="stats-card">
                    <div class="stats-number">2</div>
                    <div class="stats-label">In Accounting</div>
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <div class="stats-card">
                    <div class="stats-number">3</div>
                    <div class="stats-label">In Production</div>
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <div class="stats-card">
                    <div class="stats-number">2</div>
                    <div class="stats-label">Out for Delivery</div>
                </div>
            </div>
            <div class="col-md-2 mb-3">
                <div class="stats-card">
                    <div class="stats-number">1</div>
                    <div class="stats-label">Delivered</div>
                </div>
            </div>
        </div>
        
        <!-- Filters -->
        <div class="filter-section">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Status</label>
                    <select class="form-select">
                        <option value="">All Statuses</option>
                        <option value="accountant">With Accountant</option>
                        <option value="invoice">Invoice Stage</option>
                        <option value="production">In Production</option>
                        <option value="delivery">Assign for Delivery</option>
                        <option value="delivered">Delivered</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Date From</label>
                    <input type="date" class="form-control">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Date To</label>
                    <input type="date" class="form-control">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Seller</label>
                    <select class="form-select">
                        <option value="">All Sellers</option>
                        <option value="1">AudioTech Manufacturers</option>
                        <option value="2">TechGadgets Inc.</option>
                        <option value="3">HomeEssentials Ltd.</option>
                    </select>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <button class="btn btn-outline-secondary me-2">
                    <i class="fas fa-times me-1"></i> Reset
                </button>
                <button class="btn btn-primary">
                    <i class="fas fa-filter me-1"></i> Apply Filters
                </button>
            </div>
        </div>
        
        <!-- Orders List -->
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <span>Recent Orders</span>
                    <span class="text-muted">Showing 4 of 8 orders</span>
                </div>
            </div>
            <div class="card-body p-0">
                <!-- Order 1 - In Production -->
                <div class="card order-card m-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <div class="seller-info">
                                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" 
                                         alt="Seller" class="seller-avatar">
                                    <div>
                                        <div class="fw-bold">AudioTech Manufacturers</div>
                                        <div class="order-date">Order #ORD-2023-105</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="order-date">Placed: Oct 15, 2023</div>
                                <div class="order-date">Est. Delivery: Nov 5, 2023</div>
                            </div>
                            <div class="col-md-2">
                                <div class="order-amount">$897.50</div>
                            </div>
                            <div class="col-md-2">
                                <span class="order-status status-production">In Production</span>
                            </div>
                            <div class="col-md-3 order-actions text-end">
                                <button class="btn btn-view" data-bs-toggle="modal" data-bs-target="#orderModal">
                                    <i class="fas fa-eye me-1"></i> Track Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Order 2 - With Accountant -->
                <div class="card order-card m-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <div class="seller-info">
                                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" 
                                         alt="Seller" class="seller-avatar">
                                    <div>
                                        <div class="fw-bold">TechGadgets Inc.</div>
                                        <div class="order-date">Order #ORD-2023-106</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="order-date">Placed: Oct 18, 2023</div>
                                <div class="order-date">Est. Delivery: Nov 10, 2023</div>
                            </div>
                            <div class="col-md-2">
                                <div class="order-amount">$359.99</div>
                            </div>
                            <div class="col-md-2">
                                <span class="order-status status-accountant">With Accountant</span>
                            </div>
                            <div class="col-md-3 order-actions text-end">
                                <button class="btn btn-view" data-bs-toggle="modal" data-bs-target="#orderModal">
                                    <i class="fas fa-eye me-1"></i> Track Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Order 3 - Out for Delivery -->
                <div class="card order-card m-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <div class="seller-info">
                                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" 
                                         alt="Seller" class="seller-avatar">
                                    <div>
                                        <div class="fw-bold">HomeEssentials Ltd.</div>
                                        <div class="order-date">Order #ORD-2023-107</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="order-date">Placed: Oct 10, 2023</div>
                                <div class="order-date">Est. Delivery: Oct 25, 2023</div>
                            </div>
                            <div class="col-md-2">
                                <div class="order-amount">$49.98</div>
                            </div>
                            <div class="col-md-2">
                                <span class="order-status status-delivery">Out for Delivery</span>
                            </div>
                            <div class="col-md-3 order-actions text-end">
                                <button class="btn btn-view" data-bs-toggle="modal" data-bs-target="#orderModal">
                                    <i class="fas fa-eye me-1"></i> Track Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Order 4 - Delivered -->
                <div class="card order-card m-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <div class="seller-info">
                                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80" 
                                         alt="Seller" class="seller-avatar">
                                    <div>
                                        <div class="fw-bold">AutoParts Direct</div>
                                        <div class="order-date">Order #ORD-2023-104</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="order-date">Placed: Oct 5, 2023</div>
                                <div class="order-date">Delivered: Oct 20, 2023</div>
                            </div>
                            <div class="col-md-2">
                                <div class="order-amount">$1,150.00</div>
                            </div>
                            <div class="col-md-2">
                                <span class="order-status status-delivered">Delivered</span>
                            </div>
                            <div class="col-md-3 order-actions text-end">
                                <button class="btn btn-view" data-bs-toggle="modal" data-bs-target="#orderModal">
                                    <i class="fas fa-eye me-1"></i> View Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pagination -->
        <nav aria-label="Order pagination">
            <ul class="pagination justify-content-center mt-4">
                <li class="page-item disabled">
                    <a class="page-link" href="#">Previous</a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </div>
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
            
            // Filter functionality (simplified)
            $('.filter-section button').click(function() {
                alert('Filters applied!');
            });
        });
    </script>
@endsection
