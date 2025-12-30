@extends('manufacturer.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Contact Book</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('manufacturer.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Contact Book</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Bar -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="search-box">
                                <div class="position-relative">
                                    <input type="text" class="form-control" placeholder="Search contacts..." id="searchContacts">
                                    <i class="fas fa-search search-icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterType">
                                <option value="">All Types</option>
                                <option value="customer">Customers</option>
                                <option value="supplier">Suppliers</option>
                                <option value="partner">Partners</option>
                                <option value="lead">Leads</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterStatus">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="blocked">Blocked</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#addContactModal">
                                <i class="fas fa-plus me-1"></i> Add Contact
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contacts Grid -->
    <div class="row" id="contactsGrid">
        @forelse($contacts ?? [] as $contact)
            <div class="col-xl-3 col-md-6 contact-card" data-type="{{ $contact['type'] ?? 'customer' }}" data-status="{{ $contact['status'] ?? 'active' }}">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="dropdown float-end">
                            <a class="text-muted dropdown-toggle font-size-16" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-h"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#" onclick="editContact({{ $contact['id'] ?? 0 }})">Edit</a></li>
                                <li><a class="dropdown-item" href="#" onclick="viewContact({{ $contact['id'] ?? 0 }})">View Details</a></li>
                                <li><a class="dropdown-item text-danger" href="#" onclick="deleteContact({{ $contact['id'] ?? 0 }})">Delete</a></li>
                            </ul>
                        </div>

                        <div class="avatar-lg mx-auto mb-3">
                            <img src="{{ $contact['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($contact['name'] ?? 'Contact') . '&background=007bff&color=ffffff&size=80' }}" 
                                 alt="{{ $contact['name'] ?? 'Contact' }}" class="img-fluid rounded-circle">
                        </div>

                        <h5 class="font-size-16 mb-1">{{ $contact['name'] ?? 'Unknown Contact' }}</h5>
                        <p class="text-muted mb-2">{{ $contact['company'] ?? 'No Company' }}</p>

                        <div class="d-flex justify-content-center mb-3">
                            <span class="badge bg-{{ $contact['type'] === 'customer' ? 'success' : ($contact['type'] === 'supplier' ? 'primary' : 'info') }}-subtle text-{{ $contact['type'] === 'customer' ? 'success' : ($contact['type'] === 'supplier' ? 'primary' : 'info') }}">
                                {{ ucfirst($contact['type'] ?? 'Customer') }}
                            </span>
                        </div>

                        <div class="contact-info">
                            @if(isset($contact['email']))
                                <p class="text-muted mb-1">
                                    <i class="fas fa-envelope me-1"></i>
                                    {{ $contact['email'] }}
                                </p>
                            @endif
                            @if(isset($contact['phone']))
                                <p class="text-muted mb-1">
                                    <i class="fas fa-phone me-1"></i>
                                    {{ $contact['phone'] }}
                                </p>
                            @endif
                            @if(isset($contact['location']))
                                <p class="text-muted mb-3">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $contact['location'] }}
                                </p>
                            @endif
                        </div>

                        <div class="d-flex gap-2 justify-content-center">
                            <button type="button" class="btn btn-primary btn-sm" onclick="contactPerson('{{ $contact['email'] ?? '' }}')">
                                <i class="fas fa-envelope"></i>
                            </button>
                            <button type="button" class="btn btn-success btn-sm" onclick="callPerson('{{ $contact['phone'] ?? '' }}')">
                                <i class="fas fa-phone"></i>
                            </button>
                            <button type="button" class="btn btn-info btn-sm" onclick="chatPerson({{ $contact['id'] ?? 0 }})">
                                <i class="fas fa-comment"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-address-book fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No contacts found</h5>
                    <p class="text-muted">Start building your contact book by adding customers, suppliers, and partners.</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addContactModal">
                        <i class="fas fa-plus me-1"></i> Add First Contact
                    </button>
                </div>
            </div>
        @endforelse
    </div>
</div>

<!-- Add Contact Modal -->
<div class="modal fade" id="addContactModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Contact</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addContactForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Full Name *</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Company</label>
                                <input type="text" class="form-control" name="company">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="tel" class="form-control" name="phone">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Contact Type *</label>
                                <select class="form-select" name="type" required>
                                    <option value="">Select Type</option>
                                    <option value="customer">Customer</option>
                                    <option value="supplier">Supplier</option>
                                    <option value="partner">Partner</option>
                                    <option value="lead">Lead</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea class="form-control" name="address" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" name="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Contact</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Search functionality
document.getElementById('searchContacts').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    filterContacts();
});

// Filter functionality
document.getElementById('filterType').addEventListener('change', filterContacts);
document.getElementById('filterStatus').addEventListener('change', filterContacts);

function filterContacts() {
    const searchTerm = document.getElementById('searchContacts').value.toLowerCase();
    const typeFilter = document.getElementById('filterType').value;
    const statusFilter = document.getElementById('filterStatus').value;
    
    const contactCards = document.querySelectorAll('.contact-card');
    
    contactCards.forEach(card => {
        const name = card.querySelector('h5').textContent.toLowerCase();
        const company = card.querySelector('.text-muted').textContent.toLowerCase();
        const type = card.dataset.type;
        const status = card.dataset.status;
        
        const matchesSearch = name.includes(searchTerm) || company.includes(searchTerm);
        const matchesType = !typeFilter || type === typeFilter;
        const matchesStatus = !statusFilter || status === statusFilter;
        
        if (matchesSearch && matchesType && matchesStatus) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// Contact actions
function editContact(id) {
    // Implementation for editing contact
    console.log('Edit contact:', id);
}

function viewContact(id) {
    // Implementation for viewing contact details
    console.log('View contact:', id);
}

function deleteContact(id) {
    if (confirm('Are you sure you want to delete this contact?')) {
        // Implementation for deleting contact
        console.log('Delete contact:', id);
    }
}

function contactPerson(email) {
    if (email) {
        window.location.href = `mailto:${email}`;
    }
}

function callPerson(phone) {
    if (phone) {
        window.location.href = `tel:${phone}`;
    }
}

function chatPerson(id) {
    // Implementation for starting chat
    console.log('Chat with contact:', id);
}

// Add contact form
document.getElementById('addContactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Get form data
    const formData = new FormData(this);
    
    // Here you would typically send the data to your backend
    console.log('Adding contact:', Object.fromEntries(formData));
    
    // Close modal and reset form
    const modal = bootstrap.Modal.getInstance(document.getElementById('addContactModal'));
    modal.hide();
    this.reset();
    
    // Show success message
    alert('Contact added successfully!');
});
</script>
@endpush