@extends('seller.layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">My Accountants</h2>
            <div>
                <a href="{{ route('seller.employees.accountant.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Accountant
                </a>
            </div>
        </div>
        <x-alert type="success" :message="session('success')" />
        <x-alert type="danger" :message="session('error')" />

        <!-- ✅ Filters & Search -->
        <form method="GET" action="{{ route('seller.employees.accountant.index') }}" class="row g-2 mb-4">
            <div class="col-md-4">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                    placeholder="Search by name, email or phone...">
            </div>
            <div class="col-md-3">
                <select name="designation" class="form-select">
                    <option value="">All Designations</option>
                    <option value="Accountant" {{ request('designation') == 'Accountant' ? 'selected' : '' }}>Accountant
                    </option>
                    <option value="Senior Accountant" {{ request('designation') == 'Senior Accountant' ? 'selected' : '' }}>
                        Senior Accountant</option>
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

        @if ($accountants->count() > 0)
            <div class="row g-4">
                @foreach ($accountants as $accountant)
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body text-center">
                                <!-- Avatar -->
                                @if ($accountant->avatar)
                                    <img src="{{ asset('storage/' . $accountant->avatar) }}" alt="{{ $accountant->name }}"
                                        class="rounded-circle mb-3" style="width:100px; height:100px; object-fit:cover;">
                                @else
                                    <div class="d-flex align-items-center justify-content-center rounded-circle bg-light mb-3"
                                        style="width:100px; height:100px;">
                                        <i class="fas fa-user fa-2x text-muted"></i>
                                    </div>
                                @endif

                                <!-- Info -->
                                <h5 class="card-title mb-1">{{ $accountant->name }}</h5>
                                <p class="text-muted mb-2">{{ $accountant->designation ?? 'Accountant' }}</p>
                                <p class="mb-1"><i class="fas fa-envelope me-2"></i>{{ $accountant->email }}</p>
                                <p class="mb-1"><i class="fas fa-phone me-2"></i>{{ $accountant->phone ?? 'N/A' }}</p>
                                <p class="mb-1"><i
                                        class="fas fa-dollar-sign me-2"></i>{{ $accountant->salary ? number_format($accountant->salary, 2) : 'Not set' }}
                                </p>
                                <p class="text-muted"><i class="fas fa-calendar-alt me-2"></i>Joined:
                                    {{ $accountant->joining_date ? \Carbon\Carbon::parse($accountant->joining_date)->format('M d, Y') : 'N/A' }}
                                </p>

                                <!-- Actions -->
                                <div class="d-flex justify-content-center gap-2 mt-3">
                                    <a href="{{ route('seller.employees.accountant.show', $accountant->id) }}"
                                        class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> Show
                                    </a>

                                    <a href="{{ route('seller.employees.accountant.edit', $accountant->id) }}"
                                        class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    <form action="{{ route('seller.employees.accountant.destroy', $accountant->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure?')">
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
                {{ $accountants->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-user-tie fa-3x text-muted mb-3"></i>
                <h4>No Accountants Found</h4>
                <p class="text-muted">Try adjusting your filters or search.</p>
            </div>
        @endif
    </div>
@endsection