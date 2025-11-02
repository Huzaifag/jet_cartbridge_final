@extends('frontend.layout.main')
@section('content')
<div class="container my-5">
    <div class="row">
        <!-- Profile Header -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="avatar-wrapper mb-3">
                        @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Profile Avatar" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px; font-size: 2rem;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <h2 class="card-title mb-1">{{ auth()->user()->name }}</h2>
                    <p class="text-muted mb-3">{{ auth()->user()->email }}</p>
                    <div class="row text-center">
                        <div class="col-md-3">
                            <h4 class="text-primary">{{ $purchasedProducts->count() }}</h4>
                            <small class="text-muted">Products Purchased</small>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-success">{{ $followedSellers->count() + $followedManufacturers->count() }}</h4>
                            <small class="text-muted">Following</small>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-info">{{ $userReviews->count() }}</h4>
                            <small class="text-muted">Reviews</small>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-warning">{{ number_format($coinsBalance) }}</h4>
                            <small class="text-muted">Coins Balance</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Sections -->
    <div class="row">
        <!-- Products Purchased -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-shopping-bag me-2"></i>Products Purchased
                    </h5>
                </div>
                <div class="card-body">
                    @if($purchasedProducts->count() > 0)
                        <div class="row g-3">
                            @foreach($purchasedProducts->take(6) as $product)
                                <div class="col-6">
                                    <div class="card border-0 shadow-sm">
                                        @php
                                            $images = is_array($product->images) ? $product->images : json_decode($product->images, true);
                                            $firstImage = str_replace('\/', '/', $images[0] ?? 'default.png');
                                        @endphp
                                        <img src="{{ asset($firstImage) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 120px; object-fit: cover;">
                                        <div class="card-body p-2">
                                            <h6 class="card-title mb-1" style="font-size: 0.9rem;">{{ Str::limit($product->name, 30) }}</h6>
                                            <small class="text-muted">${{ number_format($product->b2c_price, 2) }}</small>
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
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No products purchased yet</p>
                            <a href="{{ route('home') }}" class="btn btn-primary btn-sm">Start Shopping</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Followed Sellers/Manufacturers -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users me-2"></i>Following
                    </h5>
                </div>
                <div class="card-body">
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
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Not following anyone yet</p>
                            <a href="{{ route('home') }}" class="btn btn-success btn-sm">Discover Sellers</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews & Videos Section -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-comments me-2"></i>My Reviews & Videos
                    </h5>
                </div>
                <div class="card-body">
                    @if($userReviews->count() > 0)
                        <div class="row g-4">
                            @foreach($userReviews as $review)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body">
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
                                            <h6 class="card-title mb-2">{{ $review->product->name }}</h6>
                                            @if($review->review_text)
                                                <p class="card-text small mb-3">{{ Str::limit($review->review_text, 100) }}</p>
                                            @endif
                                            @if($review->media_urls)
                                                @php
                                                    $mediaUrls = is_array($review->media_urls) ? $review->media_urls : json_decode($review->media_urls, true);
                                                @endphp
                                                <div class="media-preview mb-2">
                                                    @if(count($mediaUrls) > 0)
                                                        <small class="text-muted">
                                                            <i class="fas fa-{{ $review->review_type == 'video' ? 'video' : 'images' }} me-1"></i>
                                                            {{ count($mediaUrls) }} {{ $review->review_type == 'video' ? 'video' : 'image' }}{{ count($mediaUrls) > 1 ? 's' : '' }}
                                                        </small>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No reviews yet</p>
                            <a href="{{ route('home') }}" class="btn btn-info btn-sm">Write Your First Review</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Coins Balance Section -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm bg-warning text-white">
                <div class="card-body text-center">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="mb-2">
                                <i class="fas fa-coins me-2"></i>{{ number_format($coinsBalance) }} Coins
                            </h3>
                            <p class="mb-0">Your current referral coin balance</p>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('seller.coins.index') }}" class="btn btn-light btn-lg">
                                <i class="fas fa-exchange-alt me-2"></i>Redeem Coins
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
