<!-- Premium Top Bar -->
<div class="premium-top-bar">
    <div class="premium-container">
        <div class="d-flex justify-content-between align-items-center">
            <!-- Left Side: Ship To & Nearest Seller -->
            <div class="d-flex align-items-center py-2">
                <i class="fas fa-globe text-accent me-2"></i>
                <span class="d-none d-sm-inline me-2 text-dim">Ship to:</span>
                <img src="https://placehold.co/20x15/f03a47/ffffff?text=US" alt="Country Flag" class="rounded-1 me-3">
                <a href="#" id="nearestSellerBtn" class="nearest-seller-link" onclick="findNearestSellers()">
                    <i class="fas fa-map-marker-alt me-1"></i>
                    <span>Find Nearest Sellers</span>
                </a>
            </div>

            <!-- Right Side: Links -->
            <div class="d-flex align-items-center">
                @if (auth()->check())
                    @switch(true)
                        @case(auth()->user()->hasRole('seller'))
                            <a href="{{ route('seller.dashboard') }}" class="premium-top-link">
                                <i class="fas fa-briefcase me-1"></i>
                                <span>Seller Dashboard</span>
                            </a>
                        @break

                        @case(auth()->user()->hasRole('accountant'))
                            <a href="{{ route('accountant.dashboard.index') }}" class="premium-top-link">
                                <i class="fas fa-calculator me-1"></i>
                                <span>Accountant Dashboard</span>
                            </a>
                        @break

                        @case(auth()->user()->hasRole('salesman'))
                            <a href="{{ route('salesman.dashboard.index') }}" class="premium-top-link">
                                <i class="fas fa-chart-line me-1"></i>
                                <span>Salesman Dashboard</span>
                            </a>
                        @break

                        @case(auth()->user()->hasRole('warehouse'))
                            <a href="{{ route('warehouse.dashboard.index') }}" class="premium-top-link">
                                <i class="fas fa-warehouse me-1"></i>
                                <span>Warehouse Dashboard</span>
                            </a>
                        @break

                        @case(auth()->user()->hasRole('deliveryman'))
                            <a href="{{ route('deliveryman.dashboard') }}" class="premium-top-link">
                                <i class="fas fa-truck me-1"></i>
                                <span>Deliveryman Dashboard</span>
                            </a>
                        @break

                        @case(auth()->user()->hasRole('manufacturer'))
                            <a href="{{ route('manufacturer.dashboard') }}" class="premium-top-link">
                                <i class="fas fa-industry me-1"></i>
                                <span>Manufacturer Dashboard</span>
                            </a>
                        @break
                            <a href="{{ route('deliveryman.dashboard') }}" class="premium-top-link">
                                <i class="fas fa-truck me-1"></i>
                                <span>Deliveryman Dashboard</span>
                            </a>
                        @break

                        @default
                            <a href="/" class="premium-top-link">
                                <i class="fas fa-home me-1"></i>
                                <span>Home</span>
                            </a>
                        @break
                    @endswitch
                @endif

                @guest
                    <a href="{{ route('login') }}" class="premium-top-link">
                        <i class="fas fa-sign-in-alt me-1"></i>
                        <span>User Login</span>
                    </a>
                    <a href="{{ route('register') }}" class="premium-top-link">
                        <i class="fas fa-user-plus me-1"></i>
                        <span>Sign Up</span>
                    </a>
                    <a href="{{ route('seller.register') }}" class="premium-top-link premium-highlight">
                        <i class="fas fa-store me-1"></i>
                        <span>Join as Seller</span>
                    </a>
                    <a href="{{ route('manufacturer.register') }}" class="premium-top-link premium-highlight">
                        <i class="fas fa-industry me-1"></i>
                        <span>Join as Manufacturer</span>
                    </a>
                @endguest

                <a href="#" class="premium-top-link">
                    <i class="fas fa-question-circle"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Premium Main Navigation Bar -->
<nav class="premium-navbar fixed-top">
    <div class="premium-container">
        <!-- Premium Logo -->
        <a class="premium-nav-brand" href="{{ url('/') }}">
            <div class="logo-container">
                <img src="{{ asset('images/logo/logo.png') }}" alt="Site Logo" style="height: 40px;">
            </div>
            <!-- <span class="ms-2">Jet<span class="accent">Cartridge</span></span> -->
        </a>

        <!-- Mobile/Tablet Menu Toggler (Hidden on Desktop) -->
        <button class="navbar-toggler border-0 d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
            aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars text-white"></i>
        </button>

        <!-- Desktop Navigation (Always Visible on Large Screens) -->
        <div class="d-none d-lg-flex align-items-center mx-auto">
            <ul class="navbar-nav d-flex flex-row mb-0">
                <li class="nav-item">
                    <a class="premium-nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ url('/') }}">
                        <i class="fas fa-home me-1"></i>Home
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="premium-nav-link dropdown-toggle {{ request()->routeIs(['categories', 'sellers', 'manufacturers', 'resources']) ? 'active' : '' }}" 
                       href="#" id="browseDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-compass me-1"></i>Browse
                    </a>
                    <ul class="dropdown-menu premium-dropdown-menu" aria-labelledby="browseDropdown">
                        <li><a class="dropdown-item premium-dropdown-item" href="{{ route('categories') }}">
                            <i class="fas fa-th-large me-2"></i>Categories
                        </a></li>
                        <li><a class="dropdown-item premium-dropdown-item" href="{{ route('sellers') }}">
                            <i class="fas fa-store me-2"></i>Sellers
                        </a></li>
                        <li><a class="dropdown-item premium-dropdown-item" href="{{ route('manufacturers') }}">
                            <i class="fas fa-industry me-2"></i>Manufacturers
                        </a></li>
                        <li><hr class="dropdown-divider premium-dropdown-divider"></li>
                        <li><a class="dropdown-item premium-dropdown-item" href="{{ route('resources') }}">
                            <i class="fas fa-book me-2"></i>Resources
                        </a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="premium-nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                        <i class="fas fa-info-circle me-1"></i>About Us
                    </a>
                </li>
                <li class="nav-item">
                    <a class="premium-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                        <i class="fas fa-envelope me-1"></i>Contact
                    </a>
                </li>
                <li class="nav-item">
                    <a class="premium-nav-link {{ request()->routeIs('faq') ? 'active' : '' }}" href="{{ route('faq') }}">
                        <i class="fas fa-question-circle me-1"></i>FAQ
                    </a>
                </li>
            </ul>
        </div>

        <!-- Mobile/Tablet Collapsible Navigation -->
        <div class="collapse navbar-collapse d-lg-none" id="mainNavbar">
            <ul class="navbar-nav w-100 mb-2">
                <li class="nav-item">
                    <a class="premium-nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ url('/') }}">
                        <i class="fas fa-home me-2"></i>Home
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="premium-nav-link dropdown-toggle {{ request()->routeIs(['categories', 'sellers', 'manufacturers', 'resources']) ? 'active' : '' }}" 
                       href="#" id="browseMobileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-compass me-2"></i>Browse
                    </a>
                    <ul class="dropdown-menu premium-mobile-dropdown" aria-labelledby="browseMobileDropdown">
                        <li><a class="dropdown-item premium-dropdown-item" href="{{ route('categories') }}">
                            <i class="fas fa-th-large me-2"></i>Categories
                        </a></li>
                        <li><a class="dropdown-item premium-dropdown-item" href="{{ route('sellers') }}">
                            <i class="fas fa-store me-2"></i>Sellers
                        </a></li>
                        <li><a class="dropdown-item premium-dropdown-item" href="{{ route('manufacturers') }}">
                            <i class="fas fa-industry me-2"></i>Manufacturers
                        </a></li>
                        <li><hr class="dropdown-divider premium-dropdown-divider"></li>
                        <li><a class="dropdown-item premium-dropdown-item" href="{{ route('resources') }}">
                            <i class="fas fa-book me-2"></i>Resources
                        </a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="premium-nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                        <i class="fas fa-info-circle me-2"></i>About Us
                    </a>
                </li>
                <li class="nav-item">
                    <a class="premium-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">
                        <i class="fas fa-envelope me-2"></i>Contact
                    </a>
                </li>
                <li class="nav-item">
                    <a class="premium-nav-link {{ request()->routeIs('faq') ? 'active' : '' }}" href="{{ route('faq') }}">
                        <i class="fas fa-question-circle me-2"></i>FAQ
                    </a>
                </li>
            </ul>
        </div>

        <!-- Premium Right Icons (Always Visible) -->
        <div class="d-flex align-items-center">
            <!-- Theme Toggle Button -->
            <div class="theme-toggle-container">
                <button class="theme-toggle-btn" id="themeToggleBtn" aria-label="Toggle theme" title="Toggle between light and dark theme (Ctrl+Shift+T)">
                    <div class="theme-toggle-track">
                        <div class="theme-toggle-thumb">
                            <i class="theme-icon-sun fas fa-sun"></i>
                            <i class="theme-icon-moon fas fa-moon"></i>
                        </div>
                    </div>
                </button>
            </div>
            
            <!-- Search Bar Inside Navbar -->
            <div class="hero-search-inline ms-3 navbar-search-container" id="navbarSearchContainer" style="max-width: 280px; min-width: 180px; width: 100%; opacity: 0; transform: translateY(-10px); transition: all 0.3s ease;" data-animation="fadeInUp" data-delay="300">
                <form method="GET" action="{{ route('home') }}">
                    <div class="hero-search-wrapper" style="width: 100%;">
                        <i class="fas fa-search hero-search-icon"></i>
                        <input type="text" name="search" class="hero-search-input" style="color: #222; background: #fff; border-radius: 20px; font-size: 0.95rem; height: 36px; padding-left: 36px; width: 100%;"
                               placeholder="Search products..."
                               value="{{ request('search') }}">
                        <button type="submit" class="hero-search-btn" style="height: 36px; border-radius: 20px 20px 20px 20px; font-size: 0.95rem; padding: 0 16px;">
                            search
                        </button>
                    </div>
                </form>
            </div>
            @if (auth()->check() && auth()->user()->role == 'b2c')
                <a href="{{ route('cart') }}" class="premium-icon-link position-relative ms-3">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="premium-badge position-absolute">
                        {{ auth()->check() && auth()->user()->cart ? auth()->user()->cart->items->count() : 0 }}
                    </span>
                </a>
                <a href="{{ route('track-order.form') }}" class="premium-icon-link ms-3">
                    <i class="fas fa-truck"></i>
                </a>
            @endif
            <a href="#" class="premium-icon-link d-none d-sm-inline-flex ms-3">
                <i class="fas fa-receipt"></i>
            </a>
            @if (auth()->check())
                <div class="premium-divider mx-3 d-none d-sm-block"></div>

                <div class="dropdown">
                    <a href="#" class="premium-icon-link dropdown-toggle" id="userDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="true">
                        <i class="fas fa-user-circle"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end premium-user-dropdown" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item premium-dropdown-item" href="{{ route('user.profile') }}">
                            <i class="fas fa-user me-2"></i>My Account
                        </a></li>
                        <li><a class="dropdown-item premium-dropdown-item" href="{{ route('contributor.dashboard') }}">
                            <i class="fas fa-chart-bar me-2"></i>Contributor Dashboard
                        </a></li>
                        <li><a class="dropdown-item premium-dropdown-item" href="{{ route('user.contacts.index') }}">
                            <i class="fas fa-address-book me-2"></i>My Contacts
                        </a></li>
                        <li><a class="dropdown-item premium-dropdown-item" href="#">
                            <i class="fas fa-history me-2"></i>Order History
                        </a></li>
                        <li><a class="dropdown-item premium-dropdown-item" href="#">
                            <i class="fas fa-cog me-2"></i>Settings
                        </a></li>
                        <li><hr class="dropdown-divider premium-dropdown-divider"></li>
                        <li><a class="dropdown-item premium-dropdown-item text-danger" href="{{ route('logout') }}">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a></li>
                    </ul>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn-premium-compact btn-premium-compact-secondary ms-3">
                    <i class="fas fa-sign-in-alt"></i>Login
                </a>
            @endif
        </div>
    </div>
</nav>
