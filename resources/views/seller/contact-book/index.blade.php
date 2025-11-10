@extends('seller.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="fas fa-address-book me-2"></i>Contact Book</h2>
            <p class="text-muted mb-0">Manage your buyers and team members</p>
        </div>
        <div class="d-flex gap-2">
            <form method="GET" class="d-flex">
                <input type="text" name="search" class="form-control" placeholder="Search contacts..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary ms-2">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Buyers</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $buyers->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Salesmen</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $salesmen->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Accountants</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $accountants->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calculator fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Warehouse</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $warehouse->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-warehouse fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs mb-4" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'buyers' ? 'active' : '' }}" href="?tab=buyers">
                <i class="fas fa-shopping-cart me-1"></i> Buyers ({{ $buyers->count() }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'team' ? 'active' : '' }}" href="?tab=team">
                <i class="fas fa-users me-1"></i> Team Members
            </a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content">
        <!-- Buyers Tab -->
        @if($activeTab == 'buyers')
        <div class="row">
            @forelse($buyers as $buyer)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar-circle bg-primary text-white me-3">
                                {{ strtoupper(substr($buyer->name, 0, 2)) }}
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-0">{{ $buyer->name }}</h5>
                                <small class="text-muted">{{ $buyer->email }}</small>
                            </div>
                        </div>
                        
                        <!-- Customer Contact Details -->
                        @if($buyer->contacts && $buyer->contacts->count() > 0)
                            <div class="mb-3">
                                <h6 class="text-muted mb-2"><i class="fas fa-address-card me-1"></i>Contact Persons:</h6>
                                @foreach($buyer->contacts->take(2) as $contact)
                                <div class="mb-2 p-2 bg-light rounded">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <strong class="text-primary">{{ $contact->name }}</strong>
                                            @if($contact->location_type)
                                                <span class="badge badge-sm bg-secondary ms-1">{{ $contact->location_type }}</span>
                                            @endif
                                            <br>
                                            @if($contact->mobile)
                                                <small><i class="fas fa-phone text-muted me-1"></i>{{ $contact->mobile }}</small><br>
                                            @endif
                                            @if($contact->email)
                                                <small><i class="fas fa-envelope text-muted me-1"></i>{{ $contact->email }}</small><br>
                                            @endif
                                            @if($contact->address)
                                                <small><i class="fas fa-map-marker-alt text-muted me-1"></i>{{ $contact->city }}, {{ $contact->state }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @if($buyer->contacts->count() > 2)
                                    <small class="text-muted">+{{ $buyer->contacts->count() - 2 }} more contacts</small>
                                @endif
                            </div>
                        @else
                            @if($buyer->phone)
                            <p class="mb-2"><i class="fas fa-phone text-muted me-2"></i>{{ $buyer->phone }}</p>
                            @endif
                        @endif
                        
                        <div class="mb-3">
                            <span class="badge bg-info">{{ $buyer->orders->count() }} Orders</span>
                            @if($buyer->contacts && $buyer->contacts->count() > 0)
                                <span class="badge bg-secondary">{{ $buyer->contacts->count() }} Contacts</span>
                            @endif
                        </div>

                        <!-- Quick Actions -->
                        <div class="d-flex gap-2">
                            @php
                                $primaryContact = $buyer->contacts->first();
                                $phoneNumber = $primaryContact->mobile ?? $buyer->phone;
                            @endphp
                            @if($phoneNumber)
                            <a href="tel:{{ $phoneNumber }}" class="btn btn-sm btn-outline-success flex-fill" title="Call {{ $primaryContact->name ?? 'Customer' }}">
                                <i class="fas fa-phone"></i> Call
                            </a>
                            @else
                            <button class="btn btn-sm btn-outline-secondary flex-fill" disabled title="No phone">
                                <i class="fas fa-phone"></i> Call
                            </button>
                            @endif
                            <a href="{{ route('seller.meetings.index') }}" class="btn btn-sm btn-outline-primary flex-fill" title="Video Meeting">
                                <i class="fas fa-video"></i> Meet
                            </a>
                            <a href="{{ route('seller.chat.index') }}" class="btn btn-sm btn-outline-info flex-fill" title="Chat">
                                <i class="fas fa-comments"></i> Chat
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>No buyers found. Buyers will appear here when they place orders or send inquiries.
                </div>
            </div>
            @endforelse
        </div>
        @endif

        <!-- Team Members Tab -->
        @if($activeTab == 'team')
        <div class="row">
            <!-- Salesmen -->
            <div class="col-12 mb-4">
                <h4 class="mb-3"><i class="fas fa-user-tie me-2"></i>Salesmen</h4>
                <div class="row">
                    @forelse($salesmen as $salesman)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar-circle bg-success text-white me-3">
                                        {{ strtoupper(substr($salesman->user->name, 0, 2)) }}
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{ $salesman->user->name }}</h6>
                                        <small class="text-muted">{{ $salesman->email }}</small>
                                    </div>
                                </div>
                                <p class="mb-2"><i class="fas fa-phone text-muted me-2"></i>{{ $salesman->phone }}</p>
                                <div class="d-flex gap-2">
                                    <a href="tel:{{ $salesman->phone }}" class="btn btn-sm btn-outline-success flex-fill">
                                        <i class="fas fa-phone"></i> Call
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-primary flex-fill">
                                        <i class="fas fa-video"></i> Meet
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-info flex-fill">
                                        <i class="fas fa-comments"></i> Chat
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <p class="text-muted">No salesmen added yet.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Accountants -->
            <div class="col-12 mb-4">
                <h4 class="mb-3"><i class="fas fa-calculator me-2"></i>Accountants</h4>
                <div class="row">
                    @forelse($accountants as $accountant)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar-circle bg-info text-white me-3">
                                        {{ strtoupper(substr($accountant->user->name, 0, 2)) }}
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{ $accountant->user->name }}</h6>
                                        <small class="text-muted">{{ $accountant->email }}</small>
                                    </div>
                                </div>
                                <p class="mb-2"><i class="fas fa-phone text-muted me-2"></i>{{ $accountant->phone }}</p>
                                <div class="d-flex gap-2">
                                    <a href="tel:{{ $accountant->phone }}" class="btn btn-sm btn-outline-success flex-fill">
                                        <i class="fas fa-phone"></i> Call
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-primary flex-fill">
                                        <i class="fas fa-video"></i> Meet
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-info flex-fill">
                                        <i class="fas fa-comments"></i> Chat
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <p class="text-muted">No accountants added yet.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Warehouse Staff -->
            <div class="col-12 mb-4">
                <h4 class="mb-3"><i class="fas fa-warehouse me-2"></i>Warehouse Staff</h4>
                <div class="row">
                    @forelse($warehouse as $staff)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar-circle bg-warning text-white me-3">
                                        {{ strtoupper(substr($staff->user->name, 0, 2)) }}
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{ $staff->user->name }}</h6>
                                        <small class="text-muted">{{ $staff->email }}</small>
                                    </div>
                                </div>
                                <p class="mb-2"><i class="fas fa-phone text-muted me-2"></i>{{ $staff->phone }}</p>
                                <div class="d-flex gap-2">
                                    <a href="tel:{{ $staff->phone }}" class="btn btn-sm btn-outline-success flex-fill">
                                        <i class="fas fa-phone"></i> Call
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-primary flex-fill">
                                        <i class="fas fa-video"></i> Meet
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-info flex-fill">
                                        <i class="fas fa-comments"></i> Chat
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <p class="text-muted">No warehouse staff added yet.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Delivery Personnel -->
            <div class="col-12 mb-4">
                <h4 class="mb-3"><i class="fas fa-truck me-2"></i>Delivery Personnel</h4>
                <div class="row">
                    @forelse($delivery as $person)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar-circle bg-danger text-white me-3">
                                        {{ strtoupper(substr($person->user->name, 0, 2)) }}
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{ $person->user->name }}</h6>
                                        <small class="text-muted">{{ $person->email }}</small>
                                    </div>
                                </div>
                                <p class="mb-2"><i class="fas fa-phone text-muted me-2"></i>{{ $person->phone }}</p>
                                <div class="d-flex gap-2">
                                    <a href="tel:{{ $person->phone }}" class="btn btn-sm btn-outline-success flex-fill">
                                        <i class="fas fa-phone"></i> Call
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-primary flex-fill">
                                        <i class="fas fa-video"></i> Meet
                                    </a>
                                    <a href="#" class="btn btn-sm btn-outline-info flex-fill">
                                        <i class="fas fa-comments"></i> Chat
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <p class="text-muted">No delivery personnel added yet.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        @endif
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

.border-left-primary {
    border-left: 4px solid #4e73df !important;
}

.border-left-success {
    border-left: 4px solid #1cc88a !important;
}

.border-left-info {
    border-left: 4px solid #36b9cc !important;
}

.border-left-warning {
    border-left: 4px solid #f6c23e !important;
}
</style>
@endsection
