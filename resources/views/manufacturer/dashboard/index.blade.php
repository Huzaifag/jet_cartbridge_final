@extends('manufacturer.layouts.app')
@section('content')
<div class="dashboard-header">
  <div class="welcome-message">
      <h1>Manufacturer Dashboard</h1>
      <p>Welcome back! Here's what's happening with your business today.</p>
  </div>
  <div class="date-display">
      <i class="fas fa-calendar-alt"></i>
      <span id="current-date">{{ date('F j, Y') }}</span>
  </div>
</div>

<div class="filter-options">
  <button class="filter-btn active" data-range="today">Today</button>
  <button class="filter-btn" data-range="week">This Week</button>
  <button class="filter-btn" data-range="month">This Month</button>
  <button class="filter-btn" data-range="quarter">This Quarter</button>
  <button class="filter-btn" data-range="year">This Year</button>
  <button class="filter-btn" data-range="all">All Time</button>
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
                  <div class="stat-value">$12,845</div>
                  <div class="stat-change change-up">
                      <i class="fas fa-arrow-up"></i> 24.5% from last week
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
                  <div class="stat-value">1,258</div>
                  <div class="stat-change change-up">
                      <i class="fas fa-arrow-up"></i> 12.3% from last week
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
                  <div class="stat-value">186</div>
                  <div class="stat-change change-up">
                      <i class="fas fa-arrow-up"></i> 5.2% from last week
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
                  <div class="stat-value">64</div>
                  <div class="stat-change change-down">
                      <i class="fas fa-arrow-down"></i> 3.7% from last week
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
              <div class="top-product-item">
                  <div class="product-img">
                      <i class="fas fa-hamburger"></i>
                  </div>
                  <div class="product-info">
                      <div class="product-name">Premium Burger</div>
                      <div class="product-stats">128 sold • $2,458 revenue</div>
                      <div class="progress-bar-container">
                          <div class="progress-bar" style="width: 78%; background-color: #4361ee;"></div>
                      </div>
                  </div>
                  <div class="product-sales">78%</div>
              </div>
              <div class="top-product-item">
                  <div class="product-img">
                      <i class="fas fa-pizza-slice"></i>
                  </div>
                  <div class="product-info">
                      <div class="product-name">Special Pizza</div>
                      <div class="product-stats">96 sold • $1,845 revenue</div>
                      <div class="progress-bar-container">
                          <div class="progress-bar" style="width: 65%; background-color: #28a745;"></div>
                      </div>
                  </div>
                  <div class="product-sales">65%</div>
              </div>
              <div class="top-product-item">
                  <div class="product-img">
                      <i class="fas fa-ice-cream"></i>
                  </div>
                  <div class="product-info">
                      <div class="product-name">Deluxe Ice Cream</div>
                      <div class="product-stats">74 sold • $985 revenue</div>
                      <div class="progress-bar-container">
                          <div class="progress-bar" style="width: 52%; background-color: #ffc107;"></div>
                      </div>
                  </div>
                  <div class="product-sales">52%</div>
              </div>
              <div class="top-product-item">
                  <div class="product-img">
                      <i class="fas fa-coffee"></i>
                  </div>
                  <div class="product-info">
                      <div class="product-name">Premium Coffee</div>
                      <div class="product-stats">58 sold • $756 revenue</div>
                      <div class="progress-bar-container">
                          <div class="progress-bar" style="width: 45%; background-color: #dc3545;"></div>
                      </div>
                  </div>
                  <div class="product-sales">45%</div>
              </div>
              <div class="top-product-item">
                  <div class="product-img">
                      <i class="fas fa-cookie"></i>
                  </div>
                  <div class="product-info">
                      <div class="product-name">Gourmet Cookies</div>
                      <div class="product-stats">42 sold • $525 revenue</div>
                      <div class="progress-bar-container">
                          <div class="progress-bar" style="width: 38%; background-color: #6f42c1;"></div>
                      </div>
                  </div>
                  <div class="product-sales">38%</div>
              </div>
          </div>
      </div>
  </div>
  <div class="col-md-6 mb-4">
      <div class="card">
          <div class="card-header">
              <h5 class="card-title mb-0">Recent Activities</h5>
          </div>
          <div class="card-body">
              <div class="recent-activity-item">
                  <div class="activity-icon" style="background-color: rgba(40, 167, 69, 0.1); color: #28a745;">
                      <i class="fas fa-shopping-cart"></i>
                  </div>
                  <div class="activity-content">
                      <div class="activity-title">New order #ORD-2589 received</div>
                      <div class="activity-time">2 minutes ago</div>
                  </div>
              </div>
              <div class="recent-activity-item">
                  <div class="activity-icon" style="background-color: rgba(67, 97, 238, 0.1); color: #4361ee;">
                      <i class="fas fa-box"></i>
                  </div>
                  <div class="activity-content">
                      <div class="activity-title">Product "Special Pizza" stock is low</div>
                      <div class="activity-time">45 minutes ago</div>
                  </div>
              </div>
              <div class="recent-activity-item">
                  <div class="activity-icon" style="background-color: rgba(255, 193, 7, 0.1); color: #ffc107;">
                      <i class="fas fa-star"></i>
                  </div>
                  <div class="activity-content">
                      <div class="activity-title">New 5-star review from customer John D.</div>
                      <div class="activity-time">1 hour ago</div>
                  </div>
              </div>
              <div class="recent-activity-item">
                  <div class="activity-icon" style="background-color: rgba(108, 117, 125, 0.1); color: #6c757d;">
                      <i class="fas fa-truck"></i>
                  </div>
                  <div class="activity-content">
                      <div class="activity-title">Order #ORD-2583 has been delivered</div>
                      <div class="activity-time">2 hours ago</div>
                  </div>
              </div>
              <div class="recent-activity-item">
                  <div class="activity-icon" style="background-color: rgba(23, 162, 184, 0.1); color: #17a2b8;">
                      <i class="fas fa-user-plus"></i>
                  </div>
                  <div class="activity-content">
                      <div class="activity-title">New customer registration</div>
                      <div class="activity-time">5 hours ago</div>
                  </div>
              </div>
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
