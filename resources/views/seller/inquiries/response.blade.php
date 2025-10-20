@extends('seller.layouts.app')

@section('styles')
    <style>
        /* Reusing and adapting styles */
        .quote-page-card {
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid #e9ecef;
            padding: 20px;
        }

        .inquiry-detail-box {
            background-color: #f8f9fa;
            border-left: 4px solid var(--primary-color, #007bff);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .info-label {
            font-weight: 500;
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 2px;
        }

        .info-value {
            font-weight: 600;
            color: #343a40;
            font-size: 1rem;
        }

        .quote-field-group {
            border: 1px dashed #ced4da;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        
        /* Highlight for Price Calculation */
        #finalQuoteAmount {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--accent-color, #28a745);
        }
    </style>
@endsection

@section('content')
    {{-- Page Header --}}
    <div class="container-fluid py-4">
        <h2 class="fw-bold mb-2" style="color: var(--primary-color);">Generate Quote for Inquiry #{{ $inquiry['id'] }}</h2>
        <p class="lead text-muted mb-4">Prepare your formal response and pricing for the customer.</p>

        <form action="#" method="POST">
            @csrf
            
            <div class="row g-4">
                
                {{-- COLUMN 1: Quote Form (Main Focus) --}}
                <div class="col-lg-7">
                    <div class="quote-page-card bg-white h-100 p-4">
                        <h4 class="mb-4 fw-bold">Seller's Pricing & Terms</h4>

                        {{-- Pricing and Quantity Section --}}
                        <div class="quote-field-group">
                            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-calculator me-2"></i> Pricing Breakdown</h6>

                            <div class="mb-3">
                                <label for="quotedPricePerUnit" class="form-label">Quoted Price Per Unit (Excl. Shipping) <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="unit_price" id="quotedPricePerUnit" class="form-control" 
                                        placeholder="e.g., 139.99" required step="0.01" min="0" oninput="calculateTotal()">
                                </div>
                                <small class="text-muted mt-1 d-block">Customer's Target Price: **${{ number_format($inquiry['target_price'], 2) }}**</small>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="shippingCost" class="form-label">Estimated Shipping Cost</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" name="shipping_cost" id="shippingCost" class="form-control" 
                                            placeholder="e.g., 500.00" step="0.01" value="0" oninput="calculateTotal()">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="taxRate" class="form-label">Tax Rate (%)</label>
                                    <div class="input-group">
                                        <input type="number" name="tax_rate" id="taxRate" class="form-control" 
                                            placeholder="e.g., 5" step="0.1" value="0" oninput="calculateTotal()">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Calculated Total --}}
                            <div class="text-center mt-4 p-3 bg-light rounded">
                                <h5 class="text-muted mb-1">FINAL QUOTE AMOUNT (Approx.)</h5>
                                <span id="finalQuoteAmount">$0.00</span>
                            </div>
                        </div>

                        {{-- Terms and Response Message --}}
                        <div class="quote-field-group">
                            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-clipboard-list me-2"></i> Terms & Response</h6>

                            <div class="mb-3">
                                <label for="validity" class="form-label">Quote Validity (Days) <span class="text-danger">*</span></label>
                                <input type="number" name="validity_days" id="validity" class="form-control" required min="1" max="90" placeholder="e.g., 7 days">
                            </div>
                            
                            <div class="mb-3">
                                <label for="paymentTerms" class="form-label">Proposed Payment Terms</label>
                                <textarea name="payment_terms" id="paymentTerms" class="form-control" rows="2" 
                                    placeholder="e.g., 50% upfront, 50% upon delivery/inspection."></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="responseMessage" class="form-label">Seller's Message to Customer <span class="text-danger">*</span></label>
                                <textarea name="message" id="responseMessage" class="form-control" rows="4" required 
                                    placeholder="Address their specific requests, confirm capability, and summarize the quote."></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 mt-3">
                            <i class="fas fa-share-square me-2"></i> Send Quote to Customer
                        </button>
                    </div>
                </div>

                {{-- COLUMN 2 & 3: Inquiry Summary and Customer Info --}}
                <div class="col-lg-5">
                    <div class="quote-page-card bg-white p-4">
                        <h5 class="fw-bold mb-3 text-muted">INQUIRY SUMMARY</h5>

                        <div class="inquiry-detail-box">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <div class="info-label">Product</div>
                                    <div class="info-value">{{ $inquiry['product']['name'] }}</div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="info-label">Customer Requested Quantity</div>
                                    <div class="info-value fs-4 text-success">{{ number_format($inquiry['quantity']) }} Units</div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="info-label">Customer Deadline</div>
                                    <div class="info-value">{{ \Carbon\Carbon::parse($inquiry['deadline'])->format('M d, Y') }}</div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="info-label">Shipping Destination</div>
                                    <div class="info-value">{{ $inquiry['destination'] }}</div>
                                </div>
                            </div>
                            
                            <div class="info-label">Customer's Original Message</div>
                            <p class="alert alert-light p-2 small mb-0">{{ $inquiry['message'] }}</p>
                        </div>
                        
                        <hr>

                        <h5 class="fw-bold mb-3 text-muted">CUSTOMER CONTACT DETAILS</h5>
                        <div class="contact-detail-box">
                            <div class="info-label">Customer Name</div>
                            <div class="info-value mb-2">{{ $inquiry['customer']['name'] }}</div>
                            
                            <div class="info-label">Primary Contact</div>
                            <div class="info-value mb-2">
                                <i class="fas fa-user-tie me-1"></i> {{ $inquiry['contact']['name'] }} ({{ $inquiry['contact']['location_type'] }})
                            </div>
                            
                            <div class="info-label">Contact Info</div>
                            <div class="info-value small">
                                <i class="fas fa-envelope me-1"></i> {{ $inquiry['contact']['email'] }}
                            </div>
                            <div class="info-value small">
                                <i class="fas fa-mobile-alt me-1"></i> {{ $inquiry['contact']['mobile'] }}
                            </div>
                        </div>

                        {{-- Optional: Chat Button --}}
                        <div class="mt-4">
                            <a href="#" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-comments me-2"></i> Open Chat
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('scripts')
    <script>
        const QUANTITY = {{ $inquiry['quantity'] }};
        const TAX_RATE_FIELD = document.getElementById('taxRate');
        const UNIT_PRICE_FIELD = document.getElementById('quotedPricePerUnit');
        const SHIPPING_COST_FIELD = document.getElementById('shippingCost');
        const FINAL_QUOTE_DISPLAY = document.getElementById('finalQuoteAmount');

        /**
         * Calculates the total quote amount based on inputs and updates the display.
         */
        function calculateTotal() {
            const unitPrice = parseFloat(UNIT_PRICE_FIELD.value) || 0;
            const shippingCost = parseFloat(SHIPPING_COST_FIELD.value) || 0;
            const taxRate = parseFloat(TAX_RATE_FIELD.value) / 100 || 0; // Convert percent to decimal

            // 1. Calculate Subtotal (Units * Price)
            const subtotal = unitPrice * QUANTITY;

            // 2. Calculate Total before Tax (Subtotal + Shipping)
            const totalBeforeTax = subtotal + shippingCost;
            
            // 3. Calculate Tax Amount
            const taxAmount = totalBeforeTax * taxRate;

            // 4. Calculate Grand Total
            const grandTotal = totalBeforeTax + taxAmount;

            // Format and update display
            FINAL_QUOTE_DISPLAY.textContent = '$' + grandTotal.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
        
        // Initial calculation on page load
        document.addEventListener('DOMContentLoaded', calculateTotal);
    </script>
@endsection