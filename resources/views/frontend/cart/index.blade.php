@extends('frontend.layout.main')
@section('content')
<style>
    .cart-container {
        max-width: 1200px;
        margin: 2rem auto;
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
        box-shadow: var(--card-shadow);
        margin-bottom: 1.5rem;
    }

    .card-header {
        background: white;
        border-bottom: 1px solid #e9ecef;
        padding: 1rem 1.5rem;
        font-weight: 600;
        color: var(--dark-text);
    }

    .card-body {
        padding: 1.5rem;
    }

    .cart-item {
        display: flex;
        padding: 1.5rem;
        border-bottom: 1px solid #f1f3f5;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .item-image {
        width: 120px;
        height: 120px;
        object-fit: contain;
        border-radius: 8px;
        background: #f8f9fa;
        padding: 10px;
    }

    .item-details {
        flex: 1;
        padding: 0 1.5rem;
    }

    .item-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--dark-text);
    }

    .item-seller {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .item-price {
        font-weight: 600;
        color: var(--secondary);
        font-size: 1.1rem;
    }

    .item-actions {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: flex-end;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        overflow: hidden;
    }

    .quantity-btn {
        background: #f8f9fa;
        border: none;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .quantity-btn:hover {
        background: #e9ecef;
    }

    .quantity-input {
        width: 40px;
        height: 32px;
        border: none;
        text-align: center;
        background: white;
    }

    .remove-btn {
        color: #dc3545;
        background: none;
        border: none;
        font-size: 0.9rem;
        cursor: pointer;
    }

    .remove-btn:hover {
        text-decoration: underline;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.8rem;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        font-weight: 600;
        font-size: 1.2rem;
        border-top: 1px solid #e9ecef;
        padding-top: 1rem;
        margin-top: 1rem;
    }

    .btn-checkout {
        background: var(--secondary);
        border: none;
        color: white;
        padding: 12px;
        font-weight: 600;
        border-radius: 8px;
        width: 100%;
        margin-top: 1.5rem;
    }

    .btn-checkout:hover {
        background: #e65c00;
    }

    .btn-checkout:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .empty-cart {
        text-align: center;
        padding: 3rem;
    }

    .empty-cart-icon {
        font-size: 4rem;
        color: #dee2e6;
        margin-bottom: 1.5rem;
    }

    .saved-for-later {
        margin-top: 2rem;
    }

    .promo-code {
        display: flex;
        margin-top: 1rem;
    }

    .promo-input {
        flex: 1;
        border: 1px solid #dee2e6;
        border-right: none;
        border-radius: 6px 0 0 6px;
        padding: 0.5rem 1rem;
    }

    .btn-apply {
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 0 6px 6px 0;
        padding: 0.5rem 1rem;
    }

    .btn-apply:hover {
        background: var(--primary-dark);
    }

    @media (max-width: 768px) {
        .cart-item {
            flex-direction: column;
        }

        .item-image {
            width: 100%;
            height: auto;
            margin-bottom: 1rem;
        }

        .item-details {
            padding: 0;
            margin-bottom: 1rem;
        }

        .item-actions {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }
    }
</style>

<div class="container cart-container">
    <h1 class="page-title">Shopping Cart</h1>

    <div class="row">
        <!-- Cart Items -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="selectAll" 
                               {{ $cart && $cart->items->where('is_selected', true)->count() === $cart->items->count() && $cart->items->count() > 0 ? 'checked' : '' }}>
                        <label class="form-check-label" for="selectAll">
                            Select all items (<span id="selected-count">{{ $cart ? $cart->items->where('is_selected', true)->count() : 0 }}</span>)
                        </label>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if ($cart && $cart->items->count() > 0)
                        @foreach ($cart->items as $item)
                            <div class="cart-item" data-item-id="{{ $item->id }}">
                                <div class="form-check">
                                    <input class="form-check-input item-checkbox" 
                                           type="checkbox" 
                                           id="item-{{ $item->id }}" 
                                           data-item-id="{{ $item->id }}"
                                           data-price="{{ $item->price }}" 
                                           data-quantity="{{ $item->quantity }}"
                                           {{ $item->is_selected ? 'checked' : '' }}>
                                </div>
                                <img src="{{ asset('storage/' . ($item->product->images[0] ?? 'placeholder.png')) }}"
                                    alt="{{ $item->product->name }}" class="item-image">
                                <div class="item-details">
                                    <h5 class="item-title">{{ $item->product->name }}</h5>
                                    <p class="item-seller">Sold by:
                                        {{ $item->product->seller->company_name ?? 'N/A' }}</p>
                                    <p class="item-price">${{ number_format($item->price, 2) }}</p>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="gift{{ $item->id }}">
                                        <label class="form-check-label" for="gift{{ $item->id }}">
                                            This is a gift
                                        </label>
                                    </div>
                                </div>
                                <div class="item-actions">
                                    <div class="quantity-control">
                                        <button class="quantity-btn" onclick="updateQuantity({{ $item->id }}, -1)">-</button>
                                        <input type="number" class="quantity-input" value="{{ $item->quantity }}"
                                            id="quantity-{{ $item->id }}" min="1" max="99" readonly>
                                        <button class="quantity-btn" onclick="updateQuantity({{ $item->id }}, 1)">+</button>
                                    </div>
                                    <form action="{{ route('cart.remove', $item) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to remove this item?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="remove-btn">
                                            <i class="fas fa-trash-alt me-1"></i> Remove
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-cart">
                            <div class="empty-cart-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <h4>Your cart is empty</h4>
                            <p class="text-muted">Add items to get started</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Saved for Later -->
            <div class="card saved-for-later">
                <div class="card-header">
                    Saved for later (1 item)
                </div>
                <div class="card-body p-0">
                    <div class="cart-item">
                        <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
                            alt="Car Parts" class="item-image">
                        <div class="item-details">
                            <h5 class="item-title">Automotive Spare Parts Kit</h5>
                            <p class="item-seller">Sold by: AutoParts Direct</p>
                            <p class="item-price">$1,250.00</p>
                        </div>
                        <div class="item-actions">
                            <button class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-cart-plus me-1"></i> Move to Cart
                            </button>
                            <button class="remove-btn mt-2">
                                <i class="fas fa-trash-alt me-1"></i> Remove
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    Order Summary
                </div>
                <div class="card-body">
                    <div class="summary-item">
                        <span>Subtotal (<span id="summary-count">0</span> items)</span>
                        <span id="summary-subtotal">$0.00</span>
                    </div>
                    <div class="summary-item">
                        <span>Shipping</span>
                        <span id="summary-shipping">$0.00</span>
                    </div>
                    <div class="summary-item">
                        <span>Tax</span>
                        <span id="summary-tax">$0.00</span>
                    </div>
                    <div class="promo-code">
                        <input type="text" class="promo-input" id="promo-code-input" placeholder="Promo code">
                        <button class="btn-apply" onclick="applyPromoCode()">Apply</button>
                    </div>
                    <div class="summary-total">
                        <span>Total</span>
                        <span id="summary-total">$0.00</span>
                    </div>
                    <!-- @if ($cart && $cart->items->count() > 0)
                        <form action="{{ route('order', $cart) }}" method="POST" id="checkout-form">
                            @csrf
                            <input type="hidden" name="selected_items" id="selected-items-input">
                            <button type="submit" class="btn-checkout" id="checkout-btn">
                                <i class="fas fa-lock me-2"></i> Proceed to Checkout
                            </button>
                        </form>
                    @endif -->

                    @if ($cart && $cart->items->count() > 0)
                        <form action="{{ route('order.select-address', $cart->id) }}" method="Post" id="checkout-form">
                            @csrf
                            <input type="hidden" name="selected_items" id="selected-items-input">
                            <button type="submit" class="btn-checkout" id="checkout-btn">
                                <i class="fas fa-lock me-2"></i> Proceed to Checkout
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Security Badge -->
            <div class="card mt-4">
                <div class="card-body text-center">
                    <i class="fas fa-shield-alt fa-2x text-primary mb-2"></i>
                    <h6>Secure Checkout</h6>
                    <p class="small text-muted">Your transaction is secured with SSL encryption</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Cart configuration
    const CART_ID = {{ $cart ? $cart->id : 0 }};
    const SHIPPING_RATE = {{ $shipping ?? 15 }};
    const TAX_RATE = 0.08;
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;

    // Initialize cart on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateCartSummary();
        updateSelectedCount();
    });

    // Update quantity function with database sync
    function updateQuantity(itemId, change) {
        const quantityInput = document.getElementById(`quantity-${itemId}`);
        let quantity = parseInt(quantityInput.value);
        quantity += change;

        if (quantity < 1) quantity = 1;
        if (quantity > 99) quantity = 99;

        quantityInput.value = quantity;
        
        // Update data attribute
        const checkbox = document.getElementById(`item-${itemId}`);
        checkbox.setAttribute('data-quantity', quantity);
        
        // Update cart summary
        updateCartSummary();

        // Send AJAX request to update quantity in database
        fetch(`/cart/update/${itemId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Quantity updated successfully');
            }
        })
        .catch(error => {
            console.error('Error updating quantity:', error);
            alert('Failed to update quantity. Please try again.');
        });
    }

    // Toggle selection for individual item
    function toggleItemSelection(itemId, isSelected) {
        fetch(`/cart/${itemId}/toggle-selection`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN
            },
            body: JSON.stringify({ is_selected: isSelected })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Item selection updated');
            }
        })
        .catch(error => {
            console.error('Error updating selection:', error);
        });
    }

    // Select all items functionality with database sync
    document.getElementById('selectAll').addEventListener('change', function() {
        const isChecked = this.checked;
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        
        itemCheckboxes.forEach(checkbox => {
            checkbox.checked = isChecked;
        });
        
        updateCartSummary();
        updateSelectedCount();

        // Sync with database
        fetch(`/cart/${CART_ID}/toggle-select-all`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN
            },
            body: JSON.stringify({ select_all: isChecked })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log(data.message);
            }
        })
        .catch(error => {
            console.error('Error updating selection:', error);
        });
    });

    // Individual checkbox change with database sync
    document.querySelectorAll('.item-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const itemId = this.getAttribute('data-item-id');
            const isSelected = this.checked;
            
            updateCartSummary();
            updateSelectedCount();
            updateSelectAllCheckbox();

            // Sync with database
            toggleItemSelection(itemId, isSelected);
        });
    });

    // Update select all checkbox based on individual selections
    function updateSelectAllCheckbox() {
        const selectAllCheckbox = document.getElementById('selectAll');
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
        
        selectAllCheckbox.checked = itemCheckboxes.length === checkedBoxes.length && itemCheckboxes.length > 0;
    }

    // Update selected count
    function updateSelectedCount() {
        const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
        document.getElementById('selected-count').textContent = checkedBoxes.length;
    }

    // Update cart summary
    function updateCartSummary() {
        const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
        let subtotal = 0;
        let totalQuantity = 0;
        const selectedItems = [];

        checkedBoxes.forEach(checkbox => {
            const price = parseFloat(checkbox.getAttribute('data-price'));
            const quantity = parseInt(checkbox.getAttribute('data-quantity'));
            subtotal += price * quantity;
            totalQuantity += quantity;
            selectedItems.push(checkbox.getAttribute('data-item-id'));
        });

        const shipping = checkedBoxes.length > 0 ? SHIPPING_RATE : 0;
        const tax = subtotal * TAX_RATE;
        const total = subtotal + shipping + tax;

        // Update summary display
        document.getElementById('summary-count').textContent = totalQuantity;
        document.getElementById('summary-subtotal').textContent = `$${subtotal.toFixed(2)}`;
        document.getElementById('summary-shipping').textContent = `$${shipping.toFixed(2)}`;
        document.getElementById('summary-tax').textContent = `$${tax.toFixed(2)}`;
        document.getElementById('summary-total').textContent = `$${total.toFixed(2)}`;

        // Update hidden input for checkout
        document.getElementById('selected-items-input').value = selectedItems.join(',');

        // Disable checkout button if no items selected
        const checkoutBtn = document.getElementById('checkout-btn');
        if (checkoutBtn) {
            checkoutBtn.disabled = checkedBoxes.length === 0;
        }
    }

    // Apply promo code
    function applyPromoCode() {
        const promoCode = document.getElementById('promo-code-input').value.trim();
        
        if (!promoCode) {
            alert('Please enter a promo code');
            return;
        }

        fetch('/cart/apply-promo', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN
            },
            body: JSON.stringify({ promo_code: promoCode })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Promo code applied successfully!');
                updateCartSummary();
                document.getElementById('promo-code-input').value = '';
            } else {
                alert(data.message || 'Invalid promo code');
            }
        })
        .catch(error => {
            console.error('Error applying promo code:', error);
            alert('Error applying promo code. Please try again.');
        });
    }

    // Checkout form validation
    const checkoutForm = document.getElementById('checkout-form');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');
            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('Please select at least one item to checkout');
                return false;
            }
        });
    }
</script>
@endsection