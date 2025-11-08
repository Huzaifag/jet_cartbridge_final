@extends('frontend.layout.main')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-primary mb-3">Verified Manufacturers</h1>
                <p class="lead text-muted">Discover direct manufacturers and expand your supply chain</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @forelse($manufacturers as $manufacturer)
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0 manufacturer-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="manufacturer-avatar me-3">
                            @if($manufacturer->avatar)
                                <img src="{{ asset('storage/' . $manufacturer->avatar) }}" alt="{{ $manufacturer->business_name }}" class="rounded-circle">
                            @else
                                <div class="avatar-placeholder rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-gear fs-4 text-white"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1">{{ $manufacturer->business_name }}</h5>
                            <div class="d-flex align-items-center">
                                @if($manufacturer->is_verified)
                                    <i class="bi bi-patch-check-fill text-success me-1" title="Verified Manufacturer"></i>
                                    <small class="text-success me-2">Verified</small>
                                @endif
                                @if($manufacturer->is_premium)
                                    <i class="bi bi-star-fill text-warning me-1" title="Premium Manufacturer"></i>
                                    <small class="text-warning">Premium</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="manufacturer-info mb-3">
                        @if($manufacturer->city && $manufacturer->country)
                            <p class="text-muted mb-2">
                                <i class="bi bi-geo-alt me-1"></i>
                                {{ $manufacturer->city }}, {{ $manufacturer->country }}
                            </p>
                        @endif
                        <p class="text-muted mb-2">
                            <i class="bi bi-tools me-1"></i>
                            {{ $manufacturer->products->count() }} products
                        </p>
                        @if($manufacturer->established_year)
                            <p class="text-muted mb-0">
                                <i class="bi bi-calendar me-1"></i>
                                Est. {{ $manufacturer->established_year }}
                            </p>
                        @endif
                    </div>

                    <div class="manufacturer-specialties mb-3">
                        @if($manufacturer->specialties)
                            <div class="mb-2">
                                <small class="text-muted">Specialties:</small>
                                <div>
                                    @foreach(explode(',', $manufacturer->specialties) as $specialty)
                                        <span class="badge bg-light text-dark me-1">{{ trim($specialty) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="manufacturer-stats mb-3">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="stat">
                                    <strong>{{ $manufacturer->products->count() }}</strong>
                                    <br><small class="text-muted">Products</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat">
                                    <strong>{{ number_format($manufacturer->products->avg('rating') ?? 0, 1) }}</strong>
                                    <br><small class="text-muted">Rating</small>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat">
                                    <strong>{{ $manufacturer->products->sum('total_orders') ?? 0 }}</strong>
                                    <br><small class="text-muted">Orders</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('home', ['manufacturer' => $manufacturer->id]) }}" class="btn btn-primary flex-fill">
                            View Products
                        </a>
                        @auth
                            @if(auth()->user()->role == 'b2c')
                                <button class="btn btn-outline-primary follow-btn"
                                        data-manufacturer-id="{{ $manufacturer->id }}"
                                        data-following="{{ auth()->user()->followedManufacturers->contains($manufacturer->id) ? 'true' : 'false' }}">
                                    <i class="bi bi-heart{{ auth()->user()->followedManufacturers->contains($manufacturer->id) ? '-fill' : '' }}"></i>
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
                <i class="bi bi-gear fs-1 text-muted mb-3"></i>
                <h3 class="text-muted">No manufacturers available</h3>
                <p class="text-muted">Check back later for new verified manufacturers.</p>
            </div>
        </div>
        @endforelse
    </div>

    @if($manufacturers->hasPages())
    <div class="row mt-5">
        <div class="col-12">
            <nav aria-label="Manufacturer pagination">
                <ul class="pagination justify-content-center">
                    {{ $manufacturers->links() }}
                </ul>
            </nav>
        </div>
    </div>
    @endif

    <!-- Manufacturer Statistics -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-sm border-0 bg-light">
                <div class="card-body p-4">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="stat-item">
                                <h3 class="h2 text-primary mb-1">{{ $manufacturers->total() }}</h3>
                                <p class="text-muted mb-0">Total Manufacturers</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <h3 class="h2 text-success mb-1">{{ $manufacturers->where('is_verified', true)->count() }}</h3>
                                <p class="text-muted mb-0">Verified Manufacturers</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <h3 class="h2 text-warning mb-1">{{ $manufacturers->where('is_premium', true)->count() }}</h3>
                                <p class="text-muted mb-0">Premium Manufacturers</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <h3 class="h2 text-info mb-1">{{ $manufacturers->sum(function($manufacturer) { return $manufacturer->products->count(); }) }}</h3>
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
.manufacturer-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.manufacturer-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.manufacturer-avatar img,
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

.badge {
    font-size: 0.75rem;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle follow/unfollow functionality
    document.querySelectorAll('.follow-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const manufacturerId = this.dataset.manufacturerId;
            const isFollowing = this.dataset.following === 'true';

            fetch(`/follow/manufacturer/${manufacturerId}`, {
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
