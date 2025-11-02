@extends('deliveryman.layouts.app')
@section('title', 'Mark Order #' . $order->id . ' as Delivered')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Mark Order #{{ $order->id }} as Delivered</h1>
        <a href="{{ route('deliveryman.orders.show', $order) }}" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Order Details
        </a>
    </div>

    {{-- Order Status Alert --}}
    @php
        $statusClass = match ($order->status) {
            'Order Placed' => 'info',
            'Processing', 'Confirmed' => 'warning',
            'Invoiced', 'Shipped' => 'primary',
            'Delivered' => 'success',
            'Cancelled' => 'danger',
            default => 'secondary'
        };
    @endphp
    <div class="alert alert-{{ $statusClass }} shadow-sm mb-4" role="alert">
        <h4 class="alert-heading">Current Status: {{ $order->status }}</h4>
        <p class="mb-0">
            Payment Status: <strong>{{ ucwords($order->payment_status) }}</strong> via
            <strong>{{ strtoupper($order->payment_method) }}</strong>
        </p>
    </div>

    <div class="row">
        {{-- Left Column: Order Summary --}}
        <div class="col-xl-4 col-lg-5">
            {{-- Order Summary --}}
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Order Summary</h6>
                </div>
                <div class="card-body">
                    <p><strong>Order ID:</strong> #{{ $order->id }}</p>
                    <p><strong>Total Amount:</strong> ${{ number_format($order->total, 2) }}</p>
                    <p><strong>Placed On:</strong>
                        {{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y h:i A') }}</p>
                    <p><strong>Last Updated:</strong> {{ \Carbon\Carbon::parse($order->updated_at)->diffForHumans() }}
                    </p>
                    @if ($order->referral_code)
                        <p><strong>Referral Code:</strong> {{ $order->referral_code }}</p>
                    @endif
                    <p><strong>Notes:</strong> {{ $order->notes ?: 'N/A' }}</p>
                </div>
            </div>

            {{-- Customer Details --}}
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Customer Details</h6>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $order->customer->name ?? 'N/A' }}</p>
                    <p><strong>Email:</strong> <a
                            href="mailto:{{ $order->customer->email }}">{{ $order->customer->email }}</a></p>
                    <p><strong>User Role:</strong> {{ strtoupper($order->customer->role ?? 'customer') }}</p>
                    <p><strong>Customer Since:</strong>
                        {{ \Carbon\Carbon::parse($order->customer->created_at)->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Right Column: Delivery Form --}}
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header bg-success text-white py-3">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-check me-2"></i> Delivery Confirmation
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('deliveryman.orders.deliver', $order->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Delivery Date</label>
                                <input type="date" name="delivery_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Delivery Time</label>
                                <input type="time" name="delivery_time" class="form-control" value="{{ date('H:i') }}" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Upload Proof of Delivery</label>
                            <input type="file" name="proof_of_delivery" class="form-control" accept="image/*" required>
                            <div class="form-text text-muted">Upload a photo showing successful delivery (JPG, PNG, Max 2MB)</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Delivery Notes</label>
                            <textarea name="delivery_notes" class="form-control" rows="3" placeholder="Any additional notes about the delivery"></textarea>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('deliveryman.orders.show', $order) }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check me-1"></i> Confirm Delivery
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
