@extends('frontend.layout.main')
@section('content')
<style>
    .checkout-container {
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

    .address-card {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .address-card:hover {
        border-color: var(--primary);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.15);
    }

    .address-card.selected {
        border-color: var(--primary);
        background: #f0f8ff;
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.2);
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

    .address-type-badge {
        background: var(--primary);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.85rem;
        margin-left: 1rem;
    }

    .address-type-badge.work {
        background: #6f42c1;
    }

    .address-type-badge.other {
        background: #20c997;
    }

    .address-content {
        margin-left: 2rem;
        color: #495057;
        line-height: 1.6;
    }

    .address-name {
        font-weight: 600;
        font-size: 1.05rem;
        color: var(--dark-text);
    }

    .address-phone {
        color: #6c757d;
        font-size: 0.95rem;
    }

    .address-text {
        margin-top: 0.5rem;
        color: #495057;
    }

    .address-actions {
        position: absolute;
        top: 1rem;
        right: 1rem;
    }

    .btn-edit, .btn-delete {
        background: none;
        border: none;
        color: #6c757d;
        padding: 0.25rem 0.5rem;
        cursor: pointer;
        font-size: 0.9rem;
    }

    .btn-edit:hover {
        color: var(--primary);
    }

    .btn-delete:hover {
        color: #dc3545;
    }

    .add-address-card {
        border: 2px dashed #dee2e6;
        border-radius: 10px;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .add-address-card:hover {
        border-color: var(--primary);
        background: #f8f9fa;
    }

    .add-address-icon {
        font-size: 3rem;
        color: var(--primary);
        margin-bottom: 1rem;
    }

    .add-address-text {
        font-weight: 600;
        color: var(--dark-text);
        font-size: 1.1rem;
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

    .btn-continue {
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

    .btn-continue:hover {
        background: #e65c00;
        transform: translateY(-1px);
    }

    .btn-continue:disabled {
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

    .empty-address {
        text-align: center;
        padding: 3rem 1rem;
    }

    .empty-icon {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 1rem;
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