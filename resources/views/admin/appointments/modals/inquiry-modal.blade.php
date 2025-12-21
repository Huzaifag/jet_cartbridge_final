<!-- Inquiry Details Modal -->
<div id="inquiryModal" class="modal fade" tabindex="-1" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header" style="background: #f8f9fa; border-bottom: 1px solid #e9ecef;">
                <h5 class="modal-title" style="font-weight: 600; color: #2c3e50;">
                    <i class="fas fa-question-circle me-2"></i>Inquiry Details
                </h5>
                <button type="button" class="btn-close" onclick="closeInquiryModal()"></button>
            </div>
            
            <div class="modal-body" style="padding: 30px;">
                <div id="inquiryContent">
                    <!-- Inquiry content will be loaded here -->
                    <div class="text-center py-4">
                        <div class="spinner-border text-success" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                
                <!-- Inquiry Details Template (hidden, will be populated by JS) -->
                <div id="inquiryTemplate" style="display: none;">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="inquiry-info">
                                <h4 class="inquiry-title" style="color: #2c3e50; margin-bottom: 10px;"></h4>
                                <p class="inquiry-product" style="color: #6c757d; margin-bottom: 20px;"></p>
                                
                                <div class="inquiry-details-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
                                    <div class="detail-item">
                                        <label style="font-weight: 600; color: #495057; font-size: 14px;">Date Submitted</label>
                                        <p class="inquiry-date" style="margin: 5px 0 0 0; color: #2c3e50;"></p>
                                    </div>
                                    <div class="detail-item">
                                        <label style="font-weight: 600; color: #495057; font-size: 14px;">Inquiry Type</label>
                                        <p class="inquiry-type" style="margin: 5px 0 0 0; color: #2c3e50;"></p>
                                    </div>
                                    <div class="detail-item">
                                        <label style="font-weight: 600; color: #495057; font-size: 14px;">Priority</label>
                                        <p class="inquiry-priority" style="margin: 5px 0 0 0;"></p>
                                    </div>
                                    <div class="detail-item">
                                        <label style="font-weight: 600; color: #495057; font-size: 14px;">Status</label>
                                        <p class="inquiry-status" style="margin: 5px 0 0 0;"></p>
                                    </div>
                                </div>
                                
                                <div class="inquiry-message" style="margin-bottom: 20px;">
                                    <label style="font-weight: 600; color: #495057; font-size: 14px;">Customer Message</label>
                                    <div class="message-text" style="margin: 10px 0; padding: 15px; background: #f8f9fa; border-radius: 8px; color: #2c3e50; line-height: 1.5;"></div>
                                </div>
                                
                                <div class="product-info" style="margin-bottom: 20px; padding: 15px; background: #e3f2fd; border-radius: 8px;">
                                    <label style="font-weight: 600; color: #495057; font-size: 14px; margin-bottom: 10px; display: block;">Product Information</label>
                                    <div class="product-details" style="display: flex; gap: 15px; align-items: center;">
                                        <img class="product-image" src="" alt="Product" style="width: 60px; height: 60px; border-radius: 8px; object-fit: cover;">
                                        <div>
                                            <h6 class="product-name" style="margin: 0 0 5px 0; color: #2c3e50;"></h6>
                                            <p class="product-price" style="margin: 0; color: #28a745; font-weight: 600;"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="customer-card" style="background: #f8f9fa; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                                <h6 style="font-weight: 600; color: #2c3e50; margin-bottom: 15px;">Customer Information</h6>
                                
                                <div class="customer-avatar" style="text-align: center; margin-bottom: 15px;">
                                    <img class="customer-photo" src="" alt="Customer" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                                </div>
                                
                                <div class="customer-details">
                                    <p class="customer-name" style="font-weight: 600; color: #2c3e50; margin-bottom: 5px; text-align: center;"></p>
                                    <p class="customer-email" style="color: #6c757d; font-size: 14px; margin-bottom: 5px; text-align: center;"></p>
                                    <p class="customer-phone" style="color: #6c757d; font-size: 14px; margin-bottom: 15px; text-align: center;"></p>
                                    
                                    <div class="contact-actions" style="display: flex; gap: 8px; justify-content: center;">
                                        <button class="btn btn-sm btn-success" onclick="callCustomerFromInquiry()">
                                            <i class="fas fa-phone"></i>
                                        </button>
                                        <button class="btn btn-sm btn-success" onclick="whatsappCustomerFromInquiry()" style="background: #25d366; border-color: #25d366;">
                                            <i class="fab fa-whatsapp"></i>
                                        </button>
                                        <button class="btn btn-sm btn-primary" onclick="emailCustomerFromInquiry()">
                                            <i class="fas fa-envelope"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Quick Actions -->
                            <div class="quick-actions" style="background: #fff3cd; border-radius: 8px; padding: 15px;">
                                <h6 style="font-weight: 600; color: #856404; margin-bottom: 15px;">Quick Actions</h6>
                                <div class="d-grid gap-2">
                                    <button class="btn btn-sm btn-primary" onclick="scheduleMeetingFromInquiry()">
                                        <i class="fas fa-calendar-plus me-2"></i>Schedule Meeting
                                    </button>
                                    <button class="btn btn-sm btn-info" onclick="convertToLead()">
                                        <i class="fas fa-user-plus me-2"></i>Convert to Lead
                                    </button>
                                    <button class="btn btn-sm btn-warning" onclick="assignToSeller()">
                                        <i class="fas fa-user-tag me-2"></i>Assign to Seller
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Status Update Section -->
                    <div class="status-update-section" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e9ecef;">
                        <h6 style="font-weight: 600; color: #2c3e50; margin-bottom: 15px;">Update Inquiry Status</h6>
                        
                        <form id="inquiryStatusUpdateForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inquiryStatus" style="font-weight: 600; color: #495057; font-size: 14px;">Status</label>
                                        <select id="inquiryStatus" class="form-select" style="margin-top: 5px;">
                                            <option value="pending">Pending</option>
                                            <option value="in_progress">In Progress</option>
                                            <option value="resolved">Resolved</option>
                                            <option value="closed">Closed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inquiryPriority" style="font-weight: 600; color: #495057; font-size: 14px;">Priority</label>
                                        <select id="inquiryPriority" class="form-select" style="margin-top: 5px;">
                                            <option value="low">Low</option>
                                            <option value="medium">Medium</option>
                                            <option value="high">High</option>
                                            <option value="urgent">Urgent</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group" style="margin-top: 15px;">
                                <label for="inquiryNotes" style="font-weight: 600; color: #495057; font-size: 14px;">Admin Notes</label>
                                <textarea id="inquiryNotes" class="form-control" rows="3" placeholder="Add notes about this inquiry..." style="margin-top: 5px; resize: vertical;"></textarea>
                            </div>
                            
                            <div class="form-group" style="margin-top: 15px;">
                                <label for="followUpDate" style="font-weight: 600; color: #495057; font-size: 14px;">Follow-up Date</label>
                                <input type="datetime-local" id="followUpDate" class="form-control" style="margin-top: 5px;">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer" style="background: #f8f9fa; border-top: 1px solid #e9ecef; padding: 20px 30px;">
                <button type="button" class="btn btn-secondary" onclick="closeInquiryModal()">Close</button>
                <button type="button" class="btn btn-success" onclick="updateInquiryStatus()">
                    <i class="fas fa-save me-2"></i>Update Inquiry
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.priority-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
}

.priority-badge.low { background: #d1ecf1; color: #0c5460; }
.priority-badge.medium { background: #fff3cd; color: #856404; }
.priority-badge.high { background: #f8d7da; color: #721c24; }
.priority-badge.urgent { background: #721c24; color: white; }

.status-badge.in_progress { background: #cce5ff; color: #004085; }
.status-badge.resolved { background: #d4edda; color: #155724; }
.status-badge.closed { background: #e2e3e5; color: #383d41; }
</style>

<script>
let currentInquiryId = null;
let currentInquiryData = null;

function openInquiryModal(inquiryId) {
    currentInquiryId = inquiryId;
    document.getElementById('inquiryModal').style.display = 'block';
    
    // Load inquiry data
    fetch(`/admin/inquiries/${inquiryId}`)
        .then(response => response.json())
        .then(data => {
            currentInquiryData = data.inquiry;
            populateInquiryModal(data.inquiry);
        })
        .catch(error => {
            console.error('Error loading inquiry:', error);
            document.getElementById('inquiryContent').innerHTML = '<div class="alert alert-danger">Error loading inquiry details</div>';
        });
}

function populateInquiryModal(inquiry) {
    const template = document.getElementById('inquiryTemplate');
    const content = document.getElementById('inquiryContent');
    
    // Clone template
    const clone = template.cloneNode(true);
    clone.style.display = 'block';
    clone.id = '';
    
    // Populate data
    clone.querySelector('.inquiry-title').textContent = `Inquiry from ${inquiry.user.name}`;
    clone.querySelector('.inquiry-product').textContent = inquiry.product ? `About: ${inquiry.product.name}` : 'General Inquiry';
    clone.querySelector('.inquiry-date').textContent = new Date(inquiry.created_at).toLocaleString();
    clone.querySelector('.inquiry-type').textContent = (inquiry.inquiry_type || 'general').charAt(0).toUpperCase() + (inquiry.inquiry_type || 'general').slice(1);
    clone.querySelector('.inquiry-priority').innerHTML = `<span class="priority-badge ${inquiry.priority || 'medium'}">${inquiry.priority || 'medium'}</span>`;
    clone.querySelector('.inquiry-status').innerHTML = `<span class="status-badge ${inquiry.status.toLowerCase()}">${inquiry.status}</span>`;
    clone.querySelector('.message-text').textContent = inquiry.message || 'No message provided';
    
    // Product info
    if (inquiry.product) {
        clone.querySelector('.product-image').src = inquiry.product.image_url || 'https://via.placeholder.com/60x60?text=Product';
        clone.querySelector('.product-name').textContent = inquiry.product.name;
        clone.querySelector('.product-price').textContent = inquiry.product.formatted_price || 'Price on request';
    } else {
        clone.querySelector('.product-info').style.display = 'none';
    }
    
    // Customer info
    clone.querySelector('.customer-name').textContent = inquiry.user.name;
    clone.querySelector('.customer-email').textContent = inquiry.user.email;
    clone.querySelector('.customer-phone').textContent = inquiry.user.phone || 'No phone provided';
    clone.querySelector('.customer-photo').src = inquiry.user.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(inquiry.user.name)}&background=28a745&color=ffffff&size=60`;
    
    // Set form values
    clone.querySelector('#inquiryStatus').value = inquiry.status;
    clone.querySelector('#inquiryPriority').value = inquiry.priority || 'medium';
    clone.querySelector('#inquiryNotes').value = inquiry.admin_notes || '';
    
    // Replace content
    content.innerHTML = '';
    content.appendChild(clone);
}

function closeInquiryModal() {
    document.getElementById('inquiryModal').style.display = 'none';
    currentInquiryId = null;
    currentInquiryData = null;
}

function updateInquiryStatus() {
    if (!currentInquiryId) return;
    
    const status = document.getElementById('inquiryStatus').value;
    const priority = document.getElementById('inquiryPriority').value;
    const notes = document.getElementById('inquiryNotes').value;
    const followUpDate = document.getElementById('followUpDate').value;
    
    fetch(`/admin/inquiries/${currentInquiryId}/status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            status: status,
            priority: priority,
            admin_notes: notes,
            follow_up_date: followUpDate
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Inquiry updated successfully!');
            closeInquiryModal();
            location.reload();
        } else {
            alert('Error updating inquiry');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating inquiry');
    });
}

function callCustomerFromInquiry() {
    if (currentInquiryData && currentInquiryData.user.phone) {
        window.open(`tel:${currentInquiryData.user.phone}`);
    }
}

function whatsappCustomerFromInquiry() {
    if (currentInquiryData && currentInquiryData.user.phone) {
        const cleanPhone = currentInquiryData.user.phone.replace(/[^\d]/g, '');
        window.open(`https://wa.me/${cleanPhone}`, '_blank');
    }
}

function emailCustomerFromInquiry() {
    if (currentInquiryData && currentInquiryData.user.email) {
        window.open(`mailto:${currentInquiryData.user.email}`);
    }
}

function scheduleMeetingFromInquiry() {
    // Open create meeting modal with pre-filled customer data
    if (currentInquiryData) {
        openCreateModal();
        // Pre-fill customer data in create modal
        setTimeout(() => {
            document.getElementById('customerSelect').value = currentInquiryData.user.id;
        }, 100);
    }
}

function convertToLead() {
    if (!currentInquiryId) return;
    
    if (confirm('Convert this inquiry to a lead?')) {
        fetch(`/admin/inquiries/${currentInquiryId}/convert-to-lead`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Inquiry converted to lead successfully!');
                closeInquiryModal();
                location.reload();
            } else {
                alert('Error converting inquiry to lead');
            }
        });
    }
}

function assignToSeller() {
    // Open seller assignment modal
    alert('Seller assignment feature coming soon!');
}

// Close modal when clicking outside
document.getElementById('inquiryModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeInquiryModal();
    }
});
</script>