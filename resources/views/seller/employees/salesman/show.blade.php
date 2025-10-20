@extends('seller.layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Salesman Details: {{ $salesman->name }}</h2>
        <div class="d-flex">
            {{-- Edit Button --}}
            <a href="{{ route('seller.employees.salesman.edit', $salesman) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit me-2"></i> Edit Salesman
            </a>
            
            {{-- Back Button --}}
            <a href="{{ route('seller.employees.salesman.index') }}" class="btn btn-secondary">
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
                    @if ($salesman->avatar)
                        <img src="{{ asset('storage/' . $salesman->avatar) }}" alt="{{ $salesman->name }}'s Avatar" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <i class="fas fa-user-circle fa-8x text-muted mb-3"></i>
                    @endif
                    <h4 class="mb-0">{{ $salesman->name }}</h4>
                    <p class="text-muted">{{ $salesman->designation ?? 'Salesman' }}</p>
                    @php
                        $statusClass = $salesman->status == 'active' ? 'bg-success' : 'bg-danger';
                    @endphp
                    <span class="badge {{ $statusClass }} text-white">{{ ucfirst($salesman->status) }}</span>
                </div>

                {{-- Details Column --}}
                <div class="col-md-8">
                    <h4 class="mb-4 text-primary">Account and Employment Information</h4>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">Full Name</p>
                            <p class="lead fw-bold">{{ $salesman->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">Email</p>
                            <p class="lead fw-bold">{{ $salesman->email }}</p>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">Phone</p>
                            <p class="lead">{{ $salesman->phone ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">Salary</p>
                            <p class="lead">{{ $salesman->salary ? number_format($salesman->salary, 2) : 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">Joining Date</p>
                            <p class="lead">{{ $salesman->joining_date ? \Carbon\Carbon::parse($salesman->joining_date)->format('M d, Y') : 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">Employee ID</p>
                            <p class="lead">SAL-{{ str_pad($salesman->id, 4, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection