<div class="top-bar bg-dark text-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <!-- Left Side: Ship To -->
            <div class="d-flex align-items-center py-2">
                <i class="bi bi-globe me-2"></i>
                <span class="d-none d-sm-inline me-1">Ship to:</span>
                <img src="https://placehold.co/20x15/f03a47/ffffff?text=US" alt="Country Flag" style="border-radius: 2px;">
            </div>

            <!-- Right Side: Links -->
            <div class="d-flex align-items-center">
                @if (auth()->check())
                    @switch(true)
                        @case(auth()->user()->hasRole('seller'))
                            <a href="{{ route('seller.dashboard') }}"
                                class="px-3 py-2 text-white-50 text-decoration-none d-none d-md-flex align-items-center hover-bg-secondary">
                                <i class="bi bi-briefcase me-1"></i>
                                <span>Seller Dashboard</span>
                            </a>
                        @break

                        @case(auth()->user()->hasRole('accountant'))
                            <a href="#"
                                class="px-3 py-2 text-white-50 text-decoration-none d-none d-md-flex align-items-center hover-bg-secondary">
                                <i class="bi bi-briefcase me-1"></i>
                                <span>Accountant Dashboard</span>
                            </a>
                        @break

                        @case(auth()->user()->hasRole('salesman'))
                            <a href="{{ route('salesman.dashboard.index') }}"
                                class="px-3 py-2 text-white-50 text-decoration-none d-none d-md-flex align-items-center hover-bg-secondary">
                                <i class="bi bi-briefcase me-1"></i>
                                <span>Salesman Dashboard</span>
                            </a>
                        @break

                        @case(auth()->user()->hasRole('warehouse'))
                            <a href="#"
                                class="px-3 py-2 text-white-50 text-decoration-none d-none d-md-flex align-items-center hover-bg-secondary">
                                <i class="bi bi-briefcase me-1"></i>
                                <span>Warehouse Dashboard</span>
                            </a>
                        @break

                        @case(auth()->user()->hasRole('deliveryman'))
                            <a href="#"
                                class="px-3 py-2 text-white-50 text-decoration-none d-none d-md-flex align-items-center hover-bg-secondary">
                                <i class="bi bi-briefcase me-1"></i>
                                <span>Deliveryman Dashboard</span>
                            </a>
                        @break

                        @default
                            <a href="/"
                                class="px-3 py-2 text-white-50 text-decoration-none d-none d-md-flex align-items-center hover-bg-secondary">
                                <i class="bi bi-briefcase me-1"></i>
                                <span>Home</span>
                            </a>
                        @break
                    @endswitch
                @endif

                @guest
                    <a href="{{ route('login') }}"
                        class="px-3 py-2 text-white-50 text-decoration-none d-none d-md-flex align-items-center border-start border-secondary">
                        <i class="bi bi-box-arrow-in-right me-1"></i>
                        <span>User Login</span>
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-3 py-2 text-white-50 text-decoration-none d-none d-md-flex align-items-center border-start border-secondary">
                        <i class="bi bi-box-arrow-in-right me-1"></i>
                        <span>Sign Up</span>
                    </a>
                @endguest

                <a href="#"
                    class="ps-3 py-2 text-white-50 text-decoration-none d-flex align-items-center border-start border-secondary">
                    <i class="bi bi-question-circle"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Main Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center fs-4 fw-bold" href="#">
            <div class="logo-container">
                <img src="{{ asset('images/logo/logo.png') }}" alt="Site Logo">
            </div>
        </a>

        <!-- Mobile Menu Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
            aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="productsDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Products
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="productsDropdown">
                        <li><a class="dropdown-item" href="#">Category A</a></li>
                        <li><a class="dropdown-item" href="#">Category B</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">All Products</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="solutionsDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Solutions
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="solutionsDropdown">
                        <li><a class="dropdown-item" href="#">For Enterprise</a></li>
                        <li><a class="dropdown-item" href="#">For Small Business</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Resources</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About Us</a>
                </li>
            </ul>

            <!-- Right Icons -->
            <div class="d-flex align-items-center">
                <a href="#" class="icon-link"><i class="bi bi-search fs-5"></i></a>
                @if (auth()->check() && auth()->user()->role == 'b2c')
                    <a href="{{ route('cart') }}" class="icon-link position-relative cart-icon ms-2">
                        <i class="bi bi-cart fs-5"></i>
                        <span
                            class="position-absolute translate-middle p-1 bg-danger border border-light rounded-circle badge">{{ auth()->check() && auth()->user()->cart ? auth()->user()->cart->items->count() : 0 }}</span>
                    </a>
                    <a href="{{ route('track-order.form') }}" class="icon-link"><i class="bi bi-truck fs-5"></i></a>
                @endif
                <a href="#" class="icon-link d-none d-sm-inline-flex ms-2"><i
                        class="bi bi-receipt fs-5"></i></a>
                @if (auth()->check())
                    <div class="vr mx-2 d-none d-sm-block"></div>

                    <div class="dropdown">
                        <a href="#" class="icon-link" id="userDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle fs-5"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">My Account</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.contacts.index') }}">My Contacts</a>
                            </li>
                            <li><a class="dropdown-item" href="#">Order History</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">Logout</a></li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</nav>
</header>
