<!-- Sidebar -->
<nav class="sidebar" style="overflow-y: auto; max-height: 100vh;">
    <div class="sidebar-header">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid">
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{ route('accountant.dashboard.index') }}"
                class="nav-link {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('accountant.products.index') }}"
                class="nav-link {{ request()->routeIs('accountant.products.index') ? 'active' : '' }}">
                <i class="fas fa-box"></i>
                Products
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('accountant.placed-orders.index') }}"
                class="nav-link {{ request()->routeIs('accountant.placed-orders.index') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i>
                Placed Orders
            </a>
        </li>
    </ul>
</nav>
