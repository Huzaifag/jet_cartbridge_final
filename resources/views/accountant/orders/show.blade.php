@extends('accountant.layouts.app')

@section('title', 'Order Details #' . $order['id'])

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Order Details - #{{ $order['id'] }}</h1>

            <div class="d-flex align-items-center gap-2">
                {{-- Check if order is in accountant_billing stage and in_progress --}}
                @php
                    $accountantStage = collect($order['statuses'])->firstWhere('stage', 'accountant_billing');
                    $canCreateInvoice = $accountantStage && $accountantStage['status'] === 'in_progress';
                @endphp

                @if ($canCreateInvoice)
                    <a href="{{ route('accountant.confirmed-orders.confirm', $order['id']) }}" 
                       class="btn btn-success shadow-sm">
                        <i class="fas fa-file-invoice fa-sm text-white-50"></i> Create Invoice
                    </a>
                @elseif ($accountantStage && $accountantStage['status'] === 'completed')
                    <span class="badge bg-success p-2">
                        <i class="fas fa-check-circle"></i> Invoice Created
                    </span>
                    @if ($order['invoice'])
                        <a href="{{ asset('storage/invoices/' . $order['invoice']) }}" 
                           class="btn btn-info shadow-sm" 
                           target="_blank">
                            <i class="fas fa-download fa-sm text-white-50"></i> Download Invoice
                        </a>
                    @endif
                @endif

                <a href="{{ route('accountant.confirmed-orders.index') }}"
                    class="btn btn-sm btn-secondary shadow-sm">
                    <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Orders
                </a>
            </div>
        </div>

        {{-- Alert for Order Status --}}
        @php
            // Get current stage
            $currentStage = collect($order['statuses'])
                ->filter(fn($s) => $s['status'] === 'in_progress' || $s['status'] === 'completed')
                ->sortByDesc('updated_at')
                ->first();
            
            $stageLabels = [
                'order_placed' => 'Order Placed',
                'salesman_review' => 'Salesman Review',
                'accountant_billing' => 'Accountant Billing',
                'warehouse_dispatch' => 'Warehouse Dispatch',
                'out_for_delivery' => 'Out for Delivery',
                'delivered' => 'Delivered'
            ];
            
            $currentStageName = $stageLabels[$currentStage['stage']] ?? ucfirst(str_replace('_', ' ', $currentStage['stage']));
            
            $statusClass = match($currentStage['stage']) {
                'order_placed' => 'info',
                'salesman_review' => 'info',
                'accountant_billing' => 'warning',
                'warehouse_dispatch' => 'primary',
                'out_for_delivery' => 'warning',
                'delivered' => 'success',
                default => 'secondary'
            };
        @endphp
        <div class="alert alert-{{ $statusClass }} shadow-sm" role="alert">
            <h4 class="alert-heading">
                <i class="fas fa-info-circle"></i> Current Stage: {{ $currentStageName }}
                @if ($currentStage['status'] === 'in_progress')
                    <span class="badge bg-warning text-dark">In Progress</span>
                @elseif ($currentStage['status'] === 'completed')
                    <span class="badge bg-success">Completed</span>
                @endif
            </h4>
            <p class="mb-0">
                <strong>Payment Status:</strong> {{ ucwords($order['payment_status']) }} via {{ strtoupper($order['payment_method']) }}
                <br>
                <strong>Order Number:</strong> {{ $order['order_number'] ?? 'N/A' }}
            </p>
        </div>

        <div class="row">
            {{-- General Order Information --}}
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Order Summary</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Order ID:</strong> #{{ $order['id'] }}</p>
                        <p><strong>Total Amount:</strong> ${{ number_format($order['total'], 2) }}</p>
                        <p><strong>Placed On:</strong>
                            {{ \Carbon\Carbon::parse($order['created_at'])->format('M d, Y h:i A') }}</p>
                        <p><strong>Last Updated:</strong> {{ \Carbon\Carbon::parse($order['updated_at'])->diffForHumans() }}
                        </p>
                        @if ($order['referral_code'])
                            <p><strong>Referral Code:</strong> {{ $order['referral_code'] }}</p>
                        @endif
                        <p><strong>Notes:</strong> {{ $order['notes'] ?: 'N/A' }}</p>
                    </div>
                </div>

                {{-- Customer Information Card --}}
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Customer Details</h6>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $order['customer']['name'] }}</p>
                        <p><strong>Email:</strong> <a
                                href="mailto:{{ $order['customer']['email'] }}">{{ $order['customer']['email'] }}</a></p>
                        <p><strong>User Role:</strong> {{ strtoupper($order['customer']['role']) }}</p>
                        <p><strong>Customer Since:</strong>
                            {{ \Carbon\Carbon::parse($order['customer']['created_at'])->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- Shipping, Billing, and Timeline --}}
            <div class="col-xl-8 col-lg-7">
                {{-- Invoice Information (if created) --}}
                @if ($order['invoice'])
                    <div class="card shadow mb-4 border-left-success">
                        <div class="card-header py-3 bg-success text-white">
                            <h6 class="m-0 font-weight-bold">
                                <i class="fas fa-file-invoice"></i> Invoice Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Invoice File:</strong> {{ $order['invoice'] }}</p>
                                    <p><strong>Invoice Date:</strong> 
                                        {{ $order['invoice_date'] ? \Carbon\Carbon::parse($order['invoice_date'])->format('M d, Y h:i A') : 'N/A' }}
                                    </p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <a href="{{ asset('storage/invoices/' . $order['invoice']) }}" 
                                       class="btn btn-success" 
                                       target="_blank">
                                        <i class="fas fa-download"></i> Download Invoice
                                    </a>
                                    <a href="{{ asset('storage/invoices/' . $order['invoice']) }}" 
                                       class="btn btn-outline-success" 
                                       target="_blank">
                                        <i class="fas fa-eye"></i> View Invoice
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Addresses Card --}}
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Shipping & Billing</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Shipping Address</h6>
                                <address class="bg-light p-3 rounded">
                                    {{ $order['shipping_address'] ?: 'N/A' }}
                                </address>
                            </div>
                            <div class="col-md-6">
                                <h6>Billing Address</h6>
                                <address class="bg-light p-3 rounded">
                                    {{ $order['billing_address'] ?: 'N/A' }}
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
                            @foreach ($order['statuses'] as $status)
                                @php
                                    $stageClass =
                                        $status['status'] === 'completed'
                                            ? 'text-success'
                                            : ($status['status'] === 'in_progress'
                                                ? 'text-warning'
                                                : 'text-secondary');
                                    $iconClass =
                                        $status['status'] === 'completed'
                                            ? 'check-circle'
                                            : ($status['status'] === 'in_progress'
                                                ? 'spinner fa-spin'
                                                : 'circle');
                                @endphp
                                <p class="mb-1 {{ $stageClass }}">
                                    <i class="fas fa-{{ $iconClass }} fa-fw mr-2"></i>
                                    **{{ ucwords(str_replace('_', ' ', $status['stage'])) }}**
                                    @if ($status['completed_at'])
                                        <small class="float-right text-muted">Completed:
                                            {{ \Carbon\Carbon::parse($status['completed_at'])->format('M d, Y') }}</small>
                                    @elseif ($status['started_at'])
                                        <small class="float-right text-muted">Started:
                                            {{ \Carbon\Carbon::parse($status['started_at'])->format('M d, Y') }}</small>
                                    @else
                                        <small class="float-right text-muted">Status:
                                            {{ ucwords($status['status']) }}</small>
                                    @endif
                                </p>
                                <hr class="mt-0 mb-2">
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Order Items Table --}}
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
                            {{-- IMPORTANT: Use $order->orderItems if $order is an Eloquent model. 
                                    If $order is a plain array, use $order['order_items'] and find the product manually 
                                    (as per the previous correction context). 
                                    Assuming $order is an Eloquent Model with relations loaded: --}}
                            @foreach ($order->orderItems as $item)
                                @php
                                    $quantity = $item->quantity ?? 0;
                                    $price = $item->price ?? 0;
                                    $subtotal = $quantity * $price;
                                    $product = $item->product ?? null; // Assumes OrderItem has a 'product' relation
                                    $totalPrice += $subtotal;
                                @endphp
                                <tr>
                                    <td>{{ $product->name ?? 'Product Not Found' }}</td>
                                    <td>{{ $product->brand ?? 'N/A' }} / {{ $product->model ?? 'N/A' }}</td>
                                    <td>{{ $quantity }}</td>
                                    <td>${{ number_format($price, 2) }}</td>
                                    <td>${{ number_format($subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-right">Total:</th>
                                {{-- Use $order['total'] since the rest of the template uses array access --}}
                                <th>${{ number_format($order['total'], 2) }}</th>
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
                        <p><strong>Company Name:</strong> {{ $order['seller']['company_name'] }}</p>
                        <p><strong>Contact Person:</strong> {{ $order['seller']['contact_person_name'] }}
                            ({{ $order['seller']['contact_person_position'] }})</p>
                        <p><strong>Phone:</strong> {{ $order['seller']['company_phone'] }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Address:</strong> {{ $order['seller']['company_address'] }},
                            {{ $order['seller']['company_city'] }}</p>
                        <p><strong>Registration No:</strong> {{ $order['seller']['company_registration_number'] }}</p>
                        <p><strong>Business Type:</strong> {{ ucwords($order['seller']['business_type']) }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection