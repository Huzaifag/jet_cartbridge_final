@extends('seller.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Page Header -->
                <div class="page-header mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h3 mb-1">{{ $category->name }}</h1>
                            <p class="text-muted mb-0">Category details and information</p>
                        </div>
                        <div>
                            <a href="{{ route('seller.categories.edit', $category) }}" class="btn btn-warning me-2">
                                <i class="fas fa-edit me-2"></i>Edit Category
                            </a>
                            <a href="{{ route('seller.categories.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Categories
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Category Details -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Category Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Name</label>
                                        <p class="mb-0">{{ $category->name }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Slug</label>
                                        <p class="mb-0">{{ $category->slug }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Status</label>
                                        <p class="mb-0">
                                            @if($category->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Created</label>
                                        <p class="mb-0">{{ $category->created_at->format('M d, Y \a\t h:i A') }}</p>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-bold">Description</label>
                                        <p class="mb-0">{{ $category->description ?: 'No description provided.' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Products in this Category -->
                        <div class="card mt-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Products in this Category</h5>
                                <span class="badge bg-primary">{{ $category->products->count() }} products</span>
                            </div>
                            <div class="card-body">
                                @if($category->products->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Price</th>
                                                    <th>Stock</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($category->products as $product)
                                                    <tr>
                                                        <td>
                                                            <strong>{{ $product->name }}</strong>
                                                        </td>
                                                        <td>${{ number_format($product->b2c_price, 2) }}</td>
                                                        <td>{{ $product->stock_quantity }}</td>
                                                        <td>
                                                            @if($product->status === 'active')
                                                                <span class="badge bg-success">Active</span>
                                                            @elseif($product->status === 'inactive')
                                                                <span class="badge bg-secondary">Inactive</span>
                                                            @else
                                                                <span class="badge bg-warning">Out of Stock</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('seller.products.show', $product) }}" class="btn btn-sm btn-outline-info">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-box-open fa-2x text-muted mb-2"></i>
                                        <p class="text-muted">No products in this category yet.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Category Image -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Category Image</h5>
                            </div>
                            <div class="card-body text-center">
                                @if($category->image)
                                    <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="img-fluid rounded">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <div>
                                            <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                            <p class="text-muted">No image uploaded</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
