@extends('seller.layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">My Delivery Men</h2>
            <div>
                <a href="{{ route('seller.employees.delivery.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Delivery Man
                </a>
            </div>
        </div>
        <x-alert type="success" :message="session('success')" />
        <x-alert type="danger" :message="session('error')" />

        <!-- ✅ Filters & Search -->
        <form method="GET" action="{{ route('seller.employees.delivery.index') }}" class="row g-2 mb-4">
            <div class="col-md-4">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                    placeholder="Search by name, email or phone...">
            </div>
            <div class="col-md-3">
                <select name="designation" class="form-select">
                    <option value="">All Designations</option>
                    <option value="delivery" {{ request('designation') == 'delivery' ? 'selected' : '' }}>delivery</option>
                    <option value="Senior delivery" {{ request('designation') == 'Senior delivery' ? 'selected' : '' }}>
                        Senior delivery</option>
                    <option value="Finance Manager" {{ request('designation') == 'Finance Manager' ? 'selected' : '' }}>
                        Finance Manager</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="sort" class="form-select">
                    <option value="">Sort By</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                    <option value="salary" {{ request('sort') == 'salary' ? 'selected' : '' }}>Salary</option>
                    <option value="joining_date" {{ request('sort') == 'joining_date' ? 'selected' : '' }}>Joining Date
                    </option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-dark w-100"><i class="fas fa-search me-1"></i>Filter</button>
            </div>
        </form>

        @if ($deliverymen->count() > 0)
            <div class="row g-4">
                @foreach ($deliverymen as $delivery)
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body text-center">
                                <!-- Avatar -->
                                @if ($delivery->avatar)
                                    <img src="{{ asset('storage/' . $delivery->avatar) }}" alt="{{ $delivery->name }}"
                                        class="rounded-circle mb-3" style="width:100px; height:100px; object-fit:cover;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center rounded-circle bg-light mb-3"
                                        style="width:100px; height:100px;">
                                        <i class="fas fa-user fa-2x text-muted"></i>
                                    </div>
                                @endif

                                <!-- Info -->
                                <h5 class="card-title mb-1">{{ $delivery->name }}</h5>
                                <p class="text-muted mb-2">{{ $delivery->designation ?? 'delivery' }}</p>
                                <p class="mb-1"><i class="fas fa-envelope me-2"></i>{{ $delivery->email }}</p>
                                <p class="mb-1"><i class="fas fa-phone me-2"></i>{{ $delivery->phone ?? 'N/A' }}</p>
                                <p class="mb-1"><i
                                        class="fas fa-dollar-sign me-2"></i>{{ $delivery->salary ? number_format($delivery->salary, 2) : 'Not set' }}
                                </p>
                                <p class="text-muted"><i class="fas fa-calendar-alt me-2"></i>Joined:
                                    {{ $delivery->joining_date ? \Carbon\Carbon::parse($delivery->joining_date)->format('M d, Y') : 'N/A' }}
                                </p>

                                <!-- Actions -->
                                <div class="d-flex justify-content-center gap-2 mt-3">
                                    <a href="{{ route('seller.employees.delivery.edit', $delivery->id) }}"
                                        class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('seller.employees.delivery.destroy', $delivery->id) }}"
                                        method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $deliverymen->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-user-tie fa-3x text-muted mb-3"></i>
                <h4>No Delivery Man Found</h4>
                <p class="text-muted">Try adjusting your filters or search.</p>
            </div>
        @endif
    </div>
@endsection
