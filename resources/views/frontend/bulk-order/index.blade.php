@extends('frontend.layout.main')

@section('title', 'Bulk Order - Select Seller')

@push('styles')
<style>
.bulk-order-container {
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 2rem 0;
}

.bulk-order-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    overflow: hidden;
}

.bulk-order-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    text-align: center;
}

.step-indicator {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 2rem 0;
}

.step {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #e9ecef;
    color: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin: 0 1rem;
    position: relative;
}

.step.active {
    background: #007bff;
    color: white;
}

.step.completed {
    background: #28a745;
    color: white;
}

.step::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 100%;
    width: 2rem;
    height: 2px;
    background: #e9ecef;
    transform: translateY(-50%);
}

.step:last-child::after {
    display: none;
}

.step.completed::after {
    background: #28a745;
}

.seller-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
    padding: 2rem;
}

.seller-card {
    border: 2px solid #e9ecef;
    border-radius: 15px;
    padding: 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
}

.seller-card:hover {
    border-color: #007bff;
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,123,255,0.15);
}

.seller-card.selected {
    border-color: #007bff;
    background: #f8f9ff;
}

.seller-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    margin: 0 auto 1rem;
    object-fit: cover;
    border: 3px solid #e9ecef;
}

.seller-name {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #2c3e50;
}

.seller-company {
    color: #6c757d;
    margin-bottom: 1rem;
}

.seller-stats {
    display: flex;
    justify-content: space-around;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #e9ecef;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: bold;
    color: #007bff;
}

.stat-label {
    font-size: 0.8rem;
    color: #6c757d;
}

.search-box {
    position: relative;
    margin-bottom: 2rem;
}

.search-input {
    width: 100%;
    padding: 1rem 1rem 1rem 3rem;
    border: 2px solid #e9ecef;
    border-radius: 50px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.search-input:focus {
    outline: none;
    border-color: #007bff;
}

.search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
}

.continue-btn {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    background: #007bff;
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 50px;
    font-size: 1.1rem;
    font-weight: 600;
    box-shadow: 0 10px 25px rgba(0,123,255,0.3);
    cursor: pointer;
    transition: all 0.3s ease;
    display: none;
}

.continue-btn:hover {
    background: #0056b3;
    transform: translateY(-2px);
}

.continue-btn.show {
    display: block;
}

.empty-state {
    text-align: center;
    padding: 3rem;
    color: #6c757d;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 1rem;
    color: #dee2e6;
}

@media (max-width: 768px) {
    .seller-grid {
        grid-template-columns: 1fr;
        padding: 1rem;
    }
    
    .step-indicator {
        margin: 1rem 0;
    }
    
    .step {
        width: 30px;
        height: 30px;
        font-size: 0.8rem;
        margin: 0 0.5rem;
    }
    
    .continue-btn {
        bottom: 1rem;
        right: 1rem;
        left: 1rem;
        width: auto;
    }
}
</style>
@endpush

@section('content')
<div class="bulk-order-container">
    <div class="container">
        <div class="bulk-order-card">
            <!-- Header -->
            <div class="bulk-order-header">
                <h1><i class="fas fa-shopping-cart me-2"></i>Bulk Order</h1>
                <p class="mb-0">Order multiple products from sellers at wholesale prices</p>
            </div>

            <!-- Step Indicator -->
            <div class="step-indicator">
                <div class="step active">1</div>
                <div class="step">2</div>
                <div class="step">3</div>
                <div class="step">4</div>
            </div>
            <div class="text-center mb-4">
                <small class="text-muted">Step 1: Select Seller → Step 2: Choose Category → Step 3: Select Products → Step 4: Place Order</small>
            </div>

            <!-- Search Box -->
            <div class="px-4">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" id="sellerSearch" placeholder="Search sellers by name or company...">
                </div>
            </div>

            <!-- Sellers Grid -->
            <div class="seller-grid" id="sellersGrid">
                @forelse($sellers as $seller)
                    <div class="seller-card" data-seller-id="{{ $seller->id }}" onclick="selectSeller({{ $seller->id }})">
                        <img src="{{ $seller->user->avatar ? asset('storage/' . $seller->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($seller->user->name ?? $seller->company_name) . '&background=007bff&color=ffffff&size=80' }}" 
                             alt="{{ $seller->user->name ?? $seller->company_name }}" class="seller-avatar">
                        
                        <div class="seller-name">{{ $seller->user->name ?? 'Seller' }}</div>
                        <div class="seller-company">{{ $seller->company_name ?? 'Company Name' }}</div>
                        
                        <div class="seller-stats">
                            <div class="stat-item">
                                <div class="stat-number">{{ $seller->products_count }}</div>
                                <div class="stat-label">Products</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">{{ $seller->rating ?? '4.5' }}</div>
                                <div class="stat-label">Rating</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state">
                            <i class="fas fa-store"></i>
                            <h4>No Sellers Available</h4>
                            <p>There are currently no sellers with active products for bulk ordering.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Continue Button -->
    <button class="continue-btn" id="continueBtn" onclick="proceedToCategories()">
        <i class="fas fa-arrow-right me-2"></i>Continue to Categories
    </button>
</div>

<!-- Categories Modal -->
<div class="modal fade" id="categoriesModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-th-large me-2"></i>Select Category
                    <small class="text-muted d-block">Choose from <span id="sellerName"></span>'s categories</small>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row" id="categoriesGrid">
                    <!-- Categories will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Products Modal -->
<div class="modal fade" id="productsModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-boxes me-2"></i>Select Products
                    <small class="text-muted d-block">Choose products from <span id="categoryName"></span></small>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row" id="productsGrid">
                    <!-- Products will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-between w-100">
                    <div>
                        <span class="badge bg-primary" id="selectedCount">0 items selected</span>
                        <span class="badge bg-success ms-2" id="totalAmount">$0.00</span>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="proceedToCheckout()" disabled id="checkoutBtn">
                        <i class="fas fa-shopping-cart me-2"></i>Proceed to Checkout
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let selectedSeller = null;
let selectedCategory = null;
let selectedProducts = [];

// Search functionality
document.getElementById('sellerSearch').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const sellerCards = document.querySelectorAll('.seller-card');
    
    sellerCards.forEach(card => {
        const sellerName = card.querySelector('.seller-name').textContent.toLowerCase();
        const companyName = card.querySelector('.seller-company').textContent.toLowerCase();
        
        if (sellerName.includes(searchTerm) || companyName.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});

// Select seller
function selectSeller(sellerId) {
    // Remove previous selection
    document.querySelectorAll('.seller-card').forEach(card => {
        card.classList.remove('selected');
    });
    
    // Add selection to clicked card
    const selectedCard = document.querySelector(`[data-seller-id="${sellerId}"]`);
    selectedCard.classList.add('selected');
    
    selectedSeller = sellerId;
    
    // Show continue button
    document.getElementById('continueBtn').classList.add('show');
}

// Proceed to categories
async function proceedToCategories() {
    if (!selectedSeller) return;
    
    try {
        const response = await fetch(`/api/bulk-order/seller/${selectedSeller}/categories`);
        const data = await response.json();
        
        if (data.success) {
            document.getElementById('sellerName').textContent = data.seller.company_name || data.seller.name;
            
            const categoriesGrid = document.getElementById('categoriesGrid');
            categoriesGrid.innerHTML = '';
            
            data.categories.forEach(category => {
                const categoryCard = `
                    <div class="col-md-4 mb-3">
                        <div class="card category-card h-100" onclick="selectCategory(${category.id}, '${category.name}')">
                            <img src="${category.image ? '/storage/' + category.image : '/images/placeholder-category.jpg'}" 
                                 class="card-img-top" style="height: 150px; object-fit: cover;">
                            <div class="card-body text-center">
                                <h6 class="card-title">${category.name}</h6>
                                <p class="text-muted small">${category.products_count} products</p>
                            </div>
                        </div>
                    </div>
                `;
                categoriesGrid.innerHTML += categoryCard;
            });
            
            // Show categories modal
            new bootstrap.Modal(document.getElementById('categoriesModal')).show();
        }
    } catch (error) {
        console.error('Error loading categories:', error);
        alert('Failed to load categories. Please try again.');
    }
}

// Select category and load products
async function selectCategory(categoryId, categoryName) {
    selectedCategory = categoryId;
    
    try {
        const response = await fetch(`/api/bulk-order/seller/${selectedSeller}/category/${categoryId}/products`);
        const data = await response.json();
        
        if (data.success) {
            document.getElementById('categoryName').textContent = categoryName;
            
            const productsGrid = document.getElementById('productsGrid');
            productsGrid.innerHTML = '';
            
            data.products.forEach(product => {
                const productCard = `
                    <div class="col-md-4 mb-3">
                        <div class="card product-card h-100">
                            <img src="${product.images.length > 0 ? '/storage/' + product.images[0] : '/images/placeholder-product.jpg'}" 
                                 class="card-img-top" style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h6 class="card-title">${product.name}</h6>
                                <p class="text-muted small">${product.description ? product.description.substring(0, 100) + '...' : 'No description'}</p>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="h6 text-primary mb-0">$${parseFloat(product.b2b_price).toFixed(2)}</span>
                                    <small class="text-muted">MOQ: ${product.b2b_moq}</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <input type="number" class="form-control form-control-sm me-2" 
                                           id="qty-${product.id}" min="${product.b2b_moq}" value="${product.b2b_moq}" 
                                           style="width: 80px;">
                                    <button class="btn btn-primary btn-sm" onclick="addToSelection(${product.id}, '${product.name}', ${product.b2b_price})">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                productsGrid.innerHTML += productCard;
            });
            
            // Hide categories modal and show products modal
            bootstrap.Modal.getInstance(document.getElementById('categoriesModal')).hide();
            new bootstrap.Modal(document.getElementById('productsModal')).show();
        }
    } catch (error) {
        console.error('Error loading products:', error);
        alert('Failed to load products. Please try again.');
    }
}

// Add product to selection
function addToSelection(productId, productName, price) {
    const qtyInput = document.getElementById(`qty-${productId}`);
    const quantity = parseInt(qtyInput.value);
    
    if (quantity < 1) {
        alert('Please enter a valid quantity');
        return;
    }
    
    // Check if product already selected
    const existingIndex = selectedProducts.findIndex(p => p.product_id === productId);
    
    if (existingIndex >= 0) {
        // Update quantity
        selectedProducts[existingIndex].quantity = quantity;
        selectedProducts[existingIndex].total = quantity * price;
    } else {
        // Add new product
        selectedProducts.push({
            product_id: productId,
            name: productName,
            quantity: quantity,
            price: price,
            total: quantity * price
        });
    }
    
    updateSelectionSummary();
    
    // Visual feedback
    const btn = event.target.closest('button');
    btn.innerHTML = '<i class="fas fa-check"></i>';
    btn.classList.remove('btn-primary');
    btn.classList.add('btn-success');
    
    setTimeout(() => {
        btn.innerHTML = '<i class="fas fa-plus"></i>';
        btn.classList.remove('btn-success');
        btn.classList.add('btn-primary');
    }, 1000);
}

// Update selection summary
function updateSelectionSummary() {
    const count = selectedProducts.length;
    const total = selectedProducts.reduce((sum, product) => sum + product.total, 0);
    
    document.getElementById('selectedCount').textContent = `${count} items selected`;
    document.getElementById('totalAmount').textContent = `$${total.toFixed(2)}`;
    
    const checkoutBtn = document.getElementById('checkoutBtn');
    if (count > 0) {
        checkoutBtn.disabled = false;
    } else {
        checkoutBtn.disabled = true;
    }
}

// Proceed to checkout
function proceedToCheckout() {
    if (selectedProducts.length === 0) return;
    
    // Store data in sessionStorage and redirect to checkout
    sessionStorage.setItem('bulkOrderData', JSON.stringify({
        seller_id: selectedSeller,
        products: selectedProducts
    }));
    
    window.location.href = '/bulk-order/checkout';
}
</script>
@endpush