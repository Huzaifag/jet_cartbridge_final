@extends('frontend.layout.main')
@section('content')
    <!-- Premium Hero Slider -->
    <section class="premium-hero-slider">
        <div class="hero-slider-container">
            <!-- Slide 1 -->
            <div class="hero-slide active"
                style="background-image: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');">
                <div class="hero-slide-overlay"></div>
                <div class="premium-container">
                    <div class="hero-slide-content">
                        <h1 class="hero-slide-title" data-animation="fadeInUp">
                            Your Gateway to <span class="accent-text">Global Trade</span>
                        </h1>
                        <p class="hero-slide-subtitle" data-animation="fadeInUp" data-delay="200">
                            Connect with verified suppliers and buyers worldwide
                        </p>

                        <!-- Search Bar Inside Hero -->
                        <div class="hero-search-inline" data-animation="fadeInUp" data-delay="300">
                            <form method="GET" action="{{ route('home') }}">
                                <div class="hero-search-wrapper">
                                    <i class="fas fa-search hero-search-icon"></i>
                                    <input type="text" name="search" class="hero-search-input"
                                        placeholder="Search for products, categories, or suppliers..."
                                        value="{{ request('search') }}">
                                    <button type="submit" class="hero-search-btn">
                                        Search
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="hero-stats" data-animation="fadeInUp" data-delay="500">
                            <div class="hero-stat-item">
                                <div class="hero-stat-number">50K+</div>
                                <div class="hero-stat-label">Verified Suppliers</div>
                            </div>
                            <div class="hero-stat-item">
                                <div class="hero-stat-number">120+</div>
                                <div class="hero-stat-label">Countries</div>
                            </div>
                            <div class="hero-stat-item">
                                <div class="hero-stat-number">$10B+</div>
                                <div class="hero-stat-label">Annual Trade</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="hero-slide"
                style="background-image: url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');">
                <div class="hero-slide-overlay"></div>
                <div class="premium-container">
                    <div class="hero-slide-content">
                        <h1 class="hero-slide-title" data-animation="fadeInUp">
                            Premium <span class="accent-text">B2B Solutions</span>
                        </h1>
                        <p class="hero-slide-subtitle" data-animation="fadeInUp" data-delay="200">
                            Bulk orders with exclusive pricing and dedicated support
                        </p>

                        <!-- Search Bar Inside Hero -->
                        <div class="hero-search-inline" data-animation="fadeInUp" data-delay="300">
                            <form method="GET" action="{{ route('home') }}">
                                <div class="hero-search-wrapper">
                                    <i class="fas fa-search hero-search-icon"></i>
                                    <input type="text" name="search" class="hero-search-input"
                                        placeholder="Search for products, categories, or suppliers..."
                                        value="{{ request('search') }}">
                                    <button type="submit" class="hero-search-btn">
                                        Search
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="hero-stats" data-animation="fadeInUp" data-delay="500">
                            <div class="hero-stat-item">
                                <div class="hero-stat-number">24/7</div>
                                <div class="hero-stat-label">Support</div>
                            </div>
                            <div class="hero-stat-item">
                                <div class="hero-stat-number">100%</div>
                                <div class="hero-stat-label">Secure</div>
                            </div>
                            <div class="hero-stat-item">
                                <div class="hero-stat-number">Fast</div>
                                <div class="hero-stat-label">Shipping</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="hero-slide"
                style="background-image: url('https://images.unsplash.com/photo-1553877522-43269d4ea984?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');">
                <div class="hero-slide-overlay"></div>
                <div class="premium-container">
                    <div class="hero-slide-content">
                        <h1 class="hero-slide-title" data-animation="fadeInUp">
                            Trusted by <span class="accent-text">Thousands</span>
                        </h1>
                        <p class="hero-slide-subtitle" data-animation="fadeInUp" data-delay="200">
                            Join the leading B2B marketplace for quality products
                        </p>

                        <!-- Search Bar Inside Hero -->
                        <div class="hero-search-inline" data-animation="fadeInUp" data-delay="300">
                            <form method="GET" action="{{ route('home') }}">
                                <div class="hero-search-wrapper">
                                    <i class="fas fa-search hero-search-icon"></i>
                                    <input type="text" name="search" class="hero-search-input"
                                        placeholder="Search for products, categories, or suppliers..."
                                        value="{{ request('search') }}">
                                    <button type="submit" class="hero-search-btn">
                                        Search
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="hero-stats" data-animation="fadeInUp" data-delay="500">
                            <div class="hero-stat-item">
                                <div class="hero-stat-number">4.9/5</div>
                                <div class="hero-stat-label">Rating</div>
                            </div>
                            <div class="hero-stat-item">
                                <div class="hero-stat-number">50K+</div>
                                <div class="hero-stat-label">Reviews</div>
                            </div>
                            <div class="hero-stat-item">
                                <div class="hero-stat-number">98%</div>
                                <div class="hero-stat-label">Satisfaction</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slider Controls -->
        <button class="hero-slider-nav hero-slider-prev">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="hero-slider-nav hero-slider-next">
            <i class="fas fa-chevron-right"></i>
        </button>

        <!-- Slider Dots -->
        <div class="hero-slider-dots">
            <button class="hero-dot active" data-slide="0"></button>
            <button class="hero-dot" data-slide="1"></button>
            <button class="hero-dot" data-slide="2"></button>
        </div>


        </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="premium-section">
        <div class="premium-container">
            <div class="premium-header">
                <h2 class="premium-title">Shop by <span class="accent-text">Category</span></h2>
                <p class="premium-subtitle">Explore our wide range of product categories</p>
            </div>
            <div class="premium-grid premium-grid-4">
                <div class="premium-card premium-fade-in">
                    <img src="https://img.freepik.com/free-photo/electronic-devices_144627-41317.jpg" alt="Electronics"
                        class="w-100 mb-3" style="height: 150px; object-fit: cover; border-radius: 0.5rem;">
                    <h3 class="premium-card-title">Electronics</h3>
                    <p class="premium-card-text">20,000+ products</p>
                </div>
                <div class="premium-card premium-fade-in">
                    <img src="https://img.freepik.com/free-photo/industrial-machines_1127-3426.jpg" alt="Machinery"
                        class="w-100 mb-3" style="height: 150px; object-fit: cover; border-radius: 0.5rem;">
                    <h3 class="premium-card-title">Machinery</h3>
                    <p class="premium-card-text">15,000+ products</p>
                </div>
                <div class="premium-card premium-fade-in">
                    <img src="https://img.freepik.com/free-photo/fabric-samples-textile-swatches_93675-130843.jpg"
                        alt="Textiles" class="w-100 mb-3" style="height: 150px; object-fit: cover; border-radius: 0.5rem;">
                    <h3 class="premium-card-title">Textiles</h3>
                    <p class="premium-card-text">25,000+ products</p>
                </div>
                <div class="premium-card premium-fade-in">
                    <img src="https://img.freepik.com/free-photo/construction-equipment_1127-3294.jpg" alt="Construction"
                        class="w-100 mb-3" style="height: 150px; object-fit: cover; border-radius: 0.5rem;">
                    <h3 class="premium-card-title">Construction</h3>
                    <p class="premium-card-text">18,000+ products</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container my-5">
        <div class="row">
            <!-- Filter Toggle Button -->
            <div class="col-12 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="section-header">
                        <h3 class="mb-1">All Products</h3>
                        <p class="text-primary mb-0">Discover quality products from verified sellers</p>
                    </div>
                    <button class="btn btn-outline-primary" type="button" id="filterToggleBtn" 
                            data-bs-toggle="collapse" data-bs-target="#filtersCollapse" 
                            aria-expanded="false" aria-controls="filtersCollapse">
                        <i class="fas fa-filter me-2"></i>
                        <span class="filter-btn-text">Show Filters</span>
                        <i class="fas fa-chevron-down ms-2 filter-chevron"></i>
                    </button>
                </div>
            </div>

            <!-- Filters Sidebar -->
            <div class="col-lg-3">
                <div class="collapse" id="filtersCollapse">
                    <div class="filters-container">
                        <form method="GET" action="{{ route('home') }}" id="filter-form">
                            <div class="filter-section mb-4">
                                <h5 class="filter-title">
                                    <i class="fas fa-sliders-h me-2"></i>Filters
                                </h5>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Price</label>
                                    <select name="price" class="form-select" onchange="this.form.submit()">
                                        <option value="" {{ !request('price') ? 'selected' : '' }}>All Prices</option>
                                        <option value="low_to_high" {{ request('price') == 'low_to_high' ? 'selected' : '' }}>Low to
                                            High</option>
                                        <option value="high_to_low" {{ request('price') == 'high_to_low' ? 'selected' : '' }}>High to
                                            Low</option>
                                        <option value="under_100" {{ request('price') == 'under_100' ? 'selected' : '' }}>Under $100
                                        </option>
                                        <option value="100_500" {{ request('price') == '100_500' ? 'selected' : '' }}>$100 - $500
                                        </option>
                                        <option value="over_500" {{ request('price') == 'over_500' ? 'selected' : '' }}>Over $500
                                        </option>
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
                                        <input class="form-check-input" type="checkbox" name="seller_type[]" value="verified_manuf"
                                            id="verifiedManuf" {{ in_array('verified_manuf', request('seller_type', [])) ? 'checked' : '' }} onchange="this.form.submit()">
                                        <label class="form-check-label" for="verifiedManuf">
                                            Verified Manufacturers
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="seller_type[]" value="bulk_orders"
                                            id="bulkOrders" {{ in_array('bulk_orders', request('seller_type', [])) ? 'checked' : '' }} onchange="this.form.submit()">
                                        <label class="form-check-label" for="bulkOrders">
                                            Bulk Order Available
                                        </label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Location</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="location[]" value="nearest"
                                            id="nearest" {{ in_array('nearest', request('location', [])) ? 'checked' : '' }}
                                            onchange="this.form.submit()">
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
                            <h5 class="filter-title">
                                <i class="fas fa-tags me-2"></i>Categories
                            </h5>
                            <form method="GET" action="{{ route('home') }}">
                                <select name="category" class="form-select mb-3" onchange="this.form.submit()">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }} ({{ $category->products_count }})
                                        </option>
                                    @endforeach
                                </select>
                                @foreach(request()->except('category') as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9" id="productsColumn">
                {{-- <div class="section-header mb-4 d-none d-lg-block">
                    <h3 class="mb-1">All Products</h3>
                    <p class="text-primary">Discover quality products from verified sellers</p>
                </div> --}}

                @if($featuredProducts->count() > 0)
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                        @foreach ($featuredProducts as $product)
                            <div class="col">
                                @include('frontend.pages.partials.product-card', ['product' => $product])
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-center mt-5">
                        {{ $featuredProducts->links('vendor.pagination.bootstrap-5') }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-3x text-primary mb-3"></i>
                        <h4 class="text-primary">No products found</h4>
                        <p class="text-primary">Try adjusting your search or filters.</p>
                        <a href="{{ route('home') }}" class="btn btn-primary">Clear Filters</a>
                    </div>
                @endif
            </div>
        </div>
    </div>


    <!-- Premium Trust Badges Section -->
    <section class="premium-section" style="padding-top: 4rem; padding-bottom: 3rem;">
        <div class="premium-container">
            <div class="premium-grid premium-grid-4">
                <div class="premium-card premium-fade-in">
                    <div class="premium-card-icon-wrapper">
                        <img src="{{asset('images/credit-card.png')}}" alt="Secure Payments" class="premium-card-image">
                    </div>
                    <h3 class="premium-card-title">Secure Payments</h3>
                    <p class="premium-card-text">Bank-level security for all transactions</p>
                </div>
                <div class="premium-card premium-fade-in">
                    <div class="premium-card-icon-wrapper">
                        <img src="{{asset('images/fast-delivery.png')}}" alt="Secure Payments" class="premium-card-image">
                    </div>
                    <h3 class="premium-card-title">Fast Shipping</h3>
                    <p class="premium-card-text">Global logistics network</p>
                </div>
                <div class="premium-card premium-fade-in">
                    <div class="premium-card-icon-wrapper">
                        <img src="{{asset('images/merchant.png')}}" alt="Secure Payments" class="premium-card-image">
                    </div>
                    <h3 class="premium-card-title">Verified Sellers</h3>
                    <p class="premium-card-text">Thoroughly vetted suppliers</p>
                </div>
                <div class="premium-card premium-fade-in">
                    <div class="premium-card-icon-wrapper">
                        <img src="{{asset('images/call-center.png')}}" alt="Secure Payments" class="premium-card-image">
                    </div>
                    <h3 class="premium-card-title">24/7 Support</h3>
                    <p class="premium-card-text">Dedicated customer success</p>
                </div>
            </div>
        </div>
    </section>

    @auth
        <!-- Products from Followed Sellers/Manufacturers -->
        @if($followedProducts->count() > 0)
            <section class="premium-section">
                <div class="premium-container">
                    <div class="premium-header">
                        <h2 class="premium-title">
                            <i class="fas fa-heart text-accent me-3"></i>From Your <span class="accent-text">Followed Sellers</span>
                        </h2>
                        <p class="premium-subtitle">Exclusive products from sellers and manufacturers you trust</p>
                    </div>
                    <div class="premium-grid premium-grid-4">
                        @foreach($followedProducts as $product)
                            <div class="premium-slide-up">
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
        <section class="premium-section">
            <div class="premium-container">
                <div class="premium-header">
                    <h2 class="premium-title">
                        <i class="fas fa-fire text-accent me-3"></i><span class="accent-text">Trending</span> Now
                    </h2>
                    <p class="premium-subtitle">Most popular products loved by our community</p>
                </div>
                <div class="premium-grid premium-grid-4">
                    @foreach($trendingProducts as $product)
                        <div class="premium-scale-in">
                            @include('frontend.pages.partials.product-card', ['product' => $product, 'showTrendingBadge' => true])
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Premium Sellers Spotlight -->
    @if($premiumSellers->count() > 0)
        <section class="premium-section">
            <div class="premium-container">
                <div class="premium-header">
                    <h2 class="premium-title">
                        <i class="fas fa-crown text-accent me-3"></i><span class="accent-text">Premium</span> Sellers
                    </h2>
                    <p class="premium-subtitle">Verified premium sellers with exceptional ratings</p>
                </div>
                <div class="premium-grid premium-grid-3">
                    @foreach($premiumSellers as $seller)
                        <div class="premium-card premium-scale-in text-center">
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="premium-badge">
                                    <i class="fas fa-crown me-1"></i> PREMIUM
                                </span>
                            </div>
                            @if($seller->logo)
                                <img src="{{ asset('storage/' . $seller->logo) }}" alt="{{ $seller->company_name }}"
                                    class="rounded-circle mb-3"
                                    style="width: 80px; height: 80px; object-fit: cover; border: 3px solid var(--color-accent);">
                            @else
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3 text-accent"
                                    style="width: 80px; height: 80px; background: rgba(245, 158, 11, 0.1); border: 3px solid var(--color-accent);">
                                    <i class="fas fa-store fa-2x"></i>
                                </div>
                            @endif
                            <h3 class="premium-card-title">{{ $seller->company_name }}</h3>
                            <div class="mb-2">
                                <span class="text-accent">★★★★★</span>
                                <small class="text-dim">(4.9)</small>
                            </div>
                            <p class="premium-card-text mb-3">
                                <i class="fas fa-box me-1"></i>{{ $seller->products->count() }} Products
                            </p>
                            <a href="#" class="btn-premium btn-premium-secondary">View Store</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- The Premium B2B Focus Section -->
    <section class="b2b-exclusive-focus">
        <div class="b2b-content-wrapper">

            <!-- Headline -->
            <header class="b2b-header">
                <h2 class="b2b-title">
                    <span class="accent-text">Exclusively </span>
                    <span style="color: var(--color-white);">For Businesses & Retailers</span>
                </h2>
                <p class="b2b-subtitle">
                    Unlock institutional value, dedicated support, and specialized service programs designed for scalability
                    and success.
                </p>
            </header>

            <!-- Feature Grid -->
            <div class="b2b-feature-grid">

                <!-- Feature 1: Bulk Pricing -->
                <div class="b2b-feature-tile">
                    <div class="premium-card-icon-wrapper">
                        <img src="{{asset('images/tag.png')}}" alt="Secure Payments" class="premium-card-image">
                    </div>
                    <h3>Tiered Bulk Pricing</h3>
                    <p>Maximize profitability with special volume discounts and scalable pricing structures.</p>
                </div>

                <!-- Feature 2: Dedicated Manager -->
                <div class="b2b-feature-tile">
                    <div class="premium-card-icon-wrapper">
                        <img src="{{asset('images/accountant.png')}}" alt="Secure Payments" class="premium-card-image">
                    </div>
                    <h3>Dedicated Account Manager</h3>
                    <p>Receive one-on-one attention for seamless ordering, logistics, and strategic planning.</p>
                </div>

                <!-- Feature 3: Invoice Billing -->
                <div class="b2b-feature-tile">
                    <div class="premium-card-icon-wrapper">
                        <img src="{{asset('images/bill.png')}}" alt="Secure Payments" class="premium-card-image">
                    </div>
                    <h3>Flexible Invoice Billing</h3>
                    <p>Streamline procurement with net 30/60 payment terms and official invoice documentation.</p>
                </div>

                <!-- Feature 4: Custom Orders -->
                <div class="b2b-feature-tile">
                    <div class="premium-card-icon-wrapper">
                        <img src="{{asset('images/modification.png')}}" alt="Secure Payments" class="premium-card-image">
                    </div>
                    <h3>Custom Product Orders</h3>
                    <p>Access exclusive customization options and product sourcing for your unique business needs.</p>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="b2b-cta-group">
                <a href="#" class="b2b-quote-cta">
                    Request a Quote
                </a>
                <p class="b2b-cta-subtext">
                    Or, <a href="#">Create a Business Account</a> to get started immediately.
                </p>
            </div>

        </div>
    </section>

    <!-- B2C Focus Section -->
    <section class="premium-section b2c-focus-section">
        <div class="premium-container">
            <div class="premium-header">
                <h2 class="premium-title">
                    <span class="accent-text">Perfect</span> for Retail Customers
                </h2>
                <p class="premium-subtitle">Experience seamless shopping with quality products, fast delivery, and
                    exceptional service</p>
            </div>

            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="b2c-features-grid">
                        <div class="b2c-feature-item premium-fade-in">
                            <div class="b2c-feature-icon">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <div class="b2c-feature-content">
                                <h4>Lightning Fast Delivery</h4>
                                <p>Get your orders delivered within 24-48 hours with our express shipping network</p>
                            </div>
                        </div>

                        <div class="b2c-feature-item premium-fade-in">
                            <div class="b2c-feature-icon">
                                <i class="fas fa-undo-alt"></i>
                            </div>
                            <div class="b2c-feature-content">
                                <h4>Easy Returns</h4>
                                <p>30-day hassle-free returns with free pickup from your doorstep</p>
                            </div>
                        </div>

                        <div class="b2c-feature-item premium-fade-in">
                            <div class="b2c-feature-icon">
                                <i class="fas fa-award"></i>
                            </div>
                            <div class="b2c-feature-content">
                                <h4>Quality Assurance</h4>
                                <p>Every product is thoroughly tested and comes with manufacturer warranty</p>
                            </div>
                        </div>

                        <div class="b2c-feature-item premium-fade-in">
                            <div class="b2c-feature-icon">
                                <i class="fas fa-lock"></i>
                            </div>
                            <div class="b2c-feature-content">
                                <h4>Secure Shopping</h4>
                                <p>Bank-level security with encrypted payments and data protection</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="b2c-lifestyle-content premium-scale-in">
                        <div class="lifestyle-image-wrapper">
                            <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                                alt="Happy customer shopping" class="lifestyle-image">
                            <div class="lifestyle-overlay">
                                <div class="customer-testimonial">
                                    <div class="testimonial-content">
                                        <div class="testimonial-stars">
                                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i>
                                        </div>
                                        <p>"Amazing quality and super fast delivery! Will definitely order again."</p>
                                        <div class="testimonial-author">
                                            <strong>Sarah Johnson</strong>
                                            <span>Verified Customer</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Brand Trust & Social Proof Section -->
    <section class="premium-section brand-trust-section">
        <div class="premium-container">
            <div class="premium-header">
                <h2 class="premium-title">
                    Trusted by <span class="accent-text">Thousands</span> Worldwide
                </h2>
                <p class="premium-subtitle">Join our community of satisfied customers and verified partners</p>
            </div>

            <!-- Trust Statistics -->
            <div class="trust-stats-grid premium-fade-in">
                <div class="trust-stat-item">
                    <div class="trust-stat-number">50K+</div>
                    <div class="trust-stat-label">Happy Customers</div>
                </div>
                <div class="trust-stat-item">
                    <div class="trust-stat-number">99.8%</div>
                    <div class="trust-stat-label">Satisfaction Rate</div>
                </div>
                <div class="trust-stat-item">
                    <div class="trust-stat-number">24/7</div>
                    <div class="trust-stat-label">Customer Support</div>
                </div>
                <div class="trust-stat-item">
                    <div class="trust-stat-number">120+</div>
                    <div class="trust-stat-label">Countries Served</div>
                </div>
            </div>

            <!-- Partner Brands -->
            <div class="partner-brands-section premium-slide-up">
                <h3 class="partner-brands-title">Trusted Partners & Suppliers</h3>
                <div class="partner-brands-slider">
                    <div class="partner-brands-track">
                        <!-- First set of logos -->
                        <div class="partner-brand-item">
                            <img src="https://logo.clearbit.com/microsoft.com" alt="Microsoft" class="partner-logo">
                        </div>
                        <div class="partner-brand-item">
                            <img src="https://logo.clearbit.com/amazon.com" alt="Amazon" class="partner-logo">
                        </div>
                        <div class="partner-brand-item">
                            <img src="https://logo.clearbit.com/google.com" alt="Google" class="partner-logo">
                        </div>
                        <div class="partner-brand-item">
                            <img src="https://logo.clearbit.com/apple.com" alt="Apple" class="partner-logo">
                        </div>
                        <div class="partner-brand-item">
                            <img src="https://logo.clearbit.com/samsung.com" alt="Samsung" class="partner-logo">
                        </div>
                        <div class="partner-brand-item">
                            <img src="https://logo.clearbit.com/sony.com" alt="Sony" class="partner-logo">
                        </div>
                        <!-- Duplicate set for seamless loop -->
                        <div class="partner-brand-item">
                            <img src="https://logo.clearbit.com/microsoft.com" alt="Microsoft" class="partner-logo">
                        </div>
                        <div class="partner-brand-item">
                            <img src="https://logo.clearbit.com/amazon.com" alt="Amazon" class="partner-logo">
                        </div>
                        <div class="partner-brand-item">
                            <img src="https://logo.clearbit.com/google.com" alt="Google" class="partner-logo">
                        </div>
                        <div class="partner-brand-item">
                            <img src="https://logo.clearbit.com/apple.com" alt="Apple" class="partner-logo">
                        </div>
                        <div class="partner-brand-item">
                            <img src="https://logo.clearbit.com/samsung.com" alt="Samsung" class="partner-logo">
                        </div>
                        <div class="partner-brand-item">
                            <img src="https://logo.clearbit.com/sony.com" alt="Sony" class="partner-logo">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Testimonials -->
            <div class="customer-testimonials-section premium-scale-in">
                <h3 class="testimonials-title">What Our Customers Say</h3>
                <div class="testimonials-slider">
                    <div class="testimonials-track">
                        <!-- First set of testimonials -->
                        <div class="testimonial-card premium-card">
                            <div class="testimonial-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                    class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p class="testimonial-text">"Exceptional service and quality products. The delivery was
                                incredibly fast and the customer support team was very helpful."</p>
                            <div class="testimonial-author">
                                <div class="author-avatar">
                                    <img src="https://img.freepik.com/free-photo/beautiful-girl-stands-park_8353-5084.jpg?semt=ais_hybrid&w=740&q=80"
                                        alt="Customer">
                                </div>
                                <div class="author-info">
                                    <strong>Emily Chen</strong>
                                    <span>Business Owner</span>
                                </div>
                            </div>
                        </div>

                        <div class="testimonial-card premium-card">
                            <div class="testimonial-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                    class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p class="testimonial-text">"I've been ordering from JetCartridge for over a year now. Their
                                consistency in quality and service is unmatched."</p>
                            <div class="testimonial-author">
                                <div class="author-avatar">
                                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80"
                                        alt="Customer">
                                </div>
                                <div class="author-info">
                                    <strong>Michael Rodriguez</strong>
                                    <span>Retail Manager</span>
                                </div>
                            </div>
                        </div>

                        <div class="testimonial-card premium-card">
                            <div class="testimonial-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                    class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p class="testimonial-text">"The return process was so smooth when I needed to exchange a
                                product. Great customer experience overall!"</p>
                            <div class="testimonial-author">
                                <div class="author-avatar">
                                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80"
                                        alt="Customer">
                                </div>
                                <div class="author-info">
                                    <strong>Lisa Thompson</strong>
                                    <span>Verified Customer</span>
                                </div>
                            </div>
                        </div>

                        <!-- Duplicate set for seamless loop -->
                        <div class="testimonial-card premium-card">
                            <div class="testimonial-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                    class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p class="testimonial-text">"Exceptional service and quality products. The delivery was
                                incredibly fast and the customer support team was very helpful."</p>
                            <div class="testimonial-author">
                                <div class="author-avatar">
                                    <img src="https://img.freepik.com/free-photo/beautiful-girl-stands-park_8353-5084.jpg?semt=ais_hybrid&w=740&q=80"
                                        alt="Customer">
                                </div>
                                <div class="author-info">
                                    <strong>Emily Chen</strong>
                                    <span>Business Owner</span>
                                </div>
                            </div>
                        </div>

                        <div class="testimonial-card premium-card">
                            <div class="testimonial-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                    class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p class="testimonial-text">"I've been ordering from JetCartridge for over a year now. Their
                                consistency in quality and service is unmatched."</p>
                            <div class="testimonial-author">
                                <div class="author-avatar">
                                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80"
                                        alt="Customer">
                                </div>
                                <div class="author-info">
                                    <strong>Michael Rodriguez</strong>
                                    <span>Retail Manager</span>
                                </div>
                            </div>
                        </div>

                        <div class="testimonial-card premium-card">
                            <div class="testimonial-rating">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                    class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p class="testimonial-text">"The return process was so smooth when I needed to exchange a
                                product. Great customer experience overall!"</p>
                            <div class="testimonial-author">
                                <div class="author-avatar">
                                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80"
                                        alt="Customer">
                                </div>
                                <div class="author-info">
                                    <strong>Lisa Thompson</strong>
                                    <span>Verified Customer</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trust Badges -->
            <div class="trust-badges-section premium-fade-in">
                <div class="trust-badges-grid">
                    <div class="trust-badge-item">
                        <i class="fas fa-shield-alt trust-badge-icon"></i>
                        <div class="trust-badge-content">
                            <strong>Secure Payment</strong>
                            <span>256-bit SSL Encryption</span>
                        </div>
                    </div>
                    <div class="trust-badge-item">
                        <i class="fas fa-medal trust-badge-icon"></i>
                        <div class="trust-badge-content">
                            <strong>Verified Vendor</strong>
                            <span>ISO 9001 Certified</span>
                        </div>
                    </div>
                    <div class="trust-badge-item">
                        <i class="fas fa-undo trust-badge-icon"></i>
                        <div class="trust-badge-content">
                            <strong>Return Guarantee</strong>
                            <span>30-Day Money Back</span>
                        </div>
                    </div>
                    <div class="trust-badge-item">
                        <i class="fas fa-headset trust-badge-icon"></i>
                        <div class="trust-badge-content">
                            <strong>24/7 Support</strong>
                            <span>Always Here to Help</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Premium Sellers and Manufacturers Section -->
    @auth
        <section class="premium-section">
            <div class="premium-container">
                <div class="premium-header">
                    <h2 class="premium-title">Discover <span class="accent-text">Sellers & Manufacturers</span></h2>
                    <p class="premium-subtitle">Connect with verified suppliers worldwide</p>
                </div>

                <!-- Premium Sellers -->
                @if($sellers->count() > 0)
                    <div class="mb-5">
                        <div class="d-flex align-items-center mb-4">
                            <i class="fas fa-store text-accent me-3" style="font-size: 1.5rem;"></i>
                            <h3 class="premium-card-title mb-0">Verified Sellers</h3>
                        </div>
                        <div class="premium-grid premium-grid-3">
                            @foreach($sellers as $seller)
                                <div class="premium-card premium-fade-in text-center">
                                    @if($seller->logo)
                                        <img src="{{ asset('storage/' . $seller->logo) }}" alt="{{ $seller->company_name }}"
                                            class="rounded-circle mb-3"
                                            style="width: 80px; height: 80px; object-fit: cover; border: 3px solid var(--color-accent);">
                                    @else
                                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3 text-accent"
                                            style="width: 80px; height: 80px; background: rgba(245, 158, 11, 0.1); border: 3px solid var(--color-accent);">
                                            <i class="fas fa-store fa-2x"></i>
                                        </div>
                                    @endif
                                    <h3 class="premium-card-title">{{ $seller->company_name }}</h3>
                                    <p class="premium-card-text mb-2">
                                        <i class="fas fa-box me-1"></i>{{ $seller->products->count() }} products available
                                    </p>
                                    <p class="premium-card-text mb-3">
                                        <i class="fas fa-map-marker-alt me-1"></i>{{ Str::limit($seller->company_address, 50) }}
                                    </p>

                                    @php
                                        $isFollowing = auth()->user()->followedSellers()->where('seller_id', $seller->id)->exists();
                                    @endphp

                                    <form action="{{ route('follow.seller', $seller->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @if($isFollowing)
                                            <button type="submit" class="btn-premium btn-premium-secondary">
                                                <i class="fas fa-check me-1"></i>Following
                                            </button>
                                        @else
                                            <button type="submit" class="btn-premium btn-premium-primary">
                                                <i class="fas fa-plus me-1"></i>Follow
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Premium Manufacturers -->
                @if($manufacturers->count() > 0)
                    <div class="mb-5">
                        <div class="d-flex align-items-center mb-4">
                            <i class="fas fa-industry text-accent me-3" style="font-size: 1.5rem;"></i>
                            <h3 class="premium-card-title mb-0">Verified Manufacturers</h3>
                        </div>
                        <div class="premium-grid premium-grid-3">
                            @foreach($manufacturers as $manufacturer)
                                <div class="premium-card premium-slide-up text-center">
                                    @if($manufacturer->company_profile && isset($manufacturer->company_profile['logo']))
                                        <img src="{{ asset('storage/' . $manufacturer->company_profile['logo']) }}"
                                            alt="{{ $manufacturer->company_name }}" class="rounded-circle mb-3"
                                            style="width: 80px; height: 80px; object-fit: cover; border: 3px solid var(--color-accent);">
                                    @else
                                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3 text-accent"
                                            style="width: 80px; height: 80px; background: rgba(245, 158, 11, 0.1); border: 3px solid var(--color-accent);">
                                            <i class="fas fa-industry fa-2x"></i>
                                        </div>
                                    @endif
                                    <h3 class="premium-card-title">{{ $manufacturer->company_name }}</h3>
                                    <p class="premium-card-text mb-2">
                                        <i class="fas fa-box me-1"></i>{{ $manufacturer->products->count() }} products available
                                    </p>
                                    <p class="premium-card-text mb-3">
                                        <i class="fas fa-map-marker-alt me-1"></i>{{ Str::limit($manufacturer->company_address, 50) }}
                                    </p>

                                    @php
                                        $isFollowing = auth()->user()->followedManufacturers()->where('manufacturer_id', $manufacturer->id)->exists();
                                    @endphp

                                    <form action="{{ route('follow.manufacturer', $manufacturer->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @if($isFollowing)
                                            <button type="submit" class="btn-premium btn-premium-secondary">
                                                <i class="fas fa-check me-1"></i>Following
                                            </button>
                                        @else
                                            <button type="submit" class="btn-premium btn-premium-primary">
                                                <i class="fas fa-plus me-1"></i>Follow
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @endauth
@endsection