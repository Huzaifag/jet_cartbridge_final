
@extends('seller.layouts.app')

@section('content')
    <style>
        .contact-book-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 10px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .nav-tabs .nav-link {
            border: none;
            padding: 1rem 1.5rem;
            font-weight: 600;
            color: var(--dark);
            border-radius: 0;
        }
        
        .nav-tabs .nav-link.active {
            color: var(--primary);
            border-bottom: 3px solid var(--primary);
            background: transparent;
        }
        
        .contact-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            transition: transform 0.2s;
            margin-bottom: 1.5rem;
        }
        
        .contact-card:hover {
            transform: translateY(-5px);
        }
        
        .customer-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #fff;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .company-logo {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
            background: var(--light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--primary);
        }
        
        .stats-card {
            background: #fff;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
        }
        
        .stats-label {
            color: var(--dark);
            font-weight: 600;
        }
        
        .contact-action-btn {
            border-radius: 0.35rem;
            font-weight: 600;
            padding: 0.5rem 1rem;
        }
        
        .bulk-action-panel {
            background: #fff;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--primary);
        }
        
        .search-box {
            position: relative;
        }
        
        .search-box input {
            border-radius: 20px;
            padding-left: 40px;
        }
        
        .search-box i {
            position: absolute;
            left: 15px;
            top: 12px;
            color: #b7b9cc;
        }
        
        .filter-dropdown {
            margin-right: 10px;
        }
        
        .notification-modal .modal-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }
        
        .tag {
            display: inline-block;
            padding: 0.25rem 0.6rem;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
        }
        
        .tag-premium {
            background-color: rgba(246, 194, 62, 0.2);
            color: var(--warning);
        }
        
        .tag-new {
            background-color: rgba(28, 200, 138, 0.2);
            color: var(--success);
        }
        
        .tag-business {
            background-color: rgba(78, 115, 223, 0.2);
            color: var(--primary);
        }
    </style>
    <div class="container">
        <!-- Header -->
        <div class="contact-book-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h3 mb-1"><i class="fas fa-address-book me-2"></i> Seller Contact Book</h1>
                    <p class="mb-0">Manage your customer and company contacts for marketing and communication</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <button class="btn btn-light contact-action-btn">
                        <i class="fas fa-download me-1"></i> Export Contacts
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="row">
            <div class="col-xl-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-number">128</div>
                    <div class="stats-label">Total Contacts</div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-number">94</div>
                    <div class="stats-label">Customers</div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-number">34</div>
                    <div class="stats-label">Companies</div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-number">78%</div>
                    <div class="stats-label">Active Reach</div>
                </div>
            </div>
        </div>

        <!-- Bulk Action Panel -->
        <div class="bulk-action-panel">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0"><i class="fas fa-bullhorn me-2 text-primary"></i> Bulk Notification</h5>
                    <p class="mb-0 text-muted">Send promotions, new products, or offers to selected contacts</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <button class="btn btn-primary contact-action-btn" data-bs-toggle="modal" data-bs-target="#notificationModal">
                        <i class="fas fa-paper-plane me-1"></i> Send Notification
                    </button>
                </div>
            </div>
        </div>

        <!-- Tabs and Controls -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="customers-tab" data-bs-toggle="tab" data-bs-target="#customers" type="button" role="tab">
                        <i class="fas fa-users me-1"></i> Customers
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="companies-tab" data-bs-toggle="tab" data-bs-target="#companies" type="button" role="tab">
                        <i class="fas fa-building me-1"></i> Companies
                    </button>
                </li>
            </ul>
            
            <div class="d-flex">
                <div class="filter-dropdown">
                    <select class="form-select">
                        <option>All Contacts</option>
                        <option>Recent</option>
                        <option>Premium</option>
                        <option>Inactive</option>
                    </select>
                </div>
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" class="form-control" placeholder="Search contacts...">
                </div>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="tab-content" id="myTabContent">
            <!-- Customers Tab -->
            <div class="tab-pane fade show active" id="customers" role="tabpanel">
                <div class="row">
                    <!-- Customer Card -->
                    <div class="col-xl-4 col-md-6">
                        <div class="contact-card card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <img src="https://via.placeholder.com/200x200.png/0055bb?text=Customer1" alt="Customer" class="customer-avatar">
                                    <div>
                                        <span class="tag tag-premium">Premium</span>
                                        <span class="tag tag-new">New</span>
                                    </div>
                                </div>
                                <h5 class="card-title">Marisa Boyer MD</h5>
                                <p class="card-text text-muted">dejuan67@example.net</p>
                                <div class="mb-3">
                                    <small class="text-muted"><i class="fas fa-shopping-bag me-1"></i> 5 orders</small>
                                    <small class="text-muted ms-3"><i class="fas fa-dollar-sign me-1"></i> $3,301.00 spent</small>
                                </div>
                                <p class="card-text">Quam quos quibusdam reprehenderit quis autem voluptatem dolorem.</p>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-outline-primary btn-sm contact-action-btn">
                                        <i class="fas fa-envelope me-1"></i> Message
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm contact-action-btn">
                                        <i class="fas fa-eye me-1"></i> View
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Customer Card -->
                    <div class="col-xl-4 col-md-6">
                        <div class="contact-card card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <img src="https://via.placeholder.com/200x200.png/0044ff?text=Customer2" alt="Customer" class="customer-avatar">
                                    <div>
                                        <span class="tag tag-premium">Premium</span>
                                    </div>
                                </div>
                                <h5 class="card-title">John Smith</h5>
                                <p class="card-text text-muted">john.smith@example.com</p>
                                <div class="mb-3">
                                    <small class="text-muted"><i class="fas fa-shopping-bag me-1"></i> 12 orders</small>
                                    <small class="text-muted ms-3"><i class="fas fa-dollar-sign me-1"></i> $8,450.00 spent</small>
                                </div>
                                <p class="card-text">Regular customer with high satisfaction rate. Prefers email communication.</p>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-outline-primary btn-sm contact-action-btn">
                                        <i class="fas fa-envelope me-1"></i> Message
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm contact-action-btn">
                                        <i class="fas fa-eye me-1"></i> View
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Customer Card -->
                    <div class="col-xl-4 col-md-6">
                        <div class="contact-card card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <img src="https://via.placeholder.com/200x200.png/0066ff?text=Customer3" alt="Customer" class="customer-avatar">
                                    <div>
                                        <span class="tag tag-new">New</span>
                                    </div>
                                </div>
                                <h5 class="card-title">Sarah Johnson</h5>
                                <p class="card-text text-muted">sarahj@example.net</p>
                                <div class="mb-3">
                                    <small class="text-muted"><i class="fas fa-shopping-bag me-1"></i> 2 orders</small>
                                    <small class="text-muted ms-3"><i class="fas fa-dollar-sign me-1"></i> $520.00 spent</small>
                                </div>
                                <p class="card-text">Interested in new product lines. Responds well to discounts.</p>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-outline-primary btn-sm contact-action-btn">
                                        <i class="fas fa-envelope me-1"></i> Message
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm contact-action-btn">
                                        <i class="fas fa-eye me-1"></i> View
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    <button class="btn btn-outline-primary">
                        <i class="fas fa-plus me-2"></i> Load More Customers
                    </button>
                </div>
            </div>
            
            <!-- Companies Tab -->
            <div class="tab-pane fade" id="companies" role="tabpanel">
                <div class="row">
                    <!-- Company Card -->
                    <div class="col-xl-4 col-md-6">
                        <div class="contact-card card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="company-logo">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <div>
                                        <span class="tag tag-business">Partner</span>
                                    </div>
                                </div>
                                <h5 class="card-title">FastShip Logistics</h5>
                                <p class="card-text text-muted">contact@fastship.example.com</p>
                                <div class="mb-3">
                                    <small class="text-muted"><i class="fas fa-phone me-1"></i> (555) 123-4567</small>
                                    <small class="text-muted ms-3"><i class="fas fa-map-marker-alt me-1"></i> New York, USA</small>
                                </div>
                                <p class="card-text">Logistics partner with 2-day shipping options. Reliable for bulk orders.</p>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-outline-primary btn-sm contact-action-btn">
                                        <i class="fas fa-envelope me-1"></i> Message
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm contact-action-btn">
                                        <i class="fas fa-eye me-1"></i> View
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Company Card -->
                    <div class="col-xl-4 col-md-6">
                        <div class="contact-card card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="company-logo">
                                        <i class="fas fa-warehouse"></i>
                                    </div>
                                    <div>
                                        <span class="tag tag-business">Supplier</span>
                                    </div>
                                </div>
                                <h5 class="card-title">Global Delivery Inc.</h5>
                                <p class="card-text text-muted">orders@globaldelivery.example.com</p>
                                <div class="mb-3">
                                    <small class="text-muted"><i class="fas fa-phone me-1"></i> (555) 987-6543</small>
                                    <small class="text-muted ms-3"><i class="fas fa-map-marker-alt me-1"></i> Chicago, USA</small>
                                </div>
                                <p class="card-text">International shipping specialist. Competitive rates for large volumes.</p>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-outline-primary btn-sm contact-action-btn">
                                        <i class="fas fa-envelope me-1"></i> Message
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm contact-action-btn">
                                        <i class="fas fa-eye me-1"></i> View
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Company Card -->
                    <div class="col-xl-4 col-md-6">
                        <div class="contact-card card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="company-logo">
                                        <i class="fas fa-shipping-fast"></i>
                                    </div>
                                    <div>
                                        <span class="tag tag-business">Carrier</span>
                                    </div>
                                </div>
                                <h5 class="card-title">QuickShip Partners</h5>
                                <p class="card-text text-muted">info@quickship.example.com</p>
                                <div class="mb-3">
                                    <small class="text-muted"><i class="fas fa-phone me-1"></i> (555) 456-7890</small>
                                    <small class="text-muted ms-3"><i class="fas fa-map-marker-alt me-1"></i> Los Angeles, USA</small>
                                </div>
                                <p class="card-text">Regional delivery experts. Best for West Coast destinations.</p>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-outline-primary btn-sm contact-action-btn">
                                        <i class="fas fa-envelope me-1"></i> Message
                                    </button>
                                    <button class="btn btn-outline-secondary btn-sm contact-action-btn">
                                        <i class="fas fa-eye me-1"></i> View
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    <button class="btn btn-outline-primary">
                        <i class="fas fa-plus me-2"></i> Load More Companies
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Modal -->
    <div class="modal fade notification-modal" id="notificationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-paper-plane me-2"></i> Send Bulk Notification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Recipients</label>
                        <select class="form-select">
                            <option>All Contacts</option>
                            <option>Customers Only</option>
                            <option>Companies Only</option>
                            <option>Selected Contacts</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notification Type</label>
                        <select class="form-select">
                            <option>New Product Announcement</option>
                            <option>Special Discount</option>
                            <option>Seasonal Offer</option>
                            <option>Shipping Update</option>
                            <option>Custom Message</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Subject</label>
                        <input type="text" class="form-control" placeholder="Enter message subject">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Message</label>
                        <textarea class="form-control" rows="5" placeholder="Type your message here..."></textarea>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="includePromo">
                        <label class="form-check-label" for="includePromo">
                            Include promotional code
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Send Notification</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Simple tab persistence
        document.addEventListener('DOMContentLoaded', function() {
            const triggerTabList = document.querySelectorAll('#myTab button');
            triggerTabList.forEach(triggerEl => {
                triggerEl.addEventListener('click', event => {
                    event.preventDefault();
                    const tab = new bootstrap.Tab(triggerEl);
                    tab.show();
                });
            });
        });
    </script>

@endsection

