@extends('seller.layouts.app')
@section('content')
<div class="dashboard-header">
  <div class="welcome-message">
      <h1>Analytics Dashboard</h1>
      <p>Welcome back! Here's what's happening with your store today.</p>
  </div>
  <div class="date-display">
      <i class="fas fa-calendar-alt"></i>
      <span id="current-date">{{ date('F j, Y') }}</span>
  </div>
</div>

<div class="filter-options">
  <button class="filter-btn {{ $range == 'today' ? 'active' : '' }}" data-range="today">Today</button>
  <button class="filter-btn {{ $range == 'week' ? 'active' : '' }}" data-range="week">This Week</button>
  <button class="filter-btn {{ $range == 'month' ? 'active' : '' }}" data-range="month">This Month</button>
  <button class="filter-btn {{ $range == 'quarter' ? 'active' : '' }}" data-range="quarter">This Quarter</button>
  <button class="filter-btn {{ $range == 'year' ? 'active' : '' }}" data-range="year">This Year</button>
  <button class="filter-btn {{ $range == 'all' ? 'active' : '' }}" data-range="all">All Time</button>
</div>

<div class="row mb-4">
  <div class="col-md-3 mb-4">
      <div class="stat-card">
          <div class="card-body">
              <div class="stat-icon" style="background-color: rgba(67, 97, 238, 0.1); color: #4361ee;">
                  <i class="fas fa-dollar-sign"></i>
              </div>
              <div class="stat-content">
                  <div class="stat-title">Total Sales</div>
                  <div class="stat-value">${{ number_format($totalSales, 2) }}</div>
                  <div class="stat-change {{ $salesChange >= 0 ? 'change-up' : 'change-down' }}">
                      <i class="fas fa-arrow-{{ $salesChange >= 0 ? 'up' : 'down' }}"></i> {{ abs($salesChange) }}% from last {{ $range == 'today' ? 'day' : ($range == 'week' ? 'week' : ($range == 'month' ? 'month' : ($range == 'quarter' ? 'quarter' : 'year'))) }}
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="col-md-3 mb-4">
      <div class="stat-card">
          <div class="card-body">
              <div class="stat-icon" style="background-color: rgba(40, 167, 69, 0.1); color: #28a745;">
                  <i class="fas fa-shopping-cart"></i>
              </div>
              <div class="stat-content">
                  <div class="stat-title">Total Orders</div>
                  <div class="stat-value">{{ number_format($totalOrders) }}</div>
                  <div class="stat-change {{ $ordersChange >= 0 ? 'change-up' : 'change-down' }}">
                      <i class="fas fa-arrow-{{ $ordersChange >= 0 ? 'up' : 'down' }}"></i> {{ abs($ordersChange) }}% from last {{ $range == 'today' ? 'day' : ($range == 'week' ? 'week' : ($range == 'month' ? 'month' : ($range == 'quarter' ? 'quarter' : 'year'))) }}
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="col-md-3 mb-4">
      <div class="stat-card">
          <div class="card-body">
              <div class="stat-icon" style="background-color: rgba(255, 193, 7, 0.1); color: #ffc107;">
                  <i class="fas fa-box"></i>
              </div>
              <div class="stat-content">
                  <div class="stat-title">Active Products</div>
                  <div class="stat-value">{{ number_format($activeProducts) }}</div>
                  <div class="stat-change {{ $productsChange >= 0 ? 'change-up' : 'change-down' }}">
                      <i class="fas fa-arrow-{{ $productsChange >= 0 ? 'up' : 'down' }}"></i> {{ abs($productsChange) }}% from last {{ $range == 'today' ? 'day' : ($range == 'week' ? 'week' : ($range == 'month' ? 'month' : ($range == 'quarter' ? 'quarter' : 'year'))) }}
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="col-md-3 mb-4">
      <div class="stat-card">
          <div class="card-body">
              <div class="stat-icon" style="background-color: rgba(220, 53, 69, 0.1); color: #dc3545;">
                  <i class="fas fa-users"></i>
              </div>
              <div class="stat-content">
                  <div class="stat-title">New Customers</div>
                  <div class="stat-value">{{ number_format($newCustomers) }}</div>
                  <div class="stat-change {{ $customersChange >= 0 ? 'change-up' : 'change-down' }}">
                      <i class="fas fa-arrow-{{ $customersChange >= 0 ? 'up' : 'down' }}"></i> {{ abs($customersChange) }}% from last {{ $range == 'today' ? 'day' : ($range == 'week' ? 'week' : ($range == 'month' ? 'month' : ($range == 'quarter' ? 'quarter' : 'year'))) }}
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>

<div class="row mb-4">
  <div class="col-md-8 mb-4">
      <div class="card">
          <div class="card-header">
              <h5 class="card-title mb-0">Sales Overview</h5>
          </div>
          <div class="card-body">
              <div class="chart-container">
                  <canvas id="salesChart"></canvas>
              </div>
          </div>
      </div>
  </div>
  <div class="col-md-4 mb-4">
      <div class="card">
          <div class="card-header">
              <h5 class="card-title mb-0">Sales Distribution</h5>
          </div>
          <div class="card-body">
              <div class="chart-container">
                  <canvas id="distributionChart"></canvas>
              </div>
          </div>
      </div>
  </div>
</div>

<div class="row mb-4">
  <div class="col-md-6 mb-4">
      <div class="card">
          <div class="card-header">
              <h5 class="card-title mb-0">Top Selling Products</h5>
          </div>
          <div class="card-body">
              @if($topProducts->count() > 0)
                  @php
                      $maxRevenue = $topProducts->max('total_revenue');
                  @endphp
                  @foreach($topProducts as $product)
                  <div class="top-product-item">
                      <div class="product-img">
                          @if($product->images && is_array($product->images) && count($product->images) > 0)
                              <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px;">
                          @else
                              <i class="fas fa-box"></i>
                          @endif
                      </div>
                      <div class="product-info">
                          <div class="product-name">{{ $product->name }}</div>
                          <div class="product-stats">{{ $product->total_sold }} sold • ${{ number_format($product->total_revenue, 2) }} revenue</div>
                          <div class="progress-bar-container">
                              <div class="progress-bar" style="width: {{ $maxRevenue > 0 ? ($product->total_revenue / $maxRevenue) * 100 : 0 }}%; background-color: #4361ee;"></div>
                          </div>
                      </div>
                      <div class="product-sales">{{ $maxRevenue > 0 ? round(($product->total_revenue / $maxRevenue) * 100) : 0 }}%</div>
                  </div>
                  @endforeach
              @else
                  <div class="text-center py-4">
                      <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                      <p class="text-muted">No sales data available for the selected period.</p>
                  </div>
              @endif
          </div>
      </div>
  </div>
  <div class="col-md-6 mb-4">
      <div class="card">
          <div class="card-header">
              <h5 class="card-title mb-0">Recent Activities</h5>
          </div>
          <div class="card-body">
              @if($recentActivities->count() > 0)
                  @foreach($recentActivities as $activity)
                  <div class="recent-activity-item">
                      <div class="activity-icon" style="background-color: {{ $activity['icon_bg'] }}; color: {{ $activity['icon_color'] }};">
                          <i class="{{ $activity['icon'] }}"></i>
                      </div>
                      <div class="activity-content">
                          <div class="activity-title">{{ $activity['title'] }}</div>
                          <div class="activity-time">{{ $activity['time'] }}</div>
                      </div>
                  </div>
                  @endforeach
              @else
                  <div class="text-center py-4">
                      <i class="fas fa-history fa-3x text-muted mb-3"></i>
                      <p class="text-muted">No recent activities to display.</p>
                  </div>
              @endif
          </div>
      </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
      <div class="card">
          <div class="card-header">
              <h5 class="card-title mb-0">Monthly Revenue Trend</h5>
          </div>
          <div class="card-body">
              <div class="chart-container">
                  <canvas id="revenueChart"></canvas>
              </div>
          </div>
      </div>
  </div>
</div>
@include('seller.js.charts')
@endsection