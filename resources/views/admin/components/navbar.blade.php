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

            @php
                $user = auth()->user();
                $unreadMessagesCount = 0;
                $unreadMessages = collect();
                $pendingMeetingsCount = 0;

                // Only show messages/meetings for seller role
                if($user->seller) {
                    // Unread messages for seller
                    $unreadMessagesCount = \App\Models\Message::whereHas('conversation', function($q) use ($user) {
                        $q->where('seller_id', $user->seller->id);
                    })->where('is_read', false)->count();

                    $unreadMessages = \App\Models\Message::whereHas('conversation', function($q) use ($user) {
                        $q->where('seller_id', $user->seller->id);
                    })->where('is_read', false)->with('conversation.customer')->latest()->take(5)->get();

                    // Pending meetings
                    $pendingMeetings = $user->allMeetings()
                        ->where('status', \App\Models\Meeting::STATUS_PENDING)
                        ->where('receiver_id', $user->id)
                        ->orderBy('scheduled_at', 'asc')
                        ->get();

                    $pendingMeetingsCount = $pendingMeetings->count();
                }
            @endphp

            @if($user->seller)
                <!-- Messages Dropdown -->
                <div class="dropdown me-3">
                    <a class="nav-link position-relative" href="#" role="button" id="messagesDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-comments fa-lg text-muted"></i>
                        @if($unreadMessagesCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">
                            {{ $unreadMessagesCount }}
                            <span class="visually-hidden">unread messages</span>
                        </span>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow message-dropdown" aria-labelledby="messagesDropdown">
                        <li class="dropdown-header">
                            <h6 class="mb-0">Messages</h6>
                            @if($unreadMessagesCount > 0)
                            <span class="badge bg-primary rounded-pill">{{ $unreadMessagesCount }} Unread</span>
                            @endif
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        @forelse($unreadMessages as $message)
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="flex-shrink-0">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($message->conversation->customer->name) }}&background=random"
                                        class="rounded-circle" width="40" height="40" alt="{{ $message->conversation->customer->name }}">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="fw-bold">{{ $message->conversation->customer->name }}</div>
                                    <div class="small text-truncate">{{ Str::limit($message->message, 50) }}</div>
                                    <div class="text-muted small">{{ $message->created_at->diffForHumans() }}</div>
                                </div>
                            </a>
                        </li>
                        @empty
                        <li class="dropdown-item text-center text-muted">No unread messages</li>
                        @endforelse
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="dropdown-footer text-center">
                            <a href="{{ route('seller.chat.index') }}" class="text-primary">View All Messages</a>
                        </li>
                    </ul>
                </div>

                <!-- Meetings Dropdown -->
                <div class="dropdown me-3">
                    <a class="nav-link position-relative" href="#" role="button" id="meetingsDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-video fa-lg text-muted"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                            {{ $pendingMeetingsCount ?? 0 }}
                            <span class="visually-hidden">pending meetings</span>
                        </span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow meeting-dropdown" aria-labelledby="meetingsDropdown"
                        style="width: 350px;">
                        <li class="dropdown-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Meeting Requests</h6>
                            <span class="badge bg-success rounded-pill">{{ $pendingMeetingsCount ?? 0 }} Pending</span>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        @if(isset($pendingMeetings))
                            @forelse ($pendingMeetings as $meeting)
                                <li class="dropdown-item">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($meeting->sender->name) }}&background=random"
                                                class="rounded-circle" width="40" height="40" alt="{{ $meeting->sender->name }}">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="fw-bold">{{ $meeting->title ?? 'Meeting Request' }}</div>
                                            <div class="small text-muted">From: {{ $meeting->sender->name }}</div>
                                            <div class="small text-muted">
                                                📅
                                                {{ $meeting->scheduled_at ? $meeting->scheduled_at->format('d M, h:i A') : 'Not scheduled' }}
                                            </div>

                                            <div class="mt-2 d-flex gap-2">
                                                <button class="btn btn-sm btn-success accept-meeting"
                                                    data-id="{{ $meeting->id }}">Accept</button>
                                                <button class="btn btn-sm btn-danger reject-meeting"
                                                    data-id="{{ $meeting->id }}">Reject</button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                            @empty
                                <li class="dropdown-item text-center text-muted">No pending meetings</li>
                            @endforelse
                        @endif

                        <li class="dropdown-footer text-center">
                            <a href="{{ route('seller.meetings.index') }}" class="text-primary">View All Meetings</a>
                        </li>
                    </ul>
                </div>
            @endif

            <!-- Quick Actions Dropdown -->
            <div class="dropdown me-3 d-none d-md-block">
                <a class="nav-link" href="#" role="button" id="quickActionsDropdown" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fas fa-bolt fa-lg text-muted"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="quickActionsDropdown">
                    <li class="dropdown-header">
                        <h6 class="mb-0">Quick Actions</h6>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    @if($user->seller)
                        <li>
                            <a class="dropdown-item" href="{{ route('seller.products.create') }}">
                                <i class="fas fa-box text-info me-2"></i>Add New Product
                            </a>
                        </li>
                    @endif
                    @if($user->manufacturer)
                        <li>
                            <a class="dropdown-item" href="{{ route('manufacturer.products.create') }}">
                                <i class="fas fa-industry text-info me-2"></i>Add Manufacturer Product
                            </a>
                        </li>
                    @endif
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
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
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="avatar bg-primary text-white rounded-circle me-2">
                        @if($user->seller)
                            {{ collect(explode(' ', $user->seller->company_name))->map(fn($w) => strtoupper(Str::substr($w, 0, 1)))->implode('') }}
                        @elseif($user->manufacturer)
                            {{ collect(explode(' ', $user->manufacturer->company_name))->map(fn($w) => strtoupper(Str::substr($w, 0, 1)))->implode('') }}
                        @else
                            {{ collect(explode(' ', $user->name))->map(fn($w) => strtoupper(Str::substr($w, 0, 1)))->implode('') }}
                        @endif
                    </div>
                    <div class="d-none d-md-block">
                        <div class="fw-bold">
                            @if($user->seller)
                                {{ $user->seller->company_name }}
                            @elseif($user->manufacturer)
                                {{ $user->manufacturer->company_name }}
                            @else
                                {{ $user->name }}
                            @endif
                        </div>
                        <div class="small text-muted">
                            @php
                                $roles = [];
                                if($user->seller) $roles[] = 'Seller';
                                if($user->accountant) $roles[] = 'Accountant';
                                if($user->manufacturer) $roles[] = 'Manufacturer';
                                if($user->salesman) $roles[] = 'Salesman';
                                if($user->warehouse) $roles[] = 'Warehouse';
                                if($user->deliveryman) $roles[] = 'Delivery';
                                echo implode(', ', $roles) ?: 'User';
                            @endphp
                        </div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                    <li class="dropdown-header">
                        <h6 class="mb-0">
                            @if($user->seller)
                                {{ $user->seller->company_name }}
                            @elseif($user->manufacturer)
                                {{ $user->manufacturer->company_name }}
                            @else
                                {{ $user->name }}
                            @endif
                        </h6>
                        <small class="text-muted">
                            @php
                                $roles = [];
                                if($user->seller) $roles[] = 'Seller';
                                if($user->accountant) $roles[] = 'Accountant';
                                if($user->manufacturer) $roles[] = 'Manufacturer';
                                if($user->salesman) $roles[] = 'Salesman';
                                if($user->warehouse) $roles[] = 'Warehouse';
                                if($user->deliveryman) $roles[] = 'Delivery';
                                echo implode(', ', $roles) ?: 'User Account';
                            @endphp
                        </small>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
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
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>