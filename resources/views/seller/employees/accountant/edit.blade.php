@extends('seller.layouts.app')

@section('content')
<div class="container py-4">
    @include('components.toast')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Edit Accountant</h2>
        <a href="{{ route('seller.employees.accountant.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Back
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('seller.employees.accountant.update', $accountant) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- User Account Details Section --}}
                <h4 class="mb-3 text-primary">Account Credentials</h4>
                
                <div class="row">
                    {{-- Column 1: Username & Password --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" id="username" name="username" class="form-control" value="{{ old('username', $accountant->user->name ?? '') }}" required>
                            @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password <span class="text-muted">(Leave blank to keep current)</span></label>
                            <input type="password" id="password" name="password" class="form-control">
                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    {{-- Column 2: Email & Confirm Password --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $accountant->email ?? '') }}" required>
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                        </div>
                    </div>
                </div>
                
                <hr>

                {{-- Personal & Employee Details Section --}}
                <h4 class="mb-3 text-primary">Personal and Job Details</h4>
                
                <div class="row">
                    {{-- Column 1: Name, Phone --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $accountant->name ?? '') }}" required>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $accountant->phone ?? '') }}">
                            @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    {{-- Column 2: Designation, Salary --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="designation" class="form-label">Designation</label>
                            <select id="designation" name="designation" class="form-select">
                                <option value="Accountant" {{ (old('designation', $accountant->designation) == 'Accountant') ? 'selected' : '' }}>Accountant</option>
                                <option value="Senior Accountant" {{ (old('designation', $accountant->designation) == 'Senior Accountant') ? 'selected' : '' }}>Senior Accountant</option>
                                <option value="Finance Manager" {{ (old('designation', $accountant->designation) == 'Finance Manager') ? 'selected' : '' }}>Finance Manager</option>
                            </select>
                            @error('designation') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="salary" class="form-label">Salary</label>
                            <input type="number" step="0.01" id="salary" name="salary" class="form-control" value="{{ old('salary', $accountant->salary ?? '') }}">
                            @error('salary') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>

                {{-- Row 3: Joining Date, Status, and Avatar --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="joining_date" class="form-label">Joining Date</label>
                            <input type="date" id="joining_date" name="joining_date" class="form-control" value="{{ old('joining_date', $accountant->joining_date ? \Carbon\Carbon::parse($accountant->joining_date)->format('Y-m-d') : '') }}">
                            @error('joining_date') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select id="status" name="status" class="form-select" required>
                                <option value="active" {{ (old('status', $accountant->status) == 'active') ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ (old('status', $accountant->status) == 'inactive') ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="avatar" class="form-label">Profile Picture</label>
                            <input type="file" id="avatar" name="avatar" class="form-control">
                            @error('avatar') <small class="text-danger">{{ $message }}</small> @enderror

                            @if($accountant->avatar)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $accountant->avatar) }}" alt="Avatar" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Update Accountant
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection