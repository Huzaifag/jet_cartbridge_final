@extends('frontend.layout.main')

@section('content')
<!-- Premium Hero Section -->
<section class="premium-hero">
    <div class="premium-container">
        <div class="premium-hero-content">
            <h1 class="premium-hero-title">Product <span class="accent-text">Categories</span></h1>
            <p class="premium-hero-subtitle">Explore our comprehensive range of product categories</p>
        </div>
    </div>
</section>

<!-- Premium Categories Grid -->
<section class="premium-section">
    <div class="premium-container">
        <div class="premium-grid premium-grid-3">
            @forelse($categories as $category)
            <div class="premium-card premium-fade-in text-center">
                <div class="premium-category-icon mb-3">
                    <i class="fas fa-th-large"></i>
                </div>
                <h3 class="premium-card-title mb-3">{{ $category->name }}</h3>
                <p class="premium-card-text mb-3">
                    <i class="fas fa-box me-1"></i>{{ $category->products_count }} products available
                </p>
                <a href="{{ route('home', ['category' => $category->id]) }}" class="btn-premium btn-premium-primary">
                    <i class="fas fa-arrow-right me-1"></i>Browse Category
                </a>
            </div>
            @empty
            <div class="col-12">
                <div class="premium-card text-center">
                    <i class="fas fa-th-large premium-card-icon mb-3"></i>
                    <h3 class="premium-card-title">No categories available</h3>
                    <p class="premium-card-text">Check back later for new product categories.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

@if($categories->hasPages())
<!-- Premium Pagination -->
<section class="premium-section py-4">
    <div class="premium-container">
        <div class="d-flex justify-content-center">
            {{ $categories->links() }}
        </div>
    </div>
</section>
@endif

<!-- Premium Statistics Section -->
<section class="premium-section">
    <div class="premium-container">
        <div class="premium-header">
            <h2 class="premium-title">Category <span class="accent-text">Statistics</span></h2>
            <p class="premium-subtitle">Overview of our marketplace categories</p>
        </div>
        
        <div class="premium-grid premium-grid-4">
            <div class="premium-card premium-scale-in text-center">
                <div class="text-accent mb-2" style="font-size: 2.5rem; font-weight: 800;">{{ $categories->total() }}</div>
                <h3 class="premium-card-title">Total Categories</h3>
            </div>
            <div class="premium-card premium-scale-in text-center">
                <div class="text-accent mb-2" style="font-size: 2.5rem; font-weight: 800;">{{ $categories->sum('products_count') }}</div>
                <h3 class="premium-card-title">Total Products</h3>
            </div>
            <div class="premium-card premium-scale-in text-center">
                <div class="text-accent mb-2" style="font-size: 2.5rem; font-weight: 800;">{{ $categories->where('products_count', '>', 0)->count() }}</div>
                <h3 class="premium-card-title">Active Categories</h3>
            </div>
            <div class="premium-card premium-scale-in text-center">
                <div class="text-accent mb-2" style="font-size: 2.5rem; font-weight: 800;">{{ round($categories->avg('products_count'), 1) }}</div>
                <h3 class="premium-card-title">Avg Products/Category</h3>
            </div>
        </div>
    </div>
</section>
@endsection
