@extends('accountant.layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Invoice #{{ $order->id }}</h4>
                @if (is_null($order->invoice_generated_at))
                    <form action="{{ route('accountant.orders.invoice.save', $order->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success">Save & Generate Invoice</button>
                    </form>
                @else
                    <span class="badge bg-success">Invoice Generated on
                        {{ \Carbon\Carbon::parse($order->invoice_generated_at)->format('d M Y') }}</span>
                @endif
            </div>

            <div class="card-body">
                <!-- Order Info -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Seller</h5>
                        <p><strong>{{ $order->seller->company_name }}</strong><br>
                            {{ $order->seller->company_address }}<br>
                            {{ $order->seller->company_city }}, {{ $order->seller->company_state }}
                            {{ $order->seller->company_postal_code }}<br>
                            {{ $order->seller->company_country }}<br>
                            Phone: {{ $order->seller->company_phone }}<br>
                            Email: {{ $order->seller->contact_person_email }}
                        </p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <h5>Customer</h5>
                        <p><strong>{{ $order->customer->name }}</strong><br>
                            Email: {{ $order->customer->email }}<br>
                            Role: {{ ucfirst($order->customer->role) }}
                        </p>
                    </div>
                </div>

                <p><strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, h:i A') }}</p>
                <p><strong>Status:</strong> <span class="badge bg-info">{{ $order->status }}</span></p>
                <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
                <p><strong>Payment Status:</strong> <span
                        class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">{{ ucfirst($order->payment_status) }}</span>
                </p>

                <table class="table table-bordered mt-4">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $item)
                            <tr>
                                <td>{{ $item->product->name ?? 'N/A' }}</td>
                                <td>₨ {{ number_format($item->price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>₨ {{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Grand Total:</th>
                            <th>₨ {{ number_format($order->total, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>

                <div class="mt-4">
                    <p><strong>Notes:</strong> {{ $order->notes ?: '—' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
