<!-- Sidebar -->
<nav class="sidebar" style="overflow-y: auto; max-height: 100vh;">
    <div class="sidebar-header">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid">
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{ route('manufacturer.dashboard') }}"
                class="nav-link {{ request()->routeIs('manufacturer.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('manufacturer.products.index') }}"
                class="nav-link {{ request()->routeIs('manufacturer.products.*') ? 'active' : '' }}">
                <i class="fas fa-box"></i>
                Products
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('manufacturer.categories.index') }}"
                class="nav-link {{ request()->routeIs('manufacturer.categories.*') ? 'active' : '' }}">
                <i class="fas fa-folder"></i>
                Categories
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('manufacturer.orders.index') }}"
                class="nav-link {{ request()->routeIs('manufacturer.orders.*') ? 'active' : '' }}">
                <i class="fas fa-shopping-cart"></i>
                Orders
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('manufacturer.bulk-orders.index') }}"
                class="nav-link {{ request()->routeIs('manufacturer.bulk-orders.*') ? 'active' : '' }}">
                <i class="fas fa-boxes"></i>
                Bulk Orders
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('manufacturer.inquiries.index') }}"
                class="nav-link {{ request()->routeIs('manufacturer.inquiries.*') ? 'active' : '' }}">
                <i class="fas fa-question-circle"></i>
                Inquiries
            </a>
        </li>

        <li class="nav-item">
            <a href="#employeesSubmenu" data-bs-toggle="collapse" 
                class="nav-link {{ request()->routeIs('manufacturer.employees.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                Employees
                <i class="fas fa-chevron-down ms-auto"></i>
            </a>
            <ul class="collapse {{ request()->routeIs('manufacturer.employees.*') ? 'show' : '' }}" id="employeesSubmenu">
                <li class="nav-item">
                    <a href="{{ route('manufacturer.employees.accountant.index') }}"
                        class="nav-link {{ request()->routeIs('manufacturer.employees.accountant.*') ? 'active' : '' }}">
                        <i class="fas fa-calculator"></i>
                        Accountants
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('manufacturer.employees.salesman.index') }}"
                        class="nav-link {{ request()->routeIs('manufacturer.employees.salesman.*') ? 'active' : '' }}">
                        <i class="fas fa-user-tie"></i>
                        Salesmen
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('manufacturer.employees.warehouse.index') }}"
                        class="nav-link {{ request()->routeIs('manufacturer.employees.warehouse.*') ? 'active' : '' }}">
                        <i class="fas fa-warehouse"></i>
                        Warehouse
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('manufacturer.employees.delivery.index') }}"
                        class="nav-link {{ request()->routeIs('manufacturer.employees.delivery.*') ? 'active' : '' }}">
                        <i class="fas fa-truck"></i>
                        Delivery
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item">
            <a href="{{ route('manufacturer.settings') }}"
                class="nav-link {{ request()->routeIs('manufacturer.settings*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i>
                Settings
            </a>
        </li>
    </ul>
</nav>
