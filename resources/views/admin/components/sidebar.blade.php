<!-- Sidebar -->
<nav class="sidebar" style="overflow-y: auto; max-height: 100vh;">
    <div class="sidebar-header">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid">
    </div>
    <ul class="nav flex-column">
        <!-- Dashboard - Always visible -->
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}"
                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                Dashboard
            </a>
        </li>

        <!-- Appointments - Admin feature -->
        <li class="nav-item">
            <a href="{{ route('admin.appointments.index') }}"
                class="nav-link {{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-alt"></i>
                Appointments
                @php
                    try {
                        $pendingMeetings = \App\Models\Meeting::where('status', 'pending')->count();
                    } catch (\Exception $e) {
                        $pendingMeetings = 0;
                    }
                    
                    try {
                        $pendingInquiries = \App\Models\UserInquiry::where('status', 'pending')->count();
                    } catch (\Exception $e) {
                        $pendingInquiries = 0;
                    }
                    
                    $pendingCount = $pendingMeetings + $pendingInquiries;
                @endphp
                @if($pendingCount > 0)
                    <span class="badge bg-danger ms-2" style="font-size: 0.7rem;">{{ $pendingCount }}</span>
                @endif
            </a>
        </li>

        @if(auth()->user()->seller || auth()->user()->manufacturer || auth()->user()->salesman)
            <!-- Unified Product Management -->
            <li class="nav-item">
                <a href="{{ route('admin.products.index') }}"
                    class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fas fa-box"></i>
                    Products
                </a>
            </li>
        @endif

        @if(auth()->user()->seller)
            <!-- Seller Navigation -->

            <li class="nav-item">
                <a href="{{ route('seller.categories.index') }}"
                    class="nav-link {{ request()->routeIs('seller.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i>
                    Categories
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
                <a href="{{ route('seller.employee-activities.index') }}"
                    class="nav-link {{ request()->routeIs('seller.employee-activities.*') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list"></i> Employee Activities
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('seller.analytics.index') }}"
                    class="nav-link {{ request()->routeIs('seller.analytics.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i> Analytics
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('seller.business-history.index') }}"
                    class="nav-link {{ request()->routeIs('seller.business-history.*') ? 'active' : '' }}">
                    <i class="fas fa-history"></i> Business History
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
                <a href="{{ route('seller.chat.index') }}"
                    class="nav-link {{ request()->routeIs('seller.chat.*') ? 'active' : '' }}">
                    <i class="fas fa-comments"></i>
                    Messages
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
                <a href="{{ route('seller.settings') }}"
                    class="nav-link {{ request()->routeIs('seller.settings') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i>
                    Settings
                </a>
            </li>
        @endif

        @if(auth()->user()->accountant)
            <!-- Accountant Navigation -->
            <li class="nav-item">
                <a href="{{ route('accountant.confirmed-orders.index') }}"
                    class="nav-link {{ request()->routeIs('accountant.confirmed-orders.*') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice"></i>
                    Confirmed Orders
                </a>
            </li>
        @endif

        @if(auth()->user()->manufacturer)
            <!-- Manufacturer Navigation -->

            <li class="nav-item">
                <a href="{{ route('manufacturer.categories.index') }}"
                    class="nav-link {{ request()->routeIs('manufacturer.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-folder"></i>
                    Manufacturer Categories
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('manufacturer.orders.index') }}"
                    class="nav-link {{ request()->routeIs('manufacturer.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                    Manufacturer Orders
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('manufacturer.bulk-orders.index') }}"
                    class="nav-link {{ request()->routeIs('manufacturer.bulk-orders.*') ? 'active' : '' }}">
                    <i class="fas fa-boxes"></i>
                    Manufacturer Bulk Orders
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('manufacturer.inquiries.index') }}"
                    class="nav-link {{ request()->routeIs('manufacturer.inquiries.*') ? 'active' : '' }}">
                    <i class="fas fa-question-circle"></i>
                    Manufacturer Inquiries
                </a>
            </li>

            <!-- Manufacturer Employees Dropdown -->
            <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
                    href="#manufacturerEmployeesMenu" role="button" aria-expanded="false" aria-controls="manufacturerEmployeesMenu">
                    <span><i class="fas fa-users"></i> Manufacturer Employees</span>
                    <i class="fas fa-chevron-down small"></i>
                </a>
                <div class="collapse {{ request()->routeIs('manufacturer.employees.*') ? 'show' : '' }}" id="manufacturerEmployeesMenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a href="{{ route('manufacturer.employees.accountant.index') }}"
                                class="nav-link {{ request()->routeIs('manufacturer.employees.accountant.*') ? 'active' : '' }}">
                                <i class="fas fa-calculator"></i> Accountants
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('manufacturer.employees.salesman.index') }}"
                                class="nav-link {{ request()->routeIs('manufacturer.employees.salesman.*') ? 'active' : '' }}">
                                <i class="fas fa-user-tie"></i> Salesmen
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('manufacturer.employees.warehouse.index') }}"
                                class="nav-link {{ request()->routeIs('manufacturer.employees.warehouse.*') ? 'active' : '' }}">
                                <i class="fas fa-warehouse"></i> Warehouse
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('manufacturer.employees.delivery.index') }}"
                                class="nav-link {{ request()->routeIs('manufacturer.employees.delivery.*') ? 'active' : '' }}">
                                <i class="fas fa-truck"></i> Delivery
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a href="{{ route('manufacturer.settings') }}"
                    class="nav-link {{ request()->routeIs('manufacturer.settings*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i>
                    Manufacturer Settings
                </a>
            </li>
        @endif

        @if(auth()->user()->salesman)
            <!-- Salesman Navigation -->
            <li class="nav-item">
                <a href="{{ route('salesman.placed-orders.index') }}"
                    class="nav-link {{ request()->routeIs('salesman.placed-orders.*') ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i>
                    Placed Orders
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('salesman.leads.index') }}"
                    class="nav-link {{ request()->routeIs('salesman.leads.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    Leads
                </a>
            </li>
        @endif

        @if(auth()->user()->warehouse)
            <!-- Warehouse Navigation -->
            <li class="nav-item">
                <a href="{{ route('warehouse.orders.index') }}"
                    class="nav-link {{ request()->routeIs('warehouse.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-warehouse"></i>
                    Warehouse Orders
                </a>
            </li>
        @endif

        @if(auth()->user()->deliveryman)
            <!-- Deliveryman Navigation -->
            <li class="nav-item">
                <a href="{{ route('deliveryman.orders.index') }}"
                    class="nav-link {{ request()->routeIs('deliveryman.orders.*') ? 'active' : '' }}">
                    <i class="fas fa-truck"></i>
                    Delivery Orders
                </a>
            </li>
        @endif

        <!-- Role Badge -->
        <li class="nav-item mt-3">
            <div class="nav-link">
                <div class="role-badge" style="background-color: rgba(255, 255, 255, 0.1); border-radius: 8px; padding: 10px; text-align: center;">
                    @php
                        $userRoles = [];
                        if(auth()->user()->seller) $userRoles[] = 'Seller';
                        if(auth()->user()->accountant) $userRoles[] = 'Accountant';
                        if(auth()->user()->manufacturer) $userRoles[] = 'Manufacturer';
                        if(auth()->user()->salesman) $userRoles[] = 'Salesman';
                        if(auth()->user()->warehouse) $userRoles[] = 'Warehouse';
                        if(auth()->user()->deliveryman) $userRoles[] = 'Delivery';
                    @endphp
                    
                    @if(count($userRoles) > 0)
                        <small style="color: rgba(255, 255, 255, 0.7);">Active Roles:</small><br>
                        @foreach($userRoles as $role)
                            <span class="badge bg-warning text-dark me-1 mb-1" style="font-size: 0.7rem;">{{ $role }}</span>
                        @endforeach
                    @endif
                </div>
            </div>
        </li>
    </ul>
</nav>