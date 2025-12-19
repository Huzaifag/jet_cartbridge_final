@extends('frontend.layout.main')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="text-center mb-5">
                @if(request('nearest') == '1')
                    <h1 class="display-4 fw-bold text-primary mb-3">
                        <i class="fas fa-map-marker-alt me-2"></i>Nearest Sellers
                    </h1>
                    <p class="lead text-muted">Sellers near your location for faster delivery and service</p>
                    @if(request('user_lat') && request('user_lng'))
                        <div class="alert alert-info d-inline-block">
                            <i class="fas fa-info-circle me-2"></i>
                            Showing sellers within {{ request('radius', 25) }}km of your location
                        </div>
                    @endif
                @else
                    <h1 class="display-4 fw-bold text-primary mb-3">Verified Sellers</h1>
                    <p class="lead text-muted">Connect with trusted suppliers and manufacturers worldwide</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Search and Filter Bar -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('sellers') }}" class="row g-3 align-items-end">
                        <div class="col-md-6">
                            <label class="form-label">Search Sellers</label>
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Search by business name, city, or description..."
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Radius (km)</label>
                            <select name="radius" class="form-select" {{ !request('nearest') ? 'disabled' : '' }}>
                                <option value="10" {{ request('radius') == '10' ? 'selected' : '' }}>10 km</option>
                                <option value="25" {{ request('radius', '25') == '25' ? 'selected' : '' }}>25 km</option>
                                <option value="50" {{ request('radius') == '50' ? 'selected' : '' }}>50 km</option>
                                <option value="100" {{ request('radius') == '100' ? 'selected' : '' }}>100 km</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i>Search
                                </button>
                                @if(request('nearest') == '1')
                                    <input type="hidden" name="nearest" value="1">
                                    <input type="hidden" name="user_lat" value="{{ request('user_lat') }}">
                                    <input type="hidden" name="user_lng" value="{{ request('user_lng') }}">
                                @endif
                                <a href="{{ route('sellers') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i>Clear
                                </a>
                                @if(!request('nearest'))
                                    <button type="button" class="btn btn-success" onclick="findNearestSellers()">
                                        <i class="fas fa-map-marker-alt me-1"></i>Near Me
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
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
                                @if(isset($seller->distance))
                                    <span class="badge bg-success ms-2">
                                        <i class="fas fa-route me-1"></i>{{ number_format($seller->distance, 1) }} km away
                                    </span>
                                @endif
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
                @if(request('nearest') == '1')
                    <i class="fas fa-map-marker-alt fs-1 text-muted mb-3"></i>
                    <h3 class="text-muted">No sellers found nearby</h3>
                    <p class="text-muted mb-4">
                        We couldn't find any sellers within {{ request('radius', 25) }}km of your location.
                        <br>Try expanding your search radius or browse all sellers.
                    </p>
                    <div class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('sellers', ['nearest' => 1, 'user_lat' => request('user_lat'), 'user_lng' => request('user_lng'), 'radius' => 50]) }}" 
                           class="btn btn-primary">
                            <i class="fas fa-expand-arrows-alt me-1"></i>Expand to 50km
                        </a>
                        <a href="{{ route('sellers') }}" class="btn btn-outline-primary">
                            <i class="fas fa-globe me-1"></i>Browse All Sellers
                        </a>
                    </div>
                @else
                    <i class="bi bi-building fs-1 text-muted mb-3"></i>
                    <h3 class="text-muted">No sellers available</h3>
                    <p class="text-muted mb-4">Check back later for new verified sellers.</p>
                    <button type="button" class="btn btn-success" onclick="findNearestSellers()">
                        <i class="fas fa-map-marker-alt me-1"></i>Find Sellers Near Me
                    </button>
                @endif
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
