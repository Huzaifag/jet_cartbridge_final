@extends('seller.layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Accountant Details: {{ $accountant->name }}</h2>
        <div class="d-flex">
            {{-- Edit Button (Assuming an edit route exists) --}}
            <a href="{{ route('seller.employees.accountant.edit', $accountant) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit me-2"></i> Edit Accountant
            </a>
            
            {{-- Back Button --}}
            <a href="{{ route('seller.employees.accountant.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Back to List
            </a>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                {{-- Profile Picture Column --}}
                <div class="col-md-4 text-center border-end">
                    <h5 class="text-primary mb-3">Profile</h5>
                    @if ($accountant->avatar)
                        <img src="{{ asset('storage/' . $accountant->avatar) }}" alt="{{ $accountant->name }}'s Avatar" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <i class="fas fa-user-circle fa-8x text-muted mb-3"></i>
                    @endif
                    <h4 class="mb-0">{{ $accountant->name }}</h4>
                    <p class="text-muted">{{ $accountant->designation }}</p>
                    @php
                        $statusClass = $accountant->status == 'active' ? 'bg-success' : 'bg-danger';
                    @endphp
                    <span class="badge {{ $statusClass }} text-white">{{ ucfirst($accountant->status) }}</span>
                </div>

                {{-- Details Column --}}
                <div class="col-md-8">
                    <h4 class="mb-4 text-primary">Account and Employment Information</h4>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">Username</p>
                            <p class="lead fw-bold">{{ $accountant->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">Email</p>
                            <p class="lead fw-bold">{{ $accountant->email }}</p>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">Phone</p>
                            <p class="lead">{{ $accountant->phone ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">Salary</p>
                            <p class="lead">{{ number_format($accountant->salary, 2) ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">Joining Date</p>
                            <p class="lead">{{ $accountant->joining_date ? \Carbon\Carbon::parse($accountant->joining_date)->format('M d, Y') : 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">Employee ID (Example)</p>
                            <p class="lead">ACC-{{ str_pad($accountant->id, 4, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection