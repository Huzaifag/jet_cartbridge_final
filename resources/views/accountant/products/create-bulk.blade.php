@extends('salesman.layouts.app')

@section('content')
<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 0;
        margin-bottom: 30px;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 24px;
        font-weight: 700;
        color: var(--primary);
    }

    .logo i {
        color: var(--secondary);
    }

    .user-menu {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .user-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(45deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 18px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 10px;
    }

    .page-subtitle {
        color: var(--gray);
        font-size: 16px;
        margin-bottom: 30px;
    }

    .card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        margin-bottom: 25px;
        transition: var(--transition);
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background: white;
        border-bottom: 1px solid var(--light-gray);
        padding: 20px 25px;
        font-weight: 600;
        font-size: 18px;
        color: var(--primary-dark);
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
    }

    .card-body {
        padding: 25px;
    }

    .upload-area {
        border: 2px dashed var(--primary);
        border-radius: var(--border-radius);
        padding: 40px;
        text-align: center;
        background: var(--primary-light);
        margin-bottom: 30px;
        transition: var(--transition);
        cursor: pointer;
    }

    .upload-area:hover {
        background: rgba(67, 97, 238, 0.1);
    }

    .upload-icon {
        font-size: 48px;
        color: var(--primary);
        margin-bottom: 15px;
    }

    .upload-text {
        font-size: 18px;
        font-weight: 500;
        margin-bottom: 10px;
    }

    .upload-subtext {
        color: var(--gray);
        margin-bottom: 20px;
    }

    .btn {
        padding: 12px 24px;
        border-radius: 30px;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
        border: none;
        font-size: 15px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
    }

    .btn-outline {
        background: transparent;
        border: 1px solid var(--primary);
        color: var(--primary);
    }

    .btn-outline:hover {
        background: var(--primary);
        color: white;
    }

    .file-input {
        display: none;
    }

    .file-info {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background: var(--light);
        border-radius: var(--border-radius);
        margin-top: 20px;
        display: none;
    }

    .file-icon {
        font-size: 24px;
        color: var(--primary);
    }

    .file-details {
        flex-grow: 1;
    }

    .file-name {
        font-weight: 600;
        margin-bottom: 5px;
    }

    .file-size {
        color: var(--gray);
        font-size: 14px;
    }

    .remove-file {
        color: var(--danger);
        cursor: pointer;
        font-size: 18px;
    }

    .progress-area {
        margin-top: 20px;
        display: none;
    }

    .progress-bar {
        height: 8px;
        background: var(--light-gray);
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 10px;
    }

    .progress {
        height: 100%;
        background: var(--primary);
        border-radius: 10px;
        width: 0%;
        transition: width 0.3s ease;
    }

    .progress-info {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        color: var(--gray);
    }

    .guidance-section {
        margin-top: 40px;
    }

    .section-title {
        font-size: 20px;
        font-weight: 600;
        color: var(--primary-dark);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: var(--primary);
    }

    .guidance-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }

    .guidance-card {
        background: white;
        border-radius: var(--border-radius);
        padding: 20px;
        box-shadow: var(--shadow);
        transition: var(--transition);
    }

    .guidance-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .guidance-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: var(--primary-light);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-size: 20px;
        margin-bottom: 15px;
    }

    .guidance-title {
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--dark);
    }

    .guidance-content {
        color: var(--gray);
        font-size: 14px;
    }

    .guidance-list {
        margin-top: 10px;
        padding-left: 20px;
    }

    .guidance-list li {
        margin-bottom: 8px;
        color: var(--gray);
    }

    .template-download {
        margin-top: 30px;
        text-align: center;
        padding: 30px;
        background: var(--primary-light);
        border-radius: var(--border-radius);
    }

    .template-title {
        font-weight: 600;
        margin-bottom: 15px;
        color: var(--primary-dark);
    }

    .template-buttons {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 20px;
    }

    .requirements-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .requirements-table th,
    .requirements-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid var(--light-gray);
    }

    .requirements-table th {
        background: var(--primary-light);
        color: var(--primary-dark);
        font-weight: 600;
    }

    .requirements-table tr:hover {
        background: var(--light);
    }

    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-required {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }

    .status-optional {
        background: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }

    @media (max-width: 768px) {
        .guidance-grid {
            grid-template-columns: 1fr;
        }

        .template-buttons {
            flex-direction: column;
        }

        .upload-area {
            padding: 20px;
        }
    }
</style>

<div class="container">
    <div>
        <h1 class="page-title">Bulk Product Upload</h1>
        <p class="page-subtitle">Upload multiple products at once using CSV or XLSX files</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <span>Upload Products</span>
            <span><i class="fas fa-question-circle" style="color: var(--primary);"></i></span>
        </div>
        <div class="card-body">
            <form id="uploadForm" enctype="multipart/form-data">
                @csrf
                <div class="upload-area" id="uploadArea">
                    <div class="upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                    </div>
                    <div class="upload-text">Drag & Drop your file here</div>
                    <div class="upload-subtext">Supported formats: CSV, XLSX (Max file size: 10MB)</div>
                    <button type="button" class="btn btn-primary" id="browseButton">
                        <i class="fas fa-folder-open"></i> Browse Files
                    </button>
                    <input type="file" id="fileInput" name="file" class="file-input" accept=".csv,.xlsx,.xls">
                </div>

                <div class="file-info" id="fileInfo">
                    <div class="file-icon">
                        <i class="fas fa-file-excel"></i>
                    </div>
                    <div class="file-details">
                        <div class="file-name" id="fileName"></div>
                        <div class="file-size" id="fileSize"></div>
                    </div>
                    <div class="remove-file" id="removeFile">
                        <i class="fas fa-times"></i>
                    </div>
                </div>

                <div class="progress-area" id="progressArea">
                    <div class="progress-bar">
                        <div class="progress" id="progressBar"></div>
                    </div>
                    <div class="progress-info">
                        <span id="progressPercentage">0%</span>
                        <span id="progressStatus">Processing...</span>
                    </div>
                </div>

                <div style="text-align: center; margin-top: 30px;">
                    <button type="submit" class="btn btn-primary" id="uploadButton" disabled>
                        <i class="fas fa-upload"></i> Upload Products
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="guidance-section">
        <h2 class="section-title"><i class="fas fa-info-circle"></i> Upload Guidelines</h2>

        <div class="guidance-grid">
            <div class="guidance-card">
                <div class="guidance-icon">
                    <i class="fas fa-list-alt"></i>
                </div>
                <h3 class="guidance-title">File Format Requirements</h3>
                <div class="guidance-content">
                    <p>Ensure your file meets the following requirements:</p>
                    <ul class="guidance-list">
                        <li>CSV or XLSX format</li>
                        <li>Maximum file size: 10MB</li>
                        <li>First row must contain headers</li>
                        <li>Use UTF-8 encoding for special characters</li>
                    </ul>
                </div>
            </div>

            <div class="guidance-card">
                <div class="guidance-icon">
                    <i class="fas fa-table"></i>
                </div>
                <h3 class="guidance-title">Required Fields</h3>
                <div class="guidance-content">
                    <p>Your file must include these mandatory fields:</p>
                    <ul class="guidance-list">
                        <li>Product Name (text, 100 chars max)</li>
                        <li>SKU (unique alphanumeric code)</li>
                        <li>Price (numeric, 2 decimal places)</li>
                        <li>Category (from predefined list)</li>
                    </ul>
                </div>
            </div>

            <div class="guidance-card">
                <div class="guidance-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h3 class="guidance-title">Common Issues</h3>
                <div class="guidance-content">
                    <p>Avoid these common mistakes:</p>
                    <ul class="guidance-list">
                        <li>Missing required fields</li>
                        <li>Duplicate SKU values</li>
                        <li>Incorrect date formats</li>
                        <li>Special characters in numeric fields</li>
                        <li>Exceeding character limits</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card" style="margin-top: 30px;">
            <div class="card-header">
                <span>Field Requirements</span>
            </div>
            <div class="card-body">
                <table class="requirements-table">
                    <thead>
                        <tr>
                            <th>Field Name</th>
                            <th>Type</th>
                            <th>Required</th>
                            <th>Description</th>
                            <th>Example</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Product Name</td>
                            <td>Text</td>
                            <td><span class="status-badge status-required">Required</span></td>
                            <td>Product title (max 100 characters)</td>
                            <td>Wireless Bluetooth Headphones</td>
                        </tr>
                        <tr>
                            <td>SKU</td>
                            <td>Text</td>
                            <td><span class="status-badge status-required">Required</span></td>
                            <td>Unique stock keeping unit</td>
                            <td>WH-2023-BLK</td>
                        </tr>
                        <tr>
                            <td>Price</td>
                            <td>Number</td>
                            <td><span class="status-badge status-required">Required</span></td>
                            <td>Product price (2 decimal places)</td>
                            <td>59.99</td>
                        </tr>
                        <tr>
                            <td>Category</td>
                            <td>Text</td>
                            <td><span class="status-badge status-required">Required</span></td>
                            <td>Product category from predefined list</td>
                            <td>Electronics</td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td>Text</td>
                            <td><span class="status-badge status-optional">Optional</span></td>
                            <td>Product description (max 500 characters)</td>
                            <td>High-quality wireless headphones with noise cancellation</td>
                        </tr>
                        <tr>
                            <td>Stock Quantity</td>
                            <td>Number</td>
                            <td><span class="status-badge status-optional">Optional</span></td>
                            <td>Available inventory count</td>
                            <td>150</td>
                        </tr>
                        <tr>
                            <td>Weight</td>
                            <td>Number</td>
                            <td><span class="status-badge status-optional">Optional</span></td>
                            <td>Product weight in kg</td>
                            <td>0.45</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="template-download">
            <h3 class="template-title">Download our template file to ensure correct formatting</h3>
            <p>Our templates include all the required fields with examples to help you get started quickly.</p>
            <div class="template-buttons">
                <a href="/templates/product-upload-template.csv" class="btn btn-primary">
                    <i class="fas fa-download"></i> Download CSV Template
                </a>
                <a href="/templates/product-upload-template.xlsx" class="btn btn-outline">
                    <i class="fas fa-download"></i> Download XLSX Template
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const uploadArea = document.getElementById('uploadArea');
            const fileInput = document.getElementById('fileInput');
            const browseButton = document.getElementById('browseButton');
            const fileInfo = document.getElementById('fileInfo');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            const removeFile = document.getElementById('removeFile');
            const progressArea = document.getElementById('progressArea');
            const progressBar = document.getElementById('progressBar');
            const progressPercentage = document.getElementById('progressPercentage');
            const progressStatus = document.getElementById('progressStatus');
            const uploadButton = document.getElementById('uploadButton');
            const uploadForm = document.getElementById('uploadForm');

            // Browse file button
            browseButton.addEventListener('click', function () {
                fileInput.click();
            });

            // File input change
            fileInput.addEventListener('change', function (e) {
                if (this.files && this.files[0]) {
                    const file = this.files[0];
                    const fileType = file.name.split('.').pop().toLowerCase();

                    // Validate file type
                    if (fileType !== 'csv' && fileType !== 'xlsx' && fileType !== 'xls') {
                        alert('Please select a CSV or XLSX file.');
                        this.value = '';
                        return;
                    }

                    // Validate file size (10MB max)
                    if (file.size > 10 * 1024 * 1024) {
                        alert('File size exceeds 10MB limit.');
                        this.value = '';
                        return;
                    }

                    // Display file info
                    fileName.textContent = file.name;
                    fileSize.textContent = formatFileSize(file.size);
                    fileInfo.style.display = 'flex';
                    uploadButton.disabled = false;
                }
            });

            // Remove file
            removeFile.addEventListener('click', function () {
                fileInput.value = '';
                fileInfo.style.display = 'none';
                uploadButton.disabled = true;
                progressArea.style.display = 'none';
            });

            // Form submission with AJAX
            uploadForm.addEventListener('submit', function (e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const file = fileInput.files[0];

                if (!file) {
                    alert('Please select a file to upload.');
                    return;
                }

                // Show progress area
                progressArea.style.display = 'block';
                progressBar.style.width = '0%';
                progressPercentage.textContent = '0%';
                progressStatus.textContent = 'Uploading...';

                // Make AJAX request
                fetch('/seller/products/bulk-upload', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw err; });
                    }
                    return response.json();
                })
                .then(data => {
                    // Simulate progress for visual feedback
                    let width = 0;
                    const interval = setInterval(function () {
                        if (width >= 100) {
                            clearInterval(interval);
                            progressStatus.textContent = 'Upload completed!';
                            alert(data.message || 'Products uploaded successfully! ' + data.count + ' products have been added to your catalog.');
                            fileInput.value = '';
                            fileInfo.style.display = 'none';
                            uploadButton.disabled = true;
                            progressArea.style.display = 'none';
                        } else {
                            width += 5;
                            progressBar.style.width = width + '%';
                            progressPercentage.textContent = width + '%';
                        }
                    }, 100);
                })
                .catch(error => {
                    progressArea.style.display = 'none';
                    alert(error.message || 'An error occurred during upload. Please try again.');
                    console.error('Upload error:', error);
                });
            });

            // Drag and drop functionality
            uploadArea.addEventListener('dragover', function (e) {
                e.preventDefault();
                uploadArea.style.background = 'rgba(67, 97, 238, 0.15)';
                uploadArea.style.borderColor = 'var(--primary-dark)';
            });

            uploadArea.addEventListener('dragleave', function () {
                uploadArea.style.background = 'var(--primary-light)';
                uploadArea.style.borderColor = 'var(--primary)';
            });

            uploadArea.addEventListener('drop', function (e) {
                e.preventDefault();
                uploadArea.style.background = 'var(--primary-light)';
                uploadArea.style.borderColor = 'var(--primary)';

                if (e.dataTransfer.files && e.dataTransfer.files[0]) {
                    const file = e.dataTransfer.files[0];
                    const fileType = file.name.split('.').pop().toLowerCase();

                    // Validate file type
                    if (fileType !== 'csv' && fileType !== 'xlsx' && fileType !== 'xls') {
                        alert('Please drop a CSV or XLSX file.');
                        return;
                    }

                    // Validate file size (10MB max)
                    if (file.size > 10 * 1024 * 1024) {
                        alert('File size exceeds 10MB limit.');
                        return;
                    }

                    // Create a FileList object simulation
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    fileInput.files = dataTransfer.files;

                    // Display file info
                    fileName.textContent = file.name;
                    fileSize.textContent = formatFileSize(file.size);
                    fileInfo.style.display = 'flex';
                    uploadButton.disabled = false;
                }
            });

            // Format file size
            function formatFileSize(bytes) {
                if (bytes < 1024) return bytes + ' bytes';
                else if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
                else return (bytes / 1048576).toFixed(1) + ' MB';
            }
        });
    </script>
@endsection