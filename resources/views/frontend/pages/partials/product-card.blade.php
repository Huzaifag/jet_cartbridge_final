@php
    $stock = $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock';
    $images = is_array($product->images)
        ? $product->images
        : json_decode($product->images, true);
    $firstImage = str_replace('\/', '/', $images[0] ?? 'default.png');
    $showTrendingBadge = $showTrendingBadge ?? false;
@endphp

<div class="card h-100 shadow-sm premium-product-card">
    @if($showTrendingBadge)
    <div class="trending-badge">
        <i class="fas fa-fire"></i> TRENDING
    </div>
    @endif
    
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
                class="user-type-badge badge rounded-pill {{ $stock == 'In Stock' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} ms-2">
                {{ $stock }}
            </span>
        </div>

        <div class="modern-rating mb-2">
            <span class="text-warning">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= floor($product->rating ?? 4.5))
                        <i class="fas fa-star"></i>
                    @elseif($i - 0.5 <= ($product->rating ?? 4.5))
                        <i class="fas fa-star-half-alt"></i>
                    @else
                        <i class="far fa-star"></i>
                    @endif
                @endfor
            </span>
            <small class="text-muted ms-1">({{ $product->reviews_count ?? 128 }})</small>
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
