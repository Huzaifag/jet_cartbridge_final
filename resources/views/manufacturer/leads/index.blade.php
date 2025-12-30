@extends('manufacturer.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Lead Management</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('manufacturer.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Leads</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Lead Statistics -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <p class="text-truncate font-size-14 mb-2">Total Leads</p>
                            <h4 class="mb-2">{{ $leadStats['total_leads'] ?? 0 }}</h4>
                            <p class="text-muted mb-0">
                                <span class="text-success fw-bold font-size-12 me-2">
                                    <i class="ri-arrow-right-up-line me-1 align-middle"></i>
                                    +12% this month
                                </span>
                            </p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-primary-subtle text-primary rounded-3">
                                <i class="fas fa-users font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <p class="text-truncate font-size-14 mb-2">Qualified Leads</p>
                            <h4 class="mb-2">{{ $leadStats['qualified_leads'] ?? 0 }}</h4>
                            <p class="text-muted mb-0">
                                <span class="text-success fw-bold font-size-12 me-2">
                                    <i class="ri-arrow-right-up-line me-1 align-middle"></i>
                                    +8% this month
                                </span>
                            </p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-success-subtle text-success rounded-3">
                                <i class="fas fa-check-circle font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <p class="text-truncate font-size-14 mb-2">Conversion Rate</p>
                            <h4 class="mb-2">{{ $leadStats['conversion_rate'] ?? 0 }}%</h4>
                            <p class="text-muted mb-0">
                                <span class="text-success fw-bold font-size-12 me-2">
                                    <i class="ri-arrow-right-up-line me-1 align-middle"></i>
                                    +3.2% this month
                                </span>
                            </p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-warning-subtle text-warning rounded-3">
                                <i class="fas fa-chart-line font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <p class="text-truncate font-size-14 mb-2">Estimated Value</p>
                            <h4 class="mb-2">${{ number_format($leadStats['total_estimated_value'] ?? 0, 0) }}</h4>
                            <p class="text-muted mb-0">
                                <span class="text-success fw-bold font-size-12 me-2">
                                    <i class="ri-arrow-right-up-line me-1 align-middle"></i>
                                    +15% this month
                                </span>
                            </p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-info-subtle text-info rounded-3">
                                <i class="fas fa-dollar-sign font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="search-box">
                                <div class="position-relative">
                                    <input type="text" class="form-control" placeholder="Search leads..." id="searchLeads">
                                    <i class="fas fa-search search-icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="filterStatus">
                                <option value="">All Status</option>
                                <option value="new">New</option>
                                <option value="contacted">Contacted</option>
                                <option value="qualified">Qualified</option>
                                <option value="proposal_sent">Proposal Sent</option>
                                <option value="negotiation">Negotiation</option>
                                <option value="converted">Converted</option>
                                <option value="lost">Lost</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="filterPriority">
                                <option value="">All Priority</option>
                                <option value="high">High</option>
                                <option value="medium">Medium</option>
                                <option value="low">Low</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="filterSource">
                                <option value="">All Sources</option>
                                <option value="website">Website</option>
                                <option value="referral">Referral</option>
                                <option value="trade_show">Trade Show</option>
                                <option value="cold_call">Cold Call</option>
                                <option value="social_media">Social Media</option>
                                <option value="advertisement">Advertisement</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addLeadModal">
                                    <i class="fas fa-plus me-1"></i> Add Lead
                                </button>
                                <button type="button" class="btn btn-success" onclick="exportLeads()">
                                    <i class="fas fa-download me-1"></i> Export
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leads Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Company</th>
                                    <th>Contact Person</th>
                                    <th>Source</th>
                                    <th>Status</th>
                                    <th>Priority</th>
                                    <th>Estimated Value</th>
                                    <th>Assigned To</th>
                                    <th>Next Follow-up</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="leadsTableBody">
                                @forelse($leads ?? [] as $lead)
                                    <tr class="lead-row" data-status="{{ $lead['status'] }}" data-priority="{{ $lead['priority'] }}" data-source="{{ $lead['source'] }}">
                                        <td>
                                            <div>
                                                <h6 class="mb-1">{{ $lead['company_name'] }}</h6>
                                                <p class="text-muted mb-0">{{ $lead['email'] }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <h6 class="mb-1">{{ $lead['contact_person'] }}</h6>
                                                <p class="text-muted mb-0">{{ $lead['phone'] ?? 'No phone' }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">{{ ucfirst(str_replace('_', ' ', $lead['source'])) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $lead['status'] === 'new' ? 'primary' : ($lead['status'] === 'qualified' ? 'success' : ($lead['status'] === 'converted' ? 'info' : 'warning')) }}-subtle text-{{ $lead['status'] === 'new' ? 'primary' : ($lead['status'] === 'qualified' ? 'success' : ($lead['status'] === 'converted' ? 'info' : 'warning')) }}">
                                                {{ ucfirst(str_replace('_', ' ', $lead['status'])) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $lead['priority'] === 'high' ? 'danger' : ($lead['priority'] === 'medium' ? 'warning' : 'secondary') }}-subtle text-{{ $lead['priority'] === 'high' ? 'danger' : ($lead['priority'] === 'medium' ? 'warning' : 'secondary') }}">
                                                {{ ucfirst($lead['priority']) }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong>${{ number_format($lead['estimated_value'], 0) }}</strong>
                                        </td>
                                        <td>{{ $lead['assigned_to'] }}</td>
                                        <td>
                                            <span class="text-{{ \Carbon\Carbon::parse($lead['next_followup'])->isPast() ? 'danger' : 'muted' }}">
                                                {{ \Carbon\Carbon::parse($lead['next_followup'])->format('M d, Y') }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="text-muted dropdown-toggle font-size-16" href="#" role="button" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#" onclick="viewLead({{ $lead['id'] }})">View Details</a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="editLead({{ $lead['id'] }})">Edit</a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="addActivity({{ $lead['id'] }})">Add Activity</a></li>
                                                    <li><a class="dropdown-item text-success" href="#" onclick="convertLead({{ $lead['id'] }})">Convert to Customer</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li><a class="dropdown-item text-danger" href="#" onclick="deleteLead({{ $lead['id'] }})">Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No leads found</h5>
                                            <p class="text-muted">Start building your lead pipeline by adding potential customers.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Lead Modal -->
<div class="modal fade" id="addLeadModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Lead</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addLeadForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Company Name *</label>
                                <input type="text" class="form-control" name="company_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Contact Person *</label>
                                <input type="text" class="form-control" name="contact_person" required>
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
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Source *</label>
                                <select class="form-select" name="source" required>
                                    <option value="">Select Source</option>
                                    <option value="website">Website</option>
                                    <option value="referral">Referral</option>
                                    <option value="trade_show">Trade Show</option>
                                    <option value="cold_call">Cold Call</option>
                                    <option value="social_media">Social Media</option>
                                    <option value="advertisement">Advertisement</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Priority *</label>
                                <select class="form-select" name="priority" required>
                                    <option value="">Select Priority</option>
                                    <option value="high">High</option>
                                    <option value="medium">Medium</option>
                                    <option value="low">Low</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Estimated Value</label>
                                <input type="number" class="form-control" name="estimated_value" min="0" step="0.01">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Products Interested</label>
                        <select class="form-select" name="products_interested[]" multiple>
                            <option value="Wireless Headphones">Wireless Headphones</option>
                            <option value="Smart Watches">Smart Watches</option>
                            <option value="Bluetooth Speakers">Bluetooth Speakers</option>
                            <option value="Phone Accessories">Phone Accessories</option>
                            <option value="Smart Home Devices">Smart Home Devices</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" name="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Lead</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Search and filter functionality
document.getElementById('searchLeads').addEventListener('input', filterLeads);
document.getElementById('filterStatus').addEventListener('change', filterLeads);
document.getElementById('filterPriority').addEventListener('change', filterLeads);
document.getElementById('filterSource').addEventListener('change', filterLeads);

function filterLeads() {
    const searchTerm = document.getElementById('searchLeads').value.toLowerCase();
    const statusFilter = document.getElementById('filterStatus').value;
    const priorityFilter = document.getElementById('filterPriority').value;
    const sourceFilter = document.getElementById('filterSource').value;
    
    const rows = document.querySelectorAll('.lead-row');
    
    rows.forEach(row => {
        const companyName = row.querySelector('h6').textContent.toLowerCase();
        const contactPerson = row.querySelectorAll('h6')[1].textContent.toLowerCase();
        const status = row.dataset.status;
        const priority = row.dataset.priority;
        const source = row.dataset.source;
        
        const matchesSearch = companyName.includes(searchTerm) || contactPerson.includes(searchTerm);
        const matchesStatus = !statusFilter || status === statusFilter;
        const matchesPriority = !priorityFilter || priority === priorityFilter;
        const matchesSource = !sourceFilter || source === sourceFilter;
        
        if (matchesSearch && matchesStatus && matchesPriority && matchesSource) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Lead actions
function viewLead(id) {
    console.log('View lead:', id);
    // Implementation for viewing lead details
}

function editLead(id) {
    console.log('Edit lead:', id);
    // Implementation for editing lead
}

function addActivity(id) {
    console.log('Add activity for lead:', id);
    // Implementation for adding activity
}

function convertLead(id) {
    if (confirm('Are you sure you want to convert this lead to a customer?')) {
        console.log('Convert lead:', id);
        // Implementation for converting lead
    }
}

function deleteLead(id) {
    if (confirm('Are you sure you want to delete this lead?')) {
        console.log('Delete lead:', id);
        // Implementation for deleting lead
    }
}

function exportLeads() {
    console.log('Export leads');
    // Implementation for exporting leads
}

// Add lead form
document.getElementById('addLeadForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    // Here you would typically send the data to your backend
    console.log('Adding lead:', Object.fromEntries(formData));
    
    // Close modal and reset form
    const modal = bootstrap.Modal.getInstance(document.getElementById('addLeadModal'));
    modal.hide();
    this.reset();
    
    // Show success message
    alert('Lead added successfully!');
});
</script>
@endpush