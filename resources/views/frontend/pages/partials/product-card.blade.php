@php
    $stock = $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock';
    $images = is_array($product->images)
        ? $product->images
        : json_decode($product->images, true);
    $firstImage = str_replace('\/', '/', $images[0] ?? 'default.png');
    $showTrendingBadge = $showTrendingBadge ?? false;
@endphp

<div class="premium-product-card h-100 premium-transition">
    @if($showTrendingBadge)
    <div class="position-absolute top-0 end-0 m-3" style="z-index: 10;">
        <span class="premium-badge" style="background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%); color: white;">
            <i class="fas fa-fire me-1"></i> TRENDING
        </span>
    </div>
    @endif
    
    <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none d-block">
        <img src="{{ asset($firstImage) }}" alt="{{ $product->name }}" class="premium-product-image">
    </a>

    <div class="premium-product-content">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none flex-grow-1 me-2">
                <h5 class="premium-product-title product-title-multiline">{{ $product->name }}</h5>
            </a>
            <span class="premium-badge-outline flex-shrink-0">
                {{ $stock }}
            </span>
        </div>

        {{-- Seller Information --}}
        @if($product->seller)
        <div class="mb-2">
            <div class="d-flex align-items-center seller-info">
                <i class="fas fa-store text-accent me-1" style="font-size: 0.75rem;"></i>
                <a href="{{ route('seller.profile', $product->seller->slug) }}" 
                   class="seller-name text-decoration-none" 
                   title="View {{ $product->seller->business_name ?? $product->seller->company_name }} profile">
                    {{ $product->seller->business_name ?? $product->seller->company_name }}
                </a>
                @if($product->seller->is_verified)
                    <i class="fas fa-check-circle text-success ms-1" style="font-size: 0.7rem;" title="Verified Seller"></i>
                @endif
                @if($product->seller->is_premium)
                    <i class="fas fa-crown text-warning ms-1" style="font-size: 0.7rem;" title="Premium Seller"></i>
                @endif
            </div>
            @if($product->seller->city || $product->seller->country)
            <div class="seller-location">
                <i class="fas fa-map-marker-alt text-muted me-1" style="font-size: 0.65rem;"></i>
                <span class="seller-location-text">
                    {{ $product->seller->city }}{{ $product->seller->city && $product->seller->country ? ', ' : '' }}{{ $product->seller->country }}
                </span>
            </div>
            @endif
        </div>
        @endif

        <div class="mb-2">
            <span class="text-accent">
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
            <small class="text-dim ms-1">({{ $product->reviews_count ?? 128 }})</small>
        </div>

        <p class="text-dim mb-3 small">
            {{ Str::limit($product->description, 70) }}
        </p>

        {{-- Price Section --}}
        <div class="mt-auto">
            @auth
                @if (Auth::user()->role === 'b2c')
                    @if ($product->activePromotion && $product->activePromotion->type == 'buy_get')
                        <span class="premium-badge mb-2 d-inline-block">
                            Buy {{ $product->activePromotion->rules->first()->buy_quantity }}
                            Get {{ $product->activePromotion->rules->first()->get_quantity }} Free
                        </span>
                    @endif
                    <div class="mb-3">
                        <p class="premium-product-price mb-0">
                            ${{ number_format($product->b2c_price, 2) }}
                            @if ($product->b2c_compare_price)
                                <span class="text-dim text-decoration-line-through small ms-2">
                                    ${{ number_format($product->b2c_compare_price, 2) }}
                                </span>
                            @endif
                        </p>
                        <p class="text-dim small mb-0">Min. order: 1 piece</p>
                    </div>
                @elseif (Auth::user()->role === 'b2b')
                    <div class="mb-3">
                        <p class="premium-product-price mb-0">
                            ${{ number_format($product->b2b_price, 2) }}
                        </p>
                        <p class="text-dim small mb-0">
                            Min. order: {{ $product->b2b_moq }} pieces
                        </p>
                    </div>
                @endif
            @endauth
        </div>

        {{-- Action Buttons --}}
        @auth
            @if (Auth::user()->role === 'b2c')
                <div class="d-flex gap-2">
                    <form action="{{ route('addToCart', $product) }}" method="POST" class="flex-grow-1">
                        @csrf
                        <button type="submit" class="btn-premium btn-premium-secondary w-100" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
                            <i class="fas fa-shopping-cart me-1"></i> Add
                        </button>
                    </form>
                    <button class="btn-premium btn-premium-primary w-100" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
                        <i class="fas fa-bolt me-1"></i> Buy Now
                    </button>
                </div>
            @elseif (Auth::user()->role === 'b2b')
                <a href="{{ route('inquiry.form', $product->slug) }}" class="btn-premium btn-premium-primary w-100" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
                    <i class="fas fa-envelope me-1"></i> Send Inquiry
                </a>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn-premium btn-premium-secondary w-100" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
                <i class="fas fa-lock me-1"></i> Sign In to See Price
            </a>
        @endauth
    </div>
</div>

