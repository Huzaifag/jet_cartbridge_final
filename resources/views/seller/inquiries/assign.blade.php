@extends('seller.layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Assign Inquiry to Salesman</h2>
                    <p class="text-muted mb-0">Inquiry #{{ $inquiry->id }}</p>
                </div>
                <a href="{{ route('seller.inquiries.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Inquiries
                </a>
            </div>
            {{-- create new card --}}
            

            <!-- Inquiry Details Card -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Inquiry Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Customer</label>
                            <p class="fw-bold mb-0">{{ $inquiry->customer->name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Contact</label>
                            <p class="fw-bold mb-0">{{ $inquiry->contact->name ?? 'N/A' }}</p>
                            <small class="text-muted">{{ $inquiry->contact->phone ?? '' }}</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Product</label>
                            <p class="fw-bold mb-0">{{ $inquiry->product->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Quantity</label>
                            <p class="fw-bold mb-0">{{ number_format($inquiry->quantity) }} units</p>
                        </div>
                        @if($inquiry->target_price)
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Target Price</label>
                            <p class="fw-bold mb-0">${{ number_format($inquiry->target_price, 2) }}</p>
                        </div>
                        @endif
                        @if($inquiry->message)
                        <div class="col-12">
                            <label class="text-muted small">Message</label>
                            <p class="mb-0">{{ $inquiry->message }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Assignment Form Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Assign to Salesman</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('seller.inquiries.assign-salesman', $inquiry->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Select Salesman <span class="text-danger">*</span></label>
                            <select name="salesman_id" class="form-select form-select-lg" required>
                                <option value="">Choose a salesman...</option>
                                @foreach(auth()->user()->seller->salesmen as $salesman)
                                    <option value="{{ $salesman->id }}">
                                        {{ $salesman->user->name }} - {{ $salesman->email }}
                                    </option>
                                @endforeach
                            </select>
                            @error('salesman_id')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Notes for Salesman (Optional)</label>
                            <textarea name="notes" class="form-control" rows="4" placeholder="Add any important notes or instructions for the salesman..."></textarea>
                            <small class="text-muted">These notes will be visible to the assigned salesman.</small>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Note:</strong> This inquiry will appear as a high-priority lead in the salesman's dashboard. They will be able to view all customer details and manage the lead status.
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('seller.inquiries.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-check me-2"></i>Assign to Salesman
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
