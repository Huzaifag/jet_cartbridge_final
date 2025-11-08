@extends('frontend.layout.main')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-primary mb-3">Product Categories</h1>
                <p class="lead text-muted">Explore our comprehensive range of product categories</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        @forelse($categories as $category)
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0 category-card">
                <div class="card-body p-4 text-center">
                    <div class="category-icon mb-3">
                        <i class="bi bi-grid-3x3-gap-fill fs-1 text-primary"></i>
                    </div>
                    <h5 class="card-title mb-3">{{ $category->name }}</h5>
                    <p class="card-text text-muted mb-3">
                        {{ $category->products_count }} products available
                    </p>
                    <a href="{{ route('home', ['category' => $category->id]) }}" class="btn btn-primary">
                        Browse Category
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="text-center py-5">
                <i class="bi bi-grid-3x3-gap-fill fs-1 text-muted mb-3"></i>
                <h3 class="text-muted">No categories available</h3>
                <p class="text-muted">Check back later for new product categories.</p>
            </div>
        </div>
        @endforelse
    </div>

    @if($categories->hasPages())
    <div class="row mt-5">
        <div class="col-12">
            <nav aria-label="Category pagination">
                <ul class="pagination justify-content-center">
                    {{ $categories->links() }}
                </ul>
            </nav>
        </div>
    </div>
    @endif

    <!-- Category Statistics -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-sm border-0 bg-light">
                <div class="card-body p-4">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="stat-item">
                                <h3 class="h2 text-primary mb-1">{{ $categories->total() }}</h3>
                                <p class="text-muted mb-0">Total Categories</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <h3 class="h2 text-success mb-1">{{ $categories->sum('products_count') }}</h3>
                                <p class="text-muted mb-0">Total Products</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <h3 class="h2 text-info mb-1">{{ $categories->where('products_count', '>', 0)->count() }}</h3>
                                <p class="text-muted mb-0">Active Categories</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <h3 class="h2 text-warning mb-1">{{ round($categories->avg('products_count'), 1) }}</h3>
                                <p class="text-muted mb-0">Avg Products/Category</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.category-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.category-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: white;
}

.stat-item {
    padding: 20px 0;
}
</style>
@endsection
