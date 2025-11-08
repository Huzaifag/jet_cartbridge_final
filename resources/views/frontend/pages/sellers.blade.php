@extends('frontend.layout.main')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-primary mb-3">Verified Sellers</h1>
                <p class="lead text-muted">Connect with trusted suppliers and manufacturers worldwide</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @forelse($sellers as $seller)
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0 seller-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="seller-avatar me-3">
                            @if($seller->avatar)
                                <img src="{{ asset('storage/' . $seller->avatar) }}" alt="{{ $seller->business_name }}" class="rounded-circle">
                            @else
                                <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-building fs-4 text-white"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1">{{ $seller->business_name }}</h5>
                            <div class="d-flex align-items-center">
                                @if($seller->is_verified)
                                    <i class="bi bi-patch-check-fill text-success me-1" title="Verified Seller"></i>
                                    <small class="text-success me-2">Verified</small>
                                @endif
                                @if($seller->is_premium)
                                    <i class="bi bi-star-fill text-warning me-1" title="Premium Seller"></i>
                                    <small class="text-warning">Premium</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="seller-info mb-3">
                        @if($seller->city && $seller->country)
                            <p class="text-muted mb-2">
                                <i class="bi bi-geo-alt me-1"></i>
                                {{ $seller->city }}, {{ $seller->country }}
                            </p>
                        @endif
                        <p class="text-muted mb-2">
                            <i class="bi bi-box-seam me-1"></i>
                            {{ $seller->products->count() }} products
                        </p>
                        @if($seller->established_year)
                            <p class="text-muted mb-0">
                                <i class="bi bi-calendar me-1"></i>
                                Est. {{ $seller->established_year }}
                            </p>
                        @endif
                    </div>

                    <div class="seller-stats mb-3">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="stat">
                                    <strong>{{ $seller->products->count() }}</strong>
                                    <br><small class="text-muted">Products</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat">
                                    <strong>{{ number_format($seller->products->avg('rating') ?? 0, 1) }}</strong>
                                    <br><small class="text-muted">Rating</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat">
                                    <strong>{{ $seller->products->sum('total_orders') ?? 0 }}</strong>
                                    <br><small class="text-muted">Orders</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('home', ['seller' => $seller->id]) }}" class="btn btn-primary flex-fill">
                            View Products
                        </a>
                        @auth
                            @if(auth()->user()->role == 'b2c')
                                <button class="btn btn-outline-primary follow-btn"
                                        data-seller-id="{{ $seller->id }}"
                                        data-following="{{ auth()->user()->followedSellers->contains($seller->id) ? 'true' : 'false' }}">
                                    <i class="bi bi-heart{{ auth()->user()->followedSellers->contains($seller->id) ? '-fill' : '' }}"></i>
                                </button>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="bi bi-building fs-1 text-muted mb-3"></i>
                <h3 class="text-muted">No sellers available</h3>
                <p class="text-muted">Check back later for new verified sellers.</p>
            </div>
        </div>
        @endforelse
    </div>

    @if($sellers->hasPages())
    <div class="row mt-5">
        <div class="col-12">
            <nav aria-label="Seller pagination">
                <ul class="pagination justify-content-center">
                    {{ $sellers->links() }}
                </ul>
            </nav>
        </div>
    </div>
    @endif

    <!-- Seller Statistics -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-sm border-0 bg-light">
                <div class="card-body p-4">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="stat-item">
                                <h3 class="h2 text-primary mb-1">{{ $sellers->total() }}</h3>
                                <p class="text-muted mb-0">Total Sellers</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <h3 class="h2 text-success mb-1">{{ $sellers->where('is_verified', true)->count() }}</h3>
                                <p class="text-muted mb-0">Verified Sellers</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <h3 class="h2 text-warning mb-1">{{ $sellers->where('is_premium', true)->count() }}</h3>
                                <p class="text-muted mb-0">Premium Sellers</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <h3 class="h2 text-info mb-1">{{ $sellers->sum(function($seller) { return $seller->products->count(); }) }}</h3>
                                <p class="text-muted mb-0">Total Products</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.seller-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.seller-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.seller-avatar img,
.avatar-placeholder {
    width: 60px;
    height: 60px;
}

.avatar-placeholder {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.stat {
    padding: 10px 0;
}

.stat strong {
    font-size: 1.1rem;
    color: #495057;
}

.follow-btn {
    min-width: 40px;
}

.stat-item {
    padding: 20px 0;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle follow/unfollow functionality
    document.querySelectorAll('.follow-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const sellerId = this.dataset.sellerId;
            const isFollowing = this.dataset.following === 'true';

            fetch(`/follow/seller/${sellerId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.dataset.following = !isFollowing;
                    const icon = this.querySelector('i');
                    if (!isFollowing) {
                        icon.className = 'bi bi-heart-fill';
                        this.classList.remove('btn-outline-primary');
                        this.classList.add('btn-primary');
                    } else {
                        icon.className = 'bi bi-heart';
                        this.classList.remove('btn-primary');
                        this.classList.add('btn-outline-primary');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
    });
});
</script>
@endsection
