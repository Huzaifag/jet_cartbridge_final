<!-- Meeting Details Modal -->
<div id="meetingModal" class="modal fade" tabindex="-1" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 12px; border: none;">
            <div class="modal-header" style="background: #f8f9fa; border-bottom: 1px solid #e9ecef;">
                <h5 class="modal-title" style="font-weight: 600; color: #2c3e50;">
                    <i class="fas fa-calendar-alt me-2"></i>Meeting Details
                </h5>
                <button type="button" class="btn-close" onclick="closeMeetingModal()"></button>
            </div>
            
            <div class="modal-body" style="padding: 30px;">
                <div id="meetingContent">
                    <!-- Meeting content will be loaded here -->
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                
                <!-- Meeting Details Template (hidden, will be populated by JS) -->
                <div id="meetingTemplate" style="display: none;">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="meeting-info">
                                <h4 class="meeting-title" style="color: #2c3e50; margin-bottom: 10px;"></h4>
                                <p class="meeting-customer" style="color: #6c757d; margin-bottom: 20px;"></p>
                                
                                <div class="meeting-details-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 20px;">
                                    <div class="detail-item">
                                        <label style="font-weight: 600; color: #495057; font-size: 14px;">Date & Time</label>
                                        <p class="meeting-datetime" style="margin: 5px 0 0 0; color: #2c3e50;"></p>
                                    </div>
                                    <div class="detail-item">
                                        <label style="font-weight: 600; color: #495057; font-size: 14px;">Duration</label>
                                        <p class="meeting-duration" style="margin: 5px 0 0 0; color: #2c3e50;"></p>
                                    </div>
                                    <div class="detail-item">
                                        <label style="font-weight: 600; color: #495057; font-size: 14px;">Type</label>
                                        <p class="meeting-type" style="margin: 5px 0 0 0; color: #2c3e50;"></p>
                                    </div>
                                    <div class="detail-item">
                                        <label style="font-weight: 600; color: #495057; font-size: 14px;">Status</label>
                                        <p class="meeting-status" style="margin: 5px 0 0 0;"></p>
                                    </div>
                                </div>
                                
                                <div class="meeting-description" style="margin-bottom: 20px;">
                                    <label style="font-weight: 600; color: #495057; font-size: 14px;">Description</label>
                                    <p class="description-text" style="margin: 5px 0 0 0; color: #2c3e50; line-height: 1.5;"></p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="customer-card" style="background: #f8f9fa; border-radius: 8px; padding: 20px;">
                                <h6 style="font-weight: 600; color: #2c3e50; margin-bottom: 15px;">Customer Information</h6>
                                
                                <div class="customer-avatar" style="text-align: center; margin-bottom: 15px;">
                                    <img class="customer-photo" src="" alt="Customer" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                                </div>
                                
                                <div class="customer-details">
                                    <p class="customer-name" style="font-weight: 600; color: #2c3e50; margin-bottom: 5px; text-align: center;"></p>
                                    <p class="customer-email" style="color: #6c757d; font-size: 14px; margin-bottom: 10px; text-align: center;"></p>
                                    
                                    <div class="contact-actions" style="display: flex; gap: 8px; justify-content: center; margin-top: 15px;">
                                        <button class="btn btn-sm btn-success" onclick="callCustomerFromModal()">
                                            <i class="fas fa-phone"></i>
                                        </button>
                                        <button class="btn btn-sm btn-success" onclick="whatsappCustomerFromModal()" style="background: #25d366; border-color: #25d366;">
                                            <i class="fab fa-whatsapp"></i>
                                        </button>
                                        <button class="btn btn-sm btn-primary" onclick="emailCustomerFromModal()">
                                            <i class="fas fa-envelope"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Status Update Section -->
                    <div class="status-update-section" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e9ecef;">
                        <h6 style="font-weight: 600; color: #2c3e50; margin-bottom: 15px;">Update Meeting Status</h6>
                        
                        <form id="statusUpdateForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meetingStatus" style="font-weight: 600; color: #495057; font-size: 14px;">Status</label>
                                        <select id="meetingStatus" class="form-select" style="margin-top: 5px;">
                                            <option value="pending">Pending</option>
                                            <option value="confirmed">Confirmed</option>
                                            <option value="completed">Completed</option>
                                            <option value="cancelled">Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="appointmentType" style="font-weight: 600; color: #495057; font-size: 14px;">Appointment Type</label>
                                        <select id="appointmentType" class="form-select" style="margin-top: 5px;">
                                            <option value="physical">Physical</option>
                                            <option value="video">Video Call</option>
                                            <option value="no_appointment">No Appointment</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group" style="margin-top: 15px;">
                                <label for="meetingNotes" style="font-weight: 600; color: #495057; font-size: 14px;">Update Comments</label>
                                <textarea id="meetingNotes" class="form-control" rows="3" placeholder="Add notes about this meeting..." style="margin-top: 5px; resize: vertical;"></textarea>
                            </div>
                            
                            <div class="form-check" style="margin-top: 15px;">
                                <input type="checkbox" id="appointmentFixed" class="form-check-input">
                                <label for="appointmentFixed" class="form-check-label" style="color: #495057;">
                                    Appointment Fixed
                                </label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer" style="background: #f8f9fa; border-top: 1px solid #e9ecef; padding: 20px 30px;">
                <button type="button" class="btn btn-secondary" onclick="closeMeetingModal()">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateMeetingStatus()" style="background: #dc3545; border-color: #dc3545;">
                    <i class="fas fa-save me-2"></i>Update Meeting
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.modal {
    background: rgba(0,0,0,0.5);
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1050;
}

.modal-dialog {
    position: relative;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    max-width: 800px;
    width: 90%;
}

.modal-content {
    background: white;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

.status-badge {
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-badge.pending { background: #fff3cd; color: #856404; }
.status-badge.confirmed { background: #d4edda; color: #155724; }
.status-badge.completed { background: #d1ecf1; color: #0c5460; }
.status-badge.cancelled { background: #f8d7da; color: #721c24; }
</style>

<script>
let currentMeetingId = null;
let currentMeetingData = null;

function openMeetingModal(meetingId) {
    currentMeetingId = meetingId;
    document.getElementById('meetingModal').style.display = 'block';
    
    // Load meeting data
    fetch(`/admin/appointments/${meetingId}`)
        .then(response => response.json())
        .then(data => {
            currentMeetingData = data.meeting;
            populateMeetingModal(data.meeting);
        })
        .catch(error => {
            console.error('Error loading meeting:', error);
            document.getElementById('meetingContent').innerHTML = '<div class="alert alert-danger">Error loading meeting details</div>';
        });
}

function populateMeetingModal(meeting) {
    const template = document.getElementById('meetingTemplate');
    const content = document.getElementById('meetingContent');
    
    // Clone template
    const clone = template.cloneNode(true);
    clone.style.display = 'block';
    clone.id = '';
    
    // Populate data
    clone.querySelector('.meeting-title').textContent = meeting.title || 'Meeting';
    clone.querySelector('.meeting-customer').textContent = `Meeting with ${meeting.customer.name}`;
    clone.querySelector('.meeting-datetime').textContent = new Date(meeting.scheduled_at).toLocaleString();
    clone.querySelector('.meeting-duration').textContent = `${meeting.duration || 30} minutes`;
    clone.querySelector('.meeting-type').innerHTML = `<i class="fas fa-${meeting.meeting_type === 'video' ? 'video' : (meeting.meeting_type === 'call' ? 'phone' : 'map-marker-alt')}"></i> ${meeting.meeting_type.charAt(0).toUpperCase() + meeting.meeting_type.slice(1)}`;
    clone.querySelector('.meeting-status').innerHTML = `<span class="status-badge ${meeting.status.toLowerCase()}">${meeting.status}</span>`;
    clone.querySelector('.description-text').textContent = meeting.description || 'No description provided';
    
    // Customer info
    clone.querySelector('.customer-name').textContent = meeting.customer.name;
    clone.querySelector('.customer-email').textContent = meeting.customer.email;
    clone.querySelector('.customer-photo').src = meeting.customer.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(meeting.customer.name)}&background=007bff&color=ffffff&size=60`;
    
    // Set form values
    clone.querySelector('#meetingStatus').value = meeting.status;
    clone.querySelector('#meetingNotes').value = meeting.admin_notes || '';
    
    // Replace content
    content.innerHTML = '';
    content.appendChild(clone);
}

function closeMeetingModal() {
    document.getElementById('meetingModal').style.display = 'none';
    currentMeetingId = null;
    currentMeetingData = null;
}

function updateMeetingStatus() {
    if (!currentMeetingId) return;
    
    const status = document.getElementById('meetingStatus').value;
    const notes = document.getElementById('meetingNotes').value;
    const appointmentType = document.getElementById('appointmentType').value;
    
    fetch(`/admin/appointments/${currentMeetingId}/status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            status: status,
            notes: notes,
            appointment_type: appointmentType
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Meeting updated successfully!');
            closeMeetingModal();
            location.reload();
        } else {
            alert('Error updating meeting');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating meeting');
    });
}

function callCustomerFromModal() {
    if (currentMeetingData && currentMeetingData.customer.phone) {
        window.open(`tel:${currentMeetingData.customer.phone}`);
    }
}

function whatsappCustomerFromModal() {
    if (currentMeetingData && currentMeetingData.customer.phone) {
        const cleanPhone = currentMeetingData.customer.phone.replace(/[^\d]/g, '');
        window.open(`https://wa.me/${cleanPhone}`, '_blank');
    }
}

function emailCustomerFromModal() {
    if (currentMeetingData && currentMeetingData.customer.email) {
        window.open(`mailto:${currentMeetingData.customer.email}`);
    }
}

// Close modal when clicking outside
document.getElementById('meetingModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeMeetingModal();
    }
});
</script>