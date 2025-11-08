@extends('frontend.layout.main')
@section('content')
<div class="container my-5">
    <div class="row">
        <!-- Header -->
        <div class="col-12 mb-4">
            <div class="text-center">
                <h1 class="display-4 fw-bold text-primary mb-2">Contributor Dashboard</h1>
                <p class="text-muted">Track your contributions and impact on our platform</p>
            </div>
        </div>
    </div>

    <!-- Contributor Cards -->
    <div class="row g-4">
        @if($isSellerOrManufacturer)
            <!-- Product Uploads Card -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-lg contributor-card">
                    <div class="card-body text-center p-4">
                        <div class="icon-wrapper mb-3">
                            <i class="fas fa-upload fa-3x text-primary"></i>
                        </div>
                        <h2 class="card-title mb-2">{{ number_format($productUploads) }}</h2>
                        <p class="card-text text-muted mb-0">Product Uploads</p>
                        <small class="text-muted">Products you've added to the platform</small>
                    </div>
                </div>
            </div>

            <!-- Reviews Received Card -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-lg contributor-card">
                    <div class="card-body text-center p-4">
                        <div class="icon-wrapper mb-3">
                            <i class="fas fa-comments fa-3x text-success"></i>
                        </div>
                        <h2 class="card-title mb-2">{{ number_format($reviewsReceived) }}</h2>
                        <p class="card-text text-muted mb-0">Reviews Received</p>
                        <small class="text-muted">Customer reviews on your products</small>
                    </div>
                </div>
            </div>

            <!-- Video Analytics Card -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-lg contributor-card">
                    <div class="card-body text-center p-4">
                        <div class="icon-wrapper mb-3">
                            <i class="fas fa-video fa-3x text-info"></i>
                        </div>
                        <h2 class="card-title mb-2">{{ number_format($videoViews) }}</h2>
                        <p class="card-text text-muted mb-1">Video Views</p>
                        <p class="card-text text-warning mb-0">{{ number_format($videoLikes) }} Likes</p>
                        <small class="text-muted">Views and likes on review videos</small>
                    </div>
                </div>
            </div>

            <!-- Coins Earned Card -->
            <div class="col-lg-6 col-md-6">
                <div class="card h-100 border-0 shadow-lg contributor-card">
                    <div class="card-body text-center p-4">
                        <div class="icon-wrapper mb-3">
                            <i class="fas fa-coins fa-3x text-warning"></i>
                        </div>
                        <h2 class="card-title mb-2">{{ number_format($coinsEarned) }}</h2>
                        <p class="card-text text-muted mb-0">Coins Earned</p>
                        <small class="text-muted">Reward points from contributions</small>
                    </div>
                </div>
            </div>

            <!-- Referral Shares Card -->
            <div class="col-lg-6 col-md-6">
                <div class="card h-100 border-0 shadow-lg contributor-card">
                    <div class="card-body text-center p-4">
                        <div class="icon-wrapper mb-3">
                            <i class="fas fa-share-alt fa-3x text-danger"></i>
                        </div>
                        <h2 class="card-title mb-2">{{ number_format($referralShares) }}</h2>
                        <p class="card-text text-muted mb-0">Referral Link Shares</p>
                        <small class="text-muted">People you've referred to the platform</small>
                    </div>
                </div>
            </div>
        @else
            <!-- Number of Reviews Card -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-lg contributor-card">
                    <div class="card-body text-center p-4">
                        <div class="icon-wrapper mb-3">
                            <i class="fas fa-star fa-3x text-warning"></i>
                        </div>
                        <h2 class="card-title mb-2">{{ number_format($numberOfReviews) }}</h2>
                        <p class="card-text text-muted mb-0">Number of Reviews</p>
                        <small class="text-muted">Reviews you've written</small>
                    </div>
                </div>
            </div>

            <!-- Video Analytics Card -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-lg contributor-card">
                    <div class="card-body text-center p-4">
                        <div class="icon-wrapper mb-3">
                            <i class="fas fa-video fa-3x text-info"></i>
                        </div>
                        <h2 class="card-title mb-2">{{ number_format($videoViews) }}</h2>
                        <p class="card-text text-muted mb-1">Video Views</p>
                        <p class="card-text text-success mb-0">{{ number_format($videoLikes) }} Likes</p>
                        <small class="text-muted">Views and likes on your review videos</small>
                    </div>
                </div>
            </div>

            <!-- Coins Earned Card -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-lg contributor-card">
                    <div class="card-body text-center p-4">
                        <div class="icon-wrapper mb-3">
                            <i class="fas fa-coins fa-3x text-success"></i>
                        </div>
                        <h2 class="card-title mb-2">{{ number_format($coinsEarned) }}</h2>
                        <p class="card-text text-muted mb-0">Coins Earned</p>
                        <small class="text-muted">Reward points from your activity</small>
                    </div>
                </div>
            </div>

            <!-- Referral Shares Card -->
            <div class="col-lg-6 col-md-6">
                <div class="card h-100 border-0 shadow-lg contributor-card">
                    <div class="card-body text-center p-4">
                        <div class="icon-wrapper mb-3">
                            <i class="fas fa-share-alt fa-3x text-primary"></i>
                        </div>
                        <h2 class="card-title mb-2">{{ number_format($referralShares) }}</h2>
                        <p class="card-text text-muted mb-0">Referral Link Shares</p>
                        <small class="text-muted">People you've referred to the platform</small>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Call to Action -->
    <div class="row mt-5">
        <div class="col-12 text-center">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body py-4">
                    <h4 class="card-title mb-3">Keep Contributing!</h4>
                    <p class="card-text text-muted mb-4">Your contributions help make our platform better for everyone.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                        </a>
                        @if($isSellerOrManufacturer)
                            <a href="{{ $user->seller ? route('seller.products.index') : route('manufacturer.products.index') }}" class="btn btn-success btn-lg">
                                <i class="fas fa-plus me-2"></i>Add More Products
                            </a>
                        @else
                            <a href="{{ route('home') }}" class="btn btn-info btn-lg">
                                <i class="fas fa-star me-2"></i>Write Reviews
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.contributor-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 15px;
}

.contributor-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}

.icon-wrapper {
    background: linear-gradient(135deg, rgba(0,123,255,0.1), rgba(0,123,255,0.05));
    border-radius: 50%;
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.card-title {
    font-weight: 700;
    color: #333;
}

.display-4 {
    background: linear-gradient(135deg, #007bff, #6610f2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
</style>
@endsection
