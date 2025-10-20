@extends('seller.layouts.app')


<style>
    .order-creation-card {
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid #e9ecef;
    }

    .summary-box {
        background-color: #f7f9fc;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #eef1f6;
    }

    .form-section-header {
        font-weight: 700;
        color: #007bff;
        border-bottom: 2px solid #007bff;
        padding-bottom: 5px;
        margin-bottom: 20px;
        font-size: 1.15rem;
    }

    .product-info-thumb {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
    }


    /* Price Input Styling */
    .form-control-lg-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: #28a745;
        /* Green for price/revenue */
        text-align: right;
        /* Keeps the price figures clearly aligned */
        /* Ensure it inherits the input-group's height */
        height: calc(2.25rem + 1rem);
    }

    /* Styling for the currency symbol span within the input-group */
    .input-group-lg .input-group-text {
        padding: 0.5rem 1rem;
        /* Adjust padding to match form-control-lg */
        font-size: 1.25rem;
    }
</style>

@section('content')
    <div class="container-fluid py-4">
        <x-alert type="success" :message="session('success')" />
        <x-alert type="danger" :message="session('error')" />
        <header class="mb-4 pb-3 border-bottom">
            <h1 class="fw-bolder mb-0 text-dark">Finalize Bulk Order: <span
                    class="text-primary">#ORD-{{ $inquiry['id'] }}</span></h1>
            <p class="text-muted mt-1">Convert Inquiry #{{ $inquiry['id'] }} into a formal sales order for the customer.</p>
        </header>

        <form action="{{ route('seller.inquiries.bulk-order.store') }}" method="POST">
            @csrf
            {{-- Hidden Field to link the order back to the original inquiry --}}
            <input type="hidden" name="inquiry_id" value="{{ $inquiry['id'] }}">
            <input type="hidden" name="product_id" value="{{ $inquiry['product_id'] }}">
            <input type="hidden" name="customer_id" value="{{ $inquiry['customer_id'] }}">

            <div class="row g-4">

                {{-- LEFT COLUMN: Order Details Form --}}
                <div class="col-lg-8">
                    <div class="card order-creation-card p-4">

                        <div class="mb-4">
                            <h3 class="form-section-header">Inquiry Reference</h3>
                            <div class="row">
                                <div class="col-md-7 d-flex align-items-center mb-3">
                                    @php
                                        $firstImage = $inquiry['product']['images'][0] ?? 'default.png';
                                    @endphp
                                    <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $inquiry['product']['name'] }}"
                                        class="product-info-thumb me-3">
                                    <div>
                                        <p class="mb-0 fw-bold">{{ $inquiry['product']['name'] }}</p>
                                        <small class="text-muted">Requested by: {{ $inquiry->customer->name }}</small>
                                    </div>
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label class="form-label text-muted small">Customer Message</label>
                                    <p class="alert alert-light p-2 small mb-0">{{ Str::limit($inquiry['message'], 50) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="mb-4">
                            <h3 class="form-section-header">Pricing & Quantity</h3>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    {{-- FIX 1: Move icon into the label for better alignment --}}
                                    <label for="quantity" class="form-label">Final Order Quantity <i
                                            class="fas fa-boxes text-info ms-1"></i></label>
                                    <input type="number" class="form-control form-control-lg" id="quantity"
                                        name="quantity" value="{{ $inquiry['quantity'] }}" required>
                                    <div class="form-text">Inquiry requested {{ $inquiry['quantity'] }} units.</div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="unit_price" class="form-label">Agreed Unit Price <i
                                            class="fas fa-money-bill-wave text-success ms-1"></i></label>
                                    {{-- FIX 2: Use input-group to beautifully place the currency symbol --}}
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-success text-white fw-bold">$</span>
                                        <input type="number" step="0.01" class="form-control form-control-lg-price"
                                            id="unit_price" name="unit_price"
                                            value="{{ number_format($inquiry['target_price'] ?? $inquiry['product']['b2b_price'], 2, '.', '') }}"
                                            required>
                                    </div>
                                    {{-- FIX 3: Clean up and bold text hints --}}
                                    <div class="form-text">Current B2B:
                                        ${{ number_format($inquiry['product']['b2b_price'], 2) }}. Target:
                                        ${{ number_format($inquiry['target_price'], 2) }}.</div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="shipping_cost" class="form-label">Shipping & Handling Cost <i
                                            class="fas fa-truck text-secondary ms-1"></i></label>
                                    {{-- Using input-group for shipping cost as well for consistency --}}
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" class="form-control" id="shipping_cost"
                                            name="shipping_cost" value="0.00">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h3 class="form-section-header">Logistics & Terms</h3>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="destination" class="form-label">Delivery Destination (Country Code)</label>
                                    <input type="text" class="form-control" id="destination" name="destination"
                                        value="{{ $inquiry['destination'] }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="delivery_date" class="form-label">Agreed Delivery Date</label>
                                    <input type="date" class="form-control" id="delivery_date" name="delivery_date"
                                        value="{{ $inquiry['deadline'] }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="payment_terms" class="form-label">Payment Terms</label>
                                    <select class="form-select" id="payment_terms" name="payment_terms" required>
                                        <option value="Net 30">Net 30 Days</option>
                                        <option value="L/C">Letter of Credit (L/C)</option>
                                        <option value="Advance" selected>50% Advance / 50% Before Shipment</option>
                                        <option value="Full Advance">100% Full Advance</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="order_notes" class="form-label">Internal Order Notes (Optional)</label>
                                    <textarea class="form-control" id="order_notes" name="order_notes" rows="2"
                                        placeholder="e.g., agreed to special packaging..."></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- RIGHT COLUMN: Order Summary & Actions --}}
                <div class="col-lg-4">
                    <div class="summary-box sticky-top" style="top: 20px;">
                        <h4 class="fw-bold mb-3 text-primary">Order Summary</h4>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal (Qty x Price)</span>
                            <span class="fw-bold text-dark" id="subtotal_display">$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping Cost</span>
                            <span class="fw-bold text-dark" id="shipping_display">$0.00</span>
                        </div>
                        <div class="d-flex justify-content-between pt-2 border-top">
                            <span class="fs-5 fw-bold">Grand Total</span>
                            <span class="fs-5 fw-bold text-success" id="grand_total_display">$0.00</span>
                        </div>

                        <hr>

                        <p class="text-muted small mb-4">Click "Create & Issue Order" to formally send this document to the
                            customer.</p>

                        <button type="submit" class="btn btn-success btn w-100 mb-3">
                            <i class="fas fa-file-invoice me-2"></i> Create & Issue Order
                        </button>
                        <a href="#" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-arrow-left me-2"></i> Back to Inquiry
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quantityInput = document.getElementById('quantity');
        const unitPriceInput = document.getElementById('unit_price');
        const shippingCostInput = document.getElementById('shipping_cost');
        const subtotalDisplay = document.getElementById('subtotal_display');
        const shippingDisplay = document.getElementById('shipping_display');
        const grandTotalDisplay = document.getElementById('grand_total_display');

        // Function to calculate and update totals
        function updateOrderTotals() {
            const quantity = parseFloat(quantityInput.value) || 0;
            const unitPrice = parseFloat(unitPriceInput.value) || 0;
            const shippingCost = parseFloat(shippingCostInput.value) || 0;

            const subtotal = quantity * unitPrice;
            const grandTotal = subtotal + shippingCost;

            const formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
            });

            subtotalDisplay.textContent = formatter.format(subtotal);
            shippingDisplay.textContent = formatter.format(shippingCost);
            grandTotalDisplay.textContent = formatter.format(grandTotal);
        }

        // Attach event listeners to all price/quantity fields
        quantityInput.addEventListener('input', updateOrderTotals);
        unitPriceInput.addEventListener('input', updateOrderTotals);
        shippingCostInput.addEventListener('input', updateOrderTotals);

        // Initial calculation on page load
        updateOrderTotals();
    });
</script>
