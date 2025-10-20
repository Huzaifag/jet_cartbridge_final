@extends('frontend.layout.main')
@section('content')
    <style>
        /* CSS specific to this page (if any) */
        .inquiry-form-card {
            background-color: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: var(--shadow-hover);
        }

        .form-label {
            font-weight: 600;
        }

        /* Modal specific styling */
        .contact-card {
            cursor: pointer;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 15px;
            transition: all 0.2s ease;
        }

        .contact-card:hover {
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.1);
            border-color: var(--primary-color);
        }

        .contact-card.selected {
            border: 2px solid var(--accent-color);
            background-color: rgba(40, 167, 69, 0.08);
            box-shadow: none;
        }
    </style>

    <div class="py-5 bg-white border-bottom">
        <div class="container">
            <h1 class="fw-bold" style="color: var(--primary-color);">Send Bulk Inquiry</h1>
            <p class="lead text-muted">Submit your requirements to the seller for a tailored quotation on
                <strong>{{ $product->name }}</strong>.</p>
        </div>
    </div>


    <div class="container py-5">
        <div class="row g-5">

            <div class="col-lg-8">
                <div class="inquiry-form-card">
                    <h4 class="mb-4 fw-bold">Your Bulk Order Details</h4>

                    <form action="{{ route('inquiry.submit', $product->id) }}" method="POST" id="bulkInquiryForm">
                        @csrf

                        {{-- HIDDEN FIELD FOR SELECTED CONTACT ID --}}
                        <input type="hidden" name="contact_id" id="selectedContactId" required>
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="mb-4">
                            <label for="quantity" class="form-label">Required Quantity <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="quantity" id="quantity" class="form-control form-control-lg"
                                placeholder="Enter minimum required units (e.g., 500)" required
                                min="{{ $product->b2b_moq ?? 1 }}">
                            @if ($product->b2b_moq)
                                <small class="text-secondary mt-1 d-block">Minimum Order Quantity (MOQ) for this product
                                    is <strong>{{ $product->b2b_moq }}</strong> units.</small>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label for="target_price" class="form-label">Target Price (Per Unit) <small
                                    class="text-muted">(Optional)</small></label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text">$</span>
                                <input type="number" name="target_price" id="target_price" class="form-control"
                                    placeholder="e.g., 5.99" step="0.01">
                            </div>
                            <small class="text-secondary mt-1 d-block">Providing a target price helps the seller offer a
                                faster quote.</small>
                        </div>

                        <div class="mb-4">
                            <label for="destination" class="form-label">Shipping Destination <span
                                    class="text-danger">*</span></label>
                            <select name="destination" id="destination" class="form-select form-select-lg" required>
                                <option value="">Select Country / Region</option>
                                {{-- Loop through countries here --}}
                                <option value="USA">United States</option>
                                <option value="CAN">Canada</option>
                                <option value="GBR">United Kingdom</option>
                                {{-- etc. --}}
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="deadline" class="form-label">Desired Delivery Deadline <small
                                    class="text-muted">(Optional)</small></label>
                            <input type="date" name="deadline" id="deadline" class="form-control form-control-lg">
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label">Additional Requirements/Details <span
                                    class="text-danger">*</span></label>
                            <textarea name="message" id="message" class="form-control" rows="5"
                                placeholder="Describe any customizations, quality standards, or specific payment terms you require." required></textarea>
                        </div>

                        {{-- MODIFIED BUTTON: Added data-bs attributes to open the modal --}}
                        <button type="button" class="btn btn-primary btn-lg w-100 mt-3" data-bs-toggle="modal"
                            data-bs-target="#contactSelectionModal">
                            <i class="fas fa-paper-plane me-2"></i> Submit Inquiry to Seller
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-4">

                <div class="card shadow-sm h-100" style="border-radius: 12px; border: 1px solid rgba(0, 0, 0, 0.05);">
                    @php
                        // Assuming $product is available and images is a JSON column
                        $images = is_array($product->images) ? $product->images : (json_decode($product->images, true) ?? []);
                        $firstImage = $images[0] ?? 'default.png'; // fallback image
                    @endphp

                    <img src="{{ asset('storage/' . $firstImage) }}" class="card-img-top" alt="{{ $product->name }}"
                        style="height: 180px; object-fit: cover; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                    <div class="card-body">
                        <h5 class="card-title fw-bold" style="color: var(--primary-color);">{{ $product->name }}</h5>
                        <p class="card-text text-muted small">{{ Str::limit($product->description, 80) }}</p>

                        <ul class="list-group list-group-flush mt-3">
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                Current B2B Price:
                                <span class="fw-bold">${{ number_format($product->b2b_price, 2) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                Minimum Order:
                                <span class="fw-bold text-success">{{ $product->b2b_moq }} units</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer bg-light p-3">
                        <h6 class="mb-1 text-muted small">Seller:</h6>
                        <div class="d-flex align-items-center">
                            @if ($seller->avatar)
                                <img src="{{ asset('storage/' . $seller->avatar) }}" alt="{{ $seller->company_name }}"
                                    class="seller-avatar me-2 rounded-circle"
                                    style="width: 30px; height: 30px; object-fit: cover;">
                            @else
                                <div class="me-2 d-flex align-items-center justify-content-center rounded-circle bg-primary text-white fw-bold"
                                    style="width: 30px; height: 30px;">
                                    {{ strtoupper(substr($seller->company_name, 0, 1)) }}
                                </div>
                            @endif

                            <span class="fw-bold">{{ $seller->company_name }}</span>

                            @if ($seller->verified)
                                <span class="verification-badge ms-2">
                                    <i class="fas fa-check-circle me-1 text-success"></i> Verified
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- --------------------------------- --}}
    {{-- CONTACT SELECTION MODAL HTML --}}
    {{-- --------------------------------- --}}
    <div class="modal fade" id="contactSelectionModal" tabindex="-1" aria-labelledby="contactSelectionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px;">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="contactSelectionModalLabel" style="color: var(--primary-color);">
                        Select Contact for Inquiry</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted">Choose the contact details the seller should use to send your quote.</p>

                    <div id="contactList">
                        @forelse ($userContacts as $contact)
                            <div class="contact-card mb-3" data-contact-id="{{ $contact->id }}" data-contact-name="{{ $contact->name }}">
                                <h6 class="mb-1 fw-bold">{{ $contact->name }}</h6>
                                <p class="small mb-0 text-muted">
                                    <i class="fas fa-envelope me-1"></i> {{ $contact->email }}
                                </p>
                                <p class="small mb-0 text-muted">
                                    <i class="fas fa-phone me-1"></i> {{ $contact->mobile }}
                                </p>
                            </div>
                        @empty
                            <div class="alert alert-warning text-center">
                                <i class="fas fa-exclamation-triangle me-2"></i> You have no saved contacts. Please add one in your profile settings.
                            </div>
                        @endforelse

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="confirmInquiryBtn" disabled>
                        Confirm Contact & Send Inquiry
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const contactCards = document.querySelectorAll('.contact-card');
            const selectedContactIdInput = document.getElementById('selectedContactId');
            const confirmInquiryBtn = document.getElementById('confirmInquiryBtn');
            const bulkInquiryForm = document.getElementById('bulkInquiryForm');

            // 1. Handle Contact Selection
            contactCards.forEach(card => {
                card.addEventListener('click', function () {
                    // Remove 'selected' class from all cards
                    contactCards.forEach(c => c.classList.remove('selected'));

                    // Add 'selected' class to the clicked card
                    this.classList.add('selected');

                    // Set the hidden input field value
                    const contactId = this.getAttribute('data-contact-id');
                    selectedContactIdInput.value = contactId;

                    // Enable the confirmation button
                    confirmInquiryBtn.disabled = false;
                    confirmInquiryBtn.textContent = `Confirm ${this.getAttribute('data-contact-name')} & Send Inquiry`;
                });
            });

            // 2. Handle Final Submission
            confirmInquiryBtn.addEventListener('click', function () {
                // Manually check if a contact is selected before submission
                if (selectedContactIdInput.value) {
                    // The hidden input is filled, now submit the main form
                    bulkInquiryForm.submit();
                } else {
                    // Should not happen if the button is properly disabled, but good for safety
                    alert('Please select a contact before submitting the inquiry.');
                }
            });
        });
    </script>
@endsection