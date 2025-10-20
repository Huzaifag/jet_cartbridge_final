@extends('seller.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Page Header -->
                <div class="page-header mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="h3 mb-1">Add New Product</h1>
                            <p class="text-muted mb-0">Create a new product listing for your store</p>
                        </div>
                        <a href="{{ route('seller.products.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Products
                        </a>
                    </div>
                </div>

                <!-- Progress Indicator -->
                <div class="card mb-4">
                    <div class="card-body py-3">
                        <div class="progress-indicator">
                            <div class="step active" data-step="1">
                                <div class="step-number">1</div>
                                <div class="step-label">Basic Info</div>
                            </div>
                            <div class="step" data-step="2">
                                <div class="step-number">2</div>
                                <div class="step-label">Pricing & Stock</div>
                            </div>
                            <div class="step" data-step="3">
                                <div class="step-number">3</div>
                                <div class="step-label">Description</div>
                            </div>
                            <div class="step" data-step="4">
                                <div class="step-number">4</div>
                                <div class="step-label">Specifications</div>
                            </div>
                            <div class="step" data-step="5">
                                <div class="step-number">5</div>
                                <div class="step-label">Images</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form id="productForm" method="POST" action="{{ route('seller.products.store') }}"
                            enctype="multipart/form-data">
                            @csrf

                            <!-- Step 1: Basic Information -->
                            <div class="form-step active" data-step="1">
                                <h5 class="mb-4 border-bottom pb-2"><i
                                        class="fas fa-info-circle me-2 text-primary"></i>Basic Information</h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Product Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" required
                                            placeholder="Enter product name">
                                        <div class="form-text">Enter a clear and descriptive product name</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Category <span class="text-danger">*</span></label>
                                        <select class="form-select" name="category" required>
                                            <option value="">Select Category</option>
                                            <option value="electronics">Electronics</option>
                                            <option value="clothing">Clothing</option>
                                            <option value="furniture">Furniture</option>
                                            <option value="books">Books</option>
                                            <option value="home_appliances">Home Appliances</option>
                                            <option value="sports">Sports & Outdoors</option>
                                            <option value="beauty">Beauty & Personal Care</option>
                                            <option value="toys">Toys & Games</option>
                                            <option value="food">Food & Beverages</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Brand</label>
                                        <input type="text" class="form-control" name="brand"
                                            placeholder="Enter brand name">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Model</label>
                                        <input type="text" class="form-control" name="model"
                                            placeholder="Enter model number">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">SKU (Stock Keeping Unit)</label>
                                        <input type="text" class="form-control" name="sku"
                                            placeholder="e.g., PROD-001">
                                        <div class="form-text">Unique identifier for your product</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Weight (kg)</label>
                                        <input type="number" class="form-control" name="weight" step="0.01"
                                            min="0" placeholder="0.00">
                                        <div class="form-text">Optional: Enter the product weight in kilograms (e.g., 0.50)
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <div></div>
                                <button type="button" class="btn btn-primary next-step">Next: Pricing & Stock <i
                                        class="fas fa-arrow-right ms-2"></i></button>
                            </div>
                    </div>

                    <!-- Step 2: Pricing and Stock -->
                    <div class="form-step" data-step="2">
                        <h5 class="mb-4 border-bottom pb-2"><i class="fas fa-tags me-2 text-primary"></i>Pricing &
                            Stock</h5>

                        <div class="mb-4 p-3 border rounded bg-light">
                            <h6 class="mb-3 fw-bold text-secondary">Consumer Pricing (B2C)</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Retail Price ($) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" name="b2c_price" step="0.01"
                                            min="0" required placeholder="e.g., 19.99">
                                    </div>
                                    <div class="form-text">The regular price for a single item.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Compare at Price ($)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" name="b2c_compare_price"
                                            step="0.01" min="0" placeholder="e.g., 24.99">
                                    </div>
                                    <div class="form-text">Optional price to show a discount (e.g., a strikethrough
                                        price).</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4 p-3 border rounded bg-light">
                            <h6 class="mb-3 fw-bold text-secondary">Wholesale Pricing (B2B)</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Wholesale Price per Item ($)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" name="b2b_price" step="0.01"
                                            min="0" placeholder="e.g., 12.50">
                                    </div>
                                    <div class="form-text">The discounted price for bulk/business orders.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Minimum Order Quantity (MOQ)</label>
                                    <input type="number" class="form-control" name="b2b_moq" min="1"
                                        placeholder="e.g., 50">
                                    <div class="form-text">Minimum quantity required to get the wholesale price.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-3 border rounded bg-light">
                            <h6 class="mb-3 fw-bold text-secondary">Inventory Details</h6>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Cost per item ($)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control" name="cost" step="0.01"
                                            min="0" placeholder="0.00">
                                    </div>
                                    <div class="form-text">Your internal cost for profit tracking.</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="stock_quantity" min="0"
                                        required>
                                    <div class="form-text">Total available units.</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Barcode (ISBN, UPC, etc.)</label>
                                    <input type="text" class="form-control" name="barcode"
                                        placeholder="Enter barcode">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary prev-step"><i
                                    class="fas fa-arrow-left me-2"></i>Previous</button>
                            <button type="button" class="btn btn-primary next-step">Next: Description <i
                                    class="fas fa-arrow-right ms-2"></i></button>
                        </div>
                    </div>

                    <!-- Step 3: Description -->
                    <div class="form-step" data-step="3">
                        <h5 class="mb-4 border-bottom pb-2"><i class="fas fa-align-left me-2 text-primary"></i>Description
                        </h5>
                        <div class="mb-3">
                            <label class="form-label">Product Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="description" rows="6" required
                                placeholder="Describe your product in detail..."></textarea>
                            <div class="form-text">Include features, benefits, and usage information</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Key Features</label>
                            <div id="features-container">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="features[]"
                                        placeholder="Add a key feature">
                                    <button type="button" class="btn btn-outline-danger remove-feature"
                                        style="display: none;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="add-feature">
                                <i class="fas fa-plus me-1"></i>Add Feature
                            </button>
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary prev-step"><i
                                    class="fas fa-arrow-left me-2"></i>Previous</button>
                            <button type="button" class="btn btn-primary next-step">Next: Specifications <i
                                    class="fas fa-arrow-right ms-2"></i></button>
                        </div>
                    </div>

                    <!-- Step 4: Specifications -->
                    <div class="form-step" data-step="4">
                        <h5 class="mb-4 border-bottom pb-2"><i
                                class="fas fa-list-alt me-2 text-primary"></i>Specifications</h5>
                        <div id="specifications-container">
                            <div class="row g-3 mb-2 specification-row">
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="specifications[0][key]"
                                        placeholder="Specification Name (e.g., Color)">
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="specifications[0][value]"
                                        placeholder="Specification Value (e.g., Red)">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger remove-spec w-100"
                                        style="display: none;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-secondary mt-3" id="add-specification">
                            <i class="fas fa-plus me-1"></i>Add Specification
                        </button>
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary prev-step"><i
                                    class="fas fa-arrow-left me-2"></i>Previous</button>
                            <button type="button" class="btn btn-primary next-step">Next: Images <i
                                    class="fas fa-arrow-right ms-2"></i></button>
                        </div>
                    </div>

                    <!-- Step 5: Images -->
                    <div class="form-step" data-step="5">
                        <h5 class="mb-4 border-bottom pb-2"><i class="fas fa-images me-2 text-primary"></i>Product
                            Images</h5>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Upload high-quality images. First image will be used as the main product image.
                        </div>
                        <div class="row" id="image-preview-container">
                            <div class="col-md-3 mb-3">
                                <div class="image-upload-box">
                                    <input type="file" name="images[]" class="image-upload" accept="image/*"
                                        required>
                                    <div class="upload-placeholder">
                                        <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                                        <div>Click to upload</div>
                                        <div class="small text-muted">Max 5MB (JPG, PNG, WEBP)</div>
                                    </div>
                                    <img class="preview-image" style="display: none;">
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-secondary mt-2" id="add-image">
                            <i class="fas fa-plus me-1"></i>Add Another Image
                        </button>

                        <!-- Status -->
                        <div class="mt-4 pt-3 border-top">
                            <h5 class="mb-3"><i class="fas fa-toggle-on me-2 text-primary"></i>Product Status
                            </h5>
                            <select class="form-select" name="status" required>
                                <option value="active">Active (Visible to customers)</option>
                                <option value="inactive">Inactive (Hidden from customers)</option>
                                <option value="out_of_stock">Out of Stock (Visible but not purchasable)</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary prev-step"><i
                                    class="fas fa-arrow-left me-2"></i>Previous</button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check me-2"></i>Add Product
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    @push('styles')
        <style>
            .page-header {
                padding-bottom: 1rem;
                margin-bottom: 2rem;
                border-bottom: 1px solid #e9ecef;
            }

            .progress-indicator {
                display: flex;
                justify-content: space-between;
                align-items: center;
                position: relative;
            }

            .progress-indicator::before {
                content: '';
                position: absolute;
                top: 50%;
                left: 0;
                right: 0;
                height: 2px;
                background: #e9ecef;
                z-index: 1;
            }

            .step {
                display: flex;
                flex-direction: column;
                align-items: center;
                position: relative;
                z-index: 2;
            }

            .step-number {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background: #e9ecef;
                color: #6c757d;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 600;
                margin-bottom: 0.5rem;
                transition: all 0.3s ease;
            }

            .step-label {
                font-size: 0.875rem;
                color: #6c757d;
                transition: all 0.3s ease;
            }

            .step.active .step-number {
                background: #4361ee;
                color: white;
                box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.2);
            }

            .step.active .step-label {
                color: #4361ee;
                font-weight: 500;
            }

            .form-step {
                display: none;
            }

            .form-step.active {
                display: block;
                animation: fadeIn 0.3s ease;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .image-upload-box {
                border: 2px dashed #dee2e6;
                border-radius: 8px;
                padding: 20px;
                text-align: center;
                cursor: pointer;
                position: relative;
                height: 180px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: #f8f9fa;
                transition: all 0.3s ease;
            }

            .image-upload-box:hover {
                border-color: #4361ee;
                background: #f1f3ff;
            }

            .image-upload {
                position: absolute;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
                opacity: 0;
                cursor: pointer;
            }

            .preview-image {
                max-width: 100%;
                max-height: 100%;
                object-fit: contain;
                border-radius: 4px;
            }

            .upload-placeholder {
                color: #6c757d;
            }

            .remove-image {
                position: absolute;
                top: 5px;
                right: 5px;
                background: rgba(255, 255, 255, 0.9);
                border: none;
                border-radius: 50%;
                width: 25px;
                height: 25px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                color: #dc3545;
                z-index: 1;
                font-size: 16px;
            }

            .remove-image:hover {
                background: #fff;
                color: #bb2d3b;
            }

            .btn-next,
            .btn-prev {
                min-width: 120px;
            }

            .specification-row,
            .feature-input-group {
                transition: all 0.3s ease;
            }

            .border-bottom {
                border-color: #e9ecef !important;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Multi-step form functionality
                let currentStep = 1;
                const totalSteps = 5;

                function showStep(step) {
                    $('.form-step').removeClass('active');
                    $(`.form-step[data-step="${step}"]`).addClass('active');

                    $('.step').removeClass('active');
                    $(`.step[data-step="${step}"]`).addClass('active');

                    currentStep = step;
                }

                $('.next-step').click(function() {
                    if (currentStep < totalSteps) {
                        // Validate current step before proceeding
                        if (validateStep(currentStep)) {
                            showStep(currentStep + 1);
                            window.scrollTo(0, 0);
                        }
                    }
                });

                $('.prev-step').click(function() {
                    if (currentStep > 1) {
                        showStep(currentStep - 1);
                        window.scrollTo(0, 0);
                    }
                });

                function validateStep(step) {
                    let isValid = true;

                    // Basic validation for each step
                    if (step === 1) {
                        const name = $('input[name="name"]').val();
                        const category = $('select[name="category"]').val();

                        if (!name) {
                            showFieldError('input[name="name"]', 'Product name is required');
                            isValid = false;
                        }

                        if (!category) {
                            showFieldError('select[name="category"]', 'Category is required');
                            isValid = false;
                        }
                    } else if (step === 2) {
                        const price = $('input[name="b2c_price"]').val();
                        const b2bPrice = $('input[name="b2b_price"]').val();
                        const stock = $('input[name="stock_quantity"]').val();

                        if (!price || price <= 0) {
                            showFieldError('input[name="b2c_price"]', 'Valid price is required');
                            isValid = false;
                        }

                        if (b2bPrice && b2bPrice <= 0) {
                            showFieldError('input[name="b2b_price"]', 'Wholesale price must be greater than 0');
                            isValid = false;
                        }

                        if (!stock || stock < 0) {
                            showFieldError('input[name="stock_quantity"]', 'Valid stock quantity is required');
                            isValid = false;
                        }
                    } else if (step === 3) {
                        const description = $('textarea[name="description"]').val();

                        if (!description) {
                            showFieldError('textarea[name="description"]', 'Description is required');
                            isValid = false;
                        }
                    } else if (step === 5) {
                        const images = $('input[name="images[]"]');
                        let hasImage = false;

                        images.each(function() {
                            if (this.files && this.files[0]) {
                                hasImage = true;
                                return false; // Break the loop
                            }
                        });

                        if (!hasImage) {
                            alert('Please upload at least one product image');
                            isValid = false;
                        }
                    }

                    return isValid;
                }

                function showFieldError(selector, message) {
                    const field = $(selector);
                    field.addClass('is-invalid');

                    // Remove existing error message
                    field.next('.invalid-feedback').remove();

                    // Add error message
                    field.after(`<div class="invalid-feedback">${message}</div>`);

                    // Scroll to the field with error
                    $('html, body').animate({
                        scrollTop: field.offset().top - 100
                    }, 500);
                }

                // Handle specification rows
                let specCount = 1;

                $('#add-specification').click(function() {
                    const newRow = `
                    <div class="row g-3 mb-2 specification-row">
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="specifications[${specCount}][key]" placeholder="Specification Name">
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" name="specifications[${specCount}][value]" placeholder="Specification Value">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger remove-spec w-100">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
                    $('#specifications-container').append(newRow);
                    specCount++;

                    // Show remove buttons if there's more than one row
                    if ($('.specification-row').length > 1) {
                        $('.remove-spec').show();
                    }
                });

                $(document).on('click', '.remove-spec', function() {
                    $(this).closest('.specification-row').remove();
                    // Hide remove button for first row if it's the only one left
                    if ($('.specification-row').length === 1) {
                        $('.remove-spec').hide();
                    }
                });

                // Handle feature inputs
                let featureCount = 1;

                $('#add-feature').click(function() {
                    const newFeature = `
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" name="features[]" placeholder="Add a key feature">
                        <button type="button" class="btn btn-outline-danger remove-feature">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
                    $('#features-container').append(newFeature);
                    featureCount++;

                    // Show remove buttons if there's more than one feature
                    if ($('.remove-feature').length > 1) {
                        $('.remove-feature').show();
                    }
                });

                $(document).on('click', '.remove-feature', function() {
                    $(this).closest('.input-group').remove();
                    // Hide remove button if it's the only one left
                    if ($('.remove-feature').length === 1) {
                        $('.remove-feature').hide();
                    }
                });

                // Handle image uploads
                function createImagePreview(file, imageBox) {
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const preview = imageBox.find('.preview-image');
                            const placeholder = imageBox.find('.upload-placeholder');
                            preview.attr('src', e.target.result);
                            preview.show();
                            placeholder.hide();

                            // Add remove button if not already there
                            if (!imageBox.find('.remove-image').length) {
                                imageBox.append(
                                    '<button type="button" class="remove-image" title="Remove Image">&times;</button>'
                                );
                            }
                        }
                        reader.readAsDataURL(file);
                    }
                }

                $(document).on('change', '.image-upload', function(e) {
                    if (e.target.files && e.target.files[0]) {
                        createImagePreview(e.target.files[0], $(this).closest('.image-upload-box'));
                    }
                });

                $('#add-image').click(function() {
                    const newImageBox = `
                    <div class="col-md-3 mb-3">
                        <div class="image-upload-box">
                            <input type="file" name="images[]" class="image-upload" accept="image/*">
                            <div class="upload-placeholder">
                                <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                                <div>Click to upload</div>
                                <div class="small text-muted">Max 5MB (JPG, PNG, WEBP)</div>
                            </div>
                            <img class="preview-image" style="display: none;">
                        </div>
                    </div>
                `;
                    $('#image-preview-container').append(newImageBox);
                });

                $(document).on('click', '.remove-image', function() {
                    $(this).closest('.col-md-3').remove();
                });

                // Form submission
                $('#productForm').on('submit', function(e) {
                    e.preventDefault();

                    // Clear previous errors
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').remove();

                    // Validate all steps
                    for (let i = 1; i <= totalSteps; i++) {
                        if (!validateStep(i)) {
                            showStep(i);
                            return false;
                        }
                    }

                    const formData = new FormData(this);

                    // Show loading state
                    const submitBtn = $(this).find('button[type="submit"]');
                    const originalText = submitBtn.html();
                    submitBtn.html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding Product...'
                    );
                    submitBtn.prop('disabled', true);

                    $.ajax({
                        url: $(this).attr('action'),
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (response.success) {
                                // Show success message
                                const alert = $(
                                    '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                                    '<i class="fas fa-check-circle me-2"></i>' +
                                    response.message +
                                    '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                                    '</div>');
                                $('#productForm').before(alert);

                                // Redirect after a short delay
                                setTimeout(() => {
                                    window.location.href = response.redirect ||
                                        '{{ route('seller.products.index') }}';
                                }, 1500);
                            }
                        },
                        error: function(xhr) {
                            // Reset button state
                            submitBtn.html(originalText);
                            submitBtn.prop('disabled', false);

                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON.errors;

                                // Display validation errors
                                Object.keys(errors).forEach(key => {
                                    const input = $(`[name="${key}"]`);
                                    if (input.length) {
                                        input.addClass('is-invalid');
                                        input.after(
                                            `<div class="invalid-feedback">${errors[key][0]}</div>`
                                        );
                                    } else {
                                        // For array inputs like images[]
                                        const arrayInput = $(`[name="${key}[]"]`);
                                        if (arrayInput.length) {
                                            arrayInput.addClass('is-invalid');
                                            arrayInput.after(
                                                `<div class="invalid-feedback">${errors[key][0]}</div>`
                                            );
                                        }
                                    }
                                });

                                // Show error alert
                                const alert = $(
                                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                                    '<i class="fas fa-exclamation-circle me-2"></i>' +
                                    'Please correct the errors below.' +
                                    '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                                    '</div>');
                                $('#productForm').before(alert);

                                // Scroll to the first error
                                const firstError = $('.is-invalid').first();
                                if (firstError.length) {
                                    $('html, body').animate({
                                        scrollTop: firstError.offset().top - 100
                                    }, 500);
                                }
                            } else {
                                // Show general error message
                                const alert = $(
                                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                                    '<i class="fas fa-exclamation-circle me-2"></i>' +
                                    'An error occurred while adding the product. Please try again.' +
                                    '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                                    '</div>');
                                $('#productForm').before(alert);
                            }
                        }
                    });
                });
                showStep(1);
            });
        </script>
    @endpush
@endsection
