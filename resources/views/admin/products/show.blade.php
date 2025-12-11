@extends('admin.layouts.app')

@section('page-title', 'Product Details')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">{{ $product->name }}</h2>
                    <p class="text-muted">Product details for your {{ ucfirst($owner['role']) }} account</p>
                </div>
                <div>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-arrow-left me-2"></i>Back to Products
                    </a>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Edit Product
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Details -->
    <div class="row">
        <!-- Left Column - Images -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Product Images</h5>
                </div>
                <div class="card-body">
                    @if($product->images && count($product->images) > 0)
                        <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($product->images as $index => $image)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <img src="{{ asset($image) }}" class="d-block w-100 rounded" style="height: 400px; object-fit: cover;">
                                    </div>
                                @endforeach
                            </div>
                            @if(count($product->images) > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            @endif
                        </div>
                        
                        <!-- Thumbnail Navigation -->
                        @if(count($product->images) > 1)
                            <div class="row g-2 mt-3">
                                @foreach($product->images as $index => $image)
                                    <div class="col-3">
                                        <img src="{{ asset($image) }}" 
                                             class="img-fluid rounded cursor-pointer thumbnail-nav {{ $index == 0 ? 'border border-primary' : '' }}" 
                                             style="height: 60px; object-fit: cover; width: 100%;"
                                             data-bs-target="#productCarousel" 
                                             data-bs-slide-to="{{ $index }}">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-image fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No images available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column - Details -->
        <div class="col-lg-6">
            <!-- Basic Information -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Product Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Product Name</label>
                            <p class="mb-0">{{ $product->name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Category</label>
                            <p class="mb-0">
                                @if($product->category)
                                    <span class="badge bg-info">{{ $product->category->name }}</span>
                                @else
                                    <span class="text-muted">No Category</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Brand</label>
                            <p class="mb-0">{{ $product->brand ?: 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Model</label>
                            <p class="mb-0">{{ $product->model ?: 'N/A' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <p class="mb-0">
                                @if($product->status == 'active')
                                    <span class="badge bg-success">Active</span>
                                @elseif($product->status == 'inactive')
                                    <span class="badge bg-secondary">Inactive</span>
                                @else
                                    <span class="badge bg-danger">Out of Stock</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Owner Type</label>
                            <p class="mb-0">
                                <span class="badge bg-primary">{{ $product->owner_type_name }}</span>
                            </p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <p class="mb-0">{{ $product->description }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing Information -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Pricing & Inventory</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">B2C Price</label>
                            <p class="mb-0 h5 text-success">${{ number_format($product->b2c_price, 2) }}</p>
                            @if($product->b2c_compare_price)
                                <small class="text-muted text-decoration-line-through">
                                    Compare: ${{ number_format($product->b2c_compare_price, 2) }}
                                </small>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">B2B Price</label>
                            <p class="mb-0 h5 text-info">${{ number_format($product->b2b_price, 2) }}</p>
                            <small class="text-muted">MOQ: {{ $product->b2b_moq }} units</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Stock Quantity</label>
                            <p class="mb-0">
                                <span class="badge {{ $product->stock_quantity > 10 ? 'bg-success' : ($product->stock_quantity > 0 ? 'bg-warning' : 'bg-danger') }} fs-6">
                                    {{ $product->stock_quantity }} units
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Verification Status</label>
                            <p class="mb-0">
                                @if($product->verification_status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($product->verification_status == 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Specifications -->
            @if($product->specifications && count($product->specifications) > 0)
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Specifications</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                @foreach($product->specifications as $spec)
                                    @if(isset($spec['key']) && isset($spec['value']))
                                        <tr>
                                            <td class="fw-bold" style="width: 40%;">{{ $spec['key'] }}</td>
                                            <td>{{ $spec['value'] }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Thumbnail navigation
    document.querySelectorAll('.thumbnail-nav').forEach(thumb => {
        thumb.addEventListener('click', function() {
            // Remove active border from all thumbnails
            document.querySelectorAll('.thumbnail-nav').forEach(t => {
                t.classList.remove('border', 'border-primary');
            });
            // Add active border to clicked thumbnail
            this.classList.add('border', 'border-primary');
        });
    });
});
</script>
@endpush
@endsection