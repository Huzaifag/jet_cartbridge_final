@extends('frontend.layout.main')

@section('content')
@php
    // --- Blade Logic to find the active contact ---
    // We assume $userContacts is passed to the view (it's the array you provided).
    $activeContact = collect($userContacts)->firstWhere('status', 'active');
    
    // Placeholder for referral name
    // Assuming $review->user->name is available, as you specified.
    $referralUserName = $review->user->name ?? 'A Friend'; 

    // Placeholder variables for the Order Summary (replace with actual data)
    $product = (object)['name' => 'Premium E-Book Series', 'b2c_price' => 49.99]; 
    $shippingCost = 5.00;
    $totalDue = $product->b2c_price + $shippingCost;
@endphp

{{-- 
    NOTE: You must include the SweetAlert2 library in your main layout file 
    or include the CDN links below for the alert to work.
--}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container my-5">
    <div class="row">

        {{-- Branding/Referral Block --}}
        <div class="col-lg-12 mb-4">
            <div class="card bg-primary text-white shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-gift fa-2x me-3"></i>
                        <div>
                            <h5 class="card-title mb-1">Welcome to the Club!</h5>
                            <p class="card-text mb-0">
                                You are coming from the reference of <strong>{{ $referralUserName }}</strong>.
                                Complete your purchase and you can **earn 100 extra points** by submitting a video review!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Main Checkout Form (Left Column) --}}
        <div class="col-lg-8">
            <h2 class="mb-4">Complete Your Order</h2>
            {{-- Action is set to '#' and we use JS to intercept the submission --}}
            <form id="checkoutForm" action="#" method="POST">
                @csrf

                {{-- Shipping Information Section --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">1. Shipping & Contact Information</h5>
                    </div>
                    
                    <div class="card-body">
                        @if($activeContact)
                            {{-- Display Current Active Address --}}
                            <h6 class="text-muted">Currently Active Shipping Address:</h6>
                            <div class="p-3 border rounded mb-3 bg-light">
                                <p class="mb-1">
                                    <i class="fas fa-home me-2 text-primary"></i>
                                    <strong>{{ $activeContact['name'] }}</strong> ({{ $activeContact['location_type'] }})
                                </p>
                                <p class="mb-1 text-secondary">
                                    {{ $activeContact['address'] }}, {{ $activeContact['city'] }}, {{ $activeContact['state'] }}
                                </p>
                                
                                {{-- Hidden input for form submission --}}
                                <input type="hidden" name="shipping_address_id" value="{{ $activeContact['id'] }}">
                            </div>

                            {{-- Display Current Active Phone Number --}}
                            <h6 class="text-muted">Contact Phone Number:</h6>
                            <div class="p-3 border rounded mb-3 bg-light">
                                <p class="mb-0">
                                    <i class="fas fa-phone me-2 text-primary"></i>
                                    <strong>{{ $activeContact['mobile'] }}</strong>
                                </p>

                                {{-- Hidden input for form submission --}}
                                <input type="hidden" name="contact_phone" value="{{ $activeContact['mobile'] }}">
                            </div>

                            {{-- Button to Change Contact --}}
                            <div class="mt-3 text-end">
                                <a 
                                    href="#" {{-- Use your actual route here --}}
                                    class="btn btn-outline-secondary btn-sm"
                                >
                                    <i class="fas fa-edit me-1"></i> Change Active Contact
                                </a>
                            </div>

                        @else
                            <div class="alert alert-warning text-center">
                                No **Active** contact found. Please <a href="#">set a primary address and phone number</a>.
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Payment Method Section --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">2. Payment Method</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- Payment Option: Card --}}
                            <div class="col-md-6 mb-3">
                                <input type="radio" class="btn-check" name="payment_method" id="payment_card" value="card" autocomplete="off" checked>
                                <label class="btn btn-outline-dark w-100 p-3" for="payment_card">
                                    <i class="far fa-credit-card me-2"></i> Credit / Debit Card
                                </label>
                            </div>

                            {{-- Payment Option: PayPal/Other Wallet --}}
                            <div class="col-md-6 mb-3">
                                <input type="radio" class="btn-check" name="payment_method" id="payment_paypal" value="paypal" autocomplete="off">
                                <label class="btn btn-outline-dark w-100 p-3" for="payment_paypal">
                                    <i class="fab fa-paypal me-2"></i> PayPal / Digital Wallet
                                </label>
                            </div>

                            {{-- Placeholder for selected payment details (e.g., card input fields) --}}
                            <div id="payment-details-area" class="mt-3 p-3 border rounded bg-light">
                                <p class="mb-0 text-muted">Payment details will appear here based on your selection.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success btn-lg">Place Order</button>
                    <p class="text-center mt-2 text-muted">By placing this order, you agree to our terms and conditions.</p>
                </div>

            </form>
        </div>

        {{-- Order Summary (Right Column) --}}
        <div class="col-lg-4">
            <div class="card shadow-sm sticky-top" style="top: 20px;">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    {{-- Cart Items List (Shortened) --}}
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $product->name }} (x1)
                            <span>${{ number_format($product->b2c_price, 2) }}</span>
                        </li>
                    </ul>

                    {{-- Totals --}}
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Subtotal</span>
                        <strong>${{ number_format($product->b2c_price, 2) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Shipping</span>
                        <strong>${{ number_format($shippingCost, 2) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center border-top pt-3">
                        <h5 class="mb-0">Total Due</h5>
                        <h4 class="text-success mb-0">${{ number_format($totalDue, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('checkoutForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Stop the form from submitting normally

        // Check if an active contact exists (prevents showing success if setup failed)
        const activeContactId = document.querySelector('input[name="shipping_address_id"]');
        if (!activeContactId) {
             Swal.fire({
                icon: 'error',
                title: 'Missing Information',
                text: 'Please set an active contact and address before placing the order.',
            });
            return;
        }

        // Show the temporary SweetAlert2 notification
        Swal.fire({
            title: 'Order Processing Simulated!',
            text: 'Your order details have been collected successfully. We will integrate the actual payment gateway soon.',
            icon: 'info',
            confirmButtonText: 'OK',
            allowOutsideClick: false
        }).then((result) => {
            // Optional: You could redirect the user here for a temporary flow
            // For now, we'll just close the modal.
            // console.log("User acknowledged the temporary message.");
        });
    });
</script>

@endsection