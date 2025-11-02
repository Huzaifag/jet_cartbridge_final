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
                @if($featuredProducts->count() > 0)
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                        @foreach ($featuredProducts as $product)
                        <div class="col">
                            {{-- CARD START --}}
                            @php
                                $stock = $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock';
                                $images = is_array($product->images)
                                    ? $product->images
                                    : json_decode($product->images, true);
                                $firstImage = str_replace('\/', '/', $images[0] ?? 'default.png'); // ✅ fix escaped slashes
                            @endphp

                            <div class="card h-100 shadow-sm">
                                <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none">
                                    <div class="product-img-container">
                                        <img src="{{ asset($firstImage) }}" alt="{{ $firstImage }}" class="card-img-top modern-product-img">
                                    </div>
                                </a>

                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <a href="{{ route('product.show', $product->slug) }}"
                                            class="text-decoration-none text-dark">
                                            <h5 class="card-title fw-semibold mb-0">{{ $product->name }}</h5>
                                        </a>
                                        <span
                                            class="user-type-badge badge rounded-pill bg-success-subtle text-success ms-2">
                                            {{ $stock }}
                                        </span>
                                    </div>

                                    <div class="modern-rating mb-2">
                                        <span class="text-warning">
                                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                                class="fas fa-star"></i>
                                            <i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                        </span>
                                        <small class="text-muted ms-1">({{ number_format(128) }})</small>
                                    </div>

                                    <p class="card-text text-muted mb-3 small">
                                        {{ Str::limit($product->description, 70) }}
                                    </p>

                                    {{-- Price Section --}}
                                    <div class="mt-auto">
                                        @auth
                                            @if (Auth::user()->role === 'b2c')
                                                @if ($product->activePromotion && $product->activePromotion->type == 'buy_get')
                                                    <span class="badge bg-warning text-dark mb-2 d-inline-block">
                                                        Buy {{ $product->activePromotion->rules->first()->buy_quantity }}
                                                        Get {{ $product->activePromotion->rules->first()->get_quantity }} Free
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
                                                    <p class="text-secondary small mb-0">
                                                        Min. order: {{ $product->b2b_moq }} pieces
                                                    </p>
                                                </div>
                                            @endif
                                        @endauth
                                    </div>

                                    {{-- Action Buttons --}}
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
        <h2 class="text-center mb-4">Follow Sellers & Manufacturers</h2>

        <!-- Sellers -->
        @if($sellers->count() > 0)
        <div class="mb-5">
            <h4 class="mb-3">
                <i class="fas fa-store text-primary me-2"></i>Verified Sellers
            </h4>
            <div class="row g-4">
                @foreach($sellers as $seller)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
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
            <h4 class="mb-3">
                <i class="fas fa-industry text-success me-2"></i>Verified Manufacturers
            </h4>
            <div class="row g-4">
                @foreach($manufacturers as $manufacturer)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
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
    </div>
@endsection
