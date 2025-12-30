@extends('manufacturer.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Notifications</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('manufacturer.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Notifications</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Statistics -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <p class="text-truncate font-size-14 mb-2">Total Notifications</p>
                            <h4 class="mb-2">{{ $notificationStats['total_notifications'] ?? 0 }}</h4>
                            <p class="text-muted mb-0">
                                <span class="text-info fw-bold font-size-12 me-2">
                                    <i class="ri-arrow-right-up-line me-1 align-middle"></i>
                                    All time
                                </span>
                            </p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-primary-subtle text-primary rounded-3">
                                <i class="fas fa-bell font-size-24"></i>
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
                            <p class="text-truncate font-size-14 mb-2">Unread</p>
                            <h4 class="mb-2">{{ $notificationStats['unread_count'] ?? 0 }}</h4>
                            <p class="text-muted mb-0">
                                <span class="text-warning fw-bold font-size-12 me-2">
                                    <i class="ri-arrow-right-up-line me-1 align-middle"></i>
                                    Needs attention
                                </span>
                            </p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-warning-subtle text-warning rounded-3">
                                <i class="fas fa-exclamation-circle font-size-24"></i>
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
                            <p class="text-truncate font-size-14 mb-2">High Priority</p>
                            <h4 class="mb-2">{{ $notificationStats['high_priority'] ?? 0 }}</h4>
                            <p class="text-muted mb-0">
                                <span class="text-danger fw-bold font-size-12 me-2">
                                    <i class="ri-arrow-right-up-line me-1 align-middle"></i>
                                    Urgent
                                </span>
                            </p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-danger-subtle text-danger rounded-3">
                                <i class="fas fa-exclamation-triangle font-size-24"></i>
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
                            <p class="text-truncate font-size-14 mb-2">Today</p>
                            <h4 class="mb-2">{{ $notificationStats['today_count'] ?? 0 }}</h4>
                            <p class="text-muted mb-0">
                                <span class="text-success fw-bold font-size-12 me-2">
                                    <i class="ri-arrow-right-up-line me-1 align-middle"></i>
                                    Recent activity
                                </span>
                            </p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-success-subtle text-success rounded-3">
                                <i class="fas fa-calendar-day font-size-24"></i>
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
                            <select class="form-select" id="filterType">
                                <option value="">All Types</option>
                                <option value="order">Orders</option>
                                <option value="inquiry">Inquiries</option>
                                <option value="inventory">Inventory</option>
                                <option value="promotion">Promotions</option>
                                <option value="payment">Payments</option>
                                <option value="system">System</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="filterReadStatus">
                                <option value="">All Status</option>
                                <option value="unread">Unread</option>
                                <option value="read">Read</option>
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
                        <div class="col-md-5">
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-success" onclick="markAllAsRead()">
                                    <i class="fas fa-check-double me-1"></i> Mark All Read
                                </button>
                                <button type="button" class="btn btn-warning" onclick="deleteAll()">
                                    <i class="fas fa-trash me-1"></i> Delete All
                                </button>
                                <button type="button" class="btn btn-info" onclick="exportNotifications()">
                                    <i class="fas fa-download me-1"></i> Export
                                </button>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#preferencesModal">
                                    <i class="fas fa-cog me-1"></i> Preferences
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications List -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="notification-list">
                        @forelse($notifications ?? [] as $notification)
                            <div class="notification-item {{ $notification['read_at'] ? 'read' : 'unread' }}" 
                                 data-type="{{ $notification['type'] }}" 
                                 data-priority="{{ $notification['priority'] }}"
                                 data-read-status="{{ $notification['read_at'] ? 'read' : 'unread' }}">
                                <div class="d-flex">
                                    <div class="notification-icon me-3">
                                        <div class="avatar-sm">
                                            <span class="avatar-title bg-{{ $notification['type'] === 'order' ? 'success' : ($notification['type'] === 'inquiry' ? 'info' : ($notification['type'] === 'inventory' ? 'warning' : ($notification['type'] === 'promotion' ? 'primary' : ($notification['type'] === 'payment' ? 'success' : 'secondary')))) }}-subtle text-{{ $notification['type'] === 'order' ? 'success' : ($notification['type'] === 'inquiry' ? 'info' : ($notification['type'] === 'inventory' ? 'warning' : ($notification['type'] === 'promotion' ? 'primary' : ($notification['type'] === 'payment' ? 'success' : 'secondary')))) }} rounded-circle">
                                                <i class="fas fa-{{ $notification['type'] === 'order' ? 'shopping-cart' : ($notification['type'] === 'inquiry' ? 'question-circle' : ($notification['type'] === 'inventory' ? 'boxes' : ($notification['type'] === 'promotion' ? 'tags' : ($notification['type'] === 'payment' ? 'credit-card' : 'cog')))) }}"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="notification-content flex-1">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="notification-title mb-0">{{ $notification['title'] }}</h6>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge bg-{{ $notification['priority'] === 'high' ? 'danger' : ($notification['priority'] === 'medium' ? 'warning' : 'secondary') }}-subtle text-{{ $notification['priority'] === 'high' ? 'danger' : ($notification['priority'] === 'medium' ? 'warning' : 'secondary') }}">
                                                    {{ ucfirst($notification['priority']) }}
                                                </span>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($notification['created_at'])->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                        <p class="notification-message mb-2">{{ $notification['message'] }}</p>
                                        @if(isset($notification['data']) && is_array($notification['data']))
                                            <div class="notification-data">
                                                @foreach($notification['data'] as $key => $value)
                                                    <span class="badge bg-light text-dark me-1">{{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <div class="notification-actions ms-3">
                                        <div class="dropdown">
                                            <a class="text-muted dropdown-toggle font-size-16" href="#" role="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                @if(!$notification['read_at'])
                                                    <li><a class="dropdown-item" href="#" onclick="markAsRead({{ $notification['id'] }})">Mark as Read</a></li>
                                                @endif
                                                @if($notification['action_url'])
                                                    <li><a class="dropdown-item" href="{{ $notification['action_url'] }}">View Details</a></li>
                                                @endif
                                                <li><a class="dropdown-item text-danger" href="#" onclick="deleteNotification({{ $notification['id'] }})">Delete</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No notifications found</h5>
                                <p class="text-muted">You're all caught up! New notifications will appear here.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Notification Preferences Modal -->
<div class="modal fade" id="preferencesModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Notification Preferences</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="preferencesForm">
                <div class="modal-body">
                    <div class="mb-4">
                        <h6 class="mb-3">Delivery Methods</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="emailNotifications" name="email_notifications" checked>
                            <label class="form-check-label" for="emailNotifications">
                                Email Notifications
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="smsNotifications" name="sms_notifications">
                            <label class="form-check-label" for="smsNotifications">
                                SMS Notifications
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="pushNotifications" name="push_notifications" checked>
                            <label class="form-check-label" for="pushNotifications">
                                Push Notifications
                            </label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="mb-3">Notification Types</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="orderNotifications" name="notification_types[]" value="order" checked>
                            <label class="form-check-label" for="orderNotifications">
                                Order Notifications
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="inquiryNotifications" name="notification_types[]" value="inquiry" checked>
                            <label class="form-check-label" for="inquiryNotifications">
                                Inquiry Notifications
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="inventoryNotifications" name="notification_types[]" value="inventory" checked>
                            <label class="form-check-label" for="inventoryNotifications">
                                Inventory Alerts
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="promotionNotifications" name="notification_types[]" value="promotion">
                            <label class="form-check-label" for="promotionNotifications">
                                Promotion Updates
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="paymentNotifications" name="notification_types[]" value="payment" checked>
                            <label class="form-check-label" for="paymentNotifications">
                                Payment Notifications
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="systemNotifications" name="notification_types[]" value="system">
                            <label class="form-check-label" for="systemNotifications">
                                System Notifications
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h6 class="mb-3">Quiet Hours</h6>
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Start Time</label>
                                <input type="time" class="form-control" name="quiet_hours_start" value="22:00">
                            </div>
                            <div class="col-6">
                                <label class="form-label">End Time</label>
                                <input type="time" class="form-control" name="quiet_hours_end" value="08:00">
                            </div>
                        </div>
                        <small class="text-muted">No notifications will be sent during quiet hours</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-info" onclick="sendTestNotification()">Send Test</button>
                    <button type="submit" class="btn btn-primary">Save Preferences</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.notification-list {
    max-height: 600px;
    overflow-y: auto;
}

.notification-item {
    padding: 15px;
    border-bottom: 1px solid #f0f0f0;
    transition: background-color 0.2s;
}

.notification-item:hover {
    background-color: #f8f9fa;
}

.notification-item.unread {
    background-color: #f8f9ff;
    border-left: 3px solid #007bff;
}

.notification-item.read {
    opacity: 0.8;
}

.notification-title {
    font-size: 14px;
    font-weight: 600;
}

.notification-message {
    font-size: 13px;
    color: #6c757d;
    margin: 0;
}

.notification-data .badge {
    font-size: 10px;
}

.search-icon {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
}
</style>
@endsection

@push('scripts')
<script>
// Filter functionality
document.getElementById('filterType').addEventListener('change', filterNotifications);
document.getElementById('filterReadStatus').addEventListener('change', filterNotifications);
document.getElementById('filterPriority').addEventListener('change', filterNotifications);

function filterNotifications() {
    const typeFilter = document.getElementById('filterType').value;
    const readStatusFilter = document.getElementById('filterReadStatus').value;
    const priorityFilter = document.getElementById('filterPriority').value;
    
    const notifications = document.querySelectorAll('.notification-item');
    
    notifications.forEach(notification => {
        const type = notification.dataset.type;
        const readStatus = notification.dataset.readStatus;
        const priority = notification.dataset.priority;
        
        const matchesType = !typeFilter || type === typeFilter;
        const matchesReadStatus = !readStatusFilter || readStatus === readStatusFilter;
        const matchesPriority = !priorityFilter || priority === priorityFilter;
        
        if (matchesType && matchesReadStatus && matchesPriority) {
            notification.style.display = 'block';
        } else {
            notification.style.display = 'none';
        }
    });
}

// Notification actions
function markAsRead(id) {
    console.log('Mark as read:', id);
    // Implementation for marking notification as read
}

function markAllAsRead() {
    if (confirm('Are you sure you want to mark all notifications as read?')) {
        console.log('Mark all as read');
        // Implementation for marking all notifications as read
    }
}

function deleteNotification(id) {
    if (confirm('Are you sure you want to delete this notification?')) {
        console.log('Delete notification:', id);
        // Implementation for deleting notification
    }
}

function deleteAll() {
    if (confirm('Are you sure you want to delete all notifications? This action cannot be undone.')) {
        console.log('Delete all notifications');
        // Implementation for deleting all notifications
    }
}

function exportNotifications() {
    console.log('Export notifications');
    // Implementation for exporting notifications
}

function sendTestNotification() {
    console.log('Send test notification');
    // Implementation for sending test notification
}

// Preferences form
document.getElementById('preferencesForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    // Here you would typically send the data to your backend
    console.log('Updating preferences:', Object.fromEntries(formData));
    
    // Close modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('preferencesModal'));
    modal.hide();
    
    // Show success message
    alert('Notification preferences updated successfully!');
});

// Auto-refresh notifications every 30 seconds
setInterval(function() {
    // Here you would fetch new notifications from your backend
    console.log('Checking for new notifications...');
}, 30000);
</script>
@endpush