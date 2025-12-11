@extends('admin.layouts.app')

@section('page-title', 'Edit Product')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">Edit Product</h2>
                    <p class="text-muted">Update product information for your {{ ucfirst($owner['role']) }} account</p>
                </div>
                <div>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Products
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Form -->
    <div class="row">
        <div class="col-12">
            <form id="productForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Product Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="name" class="form-label">Product Name *</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="category_id" class="form-label">Category *</label>
                                        <select class="form-select" id="category_id" name="category_id" required>
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="brand" class="form-label">Brand</label>
                                        <input type="text" class="form-control" id="brand" name="brand" value="{{ $product->brand }}">
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="model" class="form-label">Model</label>
                                        <input type="text" class="form-control" id="model" name="model" value="{{ $product->model }}">
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label">Status *</label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            <option value="out_of_stock" {{ $product->status == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-12 mb-3">
                                        <label for="description" class="form-label">Description *</label>
                                        <textarea class="form-control" id="description" name="description" rows="4" required>{{ $product->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing Card -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Pricing & Inventory</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="b2c_price" class="form-label">B2C Price *</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" id="b2c_price" name="b2c_price" step="0.01" min="0" value="{{ $product->b2c_price }}" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="b2c_compare_price" class="form-label">B2C Compare Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" id="b2c_compare_price" name="b2c_compare_price" step="0.01" min="0" value="{{ $product->b2c_compare_price }}">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="b2b_price" class="form-label">B2B Price *</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" id="b2b_price" name="b2b_price" step="0.01" min="0" value="{{ $product->b2b_price }}" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="b2b_moq" class="form-label">B2B MOQ *</label>
                                        <input type="number" class="form-control" id="b2b_moq" name="b2b_moq" min="1" value="{{ $product->b2b_moq }}" required>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="stock_quantity" class="form-label">Stock Quantity *</label>
                                        <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" min="0" value="{{ $product->stock_quantity }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-lg-4">
                        <!-- Images Card -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Product Images</h5>
                            </div>
                            <div class="card-body">
                                <!-- Existing Images -->
                                @if($product->images && count($product->images) > 0)
                                    <div class="mb-3">
                                        <label class="form-label">Current Images</label>
                                        <div class="row g-2" id="existingImages">
                                            @foreach($product->images as $index => $image)
                                                <div class="col-6 existing-image" data-image="{{ $image }}">
                                                    <div class="position-relative">
                                                        <img src="{{ asset($image) }}" class="img-fluid rounded" style="height: 80px; object-fit: cover; width: 100%;">
                                                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-existing-image" style="padding: 2px 6px;">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                        <input type="hidden" name="existing_images[]" value="{{ $image }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="mb-3">
                                    <label for="images" class="form-label">Add New Images</label>
                                    <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
                                    <small class="text-muted">Upload additional images (JPEG, PNG, JPG). Max 2MB each.</small>
                                </div>
                                <div id="imagePreview" class="row g-2"></div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="card mt-4">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-save me-2"></i>Update Product
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Remove existing image
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-existing-image')) {
            e.target.closest('.existing-image').remove();
        }
    });

    // Image preview for new images
    document.getElementById('images').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        
        Array.from(e.target.files).forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'col-6';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="img-fluid rounded" style="height: 80px; object-fit: cover;">
                    `;
                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            }
        });
    });

    // Form submission
    document.getElementById('productForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
        
        fetch('{{ route("admin.products.update", $product->id) }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                alert(data.message || 'An error occurred');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the product');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
});
</script>
@endpush
@endsection