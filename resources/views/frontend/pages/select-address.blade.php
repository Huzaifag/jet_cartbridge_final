@extends('frontend.layout.main')
@section('content')
<style>
    /* ========================================
       CHECKOUT PAGE - THEME COMPATIBLE
       ======================================== */
    
    .checkout-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    /* Breadcrumb */
    .breadcrumb-custom {
        background: transparent;
        padding: 0;
        margin-bottom: 2rem;
    }

    .breadcrumb-custom .breadcrumb-item a {
        color: var(--color-accent);
        text-decoration: none;
        transition: var(--transition-fast);
    }

    .breadcrumb-custom .breadcrumb-item a:hover {
        color: var(--color-accent-light);
    }

    .breadcrumb-custom .breadcrumb-item.active {
        color: var(--color-text-dim);
    }

    .breadcrumb-custom .breadcrumb-item + .breadcrumb-item::before {
        content: ">";
        color: var(--color-text-dim);
    }

    /* Page Title */
    .page-title {
        font-weight: var(--font-weight-bold);
        margin-bottom: 1.5rem;
        color: var(--color-white);
        font-size: 2rem;
    }

    /* Cards */
    .card {
        background: var(--color-card-bg, rgba(255, 255, 255, 0.05));
        border: 1px solid var(--color-border, rgba(245, 158, 11, 0.1));
        border-radius: var(--border-radius-premium);
        box-shadow: var(--shadow-card);
        margin-bottom: 1.5rem;
        transition: var(--transition-premium);
    }

    .card-header {
        background: transparent;
        border-bottom: 2px solid var(--color-border, rgba(245, 158, 11, 0.2));
        padding: 1.25rem 1.5rem;
        font-weight: var(--font-weight-semibold);
        color: var(--color-white);
        font-size: 1.1rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Address Cards */
    .address-card {
        border: 2px solid var(--color-border, rgba(245, 158, 11, 0.2));
        border-radius: 10px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        cursor: pointer;
        transition: var(--transition-premium);
        position: relative;
        background: var(--color-surface, rgba(255, 255, 255, 0.02));
    }

    .address-card:hover {
        border-color: var(--color-accent);
        box-shadow: var(--shadow-hover);
        transform: translateY(-2px);
    }

    .address-card.selected {
        border-color: var(--color-accent);
        background: var(--color-surface, rgba(245, 158, 11, 0.08));
        box-shadow: var(--shadow-hover);
    }

    .address-card input[type="radio"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
    }

    .address-header {
        display: flex;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    /* Address Type Badges */
    .address-type-badge {
        background: linear-gradient(135deg, var(--color-accent) 0%, var(--color-accent-dark) 100%);
        color: #ffffff;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.85rem;
        margin-left: 1rem;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }

    .address-type-badge.work {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    }

    .address-type-badge.other {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    /* Address Content */
    .address-content {
        margin-left: 2rem;
        color: var(--color-text-light);
        line-height: 1.6;
    }

    .address-name {
        font-weight: var(--font-weight-semibold);
        font-size: 1.05rem;
        color: var(--color-white);
    }

    .address-phone {
        color: var(--color-text-dim);
        font-size: 0.95rem;
    }

    .address-text {
        margin-top: 0.5rem;
        color: var(--color-text-light);
    }

    .address-actions {
        position: absolute;
        top: 1rem;
        right: 1rem;
    }

    /* Address Actions */
    .btn-edit, .btn-delete {
        background: none;
        border: none;
        color: var(--color-text-dim);
        padding: 0.25rem 0.5rem;
        cursor: pointer;
        font-size: 0.9rem;
        transition: var(--transition-fast);
    }

    .btn-edit:hover {
        color: var(--color-accent);
    }

    .btn-delete:hover {
        color: #ef4444;
    }

    /* Add Address Card */
    .add-address-card {
        border: 2px dashed var(--color-border, rgba(245, 158, 11, 0.3));
        border-radius: 10px;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: var(--transition-premium);
        background: var(--color-surface, rgba(255, 255, 255, 0.02));
    }

    .add-address-card:hover {
        border-color: var(--color-accent);
        background: var(--color-surface, rgba(245, 158, 11, 0.05));
        transform: translateY(-2px);
    }

    .add-address-icon {
        font-size: 3rem;
        color: var(--color-accent);
        margin-bottom: 1rem;
    }

    .add-address-text {
        font-weight: var(--font-weight-semibold);
        color: var(--color-white);
        font-size: 1.1rem;
    }

    .order-summary-box {
        position: sticky;
        top: 2rem;
    }

    /* Order Summary */
    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        color: var(--color-text-light);
    }

    .summary-divider {
        border-top: 1px solid var(--color-border, rgba(245, 158, 11, 0.2));
        margin: 1rem 0;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        font-weight: var(--font-weight-bold);
        font-size: 1.2rem;
        color: var(--color-white);
        margin-top: 1rem;
    }

    /* Buttons */
    .btn-continue {
        background: linear-gradient(135deg, var(--color-accent) 0%, var(--color-accent-dark) 100%);
        border: none;
        color: #ffffff;
        padding: 14px;
        font-weight: var(--font-weight-semibold);
        border-radius: 8px;
        width: 100%;
        margin-top: 1.5rem;
        font-size: 1rem;
        transition: var(--transition-premium);
        box-shadow: 0 10px 25px rgba(245, 158, 11, 0.25);
    }

    .btn-continue:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 35px rgba(245, 158, 11, 0.35);
        color: #ffffff;
    }

    .btn-continue:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    .btn-back {
        background: transparent;
        border: 2px solid var(--color-accent);
        color: var(--color-accent);
        padding: 12px;
        font-weight: var(--font-weight-semibold);
        border-radius: 8px;
        width: 100%;
        margin-top: 0.75rem;
        transition: var(--transition-premium);
    }

    .btn-back:hover {
        background: var(--color-accent);
        color: #ffffff;
    }

    /* Empty State */
    .empty-address {
        text-align: center;
        padding: 3rem 1rem;
    }

    .empty-icon {
        font-size: 4rem;
        color: var(--color-text-dim);
        margin-bottom: 1rem;
    }

    .empty-address h4 {
        color: var(--color-white);
        margin-bottom: 0.5rem;
    }

    .empty-address p {
        color: var(--color-text-dim);
    }

    /* Checkout Steps */
    .checkout-steps {
        display: flex;
        justify-content: center;
        margin-bottom: 2rem;
        gap: 2rem;
    }

    .step {
        display: flex;
        align-items: center;
        color: var(--color-text-dim);
        transition: var(--transition-fast);
    }

    .step.active {
        color: var(--color-accent);
        font-weight: var(--font-weight-semibold);
    }

    .step.completed {
        color: #10b981;
    }

    .step-number {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: 2px solid var(--color-border, rgba(245, 158, 11, 0.3));
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.5rem;
        font-weight: var(--font-weight-semibold);
        transition: var(--transition-fast);
    }

    .step.active .step-number {
        border-color: var(--color-accent);
        background: linear-gradient(135deg, var(--color-accent) 0%, var(--color-accent-dark) 100%);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }

    .step.completed .step-number {
        border-color: #10b981;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    /* Delivery Info Icons */
    .card-body .fa-truck,
    .card-body .fa-shield-alt {
        color: var(--color-accent);
    }

    .card-body h6 {
        color: var(--color-white);
    }

    .card-body small {
        color: var(--color-text-dim);
    }

    /* ========================================
       LIGHT THEME OVERRIDES
       ======================================== */
    
    [data-theme="light"] .card {
        background: var(--color-card-bg);
        border: 1px solid rgba(58, 119, 255, 0.2);
    }

    [data-theme="light"] .address-card {
        border-color: rgba(58, 119, 255, 0.25);
        background: var(--color-surface);
    }

    [data-theme="light"] .address-card:hover {
        border-color: var(--color-accent);
        background: rgba(58, 119, 255, 0.05);
    }

    [data-theme="light"] .address-card.selected {
        border-color: var(--color-accent);
        background: rgba(58, 119, 255, 0.1);
    }

    [data-theme="light"] .add-address-card {
        border-color: rgba(58, 119, 255, 0.3);
        background: var(--color-surface);
    }

    [data-theme="light"] .add-address-card:hover {
        border-color: var(--color-accent);
        background: rgba(58, 119, 255, 0.05);
    }

    [data-theme="light"] .btn-continue {
        background: linear-gradient(135deg, var(--color-accent) 0%, var(--color-accent-dark) 100%);
        box-shadow: 0 10px 25px rgba(58, 119, 255, 0.25);
    }

    [data-theme="light"] .btn-continue:hover {
        box-shadow: 0 15px 35px rgba(58, 119, 255, 0.35);
    }

    [data-theme="light"] .address-type-badge {
        background: linear-gradient(135deg, var(--color-accent) 0%, var(--color-accent-dark) 100%);
        box-shadow: 0 4px 12px rgba(58, 119, 255, 0.3);
    }

    [data-theme="light"] .step.active .step-number {
        background: linear-gradient(135deg, var(--color-accent) 0%, var(--color-accent-dark) 100%);
        box-shadow: 0 4px 12px rgba(58, 119, 255, 0.3);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .address-actions {
            position: static;
            margin-top: 1rem;
            text-align: right;
        }

        .checkout-steps {
            flex-direction: column;
            gap: 1rem;
        }

        .checkout-container {
            padding: 0 0.5rem;
        }
    }
</style>

<div class="container checkout-container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-custom">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cart') }}">Cart</a></li>
            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
        </ol>
    </nav>

    <!-- Checkout Steps -->
    <div class="checkout-steps">
        <div class="step completed">
            <div class="step-number"><i class="fas fa-check"></i></div>
            <span>Cart</span>
        </div>
        <div class="step active">
            <div class="step-number">2</div>
            <span>Address</span>
        </div>
        <div class="step">
            <div class="step-number">3</div>
            <span>Payment</span>
        </div>
    </div>

    <h1 class="page-title">Select Delivery Address</h1>

    <div class="row">
        <!-- Address Selection -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-map-marker-alt me-2"></i>
                    Choose Delivery Address
                </div>
                <div class="card-body">
                    @if(isset($addresses) && $addresses->count() > 0)
                        <form action="{{ route('order.order-payment') }}" method="GET" id="address-form">
                            @csrf
                            <input type="hidden" name="address_id" id="selected-address-id" value="">
                            
                            @foreach($addresses as $address)
                                <div class="address-card" onclick="selectAddress({{ $address->id }})">
                                    <div class="address-header">
                                        <input type="radio" 
                                               name="address" 
                                               id="address-{{ $address->id }}" 
                                               value="{{ $address->id }}"
                                               {{ $loop->first ? 'checked' : '' }}>
                                        <label for="address-{{ $address->id }}" class="address-name ms-2 mb-0">
                                            {{ $address->name }}
                                        </label>
                                        <span class="address-type-badge {{ strtolower($address->location_type) }}">
                                            {{ ucfirst($address->location_type) }}
                                        </span>
                                    </div>
                                    <div class="address-content">
                                        <div class="address-phone">
                                            <i class="fas fa-phone me-1"></i> {{ $address->mobile }}
                                        </div>
                                        <div class="address-text">
                                            {{ $address->address }}
                                            <br>{{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}
                                            <br>{{ $address->country }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Add New Address Card -->
                            <div class="add-address-card" onclick="window.location.href='{{ route('user.contacts.index') }}'">
                                <div class="add-address-icon">
                                    <i class="fas fa-plus-circle"></i>
                                </div>
                                <div class="add-address-text">
                                    Add New Address
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="empty-address">
                            <div class="empty-icon">
                                <i class="fas fa-map-marked-alt"></i>
                            </div>
                            <h4>No Address Found</h4>
                            <p class="text-muted mb-4">Please add a delivery address to continue</p>
                            <a href="{{ route('user.contacts.index') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus me-2"></i> Add New Address
                            </a>
                        </div>
                    @endif
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
                        <div class="summary-item">
                            <span>Items ({{ $itemCount ?? 0 }})</span>
                            <span>${{ number_format($subtotal ?? 0, 2) }}</span>
                        </div>
                        <div class="summary-item">
                            <span>Shipping</span>
                            <span>${{ number_format($shipping ?? 0, 2) }}</span>
                        </div>
                        <div class="summary-item">
                            <span>Tax</span>
                            <span>${{ number_format($tax ?? 0, 2) }}</span>
                        </div>
                        <div class="summary-divider"></div>
                        <div class="summary-total">
                            <span>Total</span>
                            <span>${{ number_format($total ?? 0, 2) }}</span>
                        </div>

                        @if(isset($addresses) && $addresses->count() > 0)
                            <button type="submit" form="address-form" class="btn-continue" id="continue-btn">
                                Continue to Payment
                                <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Delivery Info -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-truck fa-2x text-primary me-3"></i>
                            <div>
                                <h6 class="mb-0">Free Delivery</h6>
                                <small class="text-muted">On orders over $50</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-shield-alt fa-2x text-success me-3"></i>
                            <div>
                                <h6 class="mb-0">Secure Payment</h6>
                                <small class="text-muted">100% secure payment</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Select address
    function selectAddress(addressId) {
        // Remove selected class from all cards
        document.querySelectorAll('.address-card').forEach(card => {
            card.classList.remove('selected');
        });
        
        // Add selected class to clicked card
        event.currentTarget.classList.add('selected');
        
        // Check the radio button
        document.getElementById('address-' + addressId).checked = true;
        
        // Update hidden input
        document.getElementById('selected-address-id').value = addressId;
    }

    // Edit address
    function editAddress(addressId, event) {
        event.stopPropagation();
        window.location.href = `/address/edit/${addressId}`;
    }

    // Delete address
    function deleteAddress(addressId, event) {
        event.stopPropagation();
        
        if (confirm('Are you sure you want to delete this address?')) {
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/address/delete/${addressId}`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            
            form.appendChild(csrfToken);
            form.appendChild(methodField);
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Initialize first address as selected
    document.addEventListener('DOMContentLoaded', function() {
        const firstAddress = document.querySelector('.address-card');
        if (firstAddress) {
            const firstRadio = firstAddress.querySelector('input[type="radio"]');
            if (firstRadio) {
                firstAddress.classList.add('selected');
                document.getElementById('selected-address-id').value = firstRadio.value;
            }
        }
    });

    // Form validation
    document.getElementById('address-form')?.addEventListener('submit', function(e) {
        const selectedAddress = document.getElementById('selected-address-id').value;
        if (!selectedAddress) {
            e.preventDefault();
            alert('Please select a delivery address');
            return false;
        }
    });
</script>
@endsection