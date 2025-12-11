@extends('admin.layouts.app')

@section('page-title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="welcome-card">
                <h2>Welcome back, {{ auth()->user()->name }}!</h2>
                <p class="text-muted">Here's what's happening with your business today.</p>
                @if(isset($userRole))
                    <span class="badge bg-primary">{{ ucfirst($userRole) }} Dashboard</span>
                @endif
            </div>
        </div>
    </div>

    @if($userRole === 'seller')
        @include('admin.dashboard.partials.seller-dashboard')
    @elseif($userRole === 'accountant')
        @include('admin.dashboard.partials.accountant-dashboard')
    @elseif($userRole === 'manufacturer')
        @include('admin.dashboard.partials.manufacturer-dashboard')
    @elseif($userRole === 'salesman')
        @include('admin.dashboard.partials.salesman-dashboard')
    @elseif($userRole === 'warehouse')
        @include('admin.dashboard.partials.warehouse-dashboard')
    @elseif($userRole === 'deliveryman')
        @include('admin.dashboard.partials.deliveryman-dashboard')
    @else
        @include('admin.dashboard.partials.default-dashboard')
    @endif

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if(auth()->user()->seller)
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('seller.products.create') }}" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-plus me-2"></i>Add Product
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('seller.orders.index') }}" class="btn btn-outline-success w-100">
                                    <i class="fas fa-shopping-cart me-2"></i>View Orders
                                </a>
                            </div>
                        @endif

                        @if(auth()->user()->accountant)
                            <div class="col-md-3 mb-3">
                                <a href="#" class="btn btn-outline-warning w-100">
                                    <i class="fas fa-file-invoice me-2"></i>Create Invoice
                                </a>
                            </div>
                        @endif

                        @if(auth()->user()->manufacturer)
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('manufacturer.products.create') }}" class="btn btn-outline-info w-100">
                                    <i class="fas fa-industry me-2"></i>Add Product
                                </a>
                            </div>
                        @endif

                        <div class="col-md-3 mb-3">
                            <a href="#" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-envelope me-2"></i>Messages
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection