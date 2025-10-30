@extends('warehouse.layouts.app')
@section('title', 'Dispatch Order #' . $order->id)

@section('content')
<div class="container py-4">
    <h4 class="mb-4">
        <i class="fas fa-truck me-2"></i> Dispatch Order #{{ $order->id }}
    </h4>

    <form action="{{ route('warehouse.orders.dispatch', $order->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="courier_name" class="form-label fw-bold">Courier Name</label>
            <input type="text" 
                   id="courier_name" 
                   name="courier_name" 
                   class="form-control @error('courier_name') is-invalid @enderror" 
                   placeholder="e.g. TCS, Leopard, DHL" 
                   value="{{ old('courier_name') }}" 
                   required>
            @error('courier_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="tracking_number" class="form-label fw-bold">Tracking Number</label>
            <input type="text" 
                   id="tracking_number" 
                   name="tracking_number" 
                   class="form-control @error('tracking_number') is-invalid @enderror" 
                   placeholder="Enter tracking number" 
                   value="{{ old('tracking_number') }}" 
                   required>
            @error('tracking_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="dispatch_details" class="form-label fw-bold">Dispatch Details / Notes</label>
            <textarea id="dispatch_details" 
                      name="dispatch_details" 
                      class="form-control @error('dispatch_details') is-invalid @enderror" 
                      rows="3" 
                      placeholder="Any extra info (e.g. fragile, COD, special handling)">{{ old('dispatch_details') }}</textarea>
            @error('dispatch_details')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="dispatch_video" class="form-label fw-bold">Upload Dispatch Video Proof</label>
            <input type="file" 
                   id="dispatch_video" 
                   name="dispatch_video" 
                   class="form-control @error('dispatch_video') is-invalid @enderror" 
                   accept="video/mp4,video/mov,video/avi" 
                   required>
            <div class="form-text text-muted">
                Allowed formats: MP4, MOV, AVI (Max file size: 20MB)
            </div>
            @error('dispatch_video')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex gap-2">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-paper-plane me-1"></i> Dispatch Now
            </button>
        </div>
    </form>
</div>
@endsection