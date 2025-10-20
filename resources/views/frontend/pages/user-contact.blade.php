@extends('frontend.layout.main')
@section('content')
    <style>
        /* Reusing your modern card styles */
        .contact-card-item {
            border-radius: 12px;
            box-shadow: var(--shadow-light);
            transition: all 0.3s ease;
            position: relative;
        }

        .contact-card-item:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-2px);
        }

        .status-badge-active {
            background-color: var(--accent-color);
            /* Green */
            color: white;
            font-weight: 600;
        }

        .status-badge-inactive {
            background-color: #6c757d;
            /* Gray */
            color: white;
        }

        .location-icon {
            color: var(--primary-color);
            margin-right: 8px;
        }
    </style>


    <div class="py-5 bg-white border-bottom">
        <div class="container">
            <h1 class="fw-bold" style="color: var(--primary-color);">Contact Book Management</h1>
            <p class="lead text-muted">View, edit, or add contacts used for bulk inquiries and order communications.</p>
        </div>
    </div>

    <div class="container py-5">

        <div class="d-flex justify-content-end mb-4">
            {{-- Button to open the Add/Edit Modal --}}
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#contactModal"
                onclick="resetContactModal()">
                <i class="fas fa-plus me-2"></i> Add New Contact
            </button>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

            @forelse ($userContacts as $contact)
                <div class="col">
                    <div class="card contact-card-item h-100 p-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title fw-bold" style="color: var(--primary-color);">
                                    {{ $contact->name }}
                                </h5>
                                <span
                                    class="badge {{ $contact->status == 'active' ? 'status-badge-active' : 'status-badge-inactive' }} rounded-pill p-2">
                                    {{ ucfirst($contact->status) }}
                                </span>
                            </div>

                            <p class="text-muted mb-3 small">
                                <i
                                    class="location-icon fas fa-{{ $contact->location_type == 'Office' ? 'building' : ($contact->location_type == 'Warehouse' ? 'warehouse' : 'home') }}"></i>
                                <strong>{{ $contact->location_type }}</strong> Contact
                            </p>

                            <ul class="list-unstyled small">
                                <li class="mb-1"><i class="fas fa-envelope me-2 text-primary"></i>
                                    {{ $contact->email }}</li>
                                <li class="mb-1"><i class="fas fa-mobile-alt me-2 text-primary"></i>
                                    {{ $contact->mobile }}</li>
                                <li class="mb-1"><i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                    {{ $contact->address }}, {{ $contact->city }}, {{ $contact->state }}
                                </li>
                            </ul>
                        </div>
                        <div class="card-footer bg-white border-0 pt-0">
                            {{-- Edit Button: Fills modal with existing data --}}
                            <button class="btn btn-sm btn-outline-primary w-100" data-bs-toggle="modal"
                                data-bs-target="#contactModal" onclick="editContact({{ json_encode($contact) }})">
                                <i class="fas fa-edit me-1"></i> Edit Contact
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center shadow-sm">
                        <i class="fas fa-info-circle me-2"></i> You currently have no saved contacts. Click "Add New
                        Contact" to create one.
                    </div>
                </div>
            @endforelse

        </div>
    </div>

    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="border-radius: 16px;">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="contactModalLabel" style="color: var(--primary-color);">
                        Add New Contact
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="contactForm" action="#" method="POST">
                    @csrf
                    {{-- This hidden input will be used to send the Contact ID for updates --}}
                    <input type="hidden" name="contact_id" id="contactId">

                    <div class="modal-body p-4">

                        <div class="row g-3">

                            {{-- Row 1: Name and Email --}}
                            <div class="col-md-6">
                                <label for="contactName" class="form-label">Contact Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" id="contactName" class="form-control" required
                                    placeholder="e.g., John Doe - Purchasing">
                            </div>
                            <div class="col-md-6">
                                <label for="contactEmail" class="form-label">Email Address <span
                                        class="text-danger">*</span></label>
                                <input type="email" name="email" id="contactEmail" class="form-control" required
                                    placeholder="name@company.com">
                            </div>

                            {{-- Row 2: Mobile and Location Type --}}
                            <div class="col-md-6">
                                <label for="contactMobile" class="form-label">Mobile Number</label>
                                <input type="tel" name="mobile" id="contactMobile" class="form-control"
                                    placeholder="+1 555 123 4567">
                            </div>
                            <div class="col-md-6">
                                <label for="locationType" class="form-label">Location Type</label>
                                <select name="location_type" id="locationType" class="form-select">
                                    <option value="Office">Office</option>
                                    <option value="Warehouse">Warehouse/Factory</option>
                                    <option value="Home">Home Address</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            {{-- Row 3: Address, City, State --}}
                            <div class="col-12">
                                <label for="completeAddress" class="form-label">Complete Address <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="address" id="completeAddress" class="form-control"
                                    required placeholder="Street address, P.O. box, company suite, etc.">
                            </div>
                            <div class="col-md-6">
                                <label for="contactCity" class="form-label">City <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="city" id="contactCity" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="contactState" class="form-label">State/Province</label>
                                <input type="text" name="state" id="contactState" class="form-control">
                            </div>

                            {{-- Row 4: Status --}}
                            <div class="col-12 mt-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="contactStatus"
                                        name="status" value="active" checked>
                                    <label class="form-check-label fw-bold" for="contactStatus">Set as Active Contact
                                        (Visible for inquiries)</label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="modalSubmitBtn">
                            <i class="fas fa-save me-2"></i> Save Contact
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Function to reset the modal for creating a new contact
        function resetContactModal() {
            document.getElementById('contactModalLabel').textContent = 'Add New Contact';
            document.getElementById('modalSubmitBtn').innerHTML = '<i class="fas fa-save me-2"></i> Save Contact';
            document.getElementById('contactForm').reset();
            document.getElementById('contactId').value = '';
            document.getElementById('contactForm').action =
                '{{ route('user.contacts.store') }}'; // Set action for creation
            document.getElementById('contactStatus').checked = true; // Default to active
        }

        // Function to populate the modal for editing an existing contact
        function editContact(contact) {
            document.getElementById('contactModalLabel').textContent = 'Edit Contact: ' + contact.name;
            document.getElementById('modalSubmitBtn').innerHTML = '<i class="fas fa-sync-alt me-2"></i> Update Contact';

            // Populate form fields
            document.getElementById('contactId').value = contact.id;
            document.getElementById('contactName').value = contact.name;
            document.getElementById('contactEmail').value = contact.email;
            document.getElementById('contactMobile').value = contact.mobile;
            document.getElementById('locationType').value = contact.location_type;
            document.getElementById('completeAddress').value = contact.address;
            document.getElementById('contactCity').value = contact.city;
            document.getElementById('contactState').value = contact.state;

            // Set status switch
            document.getElementById('contactStatus').checked = (contact.status === 'active');

            // Set form action for update (assuming a PUT/PATCH route for updates)
            // Note: Blade uses hidden input for method override, so we just set the URL here
            document.getElementById('contactForm').action = '{{ route('user.contacts.update', 0) }}'.replace(/0$/, contact
                .id);
            // You would also need a hidden input: <input type="hidden" name="_method" value="PUT">
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Add method override for update (required for RESTful Laravel routes)
            const form = document.getElementById('contactForm');
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'POST'; // Default for store

            form.prepend(methodInput);

            // Listener to update the form action and method when the modal opens/closes
            var contactModal = document.getElementById('contactModal');
            contactModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const isEdit = button && button.getAttribute('onclick') && button.getAttribute('onclick')
                    .includes('editContact');

                if (isEdit) {
                    methodInput.value = 'PUT'; // For update operation
                } else {
                    methodInput.value = 'POST'; // For store operation
                }
            });
        });
    </script>
@endsection
