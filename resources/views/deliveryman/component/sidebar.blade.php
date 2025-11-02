<!-- Sidebar -->
<nav class="sidebar" style="overflow-y: auto; max-height: 100vh;">
    <div class="sidebar-header">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid">
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{ route('warehouse.dashboard.index') }}"
                class="nav-link {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('deliveryman.orders.index') }}"
                class="nav-link {{ request()->routeIs('deliveryman.orders.index') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i>
                Orders
            </a>
        </li>
       
    </ul>
</nav>
