@extends('frontend.layout.main')
@section('content')
    <!--  Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <h1>Your Gateway to Global Trade Excellence</h1>
                    <p>Connect with verified suppliers and buyers worldwide to secure premium deals on bulk orders with
                        confidence and efficiency.</p>

                    <div class="search-container">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-lg hero-search-input"
                                placeholder="What are you looking for? (e.g., electronics, textiles, machinery)">
                            <button class="btn search-btn"><i class="fas fa-search me-2"></i> Search</button>
                        </div>
                        <div class="popular-searches mt-3">
                            <span>Popular Searches:</span>
                            <a href="#">Electronics</a>
                            <a href="#">Machinery</a>
                            <a href="#">Textiles</a>
                            <a href="#">Raw Materials</a>
                        </div>
                    </div>

                    <div class="hero-stats">
                        <div class="stat-item">
                            <div class="stat-value">50K+</div>
                            <div class="stat-label">Verified Suppliers</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">120+</div>
                            <div class="stat-label">Countries</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">$10B+</div>
                            <div class="stat-label">Annual Trade</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image-wrapper">
                        <div class="hero-image-overlay"></div>
                        <img src="https://img.freepik.com/free-vector/global-business-connection-illustration_53876-17394.jpg"
                            alt="Global business connections" class="img-fluid hero-image">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section -->
    <section class="container my-5">
        <h2 class="text-center mb-4">Top Categories</h2>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="category-card card">
                    <img src="https://img.freepik.com/free-photo/electronic-devices_144627-41317.jpg" class="category-img"
                        alt="Electronics">
                    <div class="card-body">
                        <h5 class="card-title">Electronics</h5>
                        <p class="card-text text-muted">20,000+ products</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="category-card card">
                    <img src="https://img.freepik.com/free-photo/industrial-machines_1127-3426.jpg" class="category-img"
                        alt="Machinery">
                    <div class="card-body">
                        <h5 class="card-title">Machinery</h5>
                        <p class="card-text text-muted">15,000+ products</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="category-card card">
                    <img src="https://img.freepik.com/free-photo/fabric-samples-textile-swatches_93675-130843.jpg"
                        class="category-img" alt="Textiles">
                    <div class="card-body">
                        <h5 class="card-title">Textiles</h5>
                        <p class="card-text text-muted">25,000+ products</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="category-card card">
                    <img src="https://img.freepik.com/free-photo/construction-equipment_1127-3294.jpg" class="category-img"
                        alt="Construction">
                    <div class="card-body">
                        <h5 class="card-title">Construction</h5>
                        <p class="card-text text-muted">18,000+ products</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <!-- Filters Sidebar -->
            <div class="col-lg-3">
                <div class="filter-section mb-4">
                    <h5 class="filter-title">Filters</h5>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Price</label>
                        <select class="form-select">
                            <option selected>All Prices</option>
                            <option>Low to High</option>
                            <option>High to Low</option>
                            <option>Under $100</option>
                            <option>$100 - $500</option>
                            <option>Over $500</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Product Rating</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rating4">
                            <label class="form-check-label" for="rating4">
                                <span class="rating">★★★★</span> & Up
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rating3">
                            <label class="form-check-label" for="rating3">
                                <span class="rating">★★★</span> & Up
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Seller Type</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="verifiedManuf">
                            <label class="form-check-label" for="verifiedManuf">
                                Verified Manufacturers
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="bulkOrders">
                            <label class="form-check-label" for="bulkOrders">
                                Bulk Order Available
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Location</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="nearest">
                            <label class="form-check-label" for="nearest">
                                Nearest Sellers
                            </label>
                        </div>
                    </div>

                    <button class="btn btn-primary w-100">Apply Filters</button>
                </div>

                <div class="filter-section">
                    <h5 class="filter-title">Categories</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Electronics
                            <span class="badge bg-primary rounded-pill">128</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Home Appliances
                            <span class="badge bg-primary rounded-pill">76</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Machinery
                            <span class="badge bg-primary rounded-pill">54</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Raw Materials
                            <span class="badge bg-primary rounded-pill">42</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Apparel & Textiles
                            <span class="badge bg-primary rounded-pill">89</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                    @foreach ($featuredProducts as $product)
                        <div class="col">
                            {{-- CARD START --}}
                            <div class="card modern-product-card shadow-sm h-100">
                                @php
                                    $stock = $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock';
                                    $images = is_array($product->images)
                                        ? $product->images
                                        : json_decode($product->images, true);
                                    $firstImage = $images[0] ?? 'default.png'; // fallback image
                                @endphp

                                <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none">
                                    <div class="product-img-container">
                                        <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $product->name }}"
                                            class="card-img-top modern-product-img">
                                    </div>
                                </a>

                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <a href="{{ route('product.show', $product->slug) }}"
                                            class="text-decoration-none text-dark">
                                            <h5 class="card-title fw-semibold mb-0">{{ $product->name }}
                                            </h5>
                                        </a>
                                        {{-- Badge inside for modern look --}}
                                        <span
                                            class="user-type-badge badge rounded-pill bg-success-subtle text-success ms-2">{{ $stock }}</span>
                                    </div>

                                    <div class="modern-rating mb-2">
                                        <span class="text-warning">
                                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star-half-alt"></i>
                                        </span>
                                        <small class="text-muted ms-1">({{ number_format(128) }})</small>
                                    </div>

                                    <p class="card-text text-muted mb-3 small">
                                        {{ Str::limit($product->description, 70) }}</p>

                                    {{-- Price and MOQ --}}
                                    <div class="mt-auto"> {{-- Pushes price/actions to the bottom --}}
                                        @auth
                                            @if (Auth::user()->role === 'b2c')
                                                @if ($product->activePromotion && $product->activePromotion->type == 'buy_get')
                                                    <span class="badge bg-warning text-dark">
                                                        Buy {{ $product->activePromotion->rules->first()->buy_quantity }}
                                                        Get {{ $product->activePromotion->rules->first()->get_quantity }}
                                                        Free
                                                    </span>
                                                @endif
                                                <div class="price-section mb-3">
                                                    <p class="product-price fs-5 fw-bold text-dark mb-0">
                                                        ${{ number_format($product->b2c_price, 2) }}
                                                        @if ($product->b2c_compare_price)
                                                            <span class="text-muted text-decoration-line-through small ms-2">
                                                                ${{ number_format($product->b2c_compare_price, 2) }}
                                                            </span>
                                                        @endif
                                                    </p>
                                                    <p class="text-secondary small mb-0">Min. order: 1 piece</p>
                                                </div>
                                            @elseif (Auth::user()->role === 'b2b')
                                                <div class="price-section mb-3">
                                                    <p class="product-price fs-5 fw-bold text-dark mb-0">
                                                        ${{ number_format($product->b2b_price, 2) }}
                                                    </p>
                                                    <p class="text-secondary small mb-0">Min. order:
                                                        {{ $product->b2b_moq }} pieces</p>
                                                </div>
                                            @endif
                                        @endauth
                                    </div>


                                    {{-- Footer actions (integrated into body for cleaner look) --}}
                                    @auth
                                        @if (Auth::user()->role === 'b2c')
                                            <div class="action-group d-flex gap-2">
                                                <form action="{{ route('addToCart', $product) }}" method="POST"
                                                    class="flex-grow-1">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-dark w-100 btn-sm">
                                                        <i class="fas fa-shopping-cart"></i> Add
                                                    </button>
                                                </form>
                                                <button class="btn btn-primary w-100 btn-sm">
                                                    <i class="fas fa-bolt"></i> Buy Now
                                                </button>
                                            </div>
                                        @elseif (Auth::user()->role === 'b2b')
                                            <div class="action-group">
                                                <a href="{{ route('inquiry.form', $product->slug) }}"
                                                    class="btn btn-primary w-100">
                                                    <i class="fas fa-envelope me-1"></i> Send Inquiry
                                                </a>
                                            </div>
                                        @endif
                                    @else
                                        {{-- Guest users --}}
                                        <div class="action-group text-center border-top pt-3">
                                            <a href="{{ route('login') }}" class="btn btn-outline-secondary w-100">
                                                <i class="fas fa-lock me-1"></i> Sign In to See Price
                                            </a>
                                        </div>
                                    @endauth
                                </div>
                            </div>
                            {{-- CARD END --}}
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
@endsection
