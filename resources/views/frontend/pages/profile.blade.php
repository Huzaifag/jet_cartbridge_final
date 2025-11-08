@extends('frontend.layout.main')
@section('content')
<div class="premium-section" style="padding: 3rem 0;">
    <div class="premium-container">
        <!-- Profile Header -->
        <div class="mb-4">
            <div class="premium-card" style="padding: 2.5rem;">
                <div class="text-center">
                    <div class="avatar-wrapper mb-3">
                        @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Profile Avatar" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover; border: 4px solid var(--color-accent); box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);">
                        @else
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 120px; height: 120px; font-size: 2.5rem; background: linear-gradient(135deg, var(--color-accent) 0%, var(--color-accent-dark) 100%); color: var(--color-dark-navy); box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <h2 class="premium-card-title mb-2" style="font-size: 2rem;">{{ auth()->user()->name }}</h2>
                    <p class="text-dim mb-4">{{ auth()->user()->email }}</p>
                    <div class="row text-center g-4">
                        <div class="col-6 col-md-3">
                            <div class="stat-box">
                                <h4 class="text-accent mb-1" style="font-size: 2rem; font-weight: 800;">{{ $purchasedProducts->count() }}</h4>
                                <small class="text-dim">Products Purchased</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-box">
                                <h4 class="text-accent mb-1" style="font-size: 2rem; font-weight: 800;">{{ $followedSellers->count() + $followedManufacturers->count() }}</h4>
                                <small class="text-dim">Following</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-box">
                                <h4 class="text-accent mb-1" style="font-size: 2rem; font-weight: 800;">{{ $userReviews->count() }}</h4>
                                <small class="text-dim">Reviews</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stat-box">
                                <h4 class="text-accent mb-1" style="font-size: 2rem; font-weight: 800;">{{ number_format($coinsBalance) }}</h4>
                                <small class="text-dim">Coins Balance</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Sections -->
        <div class="premium-grid premium-grid-2">
            <!-- Products Purchased -->
            <div class="premium-card">
                <div class="d-flex align-items-center mb-3 pb-3" style="border-bottom: 2px solid var(--color-accent);">
                    <i class="fas fa-shopping-bag text-accent me-2" style="font-size: 1.5rem;"></i>
                    <h5 class="premium-card-title mb-0">Products Purchased</h5>
                </div>
                <div>
                    @if($purchasedProducts->count() > 0)
                        <div class="row g-3">
                            @foreach($purchasedProducts->take(6) as $product)
                                <div class="col-6">
                                    <div class="premium-product-card" style="max-height: none;">
                                        @php
                                            $images = is_array($product->images) ? $product->images : json_decode($product->images, true);
                                            $firstImage = str_replace('\/', '/', $images[0] ?? 'default.png');
                                        @endphp
                                        <img src="{{ asset($firstImage) }}" class="premium-product-image" alt="{{ $product->name }}" style="height: 120px;">
                                        <div class="premium-product-content" style="padding: 0.75rem;">
                                            <h6 class="premium-product-title mb-1" style="font-size: 0.85rem;">{{ Str::limit($product->name, 30) }}</h6>
                                            <small class="text-accent" style="font-weight: 600;">${{ number_format($product->b2c_price, 2) }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if($purchasedProducts->count() > 6)
                            <div class="text-center mt-3">
                                <small class="text-muted">And {{ $purchasedProducts->count() - 6 }} more products...</small>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-shopping-cart text-dim mb-3" style="font-size: 3rem; opacity: 0.5;"></i>
                            <p class="text-dim mb-3">No products purchased yet</p>
                            <a href="{{ route('home') }}" class="btn-premium btn-premium-primary">Start Shopping</a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Followed Sellers/Manufacturers -->
            <div class="premium-card">
                <div class="d-flex align-items-center mb-3 pb-3" style="border-bottom: 2px solid var(--color-accent);">
                    <i class="fas fa-users text-accent me-2" style="font-size: 1.5rem;"></i>
                    <h5 class="premium-card-title mb-0">Following</h5>
                </div>
                <div>
                    @if(($followedSellers->count() + $followedManufacturers->count()) > 0)
                        <div class="list-group list-group-flush">
                            @foreach($followedSellers as $seller)
                                <div class="list-group-item px-0">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            @if($seller->logo)
                                                <img src="{{ asset('storage/' . $seller->logo) }}" alt="Seller Logo" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-store"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $seller->business_name }}</h6>
                                            <small class="text-muted">{{ $seller->products->count() }} products</small>
                                        </div>
                                        <small class="text-muted">Seller</small>
                                    </div>
                                </div>
                            @endforeach
                            @foreach($followedManufacturers as $manufacturer)
                                <div class="list-group-item px-0">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3">
                                            @if($manufacturer->logo)
                                                <img src="{{ asset('storage/' . $manufacturer->logo) }}" alt="Manufacturer Logo" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-industry"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $manufacturer->business_name }}</h6>
                                            <small class="text-muted">{{ $manufacturer->products->count() }} products</small>
                                        </div>
                                        <small class="text-muted">Manufacturer</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-users text-dim mb-3" style="font-size: 3rem; opacity: 0.5;"></i>
                            <p class="text-dim mb-3">Not following anyone yet</p>
                            <a href="{{ route('home') }}" class="btn-premium btn-premium-primary">Discover Sellers</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Reviews & Videos Section -->
        <div class="premium-card">
            <div class="d-flex align-items-center mb-3 pb-3" style="border-bottom: 2px solid var(--color-accent);">
                <i class="fas fa-comments text-accent me-2" style="font-size: 1.5rem;"></i>
                <h5 class="premium-card-title mb-0">My Reviews & Videos</h5>
            </div>
            <div>
                    @if($userReviews->count() > 0)
                        <div class="premium-grid premium-grid-3">
                            @foreach($userReviews as $review)
                                <div class="premium-card" style="padding: 1.5rem;">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="rating me-2">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->rating)
                                                            <i class="fas fa-star text-warning"></i>
                                                        @else
                                                            <i class="far fa-star text-warning"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                            </div>
                                            <h6 class="premium-card-title mb-2">{{ $review->product->name }}</h6>
                                            @if($review->review_text)
                                                <p class="premium-card-text small mb-3">{{ Str::limit($review->review_text, 100) }}</p>
                                            @endif
                                            @if($review->media_urls)
                                                @php
                                                    $mediaUrls = is_array($review->media_urls) ? $review->media_urls : json_decode($review->media_urls, true);
                                                @endphp
                                                <div class="media-preview mb-2">
                                                    @if(count($mediaUrls) > 0)
                                                        <small class="text-dim">
                                                            <i class="fas fa-{{ $review->review_type == 'video' ? 'video' : 'images' }} me-1 text-accent"></i>
                                                            {{ count($mediaUrls) }} {{ $review->review_type == 'video' ? 'video' : 'image' }}{{ count($mediaUrls) > 1 ? 's' : '' }}
                                                        </small>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-comments text-dim mb-3" style="font-size: 3rem; opacity: 0.5;"></i>
                            <p class="text-dim mb-3">No reviews yet</p>
                            <a href="{{ route('home') }}" class="btn-premium btn-premium-primary">Write Your First Review</a>
                        </div>
                    @endif
                </div>
            </div>

        <!-- Coins Balance Section -->
        <div class="premium-card" style="background: linear-gradient(135deg, var(--color-accent) 0%, var(--color-accent-dark) 100%); border: none;">
            <div class="text-center">
                <div class="row align-items-center">
                    <div class="col-md-8 text-md-start">
                        <h3 class="mb-2" style="color: var(--color-dark-navy); font-weight: 800;">
                            <i class="fas fa-coins me-2"></i>{{ number_format($coinsBalance) }} Coins
                        </h3>
                        <p class="mb-0" style="color: rgba(13, 13, 30, 0.8);">Your current referral coin balance</p>
                    </div>
                    <div class="col-md-4 mt-3 mt-md-0">
                        <a href="{{ route('seller.coins.index') }}" class="btn-premium btn-premium-secondary" style="background: var(--color-dark-navy); color: var(--color-accent); border-color: var(--color-dark-navy);">
                            <i class="fas fa-exchange-alt me-2"></i>Redeem Coins
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
