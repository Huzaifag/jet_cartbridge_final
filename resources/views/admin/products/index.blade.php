@extends('admin.layouts.app')

@section('page-title', 'Products Management')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">Products Management</h2>
                    <p class="text-muted">Manage your {{ ucfirst($owner['role']) }} products</p>
                </div>
                <div>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Add New Product
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.products.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Search</label>
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Search products..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        Products List 
                        <span class="badge bg-primary">{{ $products->total() }} Total</span>
                    </h5>
                </div>
                <div class="card-body">
                    @if($products->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>B2C Price</th>
                                        <th>B2B Price</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>
                                                @if($product->images && count($product->images) > 0)
                                                    <img src="{{ asset($product->images[0]) }}" 
                                                         alt="{{ $product->name }}" 
                                                         class="rounded" 
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                         style="width: 50px; height: 50px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div>
                                                    <h6 class="mb-1">{{ $product->name }}</h6>
                                                    <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                @if($product->category)
                                                    <span class="badge bg-info">{{ $product->category }}</span>
                                                @else
                                                    <span class="text-muted">No Category</span>
                                                @endif
                                            </td>
                                            <td>${{ number_format($product->b2c_price, 2) }}</td>
                                            <td>
                                                ${{ number_format($product->b2b_price, 2) }}
                                                <small class="text-muted d-block">MOQ: {{ $product->b2b_moq }}</small>
                                            </td>
                                            <td>
                                                <span class="badge {{ $product->stock_quantity > 10 ? 'bg-success' : ($product->stock_quantity > 0 ? 'bg-warning' : 'bg-danger') }}">
                                                    {{ $product->stock_quantity }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($product->status == 'active')
                                                    <span class="badge bg-success">Active</span>
                                                @elseif($product->status == 'inactive')
                                                    <span class="badge bg-secondary">Inactive</span>
                                                @else
                                                    <span class="badge bg-danger">Out of Stock</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.products.show', $product->id) }}" 
                                                       class="btn btn-sm btn-outline-info" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.products.edit', $product->id) }}" 
                                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.products.destroy', $product->id) }}" 
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                                title="Delete" 
                                                                onclick="return confirm('Are you sure you want to delete this product?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results
                            </div>
                            <div>
                                {{ $products->appends(request()->query())->links('pagination.custom-bootstrap-5') }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-box fa-3x text-muted mb-3"></i>
                            <h5>No Products Found</h5>
                            <p class="text-muted">You haven't added any products yet.</p>
                            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Add Your First Product
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection