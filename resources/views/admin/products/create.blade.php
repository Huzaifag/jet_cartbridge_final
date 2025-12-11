@extends('admin.layouts.app')

@section('page-title', 'Add New Product')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">Add New Product</h2>
                    <p class="text-muted">Create a new product for your {{ ucfirst($owner['role']) }} account</p>
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
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="category_id" class="form-label">Category *</label>
                                        <select class="form-select" id="category_id" name="category_id" required>
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="brand" class="form-label">Brand</label>
                                        <input type="text" class="form-control" id="brand" name="brand">
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="model" class="form-label">Model</label>
                                        <input type="text" class="form-control" id="model" name="model">
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label">Status *</label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                            <option value="out_of_stock">Out of Stock</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-12 mb-3">
                                        <label for="description" class="form-label">Description *</label>
                                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
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
                                            <input type="number" class="form-control" id="b2c_price" name="b2c_price" step="0.01" min="0" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="b2c_compare_price" class="form-label">B2C Compare Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" id="b2c_compare_price" name="b2c_compare_price" step="0.01" min="0">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="b2b_price" class="form-label">B2B Price *</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" id="b2b_price" name="b2b_price" step="0.01" min="0" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="b2b_moq" class="form-label">B2B MOQ *</label>
                                        <input type="number" class="form-control" id="b2b_moq" name="b2b_moq" min="1" required>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="stock_quantity" class="form-label">Stock Quantity *</label>
                                        <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" min="0" required>
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
                                <h5 class="card-title mb-0">Product Images *</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*" required>
                                    <small class="text-muted">Upload multiple images (JPEG, PNG, JPG). Max 2MB each.</small>
                                </div>
                                <div id="imagePreview" class="row g-2"></div>
                            </div>
                        </div>

                        <!-- Specifications Card -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Specifications</h5>
                            </div>
                            <div class="card-body">
                                <div id="specifications">
                                    <div class="spec-item mb-2">
                                        <div class="row g-2">
                                            <div class="col-5">
                                                <input type="text" class="form-control form-control-sm" name="specifications[0][key]" placeholder="Key">
                                            </div>
                                            <div class="col-5">
                                                <input type="text" class="form-control form-control-sm" name="specifications[0][value]" placeholder="Value">
                                            </div>
                                            <div class="col-2">
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-spec">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="addSpec">
                                    <i class="fas fa-plus me-1"></i>Add Specification
                                </button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="card mt-4">
                            <div class="card-body">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-save me-2"></i>Create Product
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
    let specCount = 1;

    // Add specification
    document.getElementById('addSpec').addEventListener('click', function() {
        const specificationsDiv = document.getElementById('specifications');
        const newSpec = document.createElement('div');
        newSpec.className = 'spec-item mb-2';
        newSpec.innerHTML = `
            <div class="row g-2">
                <div class="col-5">
                    <input type="text" class="form-control form-control-sm" name="specifications[${specCount}][key]" placeholder="Key">
                </div>
                <div class="col-5">
                    <input type="text" class="form-control form-control-sm" name="specifications[${specCount}][value]" placeholder="Value">
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-spec">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;
        specificationsDiv.appendChild(newSpec);
        specCount++;
    });

    // Remove specification
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-spec')) {
            e.target.closest('.spec-item').remove();
        }
    });

    // Image preview
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
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating...';
        
        fetch('{{ route("admin.products.store") }}', {
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
            alert('An error occurred while creating the product');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
});
</script>
@endpush
@endsection