<!-- Sidebar -->
<nav class="sidebar" style="overflow-y: auto; max-height: 100vh;">
    <div class="sidebar-header">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid">
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{ route('seller.dashboard') }}"
                class="nav-link {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('seller.products.index') }}"
                class="nav-link {{ request()->routeIs('seller.products.index') ? 'active' : '' }}">
                <i class="fas fa-box"></i>
                Products
            </a>
        </li>

        <!-- Employees Dropdown -->
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                href="#employeesMenu" role="button" aria-expanded="false" aria-controls="employeesMenu">
                <span><i class="fas fa-users"></i> Employees</span>
                <i class="fas fa-chevron-down small"></i>
            </a>
            <div class="collapse {{ request()->is('*employees*') ? 'show' : '' }}" id="employeesMenu">
                <ul class="nav flex-column ms-3">
                    <li class="nav-item">
                        <a href="{{ route('seller.employees.accountant.index') }}"
                            class="nav-link {{ request()->routeIs('seller.employees.accountant.*') ? 'active' : '' }}">
                            <i class="fas fa-calculator"></i> Accountant
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('seller.employees.salesman.index') }}"
                            class="nav-link {{ request()->routeIs('seller.employees.salesman.*') ? 'active' : '' }}">
                            <i class="fas fa-handshake"></i> Salesman
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('seller.employees.warehouse.index') }}"
                            class="nav-link {{ request()->routeIs('seller.employees.warehouse.*') ? 'active' : '' }}">
                            <i class="fas fa-warehouse"></i> Warehouse
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('seller.employees.delivery.index') }}"
                            class="nav-link {{ request()->routeIs('seller.employees.delivery.*') ? 'active' : '' }}">
                            <i class="fas fa-truck"></i> Delivery Man
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a href="{{ route('seller.inquiries.index') }}"
                class="nav-link {{ request()->routeIs('seller.inquiries.*') ? 'active' : '' }}">
                <i class="fas fa-comments"></i> B2B Inquiries
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('seller.contact-book.index') }}"
                class="nav-link {{ request()->routeIs('seller.contact-book.*') ? 'active' : '' }}">
                <i class="fas fa-address-book"></i> Contact Book
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('seller.orders.index') }}"
                class="nav-link {{ request()->routeIs('seller.orders.*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i>
                Orders
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('seller.bulk-orders.index') }}"
                class="nav-link {{ request()->routeIs('seller.bulk-orders.*') ? 'active' : '' }}">
                <i class="fas fa-boxes"></i>
                Bulk Orders
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('seller.orders.track.index') }}"
                class="nav-link {{ request()->routeIs('seller.orders.track') ? 'active' : '' }}">
                <i class="fas fa-map-marker-alt"></i>
                Orders Track
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('seller.leads') }}"
                class="nav-link {{ request()->routeIs('seller.leads') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i>
                Leads
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('seller.promotions.index') }}"
                class="nav-link {{ request()->routeIs('seller.promotions.*') ? 'active' : '' }}">
                <i class="fas fa-percentage"></i>
                Promotions
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('seller.coins.index') }}"
                class="nav-link {{ request()->routeIs('seller.coins.*') ? 'active' : '' }}">
                <i class="fas fa-coins"></i>
                Coins & Rewards
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('seller.communication') }}"
                class="nav-link {{ request()->routeIs('seller.communication') ? 'active' : '' }}">
                <i class="fas fa-comments"></i>
                Communication
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('seller.settings') }}"
                class="nav-link {{ request()->routeIs('seller.settings') ? 'active' : '' }}">
                <i class="fas fa-cog"></i>
                Settings
            </a>
        </li>
    </ul>
</nav>
