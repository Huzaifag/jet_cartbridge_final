@extends('frontend.layout.main')
@section('content')
<style>
    .payment-container {
        max-width: 1200px;
        margin: 2rem auto;
    }

    .breadcrumb-custom {
        background: transparent;
        padding: 0;
        margin-bottom: 2rem;
    }

    .breadcrumb-custom .breadcrumb-item + .breadcrumb-item::before {
        content: ">";
        color: #6c757d;
    }

    .page-title {
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: var(--dark-text);
    }

    .card {
        background: #ffffff;
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
    }

    .card-header {
        background: white;
        border-bottom: 2px solid #f1f3f5;
        padding: 1.25rem 1.5rem;
        font-weight: 600;
        color: var(--dark-text);
        font-size: 1.1rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    .payment-method {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .payment-method:hover {
        border-color: var(--primary);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
    }

    .payment-method.selected {
        border-color: var(--primary);
        background: #f0f8ff;
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.2);
    }

    .payment-method input[type="radio"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
    }

    .payment-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.2rem;
    }

    .cod-icon {
        background: #28a745;
        color: white;
    }

    .card-icon {
        background: #007bff;
        color: white;
    }

    .upi-icon {
        background: #6f42c1;
        color: white;
    }

    .payment-details {
        margin-left: 3.5rem;
    }

    .payment-title {
        font-weight: 600;
        font-size: 1.05rem;
        color: var(--dark-text);
        margin-bottom: 0.25rem;
    }

    .payment-description {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 0;
    }

    .order-summary-box {
        position: sticky;
        top: 2rem;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        color: #495057;
    }

    .summary-divider {
        border-top: 1px solid #e9ecef;
        margin: 1rem 0;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        font-weight: 600;
        font-size: 1.2rem;
        color: var(--dark-text);
        margin-top: 1rem;
    }

    .btn-place-order {
        background: var(--secondary);
        border: none;
        color: white;
        padding: 14px;
        font-weight: 600;
        border-radius: 8px;
        width: 100%;
        margin-top: 1.5rem;
        font-size: 1rem;
    }

    .btn-place-order:hover {
        background: #e65c00;
        transform: translateY(-1px);
    }

    .btn-place-order:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .btn-back {
        background: white;
        border: 1px solid #dee2e6;
        color: #495057;
        padding: 12px;
        font-weight: 600;
        border-radius: 8px;
        width: 100%;
        margin-top: 0.75rem;
    }

    .btn-back:hover {
        background: #f8f9fa;
    }

    .checkout-steps {
        display: flex;
        justify-content: center;
        margin-bottom: 2rem;
        gap: 2rem;
    }

    .step {
        display: flex;
        align-items: center;
        color: #6c757d;
    }

    .step.active {
        color: var(--primary);
        font-weight: 600;
    }

    .step.completed {
        color: #28a745;
    }

    .step-number {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 2px solid #dee2e6;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.5rem;
        font-weight: 600;
    }

    .step.active .step-number {
        border-color: var(--primary);
        background: var(--primary);
        color: white;
    }

    .step.completed .step-number {
        border-color: #28a745;
        background: #28a745;
        color: white;
    }

    .delivery-address {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .address-title {
        font-weight: 600;
        color: var(--dark-text);
        margin-bottom: 0.5rem;
    }

    .address-content {
        color: #495057;
        line-height: 1.5;
    }

    @media (max-width: 768px) {
        .checkout-steps {
            flex-direction: column;
            gap: 1rem;
        }
    }
</style>

<div class="container payment-container">
    @include('components.toast');
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-custom">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cart') }}">Cart</a></li>
            <li class="breadcrumb-item"><a href="{{ route('order.select-address', $cart->id) }}">Address</a></li>
            <li class="breadcrumb-item active" aria-current="page">Payment</li>
        </ol>
    </nav>

    <!-- Checkout Steps -->
    <div class="checkout-steps">
        <div class="step completed">
            <div class="step-number"><i class="fas fa-check"></i></div>
            <span>Cart</span>
        </div>
        <div class="step completed">
            <div class="step-number"><i class="fas fa-check"></i></div>
            <span>Address</span>
        </div>
        <div class="step active">
            <div class="step-number">3</div>
            <span>Payment</span>
        </div>
    </div>

    <h1 class="page-title">Choose Payment Method</h1>

    <div class="row">
        <!-- Payment Methods -->
        <div class="col-lg-8">
            <!-- Delivery Address -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-map-marker-alt me-2"></i>
                    Delivery Address
                </div>
                <div class="card-body">
                    <div class="delivery-address">
                        <div class="address-title">{{ $selectedAddress->name }}</div>
                        <div class="address-content">
                            {{ $selectedAddress->address }}<br>
                            {{ $selectedAddress->city }}, {{ $selectedAddress->state }} {{ $selectedAddress->postal_code }}<br>
                            {{ $selectedAddress->country }}<br>
                            <i class="fas fa-phone me-1"></i> {{ $selectedAddress->mobile }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-credit-card me-2"></i>
                    Payment Method
                </div>
                <div class="card-body">
                    <form action="{{ route('order.place', $cart->id) }}" method="POST" id="payment-form">
                        @csrf
                        <input type="hidden" name="payment_method" id="selected-payment-method" value="cod">

                        <!-- Cash on Delivery -->
                        <div class="payment-method selected" onclick="selectPaymentMethod('cod')">
                            <input type="radio" name="payment_method" id="cod" value="cod" checked>
                            <div class="payment-icon cod-icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="payment-details">
                                <div class="payment-title">Cash on Delivery</div>
                                <div class="payment-description">Pay when your order is delivered</div>
                            </div>
                        </div>

                        <!-- Credit/Debit Card -->
                        <div class="payment-method" onclick="selectPaymentMethod('card')">
                            <input type="radio" name="payment_method" id="card" value="card">
                            <div class="payment-icon card-icon">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <div class="payment-details">
                                <div class="payment-title">Credit/Debit Card</div>
                                <div class="payment-description">Pay securely with your card</div>
                            </div>
                        </div>

                        <!-- UPI -->
                        <div class="payment-method" onclick="selectPaymentMethod('upi')">
                            <input type="radio" name="payment_method" id="upi" value="upi">
                            <div class="payment-icon upi-icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <div class="payment-details">
                                <div class="payment-title">UPI</div>
                                <div class="payment-description">Pay using UPI apps like Google Pay, PhonePe</div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="order-summary-box">
                <div class="card">
                    <div class="card-header">
                        Order Summary
                    </div>
                    <div class="card-body">
                        @foreach($selectedItems as $item)
                            <div class="summary-item">
                                <span>{{ $item->product->name }} (x{{ $item->quantity }})</span>
                                <span>${{ number_format($item->price * $item->quantity, 2) }}</span>
                            </div>
                        @endforeach

                        <div class="summary-divider"></div>

                        <div class="summary-item">
                            <span>Subtotal</span>
                            <span>${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="summary-item">
                            <span>Shipping</span>
                            <span>${{ number_format($shipping, 2) }}</span>
                        </div>
                        <div class="summary-item">
                            <span>Tax</span>
                            <span>${{ number_format($tax, 2) }}</span>
                        </div>
                        <div class="summary-divider"></div>
                        <div class="summary-total">
                            <span>Total</span>
                            <span>${{ number_format($total, 2) }}</span>
                        </div>

                        <button type="submit" form="payment-form" class="btn-place-order" id="place-order-btn">
                            Place Order
                            <i class="fas fa-check ms-2"></i>
                        </button>

                        <a href="{{ route('order.select-address', $cart->id) }}" class="btn-back">
                            <i class="fas fa-arrow-left me-2"></i> Back to Address
                        </a>
                    </div>
                </div>

                <!-- Security Info -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-shield-alt fa-2x text-success me-3"></i>
                            <div>
                                <h6 class="mb-0">Secure Payment</h6>
                                <small class="text-muted">Your payment information is secure</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-lock fa-2x text-primary me-3"></i>
                            <div>
                                <h6 class="mb-0">SSL Encrypted</h6>
                                <small class="text-muted">256-bit SSL encryption</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Select payment method
    function selectPaymentMethod(method) {
        // Remove selected class from all methods
        document.querySelectorAll('.payment-method').forEach(method => {
            method.classList.remove('selected');
        });

        // Add selected class to clicked method
        event.currentTarget.classList.add('selected');

        // Check the radio button
        document.getElementById(method).checked = true;

        // Update hidden input
        document.getElementById('selected-payment-method').value = method;
    }

    // Form validation
    document.getElementById('payment-form').addEventListener('submit', function(e) {
        const selectedMethod = document.getElementById('selected-payment-method').value;
        if (!selectedMethod) {
            e.preventDefault();
            alert('Please select a payment method');
            return false;
        }
    });
</script>
@endsection
