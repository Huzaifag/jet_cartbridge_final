@extends('frontend.layout.main')
@section('content')
<style>
    /* Google Contributor Style CSS */
    :root {
        --google-blue: #1a73e8;
        --google-blue-light: #e8f0fe;
        --google-yellow: #fbbc04; /* For Accent/Coins */
        --google-green: #34a853; /* For Success/Reviews */
        --google-red: #ea4335;
        --google-background: #f8f9fa;
        --google-card-bg: #ffffff;
        --google-text-primary: #202124;
        --google-text-secondary: #5f6368;
        --google-border: #dadce0;
    }

    body {
        font-family: 'Inter', 'Roboto', sans-serif;
        background-color: var(--google-background);
        color: var(--google-text-primary);
        line-height: 1.5;
    }

    .contributor-section {
        padding: 3rem 1rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Card Styling (Material Elevation) */
    .contributor-card {
        background-color: var(--google-card-bg);
        border-radius: 8px;
        box-shadow: 0 1px 2px 0 rgba(60, 64, 67, 0.3), 0 1px 3px 1px rgba(60, 64, 67, 0.15);
        padding: 24px;
        margin-bottom: 20px;
        transition: box-shadow 0.2s ease-in-out;
        border: 1px solid var(--google-border); /* Subtle border for separation */
    }

    /* Grid Layout */
    .contributor-grid-2 {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
    }
    @media (min-width: 768px) {
        .contributor-grid-2 {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Profile Header */
    .profile-header-card {
        text-align: center;
    }
    .profile-avatar {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border: 3px solid var(--google-blue-light);
        box-shadow: 0 0 0 3px var(--google-blue);
    }
    .profile-initials {
        width: 100px;
        height: 100px;
        font-size: 2.5rem;
        background-color: var(--google-blue);
        color: white;
    }
    .profile-title {
        font-size: 1.8rem;
        font-weight: 500;
        color: var(--google-text-primary);
    }
    .profile-subtitle {
        color: var(--google-text-secondary);
        font-size: 1rem;
    }

    /* Chart Simulation Styling */
    .metric-box {
        padding: 1rem;
        border-radius: 6px;
        background-color: var(--google-background);
    }
    .metric-value {
        font-size: 1.75rem;
        font-weight: 600;
        color: var(--google-blue);
    }
    .metric-label {
        font-size: 0.85rem;
        color: var(--google-text-secondary);
        font-weight: 500;
    }

    /* Bar Chart Simulation (Placeholder) */
    .bar-chart-container {
        display: flex;
        align-items: flex-end;
        height: 80px;
        padding: 5px;
        gap: 8px;
        background-color: #f5f5f5;
        border-radius: 4px;
    }
    .bar {
        flex-grow: 1;
        width: 25%;
        background-color: var(--google-blue);
        border-radius: 2px 2px 0 0;
        transition: height 0.5s ease;
        opacity: 0.8;
    }
    .bar:nth-child(even) {
        background-color: var(--google-blue);
        opacity: 1;
    }

    /* Progress Ring Simulation (Coins) */
    .progress-ring-container {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: radial-gradient(closest-side, white 70%, transparent 80% 100%),
                    conic-gradient(var(--google-yellow) 55%, var(--google-border) 0);
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.9rem;
    }
    /* Note: 55% is static for demonstration; in a real app, this would be calculated and injected into the conic-gradient */
    .coins-box {
        background: linear-gradient(135deg, var(--google-yellow) 0%, var(--google-yellow) 100%);
        color: var(--google-text-primary);
    }
    .coins-box .metric-value {
        color: var(--google-text-primary);
    }
    .coins-box a {
        background-color: var(--google-text-primary);
        color: white;
        padding: 8px 16px;
        border-radius: 4px;
        font-weight: 500;
        font-size: 0.9rem;
        text-decoration: none;
    }

    /* Products and Following Lists */
    .section-title {
        border-bottom: 1px solid var(--google-border);
        padding-bottom: 10px;
        margin-bottom: 15px;
        color: var(--google-text-primary);
        font-weight: 500;
        font-size: 1.1rem;
    }
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
        gap: 10px;
    }
    .product-card {
        border: 1px solid var(--google-border);
        border-radius: 6px;
        overflow: hidden;
    }
    .product-image {
        width: 100%;
        height: 100px;
        object-fit: cover;
    }
    .product-info {
        padding: 8px;
    }
    .follow-item {
        border-bottom: 1px solid var(--google-border);
        padding: 10px 0;
    }
    .follow-item:last-child {
        border-bottom: none;
    }
    .follow-avatar {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border: 1px solid var(--google-border);
    }
    .review-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 15px;
    }
    .review-card {
        padding: 15px;
        background-color: var(--google-background);
        border-radius: 6px;
    }
    .rating-star {
        color: var(--google-yellow);
        font-size: 0.9rem;
    }
    .text-dim {
        color: var(--google-text-secondary);
    }
</style>

<div class="contributor-section">
    <!-- Profile Header Card -->
    <div class="contributor-card profile-header-card mb-4" style="padding: 2.5rem;">
        <div class="row align-items-center">
            <div class="col-md-3">
                <!-- Avatar -->
                <div class="avatar-wrapper mb-3 mx-auto" style="width: 100px;">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Profile Avatar" class="rounded-circle profile-avatar">
                    @else
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center profile-initials">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-9 text-md-start">
                <h2 class="profile-title mb-1">{{ auth()->user()->name }}</h2>
                <p class="profile-subtitle">{{ auth()->user()->email }}</p>
                <p class="mt-3 text-dim">Welcome to your personal dashboard. Track your activity, manage your products, and see your contribution impact.</p>
            </div>
        </div>
    </div>

    <!-- Metrics and Charts Section (New, Google Style) -->
    <div class="contributor-card mb-4">
        <h5 class="section-title mb-4">Your Contribution Metrics</h5>
        <div class="row g-3">
            <!-- Products Purchased Metric (with simulated bar chart) -->
            <div class="col-12 col-md-6 col-lg-3">
                <div class="metric-box">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-block">
                            <i class="fas fa-shopping-bag me-1" style="color: var(--google-blue);"></i>
                            <span class="metric-label">Products Purchased</span>
                        </div>
                        <span class="metric-value">{{ $purchasedProducts->count() }}</span>
                    </div>
                    <div class="bar-chart-container">
                        <!-- Simulated Chart Data (30%, 55%, 70%, 85% for 4 months) -->
                        <div class="bar" style="height: 30%;" title="Month 1"></div>
                        <div class="bar" style="height: 55%;" title="Month 2"></div>
                        <div class="bar" style="height: 70%;" title="Month 3"></div>
                        <div class="bar" style="height: 85%;" title="Month 4"></div>
                    </div>
                </div>
            </div>

            <!-- Reviews Metric -->
            <div class="col-12 col-md-6 col-lg-3">
                <div class="metric-box">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-block">
                            <i class="fas fa-comments me-1" style="color: var(--google-green);"></i>
                            <span class="metric-label">Total Reviews</span>
                        </div>
                        <span class="metric-value" style="color: var(--google-green);">{{ $userReviews->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-center pt-4 pb-2" style="height: 80px;">
                        <i class="fas fa-quote-right" style="font-size: 3rem; color: var(--google-green); opacity: 0.2;"></i>
                    </div>
                </div>
            </div>

            <!-- Following Metric -->
            <div class="col-12 col-md-6 col-lg-3">
                <div class="metric-box">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-block">
                            <i class="fas fa-users me-1" style="color: var(--google-red);"></i>
                            <span class="metric-label">Following (Sellers/Brands)</span>
                        </div>
                        <span class="metric-value" style="color: var(--google-red);">{{ $followedSellers->count() + $followedManufacturers->count() }}</span>
                    </div>
                    <div class="d-flex justify-content-center pt-4 pb-2" style="height: 80px;">
                        <i class="fas fa-store-alt" style="font-size: 3rem; color: var(--google-red); opacity: 0.2;"></i>
                    </div>
                </div>
            </div>

            <!-- Coins Balance (with simulated progress ring) -->
            <div class="col-12 col-md-6 col-lg-3">
                <div class="metric-box coins-box">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-block">
                            <i class="fas fa-coins me-1" style="color: var(--google-text-primary);"></i>
                            <span class="metric-label">Coins Balance</span>
                        </div>
                        <span class="metric-value">{{ number_format($coinsBalance) }}</span>
                    </div>
                    <div class="progress-ring-container mt-3" style="background: radial-gradient(closest-side, white 70%, transparent 80% 100%), conic-gradient(var(--google-yellow) 55%, var(--google-border) 0);">
                        55%
                    </div>
                    <div class="text-center mt-3">
                         <a href="{{ route('seller.coins.index') }}" class="d-inline-block">Redeem Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="contributor-grid-2">
        <!-- Products Purchased List -->
        <div class="contributor-card">
            <h5 class="section-title">Latest Purchases ({{ $purchasedProducts->count() }} Total)</h5>
            <div>
                @if($purchasedProducts->count() > 0)
                    <div class="product-grid">
 /style>                       @foreach($purchasedProducts->take(6) as $product)
                            <a href="#" class="text-decoration-none d-block product-card">
                                @php
                                    $images = is_array($product->images) ? $product->images : json_decode($product->images, true);
                                    $firstImage = str_replace('\/', '/', $images[0] ?? 'https://placehold.co/150x100/f1f3f4/5f6368?text=Product');
                                @endphp
                                <img src="{{ asset($firstImage) }}" onerror="this.onerror=null;this.src='https://placehold.co/150x100/f1f3f4/5f6368?text=Product';" class="product-image" alt="{{ $product->name }}">
                                <div class="product-info">
                                    <h6 class="mb-1" style="font-size: 0.8rem; font-weight: 500;">{{ Str::limit($product->name, 20) }}</h6>
                                    <small style="color: var(--google-blue); font-weight: 600;">${{ number_format($product->b2c_price, 2) }}</small>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    @if($purchasedProducts->count() > 6)
                        <div class="text-center mt-3">
                            <small class="text-dim">Viewing {{ min(6, $purchasedProducts->count()) }} of {{ $purchasedProducts->count() }}</small>
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-cart-arrow-down text-dim mb-3" style="font-size: 2rem;"></i>
                        <p class="text-dim mb-3">Time to treat yourself! Start shopping.</p>
                        <a href="{{ route('home') }}" class="btn-sm btn-primary" style="background-color: var(--google-blue); color: white; border-radius: 4px; padding: 6px 12px; text-decoration: none;">Explore Products</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Followed Sellers/Manufacturers List -->
        <div class="contributor-card">
            <h5 class="section-title">People & Brands I Follow</h5>
            <div>
                @if(($followedSellers->count() + $followedManufacturers->count()) > 0)
                    <div class="list-group list-group-flush">
                        @foreach($followedSellers->take(8) as $seller)
                            <div class="d-flex align-items-center follow-item">
                                <div class="flex-shrink-0 me-3">
                                    @if($seller->logo)
                                        <img src="{{ asset('storage/' . $seller->logo) }}" alt="Seller Logo" class="rounded-circle follow-avatar">
                                    @else
                                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center follow-avatar" style="background-color: var(--google-blue-light); color: var(--google-blue);">
                                            <i class="fas fa-store" style="font-size: 0.8rem;"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0" style="font-size: 0.95rem;">{{ $seller->business_name }}</h6>
                                    <small class="text-dim">{{ $seller->products->count() }} products</small>
                                </div>
                                <span class="badge" style="background-color: var(--google-blue-light); color: var(--google-blue); font-weight: 500;">Seller</span>
                            </div>
                        @endforeach
                        @foreach($followedManufacturers->take(8 - $followedSellers->count()) as $manufacturer)
                            <div class="d-flex align-items-center follow-item">
                                <div class="flex-shrink-0 me-3">
                                    @if($manufacturer->logo)
                                        <img src="{{ asset('storage/' . $manufacturer->logo) }}" alt="Manufacturer Logo" class="rounded-circle follow-avatar">
                                    @else
                                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center follow-avatar" style="background-color: var(--google-blue-light); color: var(--google-blue);">
                                            <i class="fas fa-industry" style="font-size: 0.8rem;"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0" style="font-size: 0.95rem;">{{ $manufacturer->business_name }}</h6>
                                    <small class="text-dim">{{ $manufacturer->products->count() }} products</small>
                                </div>
                                <span class="badge" style="background-color: var(--google-blue-light); color: var(--google-blue); font-weight: 500;">Brand</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-search text-dim mb-3" style="font-size: 2rem;"></i>
                        <p class="text-dim mb-3">Follow sellers and brands to keep up with their latest.</p>
                        <a href="{{ route('home') }}" class="btn-sm btn-secondary" style="border: 1px solid var(--google-blue); color: var(--google-blue); border-radius: 4px; padding: 6px 12px; text-decoration: none;">Find Brands</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="contributor-card mt-4">
        <h5 class="section-title">My Recent Reviews & Contributions</h5>
        <div>
            @if($userReviews->count() > 0)
                <div class="review-grid">
                    @foreach($userReviews->take(6) as $review)
                        <div class="review-card">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="rating me-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fas fa-star rating-star"></i>
                                        @else
                                            <i class="far fa-star text-dim" style="opacity: 0.5; font-size: 0.9rem;"></i>
                                        @endif
                                    @endfor
                                </div>
                                <small class="text-dim" style="font-size: 0.75rem;">{{ $review->created_at->diffForHumans() }}</small>
                            </div>
                            <h6 class="mb-1" style="font-size: 1rem; color: var(--google-blue);">{{ Str::limit($review->product->name, 40) }}</h6>
                            @if($review->review_text)
                                <p class="small text-dim mb-3">{{ Str::limit($review->review_text, 80) }}</p>
                            @endif
                            @if($review->media_urls)
                                @php
                                    $mediaUrls = is_array($review->media_urls) ? $review->media_urls : json_decode($review->media_urls, true);
                                @endphp
                                <div class="mt-2">
                                    @if(count($mediaUrls) > 0)
                                        <small style="color: var(--google-green); font-weight: 500;">
                                            <i class="fas fa-{{ $review->review_type == 'video' ? 'video' : 'images' }} me-1"></i>
                                            {{ count($mediaUrls) }} {{ $review->review_type == 'video' ? 'Video' : 'Image' }}{{ count($mediaUrls) > 1 ? 's' : '' }} Attached
                                        </small>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-pencil-alt text-dim mb-3" style="font-size: 2rem;"></i>
                    <p class="text-dim mb-3">Share your experience! Write a review for a recent purchase.</p>
                    <a href="{{ route('home') }}" class="btn-sm btn-primary" style="background-color: var(--google-green); color: white; border-radius: 4px; padding: 6px 12px; text-decoration: none;">Contribute Review</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection