@extends('admin.layouts.app')

@push('styles')
<style>
.appointment-dashboard {
    background: #f8f9fa;
    min-height: 100vh;
}

.appointment-header {
    background: white;
    border-bottom: 1px solid #e9ecef;
    padding: 20px 0;
    margin-bottom: 20px;
}

.appointment-title {
    font-size: 28px;
    font-weight: 600;
    color: #2c3e50;
    margin: 0;
}

.appointment-subtitle {
    color: #6c757d;
    margin: 5px 0 0 0;
}

.stats-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-left: 4px solid #007bff;
    transition: transform 0.2s;
}

.stat-card:hover {
    transform: translateY(-2px);
}

.stat-card.meetings { border-left-color: #007bff; }
.stat-card.inquiries { border-left-color: #28a745; }
.stat-card.chats { border-left-color: #ffc107; }
.stat-card.completed { border-left-color: #6f42c1; }

.stat-number {
    font-size: 32px;
    font-weight: 700;
    color: #2c3e50;
    margin: 0;
}

.stat-label {
    color: #6c757d;
    font-size: 14px;
    margin: 5px 0 0 0;
}

.calendar-week {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.week-navigation {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.week-title {
    font-size: 18px;
    font-weight: 600;
    color: #2c3e50;
}

.nav-btn {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 8px 12px;
    cursor: pointer;
    transition: all 0.2s;
}

.nav-btn:hover {
    background: #e9ecef;
}

.week-days {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 10px;
}

.day-card {
    text-align: center;
    padding: 15px 10px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
    border: 2px solid transparent;
}

.day-card:hover {
    background: #f8f9fa;
}

.day-card.selected {
    background: #007bff;
    color: white;
    border-color: #0056b3;
}

.day-card.today {
    border-color: #ffc107;
}

.day-name {
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 5px;
    text-transform: uppercase;
}

.day-number {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 5px;
}

.day-indicators {
    display: flex;
    justify-content: center;
    gap: 4px;
}

.indicator {
    width: 6px;
    height: 6px;
    border-radius: 50%;
}

.indicator.meetings { background: #007bff; }
.indicator.inquiries { background: #28a745; }

.appointment-tabs {
    background: white;
    border-radius: 12px;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.tab-header {
    display: flex;
    border-bottom: 1px solid #e9ecef;
}

.tab-btn {
    flex: 1;
    padding: 15px 20px;
    background: none;
    border: none;
    font-weight: 600;
    color: #6c757d;
    cursor: pointer;
    transition: all 0.2s;
    position: relative;
}

.tab-btn.active {
    color: #007bff;
}

.tab-btn.active::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: #007bff;
}

.tab-content {
    padding: 20px;
}

.appointment-list {
    space-y: 15px;
}

.appointment-item {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
    border-left: 4px solid #007bff;
    transition: all 0.2s;
    cursor: pointer;
}

.appointment-item:hover {
    background: #e9ecef;
    transform: translateX(5px);
}

.appointment-item.inquiry { border-left-color: #28a745; }
.appointment-item.chat { border-left-color: #ffc107; }
.appointment-item.completed { border-left-color: #6c757d; }
.appointment-item.cancelled { border-left-color: #dc3545; }

.appointment-header-info {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 10px;
}

.appointment-title-info {
    flex: 1;
}

.appointment-name {
    font-size: 16px;
    font-weight: 600;
    color: #2c3e50;
    margin: 0 0 5px 0;
}

.appointment-company {
    color: #6c757d;
    font-size: 14px;
    margin: 0;
}

.appointment-time {
    font-size: 14px;
    font-weight: 600;
    color: #007bff;
}

.appointment-details {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
}

.appointment-type {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    color: #6c757d;
}

.appointment-actions {
    display: flex;
    gap: 8px;
}

.action-btn {
    padding: 6px 12px;
    border: none;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.action-btn.call { background: #28a745; color: white; }
.action-btn.whatsapp { background: #25d366; color: white; }
.action-btn.reschedule { background: #ffc107; color: #212529; }
.action-btn.cancel { background: #dc3545; color: white; }

.status-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-badge.pending { background: #fff3cd; color: #856404; }
.status-badge.confirmed { background: #d4edda; color: #155724; }
.status-badge.completed { background: #d1ecf1; color: #0c5460; }
.status-badge.cancelled { background: #f8d7da; color: #721c24; }

.floating-add-btn {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 60px;
    height: 60px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 50%;
    font-size: 24px;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0,123,255,0.3);
    transition: all 0.2s;
    z-index: 1000;
}

.floating-add-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 16px rgba(0,123,255,0.4);
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #6c757d;
}

.empty-state i {
    font-size: 48px;
    margin-bottom: 20px;
    opacity: 0.5;
}

@media (max-width: 768px) {
    .stats-cards {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .week-days {
        grid-template-columns: repeat(7, 1fr);
        gap: 5px;
    }
    
    .day-card {
        padding: 10px 5px;
    }
    
    .appointment-header-info {
        flex-direction: column;
        gap: 10px;
    }
    
    .appointment-details {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
}
</style>
@endpush

@section('content')
<div class="appointment-dashboard">
    <div class="container-fluid">
        <!-- Header -->
        <div class="appointment-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="appointment-title">Appointments</h1>
                    <p class="appointment-subtitle">Manage meetings, inquiries, and customer communications</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary" onclick="exportData()">
                        <i class="fas fa-download me-2"></i>Export
                    </button>
                    <button class="btn btn-primary" onclick="openCreateModal()">
                        <i class="fas fa-plus me-2"></i>New Meeting
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-cards">
            <div class="stat-card meetings">
                <h3 class="stat-number">{{ $stats['total_meetings'] }}</h3>
                <p class="stat-label">Total Meetings</p>
            </div>
            <div class="stat-card inquiries">
                <h3 class="stat-number">{{ $stats['pending_inquiries'] }}</h3>
                <p class="stat-label">Pending Inquiries</p>
            </div>
            <div class="stat-card chats">
                <h3 class="stat-number">{{ $stats['active_chats'] }}</h3>
                <p class="stat-label">Active Chats</p>
            </div>
            <div class="stat-card completed">
                <h3 class="stat-number">{{ $stats['completed_meetings'] }}</h3>
                <p class="stat-label">Completed Today</p>
            </div>
        </div>

        <!-- Calendar Week View -->
        <div class="calendar-week">
            <div class="week-navigation">
                <button class="nav-btn" onclick="navigateWeek(-1)">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <h3 class="week-title">{{ Carbon\Carbon::parse($selectedDate)->format('F Y') }}</h3>
                <button class="nav-btn" onclick="navigateWeek(1)">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            
            <div class="week-days">
                @foreach($weekDays as $day)
                    <div class="day-card {{ $day['isSelected'] ? 'selected' : '' }} {{ $day['isToday'] ? 'today' : '' }}" 
                         onclick="selectDate('{{ $day['date'] }}')">
                        <div class="day-name">{{ $day['day'] }}</div>
                        <div class="day-number">{{ $day['dayNumber'] }}</div>
                        <div class="day-indicators">
                            @if($day['meetingCount'] > 0)
                                <div class="indicator meetings" title="{{ $day['meetingCount'] }} meetings"></div>
                            @endif
                            @if($day['inquiryCount'] > 0)
                                <div class="indicator inquiries" title="{{ $day['inquiryCount'] }} inquiries"></div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Appointment Tabs -->
        <div class="appointment-tabs">
            <div class="tab-header">
                <button class="tab-btn {{ $view === 'physical' ? 'active' : '' }}" onclick="switchTab('physical')">
                    <i class="fas fa-map-marker-alt me-2"></i>Physical
                </button>
                <button class="tab-btn {{ $view === 'video' ? 'active' : '' }}" onclick="switchTab('video')">
                    <i class="fas fa-video me-2"></i>Video
                </button>
                <button class="tab-btn {{ $view === 'audio' ? 'active' : '' }}" onclick="switchTab('audio')">
                    <i class="fas fa-headphones me-2"></i>Audio
                </button>
                <button class="tab-btn {{ $view === 'chats' ? 'active' : '' }}" onclick="switchTab('chats')">
                    <i class="fas fa-comments me-2"></i>Chats
                </button>
            </div>

            <div class="tab-content">
                @if(in_array($view, ['physical', 'video', 'audio', 'chats']))
                    <!-- Meetings Tab by Type -->
                    <div class="appointment-list">
                        @php $filteredMeetings = $meetings->where('type', $view); @endphp
                        @forelse($filteredMeetings as $meeting)
                            <div class="appointment-item {{ strtolower($meeting->status) }}" onclick="openMeetingModal({{ $meeting->id }})">
                                <div class="appointment-header-info">
                                    <div class="appointment-title-info">
                                        <h4 class="appointment-name">{{ $meeting->title ?? ($meeting->customer->name ?? 'Unknown Customer') }}</h4>
                                        <p class="appointment-company">
                                            @if($meeting->seller)
                                                {{ $meeting->seller->company_name }} - {{ $meeting->customer->name }}
                                            @elseif($meeting->manufacturer)
                                                {{ $meeting->manufacturer->company_name }} - {{ $meeting->customer->name }}
                                            @else
                                                {{ $meeting->customer->name }}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="d-flex flex-column align-items-end">
                                        <div class="appointment-time">{{ $meeting->scheduled_at->format('g:i A') }}</div>
                                        <span class="status-badge {{ strtolower($meeting->status) }}">{{ $meeting->status }}</span>
                                    </div>
                                </div>
                                <div class="appointment-details">
                                    <div class="appointment-type">
                                        <i class="fas fa-{{ $meeting->type === 'video' ? 'video' : ($meeting->type === 'audio' ? 'headphones' : ($meeting->type === 'chats' ? 'comments' : 'map-marker-alt')) }}"></i>
                                        {{ ucfirst($meeting->type) }} Meeting
                                        @if($meeting->duration)
                                            - {{ $meeting->duration }} min
                                        @endif
                                    </div>
                                    <div class="appointment-actions">
                                        <button class="action-btn call" onclick="event.stopPropagation(); callCustomer('{{ $meeting->customer->phone ?? '' }}')">
                                            <i class="fas fa-phone"></i>
                                        </button>
                                        <button class="action-btn whatsapp" onclick="event.stopPropagation(); openWhatsApp('{{ $meeting->customer->phone ?? '' }}')">
                                            <i class="fab fa-whatsapp"></i>
                                        </button>
                                        @if($meeting->status === 'pending')
                                            <button class="action-btn reschedule" onclick="event.stopPropagation(); rescheduleMeeting({{ $meeting->id }})">
                                                <i class="fas fa-calendar"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <i class="fas fa-calendar-times"></i>
                                <h4>No meetings scheduled</h4>
                                <p>No {{ ucfirst($view) }} meetings found for {{ Carbon\Carbon::parse($selectedDate)->format('F j, Y') }}</p>
                            </div>
                        @endforelse
                    </div>

                @elseif($view === 'call')
                    <!-- Inquiries Tab -->
                    <div class="appointment-list">
                        @forelse($inquiries as $inquiry)
                            <div class="appointment-item inquiry" onclick="openInquiryModal({{ $inquiry->id }})">
                                <div class="appointment-header-info">
                                    <div class="appointment-title-info">
                                        <h4 class="appointment-name">{{ $inquiry->user->name }}</h4>
                                        <p class="appointment-company">
                                            Inquiry about: {{ $inquiry->product->name ?? 'General Inquiry' }}
                                        </p>
                                    </div>
                                    <div class="d-flex flex-column align-items-end">
                                        <div class="appointment-time">{{ $inquiry->created_at->format('g:i A') }}</div>
                                        <span class="status-badge {{ strtolower($inquiry->status) }}">{{ $inquiry->status }}</span>
                                    </div>
                                </div>
                                
                                <div class="appointment-details">
                                    <div class="appointment-type">
                                        <i class="fas fa-question-circle"></i>
                                        {{ ucfirst($inquiry->inquiry_type ?? 'general') }} Inquiry
                                    </div>
                                    
                                    <div class="appointment-actions">
                                        <button class="action-btn call" onclick="event.stopPropagation(); callCustomer('{{ $inquiry->user->phone ?? '' }}')">
                                            <i class="fas fa-phone"></i>
                                        </button>
                                        <button class="action-btn whatsapp" onclick="event.stopPropagation(); openWhatsApp('{{ $inquiry->user->phone ?? '' }}')">
                                            <i class="fab fa-whatsapp"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <h4>No pending inquiries</h4>
                                <p>No inquiries found for {{ Carbon\Carbon::parse($selectedDate)->format('F j, Y') }}</p>
                            </div>
                        @endforelse
                    </div>

                @else
                    <!-- Chats Tab -->
                    <div class="appointment-list">
                        @forelse($conversations as $conversation)
                            <div class="appointment-item chat" onclick="openChatModal({{ $conversation->id }})">
                                <div class="appointment-header-info">
                                    <div class="appointment-title-info">
                                        <h4 class="appointment-name">{{ $conversation->customer->name }}</h4>
                                        <p class="appointment-company">
                                            @if($conversation->seller)
                                                Chat with {{ $conversation->seller->company_name }}
                                            @elseif($conversation->manufacturer)
                                                Chat with {{ $conversation->manufacturer->company_name }}
                                            @else
                                                General Chat
                                            @endif
                                        </p>
                                    </div>
                                    <div class="appointment-time">{{ $conversation->updated_at->format('g:i A') }}</div>
                                </div>
                                
                                <div class="appointment-details">
                                    <div class="appointment-type">
                                        <i class="fas fa-comments"></i>
                                        @if($conversation->latestMessage)
                                            {{ Str::limit($conversation->latestMessage->message, 50) }}
                                        @else
                                            No messages yet
                                        @endif
                                    </div>
                                    
                                    <div class="appointment-actions">
                                        <button class="action-btn whatsapp" onclick="event.stopPropagation(); openWhatsApp('{{ $conversation->customer->phone ?? '' }}')">
                                            <i class="fab fa-whatsapp"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="empty-state">
                                <i class="fas fa-comment-slash"></i>
                                <h4>No active chats</h4>
                                <p>No chat conversations found for {{ Carbon\Carbon::parse($selectedDate)->format('F j, Y') }}</p>
                            </div>
                        @endforelse
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Floating Add Button -->
    <button class="floating-add-btn" onclick="openCreateModal()">
        <i class="fas fa-plus"></i>
    </button>
</div>

<!-- Include modals -->
@include('admin.appointments.modals.meeting-modal')
@include('admin.appointments.modals.inquiry-modal')
@include('admin.appointments.modals.create-modal')
@endsection

@push('scripts')
<script>
function selectDate(date) {
    window.location.href = `{{ route('admin.appointments.index') }}?date=${date}&view={{ $view }}&status={{ $status }}`;
}

function switchTab(tab) {
    window.location.href = `{{ route('admin.appointments.index') }}?date={{ $selectedDate }}&view=${tab}&status={{ $status }}`;
}

function navigateWeek(direction) {
    const currentDate = new Date('{{ $selectedDate }}');
    currentDate.setDate(currentDate.getDate() + (direction * 7));
    const newDate = currentDate.toISOString().split('T')[0];
    selectDate(newDate);
}

function openMeetingModal(meetingId) {
    // Load meeting details and show modal
    fetch(`/admin/appointments/${meetingId}`)
        .then(response => response.json())
        .then(data => {
            // Populate modal with meeting data
            document.getElementById('meetingModal').style.display = 'block';
        });
}

function openInquiryModal(inquiryId) {
    // Load inquiry details and show modal
    document.getElementById('inquiryModal').style.display = 'block';
}

function openChatModal(conversationId) {
    // Open chat interface
    window.open(`/admin/chat/${conversationId}`, '_blank');
}

function openCreateModal() {
    document.getElementById('createModal').style.display = 'block';
}

function callCustomer(phone) {
    if (phone) {
        window.open(`tel:${phone}`);
    } else {
        alert('Phone number not available');
    }
}

function openWhatsApp(phone) {
    if (phone) {
        const cleanPhone = phone.replace(/[^\d]/g, '');
        window.open(`https://wa.me/${cleanPhone}`, '_blank');
    } else {
        alert('Phone number not available');
    }
}

function exportData() {
    window.open(`{{ route('admin.appointments.export') }}?date={{ $selectedDate }}&view={{ $view }}`, '_blank');
}

// Auto-refresh every 30 seconds
setInterval(() => {
    location.reload();
}, 30000);
</script>
@endpush