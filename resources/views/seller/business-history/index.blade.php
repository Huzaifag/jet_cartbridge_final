@extends('seller.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="fas fa-history me-2"></i>Business History</h2>
            <p class="text-muted mb-0">View complete interaction history with your customers</p>
        </div>
    </div>

    <!-- Customers List -->
    <div class="row">
        @forelse($customers as $customer)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm hover-card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar-circle bg-primary text-white me-3">
                            {{ strtoupper(substr($customer->name, 0, 2)) }}
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-0">{{ $customer->name }}</h5>
                            <small class="text-muted">{{ $customer->email }}</small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <span class="badge bg-info me-1">{{ $customer->orders_count }} Orders</span>
                    </div>

                    <a href="{{ route('seller.business-history.show', $customer->id) }}" class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-eye me-1"></i> View History
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle me-2"></i>No customer history available yet.
            </div>
        </div>
        @endforelse
    </div>
</div>

<style>
.avatar-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.2rem;
}

.hover-card {
    transition: transform 0.2s;
}

.hover-card:hover {
    transform: translateY(-5px);
}
</style>
@endsection
