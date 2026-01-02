@extends('frontend.layout.main')

@section('title', 'Bulk Order Checkout')

@push('styles')
<style>
.checkout-container {
    min-height: 100vh;
    background: #f8f9fa;
    padding: 2rem 0;
}

.checkout-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    overflow: hidden;
}

.checkout-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    text-align: center;
}

.order-summary {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.product-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    border-bottom: 1px solid #e9ecef;
}

.product-item:last-child {
    border-bottom: none;
}

.product-image {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    object-fit: cover;
    margin-right: 1rem;
}

.product-details {
    flex: 1;
}

.product-name {
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.product-price {
    color: #007bff;
    font-weight: 600;
}

.quantity-badge {
    background: #007bff;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.875rem;
}

.form-section {
    margin-bottom: 2rem;
}

.form-section h5 {
    color: #2c3e50;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e9ecef;
}

.total-section {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1.5rem;
    margin-top: 2rem;
}

.total-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
}

.total-row.final {
    font-size: 1.25rem;
    font-weight: bold;
    color: #007bff;
    border-top: 2px solid #dee2e6;
    padding-top: 1rem;
    margin-top: 1rem;
}

.place-order-btn {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border: none;
    color: white;
    padding: 1rem 2rem;
    border-radius: 50px;
    font-size: 1.1rem;
    font-weight: 600;
    width: 100%;
    margin-top: 2rem;
    transition: all 0.3s ease;
}

.place-order-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(40, 167, 69, 0.3);
}

.back-btn {
    background: #6c757d;
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    text-decoration: none;
    display: inline-block;
    margin-bottom: 2rem;
    transition: all 0.3s ease;
}

.back-btn:hover {
    background: #5a6268;
    color: white;
    text-decoration: none;
}

@media (max-width: 768px) {
    .product-item {
        flex-direction: column;
        text-align: center;
    }
    
    .product-image {
        margin-right: 0;
        margin-bottom: 1rem;
    }
}
</style>
@endpush

@section('content')
<div class="checkout-container">
    <div class="container">
        <a href="/bulk-order" class="back-btn">
            <i class="fas fa-arrow-left me-2"></i>Back to Product Selection
        </a>

        <div class="checkout-card">
            <div class="checkout-header">
                <h1><i class="fas fa-clipboard-check me-2"></i>Bulk Order Checkout</h1>
                <p class="mb-0">Review your order and provide delivery details</p>
            </div>

            <div class="p-4">
                <div class="row">
                    <div class="col-lg-8">
                        <!-- Order Summary -->
                        <div class="form-section">
                            <h5><i class="fas fa-list me-2"></i>Order Summary</h5>
                            <div class="order-summary">
                                <div id="orderItems">
                                    <!-- Order items will be loaded here -->
                                </div>
                            </div>
                        </div>

                        <!-- Delivery Information -->
                        <div class="form-section">
                            <h5><i class="fas fa-truck me-2"></i>Delivery Information</h5>
                            <form id="checkoutForm">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Delivery Address *</label>
                                        <textarea class="form-control" name="delivery_address" rows="3" required 
                                                  placeholder="Enter your complete delivery address..."></textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Preferred Delivery Date</label>
                                        <input type="date" class="form-control" name="delivery_date" 
                                               min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Contact Phone</label>
                                        <input type="tel" class="form-control" name="contact_phone" 
                                               placeholder="Your contact number">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">Special Instructions</label>
                                        <textarea class="form-control" name="notes" rows="3" 
                                                  placeholder="Any special instructions for the seller..."></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <!-- Order Total -->
                        <div class="total-section">
                            <h5><i class="fas fa-calculator me-2"></i>Order Total</h5>
                            <div class="total-row">
                                <span>Subtotal:</span>
                                <span id="subtotal">$0.00</span>
                            </div>
                            <div class="total-row">
                                <span>Items:</span>
                                <span id="totalItems">0</span>
                            </div>
                            <div class="total-row final">
                                <span>Total Amount:</span>
                                <span id="totalAmount">$0.00</span>
                            </div>
                            
                            <button type="button" class="place-order-btn" onclick="placeOrder()">
                                <i class="fas fa-paper-plane me-2"></i>Place Bulk Order
                            </button>
                            
                            <div class="mt-3 text-center">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    The seller will review your order and respond within 24 hours
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                <h4>Order Submitted Successfully!</h4>
                <p class="text-muted">Your bulk order has been sent to the seller for review.</p>
                <p><strong>Order Number: <span id="orderNumber"></span></strong></p>
                <div class="mt-4">
                    <a href="/bulk-order/my-orders" class="btn btn-primary me-2">View My Orders</a>
                    <a href="/bulk-order" class="btn btn-outline-secondary">Place Another Order</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let orderData = null;

document.addEventListener('DOMContentLoaded', function() {
    // Load order data from sessionStorage
    const storedData = sessionStorage.getItem('bulkOrderData');
    if (!storedData) {
        alert('No order data found. Redirecting to bulk order page.');
        window.location.href = '/bulk-order';
        return;
    }
    
    orderData = JSON.parse(storedData);
    loadOrderSummary();
});

function loadOrderSummary() {
    const orderItems = document.getElementById('orderItems');
    let totalAmount = 0;
    let totalItems = 0;
    
    orderItems.innerHTML = '';
    
    orderData.products.forEach(product => {
        totalAmount += product.total;
        totalItems += product.quantity;
        
        const productItem = `
            <div class="product-item">
                <img src="/images/placeholder-product.jpg" alt="${product.name}" class="product-image">
                <div class="product-details">
                    <div class="product-name">${product.name}</div>
                    <div class="product-price">$${product.price.toFixed(2)} each</div>
                </div>
                <div class="text-end">
                    <div class="quantity-badge">${product.quantity} items</div>
                    <div class="mt-1 fw-bold">$${product.total.toFixed(2)}</div>
                </div>
            </div>
        `;
        orderItems.innerHTML += productItem;
    });
    
    // Update totals
    document.getElementById('subtotal').textContent = `$${totalAmount.toFixed(2)}`;
    document.getElementById('totalItems').textContent = totalItems;
    document.getElementById('totalAmount').textContent = `$${totalAmount.toFixed(2)}`;
}

async function placeOrder() {
    const form = document.getElementById('checkoutForm');
    const formData = new FormData(form);
    
    // Validate required fields
    if (!formData.get('delivery_address')) {
        alert('Please enter a delivery address');
        return;
    }
    
    // Prepare order data
    const orderPayload = {
        seller_id: orderData.seller_id,
        products: orderData.products.map(product => ({
            product_id: product.product_id,
            quantity: product.quantity,
            price: product.price
        })),
        delivery_address: formData.get('delivery_address'),
        delivery_date: formData.get('delivery_date'),
        contact_phone: formData.get('contact_phone'),
        notes: formData.get('notes')
    };
    
    try {
        // Show loading state
        const btn = document.querySelector('.place-order-btn');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Placing Order...';
        btn.disabled = true;
        
        const response = await fetch('/api/bulk-order/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(orderPayload)
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Clear stored data
            sessionStorage.removeItem('bulkOrderData');
            
            // Show success modal
            document.getElementById('orderNumber').textContent = data.order_number;
            new bootstrap.Modal(document.getElementById('successModal')).show();
        } else {
            throw new Error(data.message || 'Failed to place order');
        }
        
    } catch (error) {
        console.error('Error placing order:', error);
        alert('Failed to place order. Please try again.');
        
        // Reset button
        btn.innerHTML = originalText;
        btn.disabled = false;
    }
}
</script>
@endpush