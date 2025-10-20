<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" id="sidebarToggle">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Search Bar -->
        <div class="navbar-search me-auto d-none d-lg-block">
            <div class="input-group">
                <span class="input-group-text bg-transparent border-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
                <input type="text" class="form-control border-0 shadow-none bg-light rounded-pill"
                    placeholder="Search..." style="min-width: 300px;">
            </div>
        </div>

        <div class="d-flex align-items-center ms-auto">
            <!-- Notification Dropdown -->
            <div class="dropdown me-3">
                <a class="nav-link position-relative" href="#" role="button" id="notificationDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-bell fa-lg text-muted"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        5
                        <span class="visually-hidden">unread notifications</span>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow notification-dropdown"
                    aria-labelledby="notificationDropdown">
                    <li class="dropdown-header">
                        <h6 class="mb-0">Notifications</h6>
                        <span class="badge bg-primary rounded-pill">5 New</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <div class="flex-shrink-0">
                                <div class="avatar bg-success text-white rounded-circle">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-bold">New Order Received</div>
                                <div class="small text-muted">Order #ORD-2589 for $125.00</div>
                                <div class="text-muted small">2 minutes ago</div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <div class="flex-shrink-0">
                                <div class="avatar bg-info text-white rounded-circle">
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-bold">New 5-Star Review</div>
                                <div class="small text-muted">From customer John D.</div>
                                <div class="text-muted small">1 hour ago</div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <div class="flex-shrink-0">
                                <div class="avatar bg-warning text-white rounded-circle">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-bold">Low Stock Alert</div>
                                <div class="small text-muted">Special Pizza is running low</div>
                                <div class="text-muted small">3 hours ago</div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class="dropdown-footer text-center">
                        <a href="#" class="text-primary">View All Notifications</a>
                    </li>
                </ul>
            </div>

            <!-- Messages Dropdown -->
            <div class="dropdown me-3">
                <a class="nav-link position-relative" href="#" role="button" id="messagesDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-comments fa-lg text-muted"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                        3
                        <span class="visually-hidden">unread messages</span>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow message-dropdown" aria-labelledby="messagesDropdown">
                    <li class="dropdown-header">
                        <h6 class="mb-0">Messages</h6>
                        <span class="badge bg-primary rounded-pill">3 Unread</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <div class="flex-shrink-0">
                                <img src="https://ui-avatars.com/api/?name=Customer+One&background=random"
                                    class="rounded-circle" width="40" height="40" alt="Customer One">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-bold">Customer One</div>
                                <div class="small text-truncate">Hi, when will my order be delivered?</div>
                                <div class="text-muted small">30 minutes ago</div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <div class="flex-shrink-0">
                                <img src="https://ui-avatars.com/api/?name=Customer+Two&background=random"
                                    class="rounded-circle" width="40" height="40" alt="Customer Two">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-bold">Customer Two</div>
                                <div class="small text-truncate">I have a special request for my order</div>
                                <div class="text-muted small">2 hours ago</div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <div class="flex-shrink-0">
                                <img src="https://ui-avatars.com/api/?name=Customer+Three&background=random"
                                    class="rounded-circle" width="40" height="40" alt="Customer Three">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="fw-bold">Customer Three</div>
                                <div class="small text-truncate">Thank you for the great service!</div>
                                <div class="text-muted small">5 hours ago</div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class="dropdown-footer text-center">
                        <a href="#" class="text-primary">View All Messages</a>
                    </li>
                </ul>
            </div>

            <!-- Quick Actions Dropdown -->
            <div class="dropdown me-3 d-none d-md-block">
                <a class="nav-link" href="#" role="button" id="quickActionsDropdown"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-bolt fa-lg text-muted"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="quickActionsDropdown">
                    <li class="dropdown-header">
                        <h6 class="mb-0">Quick Actions</h6>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    {{-- <li>
                        <a class="dropdown-item" href="{{ route('seller.orders.create') }}">
                            <i class="fas fa-plus-circle text-success me-2"></i>Create New Order
                        </a>
                    </li> --}}
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-box text-info me-2"></i>Add New Product
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-chart-line text-warning me-2"></i>View Dashboard
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-cog text-secondary me-2"></i>Settings
                        </a>
                    </li>
                </ul>
            </div>

            <!-- User Dropdown -->
            <div class="user-dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="avatar bg-primary text-white rounded-circle me-2">

                        {{ collect(explode(' ', Auth::user()->seller->company_name))->map(fn($w) => strtoupper(Str::substr($w, 0, 1)))->implode('') }}
                    </div>
                    <div class="d-none d-md-block">
                        <div class="fw-bold">{{ Auth::user()->seller->company_name }}</div>
                        <div class="small text-muted">Seller Account</div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                    <li class="dropdown-header">
                        <h6 class="mb-0">{{ Auth::user()->seller->company_name }}</h6>
                        <small class="text-muted">Seller Account</small>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-user me-2"></i>Profile
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-cog me-2"></i>Settings
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-question-circle me-2"></i>Help & Support
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form action="{{ route('seller.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<style>
    /* Navbar Styles */
    .navbar {
        background-color: #ffffff;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        padding: 0.8rem 1.5rem;
        transition: all 0.3s ease;
        z-index: 999;
        margin-left: 280px;
    }

    .navbar-search .form-control:focus {
        box-shadow: none;
        background-color: #f8f9fa;
    }

    .navbar .nav-link {
        color: #6c757d;
        padding: 0.5rem 0.75rem;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
    }

    .navbar .nav-link:hover {
        color: #495057;
        background-color: #f8f9fa;
    }

    .dropdown-menu {
        border: none;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
        border-radius: 0.75rem;
        padding: 0.5rem;
        min-width: 280px;
    }

    .notification-dropdown,
    .message-dropdown {
        min-width: 350px;
    }

    .dropdown-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem 1rem;
        background-color: #f8f9fa;
        border-radius: 0.5rem 0.5rem 0 0;
    }

    .dropdown-item {
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
        margin-bottom: 0.25rem;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
    }

    .dropdown-divider {
        margin: 0.5rem 0;
    }

    .dropdown-footer {
        padding: 0.5rem;
    }

    .avatar {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }

    .badge {
        font-size: 0.7rem;
        padding: 0.35em 0.65em;
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
        .navbar {
            margin-left: 0;
        }

        .navbar-search {
            display: none !important;
        }

        .dropdown-menu {
            position: fixed;
            top: 60px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 400px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mark notifications as read when dropdown is opened
        document.getElementById('notificationDropdown').addEventListener('shown.bs.dropdown', function() {
            // In a real application, you would make an API call to mark notifications as read
            const badge = this.querySelector('.badge');
            if (badge) {
                badge.style.display = 'none';
            }
        });

        // Mark messages as read when dropdown is opened
        document.getElementById('messagesDropdown').addEventListener('shown.bs.dropdown', function() {
            // In a real application, you would make an API call to mark messages as read
            const badge = this.querySelector('.badge');
            if (badge) {
                badge.style.display = 'none';
            }
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
