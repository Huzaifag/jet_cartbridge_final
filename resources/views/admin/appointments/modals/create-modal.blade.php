<!-- Create Meeting Modal -->
<div id="createModal" class="modal fade" tabindex="-1" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header" style="background: #f8f9fa; border-bottom: 1px solid #e9ecef;">
                <h5 class="modal-title" style="font-weight: 600; color: #2c3e50;">
                    <i class="fas fa-calendar-plus me-2"></i>Schedule New Meeting
                </h5>
                <button type="button" class="btn-close" onclick="closeCreateModal()"></button>
            </div>
            
            <form id="createMeetingForm">
                <div class="modal-body" style="padding: 30px;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="customerSelect" style="font-weight: 600; color: #495057; font-size: 14px;">Customer *</label>
                                <select id="customerSelect" name="customer_id" class="form-select" required style="margin-top: 5px;">
                                    <option value="">Search and select customer...</option>
                                </select>
                                <div class="customer-search-results" style="display: none; position: absolute; z-index: 1000; background: white; border: 1px solid #ddd; border-radius: 4px; max-height: 200px; overflow-y: auto; width: 100%;"></div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="meetingTitle" style="font-weight: 600; color: #495057; font-size: 14px;">Meeting Title *</label>
                                <input type="text" id="meetingTitle" name="title" class="form-control" required placeholder="e.g., Product Discussion" style="margin-top: 5px;">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="meetingDate" style="font-weight: 600; color: #495057; font-size: 14px;">Date & Time *</label>
                                <input type="datetime-local" id="meetingDate" name="scheduled_at" class="form-control" required style="margin-top: 5px;">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="meetingDuration" style="font-weight: 600; color: #495057; font-size: 14px;">Duration (minutes) *</label>
                                <select id="meetingDuration" name="duration" class="form-select" required style="margin-top: 5px;">
                                    <option value="15">15 minutes</option>
                                    <option value="30" selected>30 minutes</option>
                                    <option value="45">45 minutes</option>
                                    <option value="60">1 hour</option>
                                    <option value="90">1.5 hours</option>
                                    <option value="120">2 hours</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="meetingType" style="font-weight: 600; color: #495057; font-size: 14px;">Meeting Type *</label>
                                <select id="meetingType" name="meeting_type" class="form-select" required style="margin-top: 5px;">
                                    <option value="physical">Physical Meeting</option>
                                    <option value="video">Video Call</option>
                                    <option value="call">Phone Call</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="assignTo" style="font-weight: 600; color: #495057; font-size: 14px;">Assign To</label>
                                <select id="assignTo" name="assigned_to" class="form-select" style="margin-top: 5px;">
                                    <option value="">Select seller/manufacturer...</option>
                                    <option value="seller_1">ABC Company (Seller)</option>
                                    <option value="manufacturer_1">XYZ Manufacturing (Manufacturer)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="meetingDescription" style="font-weight: 600; color: #495057; font-size: 14px;">Description</label>
                        <textarea id="meetingDescription" name="description" class="form-control" rows="3" placeholder="Meeting agenda, topics to discuss..." style="margin-top: 5px; resize: vertical;"></textarea>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="meetingLocation" style="font-weight: 600; color: #495057; font-size: 14px;">Location/Meeting Link</label>
                        <input type="text" id="meetingLocation" name="location" class="form-control" placeholder="Office address or video call link" style="margin-top: 5px;">
                    </div>
                    
                    <!-- Meeting Type Specific Fields -->
                    <div id="physicalMeetingFields" style="display: none;">
                        <div class="alert alert-info" style="margin-top: 15px;">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <strong>Physical Meeting:</strong> Please provide the meeting location above.
                        </div>
                    </div>
                    
                    <div id="videoMeetingFields" style="display: none;">
                        <div class="alert alert-primary" style="margin-top: 15px;">
                            <i class="fas fa-video me-2"></i>
                            <strong>Video Call:</strong> Meeting link will be generated automatically or provide custom link above.
                        </div>
                    </div>
                    
                    <div id="callMeetingFields" style="display: none;">
                        <div class="alert alert-success" style="margin-top: 15px;">
                            <i class="fas fa-phone me-2"></i>
                            <strong>Phone Call:</strong> Customer will be contacted via phone at the scheduled time.
                        </div>
                    </div>
                    
                    <!-- Notification Settings -->
                    <div class="notification-settings" style="margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px;">
                        <h6 style="font-weight: 600; color: #2c3e50; margin-bottom: 15px;">Notification Settings</h6>
                        
                        <div class="form-check mb-2">
                            <input type="checkbox" id="notifyCustomer" name="notify_customer" class="form-check-input" checked>
                            <label for="notifyCustomer" class="form-check-label">Send email notification to customer</label>
                        </div>
                        
                        <div class="form-check mb-2">
                            <input type="checkbox" id="notifySeller" name="notify_seller" class="form-check-input" checked>
                            <label for="notifySeller" class="form-check-label">Send notification to assigned seller/manufacturer</label>
                        </div>
                        
                        <div class="form-check mb-2">
                            <input type="checkbox" id="addToCalendar" name="add_to_calendar" class="form-check-input" checked>
                            <label for="addToCalendar" class="form-check-label">Add to calendar</label>
                        </div>
                        
                        <div class="form-check">
                            <input type="checkbox" id="sendReminder" name="send_reminder" class="form-check-input" checked>
                            <label for="sendReminder" class="form-check-label">Send reminder 1 hour before meeting</label>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer" style="background: #f8f9fa; border-top: 1px solid #e9ecef; padding: 20px 30px;">
                    <button type="button" class="btn btn-secondary" onclick="closeCreateModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-calendar-plus me-2"></i>Schedule Meeting
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.customer-search-item {
    padding: 10px 15px;
    cursor: pointer;
    border-bottom: 1px solid #eee;
    transition: background-color 0.2s;
}

.customer-search-item:hover {
    background-color: #f8f9fa;
}

.customer-search-item:last-child {
    border-bottom: none;
}

.customer-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

.customer-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
}

.customer-details h6 {
    margin: 0;
    font-size: 14px;
    font-weight: 600;
    color: #2c3e50;
}

.customer-details p {
    margin: 0;
    font-size: 12px;
    color: #6c757d;
}
</style>

<script>
let customerSearchTimeout;

function openCreateModal() {
    document.getElementById('createModal').style.display = 'block';
    
    // Set default date to tomorrow at 10 AM
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    tomorrow.setHours(10, 0, 0, 0);
    document.getElementById('meetingDate').value = tomorrow.toISOString().slice(0, 16);
    
    // Setup customer search
    setupCustomerSearch();
    
    // Setup meeting type change handler
    document.getElementById('meetingType').addEventListener('change', handleMeetingTypeChange);
    handleMeetingTypeChange(); // Initial call
}

function closeCreateModal() {
    document.getElementById('createModal').style.display = 'none';
    document.getElementById('createMeetingForm').reset();
}

function setupCustomerSearch() {
    const customerSelect = document.getElementById('customerSelect');
    const searchResults = document.querySelector('.customer-search-results');
    
    // Convert select to searchable input
    customerSelect.style.display = 'none';
    
    // Create search input
    const searchInput = document.createElement('input');
    searchInput.type = 'text';
    searchInput.className = 'form-control';
    searchInput.placeholder = 'Type customer name or email...';
    searchInput.style.marginTop = '5px';
    
    customerSelect.parentNode.insertBefore(searchInput, customerSelect.nextSibling);
    
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        if (query.length < 2) {
            searchResults.style.display = 'none';
            return;
        }
        
        clearTimeout(customerSearchTimeout);
        customerSearchTimeout = setTimeout(() => {
            searchCustomers(query);
        }, 300);
    });
    
    searchInput.addEventListener('focus', function() {
        if (this.value.length >= 2) {
            searchResults.style.display = 'block';
        }
    });
    
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.style.display = 'none';
        }
    });
}

function searchCustomers(query) {
    fetch(`/admin/appointments/search-customers?q=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(customers => {
            displayCustomerResults(customers);
        })
        .catch(error => {
            console.error('Error searching customers:', error);
        });
}

function displayCustomerResults(customers) {
    const searchResults = document.querySelector('.customer-search-results');
    
    if (customers.length === 0) {
        searchResults.innerHTML = '<div style="padding: 15px; text-align: center; color: #6c757d;">No customers found</div>';
    } else {
        searchResults.innerHTML = customers.map(customer => `
            <div class="customer-search-item" onclick="selectCustomer(${customer.id}, '${customer.name}', '${customer.email}')">
                <div class="customer-info">
                    <img class="customer-avatar" src="https://ui-avatars.com/api/?name=${encodeURIComponent(customer.name)}&background=007bff&color=ffffff&size=32" alt="${customer.name}">
                    <div class="customer-details">
                        <h6>${customer.name}</h6>
                        <p>${customer.email}</p>
                    </div>
                </div>
            </div>
        `).join('');
    }
    
    searchResults.style.display = 'block';
}

function selectCustomer(id, name, email) {
    const customerSelect = document.getElementById('customerSelect');
    const searchInput = customerSelect.nextSibling;
    const searchResults = document.querySelector('.customer-search-results');
    
    // Set the selected customer
    customerSelect.innerHTML = `<option value="${id}" selected>${name} (${email})</option>`;
    searchInput.value = `${name} (${email})`;
    searchResults.style.display = 'none';
}

function handleMeetingTypeChange() {
    const meetingType = document.getElementById('meetingType').value;
    const physicalFields = document.getElementById('physicalMeetingFields');
    const videoFields = document.getElementById('videoMeetingFields');
    const callFields = document.getElementById('callMeetingFields');
    
    // Hide all fields first
    physicalFields.style.display = 'none';
    videoFields.style.display = 'none';
    callFields.style.display = 'none';
    
    // Show relevant fields
    switch (meetingType) {
        case 'physical':
            physicalFields.style.display = 'block';
            document.getElementById('meetingLocation').placeholder = 'Meeting address';
            break;
        case 'video':
            videoFields.style.display = 'block';
            document.getElementById('meetingLocation').placeholder = 'Video call link (optional)';
            break;
        case 'call':
            callFields.style.display = 'block';
            document.getElementById('meetingLocation').placeholder = 'Phone number (optional)';
            break;
    }
}

// Handle form submission
document.getElementById('createMeetingForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    
    // Add checkboxes (they won't be in FormData if unchecked)
    data.notify_customer = document.getElementById('notifyCustomer').checked;
    data.notify_seller = document.getElementById('notifySeller').checked;
    data.add_to_calendar = document.getElementById('addToCalendar').checked;
    data.send_reminder = document.getElementById('sendReminder').checked;
    
    fetch('/admin/appointments/create', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            alert('Meeting scheduled successfully!');
            closeCreateModal();
            location.reload();
        } else {
            alert('Error scheduling meeting: ' + (result.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error scheduling meeting');
    });
});

// Close modal when clicking outside
document.getElementById('createModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCreateModal();
    }
});
</script>