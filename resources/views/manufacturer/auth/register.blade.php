<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manufacturer Registration - JetCartridge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .registration-container {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .registration-header {
            background: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .registration-body {
            padding: 30px;
        }
        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            position: relative;
        }
        .step-indicator::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            background: #dee2e6;
            z-index: 1;
        }
        .step {
            background: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            border: 2px solid #dee2e6;
            position: relative;
            z-index: 2;
        }
        .step.active {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }
        .step.completed {
            background: #28a745;
            color: white;
            border-color: #28a745;
        }
        .form-step {
            display: none;
        }
        .form-step.active {
            display: block;
        }
        .btn-next, .btn-prev {
            min-width: 120px;
        }
        .form-control {
            border-radius: 8px;
            padding: 12px;
        }
        .document-upload {
            border: 2px dashed #dee2e6;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .document-upload i {
            font-size: 24px;
            color: #6c757d;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="registration-container">
            <div class="registration-header">
                <h4 class="mb-0">Manufacturer Registration</h4>
                <p class="mb-0">Join JetCartridge as a Manufacturer</p>
            </div>
            <div class="registration-body">
                <div class="step-indicator">
                    <div class="step active" id="step1-indicator">1</div>
                    <div class="step" id="step2-indicator">2</div>
                    <div class="step" id="step3-indicator">3</div>
                </div>

                <!-- Step 1: Company Details -->
                <form id="step1-form" class="form-step active">
                    <h5 class="mb-4">Company Details</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="company_name" name="company_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="company_registration_number" class="form-label">Registration Number</label>
                            <input type="text" class="form-control" id="company_registration_number" name="company_registration_number" required>
                        </div>
                        <div class="col-12">
                            <label for="company_address" class="form-label">Address</label>
                            <textarea class="form-control" id="company_address" name="company_address" rows="3" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="company_city" class="form-label">City</label>
                            <input type="text" class="form-control" id="company_city" name="company_city" required>
                        </div>
                        <div class="col-md-6">
                            <label for="company_state" class="form-label">State</label>
                            <input type="text" class="form-control" id="company_state" name="company_state" required>
                        </div>
                        <div class="col-md-6">
                            <label for="company_country" class="form-label">Country</label>
                            <input type="text" class="form-control" id="company_country" name="company_country" required>
                        </div>
                        <div class="col-md-6">
                            <label for="company_postal_code" class="form-label">Postal Code</label>
                            <input type="text" class="form-control" id="company_postal_code" name="company_postal_code" required>
                        </div>
                        <div class="col-md-6">
                            <label for="company_phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="company_phone" name="company_phone" required>
                        </div>
                        <div class="col-md-6">
                            <label for="company_website" class="form-label">Website (Optional)</label>
                            <input type="url" class="form-control" id="company_website" name="company_website">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary btn-next">Next Step</button>
                    </div>
                </form>

                <!-- Step 2:  -->
                <form id="step2-form" class="form-step">
                    <h5 class="mb-4">Additional Details</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="contact_person_name" class="form-label">Contact Person Name</label>
                            <input type="text" class="form-control" id="contact_person_name" name="contact_person_name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="contact_person_position" class="form-label">Position</label>
                            <input type="text" class="form-control" id="contact_person_position" name="contact_person_position" required>
                        </div>
                        <div class="col-md-6">
                            <label for="contact_person_email" class="form-label">Contact Email</label>
                            <input type="email" class="form-control" id="contact_person_email" name="contact_person_email" required>
                        </div>
                        <div class="col-md-6">
                            <label for="contact_person_phone" class="form-label">Contact Phone</label>
                            <input type="tel" class="form-control" id="contact_person_phone" name="contact_person_phone" required>
                        </div>
                        <div class="col-md-6">
                            <label for="business_type" class="form-label">Business Type</label>
                            <select class="form-control" id="business_type" name="business_type" required>
                                <option value="">Select Business Type</option>
                                <option value="manufacturer">Manufacturer</option>
                                <option value="wholesaler">Wholesaler</option>
                                <option value="retailer">Retailer</option>
                                <option value="trader">Trader</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="years_in_business" class="form-label">Years in Business</label>
                            <input type="number" class="form-control" id="years_in_business" name="years_in_business" required min="0">
                        </div>
                        <div class="col-12">
                            <label for="main_products" class="form-label">Main Products</label>
                            <input type="text" class="form-control" id="main_products" name="main_products" required placeholder="Enter products separated by commas">
                        </div>
                        <div class="col-md-6">
                            <label for="number_of_employees" class="form-label">Number of Employees</label>
                            <select class="form-control" id="number_of_employees" name="number_of_employees" required>
                                <option value="">Select Range</option>
                                <option value="1-10">1-10</option>
                                <option value="11-50">11-50</option>
                                <option value="51-200">51-200</option>
                                <option value="201-500">201-500</option>
                                <option value="500+">500+</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="annual_revenue" class="form-label">Annual Revenue</label>
                            <select class="form-control" id="annual_revenue" name="annual_revenue" required>
                                <option value="">Select Range</option>
                                <option value="Below $100K">Below $100K</option>
                                <option value="$100K-$500K">$100K-$500K</option>
                                <option value="$500K-$1M">$500K-$1M</option>
                                <option value="$1M-$5M">$1M-$5M</option>
                                <option value="Above $5M">Above $5M</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Login Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        {{-- <button type="button" class="btn btn-secondary btn-prev">Previous</button> --}}
                        <button type="submit" class="btn btn-primary btn-next">Next Step</button>
                    </div>
                </form>

                <!-- Step 3: Document Upload -->
                <form id="step3-form" class="form-step">
                    <h5 class="mb-4">Document Upload</h5>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="document-upload">
                                <i class="fas fa-file-alt"></i>
                                <h6>Business License</h6>
                                <p class="text-muted small mb-2">Upload your business license (PDF, JPG, PNG)</p>
                                <input type="file" class="form-control" id="business_license" name="business_license" accept=".pdf,.jpg,.jpeg,.png" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="document-upload">
                                <i class="fas fa-file-invoice"></i>
                                <h6>Tax Certificate</h6>
                                <p class="text-muted small mb-2">Upload your tax certificate (PDF, JPG, PNG)</p>
                                <input type="file" class="form-control" id="tax_certificate" name="tax_certificate" accept=".pdf,.jpg,.jpeg,.png" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="document-upload">
                                <i class="fas fa-id-card"></i>
                                <h6>ID Proof</h6>
                                <p class="text-muted small mb-2">Upload your ID proof (PDF, JPG, PNG)</p>
                                <input type="file" class="form-control" id="id_proof" name="id_proof" accept=".pdf,.jpg,.jpeg,.png" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="document-upload">
                                <i class="fas fa-building"></i>
                                <h6>Company Profile (Optional)</h6>
                                <p class="text-muted small mb-2">Upload your company profile (PDF only)</p>
                                <input type="file" class="form-control" id="company_profile" name="company_profile" accept=".pdf">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-secondary btn-prev">Previous</button>
                        <button type="submit" class="btn btn-success">Complete Registration</button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <p class="text-muted">Already have an account? <a href="{{ route('manufacturer.login') }}" class="text-decoration-none">Sign in here</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Add CSRF token to all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            // Form step handling
            let currentStep = 1;

            function showStep(step) {
                $('.form-step').removeClass('active');
                $(`#step${step}-form`).addClass('active');

                // Update indicators
                $('.step').removeClass('active completed');
                $(`#step${step}-indicator`).addClass('active');
                for(let i = 1; i < step; i++) {
                    $(`#step${i}-indicator`).addClass('completed');
                }
            }

            // Step 1 submission
            $('#step1-form').on('submit', function(e) {
                e.preventDefault();

                // Clear previous errors
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                const formData = new FormData(this);

                // Convert FormData to plain object for debugging
                const formDataObj = {};
                formData.forEach((value, key) => {
                    formDataObj[key] = value;
                });
                console.log('Step 1 Form Data:', formDataObj);

                $.ajax({
                    url: '{{ route("manufacturer.register.step1") }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log('Step 1 Success:', response);
                        if(response.success) {
                            currentStep = 2;
                            showStep(currentStep);
                        }
                    },
                    error: function(xhr) {
                        console.log('Step 1 Error:', xhr.responseJSON);
                        if(xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            Object.keys(errors).forEach(field => {
                                const input = $(`[name="${field}"]`);
                                input.addClass('is-invalid');
                                const feedback = input.next('.invalid-feedback');
                                if (feedback.length === 0) {
                                    input.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
                                } else {
                                    feedback.text(errors[field][0]);
                                }
                            });
                        } else {
                            alert('An error occurred. Please try again.');
                        }
                    }
                });
            });

            // Step 2 submission
            $('#step2-form').on('submit', function(e) {
                e.preventDefault();

                // Clear previous errors
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                // Convert comma-separated products to array
                const mainProducts = $('#main_products').val() ? $('#main_products').val().split(',').map(item => item.trim()) : [];

                // Create FormData object
                let formData = new FormData(this);

                // Remove existing main_products and add the JSON string
                formData.delete('main_products');
                formData.append('main_products', JSON.stringify(mainProducts));

                // Convert FormData to plain object for debugging
                const formDataObj = {};
                formData.forEach((value, key) => {
                    formDataObj[key] = value;
                });
                console.log('Step 2 Form Data:', formDataObj);

                // Validate password confirmation
                const password = $('#password').val();
                const passwordConfirmation = $('#password_confirmation').val();

                if (password !== passwordConfirmation) {
                    $('#password, #password_confirmation').addClass('is-invalid');
                    $('#password_confirmation').after('<div class="invalid-feedback">The password confirmation does not match.</div>');
                    return;
                }

                $.ajax({
                    url: '{{ route("manufacturer.register.step2") }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log('Step 2 Success:', response);
                        if(response.success) {
                            currentStep = 3;
                            showStep(currentStep);
                        }
                    },
                    error: function(xhr) {
                        console.log('Step 2 Error:', xhr.responseJSON);
                        if(xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            Object.keys(errors).forEach(field => {
                                const input = $(`[name="${field}"]`);
                                input.addClass('is-invalid');
                                const feedback = input.next('.invalid-feedback');
                                if (feedback.length === 0) {
                                    input.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
                                } else {
                                    feedback.text(errors[field][0]);
                                }
                            });
                        } else {
                            alert('An error occurred. Please try again.');
                        }
                    }
                });
            });

            // Step 3 submission
            $('#step3-form').on('submit', function(e) {
                e.preventDefault();

                // Clear previous errors
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').remove();

                // Get the submit button
                const submitBtn = $(this).find('button[type="submit"]');
                const originalBtnText = submitBtn.text();

                // Validate files before submission
                let hasErrors = false;
                const requiredFiles = ['business_license', 'tax_certificate', 'id_proof'];

                requiredFiles.forEach(fieldName => {
                    const fileInput = $(`#${fieldName}`);
                    const file = fileInput[0].files[0];

                    if (!file) {
                        fileInput.addClass('is-invalid');
                        fileInput.after(`<div class="invalid-feedback">Please select a file for ${fieldName.replace('_', ' ')}.</div>`);
                        hasErrors = true;
                    } else {
                        // Check file type
                        const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
                        if (!allowedTypes.includes(file.type)) {
                            fileInput.addClass('is-invalid');
                            fileInput.after(`<div class="invalid-feedback">Please select a PDF, JPG, or PNG file.</div>`);
                            hasErrors = true;
                        }

                        // Check file size (2MB = 2 * 1024 * 1024 bytes)
                        if (file.size > 2 * 1024 * 1024) {
                            fileInput.addClass('is-invalid');
                            fileInput.after(`<div class="invalid-feedback">File size should not exceed 2MB.</div>`);
                            hasErrors = true;
                        }
                    }
                });

                // Check company profile if selected
                const companyProfileInput = $('#company_profile');
                const companyProfileFile = companyProfileInput[0].files[0];
                if (companyProfileFile) {
                    if (companyProfileFile.type !== 'application/pdf') {
                        companyProfileInput.addClass('is-invalid');
                        companyProfileInput.after(`<div class="invalid-feedback">Company profile must be a PDF file.</div>`);
                        hasErrors = true;
                    }
                    if (companyProfileFile.size > 2 * 1024 * 1024) {
                        companyProfileInput.addClass('is-invalid');
                        companyProfileInput.after(`<div class="invalid-feedback">File size should not exceed 2MB.</div>`);
                        hasErrors = true;
                    }
                }

                if (hasErrors) {
                    alert('Please check all required files and try again.');
                    return;
                }

                // Prepare form data
                let formData = new FormData(this);

                // Show loading state
                submitBtn.prop('disabled', true)
                    .html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Uploading...');

                $.ajax({
                    url: '{{ route("manufacturer.register.step3") }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = ((evt.loaded / evt.total) * 100);
                                submitBtn.html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Uploading ${Math.round(percentComplete)}%`);
                            }
                        }, false);
                        return xhr;
                    },
                    success: function(response) {
                        if(response.success) {
                            window.location.href = response.redirect;
                        } else {
                            submitBtn.prop('disabled', false).text(originalBtnText);
                            if (response.message) {
                                alert(response.message);
                            } else {
                                alert('An error occurred. Please try again.');
                            }
                        }
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).text(originalBtnText);

                        if(xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            Object.keys(errors).forEach(field => {
                                const input = $(`#${field}`);
                                input.addClass('is-invalid');
                                input.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
                            });

                            if (errors.general) {
                                alert(errors.general[0]);
                            } else {
                                alert('Please check all required files and try again.');
                            }
                        } else {
                            console.error('Upload error:', xhr.responseText);
                            alert('An error occurred while uploading files. Please try again.');
                        }
                    }
                });
            });

            // Previous button handling
            $('.btn-prev').click(function() {
                if(currentStep > 1) {
                    currentStep--;
                    showStep(currentStep);
                }
            });

            // Add Previous button to Step 2
            $('#step2-form .d-flex').prepend(`
                <button type="button" class="btn btn-secondary btn-prev">Previous</button>
            `);
        });
    </script>
</body>
</html>
