@extends('frontend.layout.main')
@section('content')
    {{-- Font Awesome CDN for icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        /* Added styles for tab visibility */
        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .profile-container {
            display: flex;
            gap: 30px;
            margin-bottom: 40px;
        }

        .profile-sidebar {
            flex: 0 0 300px;
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            align-self: flex-start;
        }

        .profile-main {
            flex: 1;
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 25px;
            border: 4px solid #f0f2ff;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-info h1 {
            font-size: 28px;
            margin-bottom: 5px;
            color: #2d3748;
        }

        .profile-info p {
            color: #718096;
            margin-bottom: 15px;
        }

        .user-badge {
            display: inline-block;
            background: #f0f2ff;
            color: #4e54c8;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .stats {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #4e54c8;
        }

        .stat-label {
            font-size: 14px;
            color: #718096;
        }

        .section-title {
            font-size: 20px;
            margin: 30px 0 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e1e5eb;
            color: #2d3748;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .info-item {
            margin-bottom: 15px;
        }

        .info-label {
            font-size: 14px;
            color: #718096;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 16px;
            color: #2d3748;
            font-weight: 500;
        }

        .activity-list {
            list-style: none;
            padding: 0;
        }

        .activity-item {
            display: flex;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid #e1e5eb;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f0f2ff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4e54c8;
            font-size: 18px;
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .activity-time {
            font-size: 14px;
            color: #718096;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: background 0.3s;
            color: #4a5568;
            text-decoration: none;
        }

        .menu-item:hover,
        .menu-item.active {
            background: #f0f2ff;
            color: #4e54c8;
        }

        .menu-item i {
            margin-right: 12px;
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        @media (max-width: 900px) {
            .profile-container {
                flex-direction: column;
            }

            .profile-sidebar {
                flex: 1;
                width: 100%;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 600px) {
            .profile-header {
                flex-direction: column;
                text-align: center;
            }

            .avatar {
                margin-right: 0;
                margin-bottom: 20px;
            }

            .stats {
                justify-content: center;
            }
        }
    </style>

    <div class="container mt-4">
        <div class="profile-container">
            <div class="profile-sidebar">
                <a href="#personal" class="menu-item active" data-tab="personal">
                    <i class="fas fa-user"></i> Personal Information
                </a>
                <a href="#orders" class="menu-item" data-tab="orders">
                    <i class="fas fa-shopping-bag"></i> Orders
                </a>
                <a href="#addresses" class="menu-item" data-tab="addresses">
                    <i class="fas fa-map-marker-alt"></i> Addresses
                </a>
                <a href="#payments" class="menu-item" data-tab="payments">
                    <i class="fas fa-credit-card"></i> Payment Methods
                </a>
                <a href="#wishlist" class="menu-item" data-tab="wishlist">
                    <i class="fas fa-heart"></i> Wishlist
                </a>
                <a href="#settings" class="menu-item" data-tab="settings">
                    <i class="fas fa-cog"></i> Settings
                </a>
                <a href="#security" class="menu-item" data-tab="security">
                    <i class="fas fa-shield-alt"></i> Privacy & Security
                </a>
            </div>

            <div class="profile-main" id="profile-content">
                <div id="personal" class="tab-content active">
                    <div class="profile-header">
                        <div class="avatar">
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Profile Picture">
                        </div>
                        <div class="profile-info">
                            <h1>{{ $user->name }}</h1>
                            <p>Joined: {{ $user->created_at->format('F d, Y') }}</p>
                            <span class="user-badge">Premium Member</span>

                            <div class="stats">
                                <div class="stat-item">
                                    <div class="stat-value">24</div>
                                    <div class="stat-label">Orders</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value">5</div>
                                    <div class="stat-label">Reviews</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-value">2</div>
                                    <div class="stat-label">Years</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h2 class="section-title">Personal Information</h2>
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Full Name</div>
                            <div class="info-value">{{ $user->name }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Email Address</div>
                            <div class="info-value">{{ $user->email }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Phone Number</div>
                            <div class="info-value">(555) 123-4567</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Date of Birth</div>
                            <div class="info-value">January 15, 1985</div>
                        </div>
                    </div>

                    <h2 class="section-title">Recent Activity</h2>
                    <ul class="activity-list">
                        <li class="activity-item">
                            <div class="activity-icon"><i class="fas fa-shopping-cart"></i></div>
                            <div class="activity-content">
                                <div class="activity-title">Placed new order #3245</div>
                                <div class="activity-time">2 hours ago</div>
                            </div>
                        </li>
                        <li class="activity-item">
                            <div class="activity-icon"><i class="fas fa-star"></i></div>
                            <div class="activity-content">
                                <div class="activity-title">Reviewed "Wireless Headphones"</div>
                                <div class="activity-time">1 day ago</div>
                            </div>
                        </li>
                    </ul>

                    <div style="text-align: center; margin-top: 30px;">
                        <a href="#" class="btn btn-primary"><i class="fas fa-edit"></i> Edit Profile</a>
                    </div>
                </div>

                <div id="orders" class="tab-content">
                    <h2 class="section-title">Your Orders</h2>
                    <p>Order details will be displayed here...</p>
                </div>

                <div id="addresses" class="tab-content">
                    <h2 class="section-title">Your Addresses</h2>
                    <p>Address details will be displayed here...</p>
                </div>

                <div id="payments" class="tab-content">
                    <h2 class="section-title">Payment Methods</h2>
                    <p>Payment methods will be displayed here...</p>
                </div>

                <div id="wishlist" class="tab-content">
                    <h2 class="section-title">Your Wishlist</h2>
                    <p>Your wishlist items will be displayed here...</p>
                </div>

                <div id="settings" class="tab-content">
                    <h2 class="section-title">Account Settings</h2>
                    <p>Account settings will be displayed here...</p>
                </div>

                <div id="security" class="tab-content">
                    <h2 class="section-title">Privacy & Security</h2>
                    <p>Privacy and security settings will be displayed here...</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuItems = document.querySelectorAll('.menu-item');
            const tabContents = document.querySelectorAll('.tab-content');

            function showTab(tabId) {
                // Hide all tab contents
                tabContents.forEach(content => {
                    content.classList.remove('active');
                });

                // Deactivate all menu items
                menuItems.forEach(item => {
                    item.classList.remove('active');
                });

                // Activate the selected tab and menu item
                const selectedContent = document.getElementById(tabId);
                const selectedMenu = document.querySelector(`[data-tab="${tabId}"]`);

                if (selectedContent && selectedMenu) {
                    selectedContent.classList.add('active');
                    selectedMenu.classList.add('active');
                }
            }

            // Handle menu item clicks
            menuItems.forEach(item => {
                item.addEventListener('click', (e) => {
                    e.preventDefault(); // Prevent default anchor behavior
                    const tabId = item.getAttribute('data-tab');

                    // Update URL without reloading the page
                    window.history.pushState(null, '', `#${tabId}`);

                    showTab(tabId);
                });
            });

            // Check for a hash in the URL on page load
            const currentHash = window.location.hash.substring(1);
            if (currentHash) {
                showTab(currentHash);
            } else {
                // If no hash, show the default tab ('personal')
                showTab('personal');
            }
        });
    </script>
@endsection
