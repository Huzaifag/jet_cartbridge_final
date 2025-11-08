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

                    <form method="GET" action="{{ route('home') }}" class="search-container">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control form-control-lg hero-search-input"
                                placeholder="What are you looking for? (e.g., electronics, textiles, machinery)"
                                value="{{ request('search') }}" style="color: #fff;">
                            <button type="submit" class="btn search-btn"><i class="fas fa-search me-2"></i> Search</button>
                        </div>
                        <div class="popular-searches mt-3">
                            <span>Popular Searches:</span>
                            <a href="{{ route('home', ['search' => 'Electronics']) }}">Electronics</a>
                            <a href="{{ route('home', ['search' => 'Machinery']) }}">Machinery</a>
                            <a href="{{ route('home', ['search' => 'Textiles']) }}">Textiles</a>
                            <a href="{{ route('home', ['search' => 'Raw Materials']) }}">Raw Materials</a>
                        </div>
                    </form>

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

    <!-- Premium Trust Badges Section -->
    <section class="trust-badges-section py-4 bg-white">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-3">
                    <div class="trust-badge">
                        <i class="fas fa-shield-alt fa-2x text-primary mb-2"></i>
                        <h6 class="mb-0">Secure Payments</h6>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div class="trust-badge">
                        <i class="fas fa-truck fa-2x text-success mb-2"></i>
                        <h6 class="mb-0">Fast Shipping</h6>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div class="trust-badge">
                        <i class="fas fa-certificate fa-2x text-warning mb-2"></i>
                        <h6 class="mb-0">Verified Sellers</h6>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <div class="trust-badge">
                        <i class="fas fa-headset fa-2x text-info mb-2"></i>
                        <h6 class="mb-0">24/7 Support</h6>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @auth
    <!-- Products from Followed Sellers/Manufacturers -->
    @if($followedProducts->count() > 0)
    <section class="container my-5">
        <div class="section-header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="section-title mb-1">
                    <i class="fas fa-heart text-danger me-2"></i>From Your Followed Sellers
                </h2>
                <p class="text-muted">Exclusive products from sellers and manufacturers you trust</p>
            </div>
        </div>
        <div class="premium-products-slider">
            <div class="row g-4">
                @foreach($followedProducts as $product)
                <div class="col-md-6 col-lg-3">
                    @include('frontend.pages.partials.product-card', ['product' => $product])
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    @endauth

    <!-- Trending Products Section -->
    @if($trendingProducts->count() > 0)
    <section class="trending-section py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2 class="section-title mb-2">
                    <i class="fas fa-fire text-danger me-2"></i>Trending Now
                </h2>
                <p class="text-muted">Most popular products loved by our community</p>
            </div>
            <div class="row g-4">
                @foreach($trendingProducts as $product)
                <div class="col-md-6 col-lg-3">
                    @include('frontend.pages.partials.product-card', ['product' => $product, 'showTrendingBadge' => true])
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Categories Section -->
    <section class="container my-5">
        <div class="section-header text-center mb-5">
            <h2 class="section-title mb-2">Shop by Category</h2>
            <p class="text-muted">Explore our wide range of product categories</p>
        </div>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="category-card card premium-card">
                    <img src="https://img.freepik.com/free-photo/electronic-devices_144627-41317.jpg" class="category-img"
                        alt="Electronics">
                    <div class="card-body">
                        <h5 class="card-title">Electronics</h5>
                        <p class="card-text text-muted">20,000+ products</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="category-card card premium-card">
                    <img src="https://img.freepik.com/free-photo/industrial-machines_1127-3426.jpg" class="category-img"
                        alt="Machinery">
                    <div class="card-body">
                        <h5 class="card-title">Machinery</h5>
                        <p class="card-text text-muted">15,000+ products</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="category-card card premium-card">
                    <img src="https://img.freepik.com/free-photo/fabric-samples-textile-swatches_93675-130843.jpg"
                        class="category-img" alt="Textiles">
                    <div class="card-body">
                        <h5 class="card-title">Textiles</h5>
                        <p class="card-text text-muted">25,000+ products</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="category-card card premium-card">
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

    <!-- Premium Sellers Spotlight -->
    @if($premiumSellers->count() > 0)
    <section class="premium-sellers-section py-5 bg-white">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2 class="section-title mb-2">
                    <i class="fas fa-crown text-warning me-2"></i>Premium Sellers
                </h2>
                <p class="text-muted">Verified premium sellers with exceptional ratings</p>
            </div>
            <div class="row g-4">
                @foreach($premiumSellers as $seller)
                <div class="col-md-4">
                    <div class="premium-seller-card card h-100">
                        <div class="card-body text-center">
                            <div class="premium-badge">
                                <i class="fas fa-crown"></i> PREMIUM
                            </div>
                            @if($seller->logo)
                                <img src="{{ asset('storage/' . $seller->logo) }}" alt="{{ $seller->company_name }}" 
                                     class="seller-logo mb-3">
                            @else
                                <div class="seller-logo-placeholder mb-3">
                                    <i class="fas fa-store fa-3x"></i>
                                </div>
                            @endif
                            <h5 class="card-title mb-2">{{ $seller->company_name }}</h5>
                            <div class="seller-rating mb-2">
                                <span class="text-warning">★★★★★</span>
                                <small class="text-muted">(4.9)</small>
                            </div>
                            <p class="text-muted small mb-3">
                                <i class="fas fa-box me-1"></i>{{ $seller->products->count() }} Products
                            </p>
                            <a href="#" class="btn btn-outline-primary btn-sm">View Store</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Main Content -->
    <div class="container my-5">
        <div class="row">
            <!-- Filters Sidebar -->
            <div class="col-lg-3">
                <form method="GET" action="{{ route('home') }}" id="filter-form">
                    <div class="filter-section mb-4">
                        <h5 class="filter-title">Filters</h5>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Price</label>
                            <select name="price" class="form-select" onchange="this.form.submit()">
                                <option value="" {{ !request('price') ? 'selected' : '' }}>All Prices</option>
                                <option value="low_to_high" {{ request('price') == 'low_to_high' ? 'selected' : '' }}>Low to High</option>
                                <option value="high_to_low" {{ request('price') == 'high_to_low' ? 'selected' : '' }}>High to Low</option>
                                <option value="under_100" {{ request('price') == 'under_100' ? 'selected' : '' }}>Under $100</option>
                                <option value="100_500" {{ request('price') == '100_500' ? 'selected' : '' }}>$100 - $500</option>
                                <option value="over_500" {{ request('price') == 'over_500' ? 'selected' : '' }}>Over $500</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Product Rating</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rating" value="4" id="rating4" {{ request('rating') == '4' ? 'checked' : '' }} onchange="this.form.submit()">
                                <label class="form-check-label" for="rating4">
                                    <span class="rating">★★★★</span> & Up
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="rating" value="3" id="rating3" {{ request('rating') == '3' ? 'checked' : '' }} onchange="this.form.submit()">
                                <label class="form-check-label" for="rating3">
                                    <span class="rating">★★★</span> & Up
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Seller Type</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="seller_type[]" value="verified_manuf" id="verifiedManuf" {{ in_array('verified_manuf', request('seller_type', [])) ? 'checked' : '' }} onchange="this.form.submit()">
                                <label class="form-check-label" for="verifiedManuf">
                                    Verified Manufacturers
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="seller_type[]" value="bulk_orders" id="bulkOrders" {{ in_array('bulk_orders', request('seller_type', [])) ? 'checked' : '' }} onchange="this.form.submit()">
                                <label class="form-check-label" for="bulkOrders">
                                    Bulk Order Available
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Location</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="location[]" value="nearest" id="nearest" {{ in_array('nearest', request('location', [])) ? 'checked' : '' }} onchange="this.form.submit()">
                                <label class="form-check-label" for="nearest">
                                    Nearest Sellers
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100 mt-2">Clear Filters</a>
                    </div>
                </form>

                <div class="filter-section">
                    <h5 class="filter-title">Categories</h5>
                    <ul class="list-group list-group-flush">
                        @foreach($categories as $category)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ route('home', array_merge(request()->query(), ['category' => $category->id])) }}" class="text-decoration-none text-dark">{{ $category->name }}</a>
                            <span class="badge bg-primary rounded-pill">{{ $category->products_count }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="section-header mb-4">
                    <h3 class="mb-1">All Products</h3>
                    <p class="text-muted">Discover quality products from verified sellers</p>
                </div>
                
                @if($featuredProducts->count() > 0)
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                        @foreach ($featuredProducts as $product)
                        <div class="col">
                            @include('frontend.pages.partials.product-card', ['product' => $product])
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-5">
                    {{ $featuredProducts->links() }}
                </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No products found</h4>
                        <p class="text-muted">Try adjusting your search or filters.</p>
                        <a href="{{ route('home') }}" class="btn btn-primary">Clear Filters</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sellers and Manufacturers Section -->
    @auth
    <section class="container my-5">
        <div class="section-header text-center mb-5">
            <h2 class="section-title mb-2">Discover Sellers & Manufacturers</h2>
            <p class="text-muted">Connect with verified suppliers worldwide</p>
        </div>

        <!-- Sellers -->
        @if($sellers->count() > 0)
        <div class="mb-5">
            <h4 class="mb-4">
                <i class="fas fa-store text-primary me-2"></i>Verified Sellers
            </h4>
            <div class="row g-4">
                @foreach($sellers as $seller)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm seller-card-hover">
                        <div class="card-body text-center">
                            @if($seller->logo)
                                <img src="{{ asset('storage/' . $seller->logo) }}" alt="{{ $seller->company_name }}" class="rounded-circle mb-3" style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                                    <i class="fas fa-store"></i>
                                </div>
                            @endif
                            <h5 class="card-title">{{ $seller->company_name }}</h5>
                            <p class="text-muted small mb-2">{{ $seller->products->count() }} products available</p>
                            <p class="text-muted small mb-3">{{ Str::limit($seller->company_address, 50) }}</p>

                            @php
                                $isFollowing = auth()->user()->followedSellers()->where('seller_id', $seller->id)->exists();
                            @endphp

                            <form action="{{ route('follow.seller', $seller->id) }}" method="POST" class="d-inline">
                                @csrf
                                @if($isFollowing)
                                    <button type="submit" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-check me-1"></i>Following
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus me-1"></i>Follow
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Manufacturers -->
        @if($manufacturers->count() > 0)
        <div class="mb-5">
            <h4 class="mb-4">
                <i class="fas fa-industry text-success me-2"></i>Verified Manufacturers
            </h4>
            <div class="row g-4">
                @foreach($manufacturers as $manufacturer)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm seller-card-hover">
                        <div class="card-body text-center">
                            @if($manufacturer->company_profile && isset($manufacturer->company_profile['logo']))
                                <img src="{{ asset('storage/' . $manufacturer->company_profile['logo']) }}" alt="{{ $manufacturer->company_name }}" class="rounded-circle mb-3" style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                                <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                                    <i class="fas fa-industry"></i>
                                </div>
                            @endif
                            <h5 class="card-title">{{ $manufacturer->company_name }}</h5>
                            <p class="text-muted small mb-2">{{ $manufacturer->products->count() }} products available</p>
                            <p class="text-muted small mb-3">{{ Str::limit($manufacturer->company_address, 50) }}</p>

                            @php
                                $isFollowing = auth()->user()->followedManufacturers()->where('manufacturer_id', $manufacturer->id)->exists();
                            @endphp

                            <form action="{{ route('follow.manufacturer', $manufacturer->id) }}" method="POST" class="d-inline">
                                @csrf
                                @if($isFollowing)
                                    <button type="submit" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-check me-1"></i>Following
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus me-1"></i>Follow
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </section>
    @endauth
@endsection
