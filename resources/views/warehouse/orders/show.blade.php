@extends('warehouse.layouts.app')
@section('title', 'Order Details #' . $order->id)

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Order Details - #{{ $order->id }}</h1>

            <div class="d-flex align-items-center gap-2">
                {{-- Create Invoice Button --}}
                @if ($order->status === 'Confirmed')
                    @role('accountant')
                    <form action="{{ route('accountant.confirmed-orders.invoincing', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success shadow-sm"
                            onclick="return confirm('Are you sure you want to create an invoice for this order? This action cannot be undone.')">
                            <i class="fas fa-file-invoice fa-sm text-white-50"></i> Create Invoice
                        </button>
                    </form>
                    @endrole
                @endif

                <a href="{{ route('accountant.confirmed-orders.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                    <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Orders
                </a>

                {{-- Dispatch Button --}}
                @if ($order->status === 'Invoiced')
                    @role('warehouse')
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#dispatchModal">
                        <i class="fas fa-truck"></i> Mark as Dispatched
                    </button>
                    @endrole
                @endif
            </div>
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
            {{-- Left Column: Summary & Customer --}}
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

            {{-- Right Column: Addresses, Timeline, and Dispatch (if applicable) --}}
            <div class="col-xl-8 col-lg-7">
                {{-- Dispatch Info (if dispatched) --}}
                @if ($order->status === 'Dispatched' || $order->dispatched_at)
                    <div class="card shadow mb-4">
                        <div class="card-header bg-success text-white py-3">
                            <h6 class="m-0 font-weight-bold">Dispatch Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p><strong>Courier Name:</strong> {{ $order->courier_name ?? 'N/A' }}</p>
                                    <p><strong>Tracking Number:</strong> {{ $order->tracking_number ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Dispatched At:</strong>
                                        {{ \Carbon\Carbon::parse($order->dispatched_at)->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>

                            @if ($order->dispatch_details)
                                <p><strong>Dispatch Notes:</strong></p>
                                <div class="bg-light p-3 rounded mb-3">
                                    {{ $order->dispatch_details }}
                                </div>
                            @endif

                            @if ($order->dispatch_video)
                                <p><strong>Dispatch Video Proof:</strong></p>
                                <video width="100%" height="auto" controls class="rounded shadow-sm">
                                    <source src="{{ asset('storage/' . $order->dispatch_video) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Shipping & Billing --}}
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Shipping & Billing</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Shipping Address</h6>
                                <address class="bg-light p-3 rounded">
                                    {{ $order->shipping_address ?: 'N/A' }}
                                </address>
                            </div>
                            <div class="col-md-6">
                                <h6>Billing Address</h6>
                                <address class="bg-light p-3 rounded">
                                    {{ $order->billing_address ?: 'N/A' }}
                                </address>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Order Progress Timeline --}}
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Order Progress</h6>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            @foreach ($order->statuses as $status)
                                @php
                                    $stageClass = match ($status['status']) {
                                        'completed' => 'text-success',
                                        'in_progress' => 'text-warning',
                                        default => 'text-secondary'
                                    };
                                    $icon = match ($status['status']) {
                                        'completed' => 'check-circle',
                                        'in_progress' => 'spinner fa-spin',
                                        default => 'circle'
                                    };
                                @endphp
                                <p class="mb-1 {{ $stageClass }}">
                                    <i class="fas fa-{{ $icon }} fa-fw me-2"></i>
                                    <strong>{{ ucwords(str_replace('_', ' ', $status['stage'])) }}</strong>
                                    @if ($status['completed_at'])
                                        <small class="float-end text-muted">Completed:
                                            {{ \Carbon\Carbon::parse($status['completed_at'])->format('M d, Y') }}</small>
                                    @elseif ($status['started_at'])
                                        <small class="float-end text-muted">Started:
                                            {{ \Carbon\Carbon::parse($status['started_at'])->format('M d, Y') }}</small>
                                    @else
                                        <small class="float-end text-muted">Status: {{ ucwords($status['status']) }}</small>
                                    @endif
                                </p>
                                <hr class="mt-0 mb-2">
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Order Items --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Products Ordered</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Brand / Model</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalPrice = 0; @endphp
                            @foreach ($order->orderItems as $item)
                                @php
                                    $quantity = $item->quantity ?? 0;
                                    $price = $item->price ?? 0;
                                    $subtotal = $quantity * $price;
                                    $product = $item->product ?? null;
                                    $totalPrice += $subtotal;
                                @endphp
                                <tr>
                                    <td>{{ $product?->name ?: 'Product Not Found' }}</td>
                                    <td>{{ $product?->brand ?: 'N/A' }} / {{ $product?->model ?: 'N/A' }}</td>
                                    <td>{{ $quantity }}</td>
                                    <td>${{ number_format($price, 2) }}</td>
                                    <td>${{ number_format($subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-end">Total:</th>
                                <th>${{ number_format($order->total, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- Seller Information --}}
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Seller Information</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Company Name:</strong> {{ $order->seller->company_name ?? 'N/A' }}</p>
                        <p><strong>Contact Person:</strong> {{ $order->seller->contact_person_name ?? 'N/A' }}
                            ({{ $order->seller->contact_person_position ?? 'N/A' }})</p>
                        <p><strong>Phone:</strong> {{ $order->seller->company_phone ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Address:</strong> {{ $order->seller->company_address ?? 'N/A' }},
                            {{ $order->seller->company_city ?? '' }}
                        </p>
                        <p><strong>Registration No:</strong> {{ $order->seller->company_registration_number ?? 'N/A' }}</p>
                        <p><strong>Business Type:</strong> {{ ucwords($order->seller->business_type ?? 'N/A') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Dispatch Modal (outside container-fluid, at the end of body content) --}}
    <div class="modal fade" id="dispatchModal" tabindex="-1" aria-labelledby="dispatchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('warehouse.orders.dispatch', $order->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="dispatchModalLabel">
                            <i class="fas fa-truck me-2"></i> Dispatch Order #{{ $order->id }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Courier Name</label>
                            <input type="text" name="courier_name" class="form-control" placeholder="e.g. TCS, Leopard, DHL"
                                required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tracking Number</label>
                            <input type="text" name="tracking_number" class="form-control"
                                placeholder="Enter tracking number" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Dispatch Details / Notes</label>
                            <textarea name="dispatch_details" class="form-control" rows="3"
                                placeholder="Any extra info (e.g. fragile, COD, etc.)"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Upload Dispatch Video Proof</label>
                            <input type="file" name="dispatch_video" class="form-control"
                                accept="video/mp4,video/mov,video/avi" required>
                            <div class="form-text text-muted">Allowed formats: MP4, MOV, AVI (Max 20MB)</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-paper-plane me-1"></i> Dispatch Now
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection