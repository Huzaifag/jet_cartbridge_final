@extends('frontend.layout.main')

@push('styles')
<style>
/* Customer Dashboard Styles - Google Analytics Inspired */
.customer-dashboard {
    background: #f8f9fa;
    min-height: 100vh;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.dashboard-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem 0;
    margin-bottom: 2rem;
}

.profile-avatar-large {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 4px solid white;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    object-fit: cover;
}

.dashboard-welcome {
    font-size: 2rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.dashboard-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 0;
}

.stats-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
    height: 100%;
}

.stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.15);
}

.stats-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

.stats-number {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
    line-height: 1;
}.stats-la
bel {
    color: #6c757d;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
}

.stats-change {
    font-size: 0.8rem;
    font-weight: 600;
}

.stats-change.positive {
    color: #28a745;
}

.stats-change.negative {
    color: #dc3545;
}

.chart-container {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: 1px solid #e9ecef;
    margin-bottom: 2rem;
}

.chart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #e9ecef;
}

.chart-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #495057;
    margin: 0;
}

.chart-period {
    display: flex;
    gap: 0.5rem;
}

.period-btn {
    padding: 0.25rem 0.75rem;
    border: 1px solid #dee2e6;
    background: white;
    border-radius: 6px;
    font-size: 0.8rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.period-btn.active {
    background: #007bff;
    color: white;
    border-color: #007bff;
}

.period-btn:hover {
    background: #f8f9fa;
}.rewards
-section {
    background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
    border-radius: 12px;
    padding: 2rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
}

.rewards-section::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
    animation: float 20s infinite linear;
}

@keyframes float {
    0% { transform: translateX(0) translateY(0); }
    100% { transform: translateX(-50px) translateY(-50px); }
}

.rewards-content {
    position: relative;
    z-index: 1;
}

.rewards-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #8b4513;
    margin-bottom: 0.5rem;
}

.rewards-subtitle {
    color: #a0522d;
    margin-bottom: 1.5rem;
}

.rewards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.reward-item {
    background: rgba(255,255,255,0.9);
    border-radius: 8px;
    padding: 1rem;
    text-align: center;
    backdrop-filter: blur(10px);
}.
reward-icon {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.reward-value {
    font-size: 1.25rem;
    font-weight: 700;
    color: #8b4513;
}

.reward-label {
    font-size: 0.8rem;
    color: #a0522d;
}

.profile-section {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border: 1px solid #e9ecef;
    margin-bottom: 2rem;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #495057;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.order-timeline {
    position: relative;
}

.timeline-item {
    display: flex;
    gap: 1rem;
    margin-bottom: 1.5rem;
    position: relative;
}

.timeline-item:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 20px;
    top: 40px;
    bottom: -24px;
    width: 2px;
    background: #e9ecef;
}

.timeline-marker {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
    position: relative;
    z-index: 1;
}.timeli
ne-content {
    flex: 1;
    background: #f8f9fa;
    border-radius: 8px;
    padding: 1rem;
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 0.5rem;
}

.order-number {
    font-weight: 600;
    color: #495057;
}

.order-status {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-completed {
    background: #d4edda;
    color: #155724;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
}

.status-cancelled {
    background: #f8d7da;
    color: #721c24;
}

.order-details {
    font-size: 0.9rem;
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.order-total {
    font-weight: 600;
    color: #495057;
}

.btn-primary-custom {
    background: linear-gradient(135deg, #007bff, #0056b3);
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-primary-custom:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,123,255,0.3);
}.
address-card {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1rem;
    position: relative;
}

.address-card.default {
    border-color: #007bff;
    background: #e3f2fd;
}

.address-actions {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    display: flex;
    gap: 0.5rem;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.8rem;
    border-radius: 4px;
}

.analytics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.metric-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-left: 4px solid #007bff;
}

.metric-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.metric-title {
    font-size: 0.9rem;
    color: #6c757d;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.metric-value {
    font-size: 2rem;
    font-weight: 700;
    color: #495057;
}.metric-
change {
    font-size: 0.8rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.chart-placeholder {
    height: 300px;
    background: #f8f9fa;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    font-size: 1.1rem;
}

@media (max-width: 768px) {
    .dashboard-header {
        text-align: center;
    }
    
    .analytics-grid {
        grid-template-columns: 1fr;
    }
    
    .order-header {
        flex-direction: column;
        gap: 0.5rem;
    }
}
</style>
@endpush

@section('content')
<div class="customer-dashboard">
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-2 text-center text-md-start">
                    <img src="{{ $user->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=007bff&color=ffffff&size=120' }}" 
                         alt="{{ $user->name }}" class="profile-avatar-large">
                </div>
                <div class="col-md-8 text-center text-md-start mt-3 mt-md-0">
                    <h1 class="dashboard-welcome">Welcome back, {{ $user->profile?->first_name ?? explode(' ', $user->name)[0] }}!</h1>
                    <p class="dashboard-subtitle">Here's your shopping activity and account overview</p>
                </div>
                <div class="col-md-2 text-center text-md-end mt-3 mt-md-0">
                    <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="fas fa-edit me-2"></i>Edit Profile
                    </button>
                </div>
            </div>
        </div>
    </div>   
 <div class="container">
        <!-- Analytics Overview -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stats-card">
                    <div class="stats-icon" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white;">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stats-number">{{ $orderStats['total_orders'] ?? 0 }}</div>
                    <div class="stats-label">Total Orders</div>
                    <div class="stats-change positive">
                        <i class="fas fa-arrow-up"></i> +{{ $orderStats['orders_this_month'] ?? 0 }} this month
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stats-card">
                    <div class="stats-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c); color: white;">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stats-number">${{ number_format($orderStats['total_spent'] ?? 0, 2) }}</div>
                    <div class="stats-label">Total Spent</div>
                    <div class="stats-change positive">
                        <i class="fas fa-arrow-up"></i> +${{ number_format($orderStats['spent_this_month'] ?? 0, 2) }} this month
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stats-card">
                    <div class="stats-icon" style="background: linear-gradient(135deg, #4facfe, #00f2fe); color: white;">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stats-number">{{ $orderStats['reviews_given'] ?? 0 }}</div>
                    <div class="stats-label">Reviews Given</div>
                    <div class="stats-change positive">
                        <i class="fas fa-arrow-up"></i> +{{ $orderStats['reviews_this_month'] ?? 0 }} this month
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stats-card">
                    <div class="stats-icon" style="background: linear-gradient(135deg, #43e97b, #38f9d7); color: white;">
                        <i class="fas fa-gift"></i>
                    </div>
                    <div class="stats-number">{{ $rewardStats['total_points'] ?? 0 }}</div>
                    <div class="stats-label">Reward Points</div>
                    <div class="stats-change positive">
                        <i class="fas fa-arrow-up"></i> +{{ $rewardStats['points_this_month'] ?? 0 }} earned
                    </div>
                </div>
            </div>
        </div>       
 <!-- Rewards Section -->
        <div class="rewards-section">
            <div class="rewards-content">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="rewards-title">🎉 Your Rewards Dashboard</h3>
                        <p class="rewards-subtitle">Keep shopping to unlock more rewards and exclusive benefits!</p>
                    </div>
                    <div class="col-md-6">
                        <div class="rewards-grid">
                            <div class="reward-item">
                                <div class="reward-icon">🏆</div>
                                <div class="reward-value">{{ $rewardStats['level'] ?? 'Bronze' }}</div>
                                <div class="reward-label">Current Level</div>
                            </div>
                            <div class="reward-item">
                                <div class="reward-icon">💰</div>
                                <div class="reward-value">${{ number_format($rewardStats['cashback_earned'] ?? 0, 2) }}</div>
                                <div class="reward-label">Cashback Earned</div>
                            </div>
                            <div class="reward-item">
                                <div class="reward-icon">🎁</div>
                                <div class="reward-value">{{ $rewardStats['coupons_available'] ?? 0 }}</div>
                                <div class="reward-label">Available Coupons</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Charts Section -->
            <div class="col-lg-8">
                <!-- Order Trends Chart -->
                <div class="chart-container">
                    <div class="chart-header">
                        <h3 class="chart-title">Order Trends</h3>
                        <div class="chart-period">
                            <button class="period-btn active" data-period="7d">7 Days</button>
                            <button class="period-btn" data-period="30d">30 Days</button>
                            <button class="period-btn" data-period="90d">90 Days</button>
                            <button class="period-btn" data-period="1y">1 Year</button>
                        </div>
                    </div>
                    <div class="chart-placeholder">
                        <canvas id="orderTrendsChart" width="400" height="200"></canvas>
                    </div>
                </div> 
               <!-- Spending Analytics -->
                <div class="analytics-grid">
                    <div class="metric-card">
                        <div class="metric-header">
                            <span class="metric-title">Average Order Value</span>
                            <i class="fas fa-chart-line text-primary"></i>
                        </div>
                        <div class="metric-value">${{ number_format($orderStats['avg_order_value'] ?? 0, 2) }}</div>
                        <div class="metric-change positive">
                            <i class="fas fa-arrow-up"></i> +12% from last month
                        </div>
                    </div>
                    <div class="metric-card">
                        <div class="metric-header">
                            <span class="metric-title">Orders This Month</span>
                            <i class="fas fa-shopping-bag text-success"></i>
                        </div>
                        <div class="metric-value">{{ $orderStats['orders_this_month'] ?? 0 }}</div>
                        <div class="metric-change positive">
                            <i class="fas fa-arrow-up"></i> +{{ $orderStats['orders_growth'] ?? 0 }}% growth
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="profile-section">
                    <h3 class="section-title">
                        <i class="fas fa-history"></i>
                        Recent Orders
                    </h3>
                    <div class="order-timeline">
                        @forelse($recentOrders ?? [] as $order)
                            <div class="timeline-item">
                                <div class="timeline-marker" style="background: {{ $order->status === 'completed' ? '#28a745' : ($order->status === 'pending' ? '#ffc107' : '#dc3545') }}; color: white;">
                                    <i class="fas fa-{{ $order->status === 'completed' ? 'check' : ($order->status === 'pending' ? 'clock' : 'times') }}"></i>
                                </div>
                                <div class="timeline-content">
                                    <div class="order-header">
                                        <div>
                                            <div class="order-number">Order #{{ $order->order_number ?? 'N/A' }}</div>
                                            <div class="order-details">{{ $order->created_at ? $order->created_at->format('M d, Y') : 'N/A' }} • {{ $order->orderItems ? $order->orderItems->count() : 0 }} items</div>
                                        </div>
                                        <span class="order-status status-{{ $order->status ?? 'pending' }}">{{ ucfirst($order->status ?? 'Pending') }}</span>
                                    </div>
                                    <div class="order-total">Total: ${{ number_format($order->total ?? 0, 2) }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No orders yet</h5>
                                <p class="text-muted">Start shopping to see your order history here!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>    
        <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Personal Information -->
                <div class="profile-section">
                    <h3 class="section-title">
                        <i class="fas fa-user"></i>
                        Personal Information
                    </h3>
                    <div class="mb-3">
                        <strong>Full Name:</strong><br>
                        {{ $user->profile?->first_name && $user->profile?->last_name ? $user->profile->first_name . ' ' . $user->profile->last_name : $user->name }}
                    </div>
                    <div class="mb-3">
                        <strong>Email:</strong><br>
                        {{ $user->email }}
                    </div>
                    @if($user->profile?->phone)
                        <div class="mb-3">
                            <strong>Phone:</strong><br>
                            {{ $user->profile->phone }}
                        </div>
                    @endif
                    @if($user->profile?->date_of_birth)
                        <div class="mb-3">
                            <strong>Date of Birth:</strong><br>
                            {{ $user->profile->date_of_birth->format('M d, Y') }}
                        </div>
                    @endif
                    <button class="btn btn-primary-custom btn-sm w-100" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="fas fa-edit me-2"></i>Edit Information
                    </button>
                </div>

                <!-- Addresses -->
                <div class="profile-section">
                    <h3 class="section-title">
                        <i class="fas fa-map-marker-alt"></i>
                        Saved Addresses
                    </h3>
                    @forelse($user->addresses ?? [] as $address)
                        <div class="address-card {{ $address->is_default ? 'default' : '' }}">
                            @if($address->is_default)
                                <span class="badge bg-primary mb-2">Default</span>
                            @endif
                            <div class="address-actions">
                                <button class="btn btn-sm btn-outline-primary" onclick="editAddress({{ $address->id }})">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteAddress({{ $address->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <div><strong>{{ $address->label ?? 'Address' }}</strong></div>
                            <div>{{ $address->street_address ?? 'N/A' }}</div>
                            <div>{{ $address->city ?? 'N/A' }}, {{ $address->state ?? 'N/A' }} {{ $address->postal_code ?? '' }}</div>
                            <div>{{ $address->country ?? 'N/A' }}</div>
                        </div>
                    @empty
                        <div class="text-center py-3">
                            <i class="fas fa-map-marker-alt fa-2x text-muted mb-2"></i>
                            <p class="text-muted mb-2">No addresses saved</p>
                            <button class="btn btn-primary-custom btn-sm" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                <i class="fas fa-plus me-2"></i>Add Address
                            </button>
                        </div>
                    @endforelse  
                  @if(isset($user->addresses) && $user->addresses->count() > 0)
                        <button class="btn btn-outline-primary btn-sm w-100 mt-2" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                            <i class="fas fa-plus me-2"></i>Add New Address
                        </button>
                    @endif
                </div>

                <!-- Quick Actions -->
                <div class="profile-section">
                    <h3 class="section-title">
                        <i class="fas fa-bolt"></i>
                        Quick Actions
                    </h3>
                    <div class="d-grid gap-2">
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-list me-2"></i>View All Orders
                        </a>
                        <a href="{{ route('wishlist.index') }}" class="btn btn-outline-success">
                            <i class="fas fa-heart me-2"></i>My Wishlist
                        </a>
                        <a href="{{ route('reviews.index') }}" class="btn btn-outline-warning">
                            <i class="fas fa-star me-2"></i>My Reviews
                        </a>
                        <a href="{{ route('rewards.index') }}" class="btn btn-outline-info">
                            <i class="fas fa-gift me-2"></i>Rewards & Coupons
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control" value="{{ $user->profile?->first_name ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control" value="{{ $user->profile?->last_name ?? '' }}">
                            </div>
                        </div>
                    </div>  
                  <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Phone</label>
                                <input type="tel" name="phone" class="form-control" value="{{ $user->profile?->phone ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" name="date_of_birth" class="form-control" value="{{ $user->profile?->date_of_birth?->format('Y-m-d') ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Profile Picture</label>
                        <input type="file" name="profile_picture" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-custom">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Address Modal -->
<div class="modal fade" id="addAddressModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('addresses.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Address Label</label>
                        <input type="text" name="label" class="form-control" placeholder="Home, Office, etc.">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Street Address</label>
                        <input type="text" name="street_address" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">State</label>
                                <input type="text" name="state" class="form-control">
                            </div>
                        </div>
                    </div>     
               <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Postal Code</label>
                                <input type="text" name="postal_code" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Country</label>
                                <input type="text" name="country" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" name="is_default" class="form-check-input" id="isDefault">
                        <label class="form-check-label" for="isDefault">Set as default address</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-custom">Add Address</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Order Trends Chart
const ctx = document.getElementById('orderTrendsChart').getContext('2d');
const orderTrendsChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'Orders',
            data: [12, 19, 3, 5, 2, 3],
            borderColor: '#007bff',
            backgroundColor: 'rgba(0, 123, 255, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: '#f8f9fa'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Period buttons functionality
document.querySelectorAll('.period-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.period-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        // Update chart data based on period
        // This would typically make an AJAX call to get new data
    });
});

// Address management functions
function editAddress(addressId) {
    // Implementation for editing address
    console.log('Edit address:', addressId);
}

function deleteAddress(addressId) {
    if (confirm('Are you sure you want to delete this address?')) {
        // Implementation for deleting address
        console.log('Delete address:', addressId);
    }
}
</script>
@endpush
@endsection