<!-- Customer Support Popup Button -->
<button class="customer-support-btn" id="customerSupportBtn" onclick="toggleSupportPopup()">
    <i class="fas fa-headset"></i>
    <span class="support-badge">Help</span>
</button>

<!-- Customer Support Popup -->
<div class="customer-support-popup" id="customerSupportPopup">
    <!-- Support List View -->
    <div class="support-list-view" id="supportListView">
        <div class="support-popup-header">
            <h5 class="mb-0">
                <i class="fas fa-headset me-2"></i>Customer Support
            </h5>
            <button class="btn-close" onclick="toggleSupportPopup()"></button>
        </div>

        <div class="support-popup-body">
        <!-- Search Bar -->
        <div class="support-search mb-3">
            <input type="text" class="form-control" id="supportSearch" placeholder="Search sellers or manufacturers...">
            <i class="fas fa-search"></i>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-pills support-tabs mb-3" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="sellers-tab" data-bs-toggle="pill" data-bs-target="#sellers" type="button">
                    <i class="fas fa-store me-1"></i>Sellers
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="manufacturers-tab" data-bs-toggle="pill" data-bs-target="#manufacturers" type="button">
                    <i class="fas fa-industry me-1"></i>Manufacturers
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Sellers Tab -->
            <div class="tab-pane fade show active" id="sellers" role="tabpanel">
                <div class="support-list" id="sellersList">
                    <div class="text-center py-3">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Manufacturers Tab -->
            <div class="tab-pane fade" id="manufacturers" role="tabpanel">
                <div class="support-list" id="manufacturersList">
                    <div class="text-center py-3">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Chat View -->
    <div class="chat-view" id="supportChatView" style="display: none;">
        <div class="chat-header">
            <button class="btn-back" onclick="closeChatView()">
                <i class="fas fa-arrow-left"></i>
            </button>
            <div class="chat-user-info">
                <div class="chat-avatar" id="supportChatAvatar"></div>
                <div class="chat-user-details">
                    <div class="chat-user-name" id="supportChatUserName"></div>
                    <div class="chat-user-status">
                        <span class="status-dot"></span>
                        <span class="status-text">Online</span>
                    </div>
                </div>
            </div>
            <button class="btn-close" onclick="toggleSupportPopup()"></button>
        </div>

        <div class="chat-messages" id="supportChatMessages">
            <div class="chat-date-divider">
                <span>Today</span>
            </div>
            <!-- Messages will be loaded here -->
        </div>

        <div class="chat-input-container">
            <input type="text" class="chat-input" id="supportChatInput" placeholder="Type a message...">
            <button class="chat-send-btn" id="supportChatSendBtn" onclick="sendChatMessage()">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>

        <div class="chat-typing-indicator" id="supportTypingIndicator" style="display: none;">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</div>

<!-- Backdrop -->
<div class="support-popup-backdrop" id="supportBackdrop" onclick="toggleSupportPopup()"></div>

<!-- Meeting Request Modal -->
<div class="meeting-request-modal" id="meetingModal">
    <div class="meeting-modal-content">
        <div class="meeting-modal-header">
            <h5 class="mb-0">
                <i class="fas fa-calendar-plus me-2"></i>Request Meeting
            </h5>
            <button class="btn-close" onclick="closeMeetingModal()"></button>
        </div>
        <div class="meeting-modal-body">
            <form id="meetingRequestForm">
                <input type="hidden" id="meetingType" name="type">
                <input type="hidden" id="meetingId" name="id">
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Meeting With</label>
                    <div class="meeting-with-info">
                        <div class="meeting-avatar" id="meetingAvatar"></div>
                        <div class="meeting-name" id="meetingName"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="meetingTitle" class="form-label fw-bold">
                        <i class="fas fa-heading me-1"></i>Meeting Title
                    </label>
                    <input type="text" class="form-control" id="meetingTitle" name="title" 
                           placeholder="e.g., Product Discussion" required>
                </div>

                <div class="mb-3">
                    <label for="meetingDescription" class="form-label fw-bold">
                        <i class="fas fa-align-left me-1"></i>Description
                    </label>
                    <textarea class="form-control" id="meetingDescription" name="description" 
                              rows="3" placeholder="What would you like to discuss?" required></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="meetingDate" class="form-label fw-bold">
                            <i class="fas fa-calendar me-1"></i>Date
                        </label>
                        <input type="date" class="form-control" id="meetingDate" name="date" 
                               min="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="meetingTime" class="form-label fw-bold">
                            <i class="fas fa-clock me-1"></i>Time
                        </label>
                        <input type="time" class="form-control" id="meetingTime" name="time" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="meetingDuration" class="form-label fw-bold">
                        <i class="fas fa-hourglass-half me-1"></i>Duration
                    </label>
                    <select class="form-select" id="meetingDuration" name="duration">
                        <option value="30">30 minutes</option>
                        <option value="60" selected>1 hour</option>
                        <option value="90">1.5 hours</option>
                        <option value="120">2 hours</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="meetingType" class="form-label fw-bold">
                        <i class="fas fa-video me-1"></i>Meeting Type
                    </label>
                    <select class="form-select" id="meetingTypeSelect" name="meeting_type">
                        <option value="video">Video Call</option>
                        <option value="audio">Audio Call</option>
                        <option value="in-person">In-Person</option>
                    </select>
                </div>

                <div class="alert alert-info small">
                    <i class="fas fa-info-circle me-1"></i>
                    Your meeting request will be sent to the seller/manufacturer. They will confirm the meeting time.
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-paper-plane me-2"></i>Send Request
                    </button>
                    <button type="button" class="btn btn-outline-secondary" onclick="closeMeetingModal()">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Support Button */
    .customer-support-btn {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
        transition: all 0.3s;
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: pulse-support 2s infinite;
    }

    .customer-support-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 25px rgba(102, 126, 234, 0.6);
    }

    .support-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #ff4458;
        color: white;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 0.25rem 0.5rem;
        border-radius: 10px;
        border: 2px solid white;
    }

    @keyframes pulse-support {
        0%, 100% {
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
        }
        50% {
            box-shadow: 0 4px 30px rgba(102, 126, 234, 0.7);
        }
    }

    /* Support Popup */
    .customer-support-popup {
        position: fixed;
        bottom: 90px;
        right: 20px;
        width: 420px;
        max-width: calc(100vw - 40px);
        height: 620px;
        max-height: calc(100vh - 120px);
        background: linear-gradient(180deg, #ffffff, #fbfdff);
        border-radius: 20px;
        box-shadow: 0 14px 50px rgba(12, 20, 39, 0.12), 0 4px 12px rgba(102,126,234,0.06);
        z-index: 1001;
        display: none;
        flex-direction: column;
        animation: slideUp 0.32s cubic-bezier(.2,.9,.3,1);
        overflow: hidden; /* ensure header and children clip to rounded corners */
        backdrop-filter: blur(6px) saturate(110%);
    }

    .customer-support-popup.show {
        display: flex;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .support-popup-header {
        padding: 1.25rem 1.25rem 1rem 1.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: linear-gradient(135deg, #4f63d6 0%, #6b4fcf 60%, #6b65d8 100%);
        color: white;
        /* header is clipped by parent via overflow:hidden; do not set its own radius */
    }

    .support-popup-header h5 {
        margin: 0;
        font-weight: 700;
    }

    .support-popup-header .btn-close {
        filter: brightness(0) invert(1);
        background: rgba(255,255,255,0.12);
        border-radius: 8px;
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: background .15s ease, transform .12s ease;
    }
    .support-popup-header .btn-close:hover { background: rgba(255,255,255,0.2); transform: translateY(-1px); }

    .support-popup-body {
        flex: 1;
        overflow-y: auto;
        padding: 1rem;
    }

    /* Search Bar */
    .support-search {
        position: relative;
    }

    .support-search input {
        padding-left: 2.5rem;
        border-radius: 999px;
        border: 1px solid rgba(20,30,60,0.06);
        background: linear-gradient(180deg,#ffffff,#f7fbff);
        box-shadow: 0 4px 18px rgba(12,20,39,0.04) inset;
    }

    .support-search input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .support-search i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }

    /* Tabs */
    .support-tabs {
        border-bottom: 2px solid #e9ecef;
    }

    .support-tabs .nav-link {
        color: #6c757d;
        border: none;
        border-bottom: 2px solid transparent;
        border-radius: 0;
        padding: 0.75rem 1rem;
        font-weight: 600;
        transition: all 0.3s;
    }

    .support-tabs .nav-link:hover {
        color: #667eea;
        border-bottom-color: #667eea;
    }

    .support-tabs .nav-link.active {
        color: #667eea;
        background: transparent;
        border-bottom-color: #667eea;
    }

    /* Support List */
    .support-list {
        max-height: 400px;
        overflow-y: auto;
    }

    .support-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.85rem;
        background: linear-gradient(180deg, rgba(255,255,255,0.9), rgba(250,252,255,0.95));
        border-radius: 12px;
        margin-bottom: 0.75rem;
        transition: transform .18s ease, box-shadow .18s ease;
        cursor: pointer;
        box-shadow: 0 6px 20px rgba(12,20,39,0.04);
        border: 1px solid rgba(12,20,39,0.03);
    }

    .support-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 18px 40px rgba(12,20,39,0.06);
    }

    .support-item-avatar {
        width: 54px;
        height: 54px;
        border-radius: 12px;
        background: linear-gradient(135deg, #6b63e6 0%, #6b4fcf 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.1rem;
        flex-shrink: 0;
        overflow: hidden;
        box-shadow: 0 6px 18px rgba(102,126,234,0.08);
    }

    .support-item-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .support-item-info {
        flex: 1;
        min-width: 0;
    }

    .support-item-name {
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 0.25rem;
        color: #212529;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .support-item-meta {
        font-size: 0.75rem;
        color: #6c757d;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .support-item-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.18rem 0.55rem;
        background: linear-gradient(90deg,#eef7ff,#e8f3ff);
        color: #155fa6;
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 600;
        box-shadow: 0 6px 18px rgba(21,95,166,0.06);
    }

    .support-item-actions {
        display: flex;
        gap: 0.5rem;
    }

    .support-action-btn {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: transform .12s ease, box-shadow .12s ease;
        font-size: 0.95rem;
        box-shadow: 0 6px 18px rgba(12,20,39,0.04);
    }

    .support-action-btn.chat {
        background: linear-gradient(90deg,#e8f2ff,#e6f0ff);
        color: #0b63d6;
    }

    .support-action-btn.chat:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 36px rgba(11,99,214,0.12);
        background: linear-gradient(90deg,#0b63d6,#054bb0);
        color: #fff;
    }

    .support-action-btn.meeting {
        background: linear-gradient(90deg,#fff7ed,#fff3e6);
        color: #b85b00;
    }

    .support-action-btn.meeting:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 36px rgba(184,91,0,0.12);
        background: linear-gradient(90deg,#ff9800,#ff7a00);
        color: #fff;
    }

    /* Backdrop */
    .support-popup-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(8,12,20,0.36);
        z-index: 999;
        display: none;
        backdrop-filter: blur(6px) saturate(110%);
    }

    .support-popup-backdrop.show {
        display: block;
    }

    /* Meeting Request Modal */
    .meeting-request-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
        z-index: 1002;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    .meeting-request-modal.show {
        display: flex;
    }

    .meeting-modal-content {
        background: white;
        border-radius: 16px;
        width: 100%;
        max-width: 500px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        animation: modalSlideIn 0.3s ease;
    }

    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: scale(0.9) translateY(20px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .meeting-modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 16px 16px 0 0;
    }

    .meeting-modal-header h5 {
        margin: 0;
        font-weight: 700;
    }

    .meeting-modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    .meeting-modal-body {
        padding: 1.5rem;
    }

    .meeting-with-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 12px;
        border: 2px solid #e9ecef;
    }

    .meeting-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .meeting-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .meeting-name {
        font-weight: 600;
        font-size: 1.1rem;
        color: #212529;
    }

    .form-label {
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    /* Chat View Styles */
    .support-list-view,
    .chat-view {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .chat-view {
        background: white;
    }

    .chat-header {
        padding: 1rem;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        gap: 1rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    .chat-user-info {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .chat-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #667eea;
        font-weight: 700;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .chat-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .chat-user-details {
        flex: 1;
        min-width: 0;
    }

    .chat-user-name {
        font-weight: 600;
        font-size: 1rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .chat-user-status {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.75rem;
        opacity: 0.9;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #28a745;
        animation: pulse-dot 2s infinite;
    }

    @keyframes pulse-dot {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }

    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 1rem;
        background: #f8f9fa;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .chat-messages::-webkit-scrollbar {
        width: 6px;
    }

    .chat-messages::-webkit-scrollbar-track {
        background: transparent;
    }

    .chat-messages::-webkit-scrollbar-thumb {
        background: #dee2e6;
        border-radius: 3px;
    }

    .chat-date-divider {
        text-align: center;
        margin: 1rem 0;
    }

    .chat-date-divider span {
        background: white;
        padding: 0.25rem 1rem;
        border-radius: 12px;
        font-size: 0.75rem;
        color: #6c757d;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .chat-message {
        display: flex;
        gap: 0.5rem;
        animation: messageSlideIn 0.3s ease;
    }

    @keyframes messageSlideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .chat-message.sent {
        flex-direction: row-reverse;
    }

    .chat-message-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.875rem;
        flex-shrink: 0;
    }

    .chat-message-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .chat-message-content {
        max-width: 70%;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .chat-message.sent .chat-message-content {
        align-items: flex-end;
    }

    .chat-message-bubble {
        padding: 0.75rem 1rem;
        border-radius: 18px;
        word-wrap: break-word;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .chat-message.received .chat-message-bubble {
        background: white;
        color: #212529;
        border-bottom-left-radius: 4px;
    }

    .chat-message.sent .chat-message-bubble {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-bottom-right-radius: 4px;
    }

    .chat-message-time {
        font-size: 0.7rem;
        color: #6c757d;
        padding: 0 0.5rem;
    }

    .chat-input-container {
        padding: 1rem;
        border-top: 1px solid #e9ecef;
        background: white;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .chat-input {
        flex: 1;
        border: 1px solid #e9ecef;
        border-radius: 25px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        outline: none;
        transition: all 0.3s;
    }

    .chat-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    }

    .chat-send-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
    }

    .chat-send-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }

    .chat-send-btn:active {
        transform: scale(0.95);
    }

    .chat-typing-indicator {
        padding: 0.5rem 1rem;
        display: flex;
        gap: 0.25rem;
        align-items: center;
    }

    .chat-typing-indicator span {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #6c757d;
        animation: typing 1.4s infinite;
    }

    .chat-typing-indicator span:nth-child(2) {
        animation-delay: 0.2s;
    }

    .chat-typing-indicator span:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes typing {
        0%, 60%, 100% {
            transform: translateY(0);
            opacity: 0.7;
        }
        30% {
            transform: translateY(-10px);
            opacity: 1;
        }
    }

    /* Responsive */
    @media (max-width: 576px) {
        .customer-support-popup {
            bottom: 0;
            right: 0;
            left: 0;
            width: 100%;
            max-width: 100%;
            height: 80vh;
            border-radius: 16px 16px 0 0;
        }

        .customer-support-btn {
            bottom: 15px;
            right: 15px;
            width: 55px;
            height: 55px;
        }

        .meeting-modal-content {
            max-width: 100%;
            border-radius: 16px 16px 0 0;
        }
    }
</style>

<script>
let supportPopupOpen = false;
let sellersData = [];
let manufacturersData = [];

function toggleSupportPopup() {
    const popup = document.getElementById('customerSupportPopup');
    const backdrop = document.getElementById('supportBackdrop');
    
    supportPopupOpen = !supportPopupOpen;
    
    if (supportPopupOpen) {
        popup.classList.add('show');
        backdrop.classList.add('show');
        loadSupportData();
    } else {
        popup.classList.remove('show');
        backdrop.classList.remove('show');
    }
}

function loadSupportData() {
    // Load sellers
    fetch('/api/sellers/list')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                sellersData = data.sellers || [];
                renderSellers(sellersData);
            } else {
                throw new Error(data.message || 'Failed to load sellers');
            }
        })
        .catch(error => {
            console.error('Error loading sellers:', error);
            document.getElementById('sellersList').innerHTML = `
                <div class="text-center text-muted py-4">
                    <i class="fas fa-exclamation-circle fa-2x mb-2"></i>
                    <p>Failed to load sellers</p>
                    <button class="btn btn-sm btn-primary" onclick="loadSupportData()">Retry</button>
                </div>
            `;
        });

    // Load manufacturers
    fetch('/api/manufacturers/list')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                manufacturersData = data.manufacturers || [];
                renderManufacturers(manufacturersData);
            } else {
                throw new Error(data.message || 'Failed to load manufacturers');
            }
        })
        .catch(error => {
            console.error('Error loading manufacturers:', error);
            document.getElementById('manufacturersList').innerHTML = `
                <div class="text-center text-muted py-4">
                    <i class="fas fa-exclamation-circle fa-2x mb-2"></i>
                    <p>Failed to load manufacturers</p>
                    <button class="btn btn-sm btn-primary" onclick="loadSupportData()">Retry</button>
                </div>
            `;
        });
}

function renderSellers(sellers) {
    const container = document.getElementById('sellersList');
    
    if (!sellers || sellers.length === 0) {
        container.innerHTML = `
            <div class="text-center text-muted py-4">
                <i class="fas fa-store fa-3x mb-3 opacity-50"></i>
                <p>No sellers available at the moment</p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = sellers.map(seller => `
        <div class="support-item">
            <div class="support-item-avatar">
                ${seller.logo ? `<img src="${seller.logo}" alt="${seller.name}">` : seller.name.charAt(0).toUpperCase()}
            </div>
            <div class="support-item-info">
                <div class="support-item-name">${seller.name}</div>
                <div class="support-item-meta">
                    <span class="support-item-badge">
                        <i class="fas fa-check-circle"></i> Verified
                    </span>
                    ${seller.rating ? `<span><i class="fas fa-star text-warning"></i> ${seller.rating}</span>` : ''}
                </div>
            </div>
            <div class="support-item-actions">
                <button class="support-action-btn chat" onclick="startChat('seller', ${seller.id})" title="Start Chat">
                    <i class="fas fa-comment"></i>
                </button>
                <button class="support-action-btn meeting" onclick="requestMeeting('seller', ${seller.id})" title="Request Meeting">
                    <i class="fas fa-calendar"></i>
                </button>
            </div>
        </div>
    `).join('');
}

function renderManufacturers(manufacturers) {
    const container = document.getElementById('manufacturersList');
    
    if (!manufacturers || manufacturers.length === 0) {
        container.innerHTML = `
            <div class="text-center text-muted py-4">
                <i class="fas fa-industry fa-3x mb-3 opacity-50"></i>
                <p>No manufacturers available at the moment</p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = manufacturers.map(manufacturer => `
        <div class="support-item">
            <div class="support-item-avatar">
                ${manufacturer.logo ? `<img src="${manufacturer.logo}" alt="${manufacturer.name}">` : manufacturer.name.charAt(0).toUpperCase()}
            </div>
            <div class="support-item-info">
                <div class="support-item-name">${manufacturer.name}</div>
                <div class="support-item-meta">
                    <span class="support-item-badge">
                        <i class="fas fa-industry"></i> Manufacturer
                    </span>
                    ${manufacturer.rating ? `<span><i class="fas fa-star text-warning"></i> ${manufacturer.rating}</span>` : ''}
                </div>
            </div>
            <div class="support-item-actions">
                <button class="support-action-btn chat" onclick="startChat('manufacturer', ${manufacturer.id})" title="Start Chat">
                    <i class="fas fa-comment"></i>
                </button>
                <button class="support-action-btn meeting" onclick="requestMeeting('manufacturer', ${manufacturer.id})" title="Request Meeting">
                    <i class="fas fa-calendar"></i>
                </button>
            </div>
        </div>
    `).join('');
}

let currentConversationId = null;
let currentChatUser = null;
let messagePollingInterval = null;

function startChat(type, id) {
    @auth
        // Find the seller/manufacturer data
        const data = type === 'seller' 
            ? sellersData.find(s => s.id === id)
            : manufacturersData.find(m => m.id === id);
        
        if (!data) {
            alert('Could not find ' + type + ' information');
            return;
        }

        // Create or open conversation
        fetch('/api/conversations/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                type: type,
                id: id
            })
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                currentConversationId = result.conversation_id;
                currentChatUser = data;
                openChatView(data);
                loadChatMessages(result.conversation_id);
            } else {
                alert(result.message || 'Failed to start chat. Please try again.');
            }
        })
        .catch(err => {
            console.error('Error starting chat:', err);
            alert('Failed to start chat. Please try again.');
        });
    @else
        alert('Please login to start a chat');
        window.location.href = '/login';
    @endauth
}

function openChatView(userData) {
    // Hide support list
    document.getElementById('supportListView').style.display = 'none';
    
    // Show chat view
    const chatView = document.getElementById('supportChatView');
    chatView.style.display = 'flex';
    
    // Set user info
    const avatar = document.getElementById('supportChatAvatar');
    if (userData.logo) {
        avatar.innerHTML = `<img src="${userData.logo}" alt="${userData.name}">`;
    } else {
        avatar.textContent = userData.name.charAt(0).toUpperCase();
    }
    document.getElementById('supportChatUserName').textContent = userData.name;
    
    // Focus input
    document.getElementById('supportChatInput').focus();
    
    // Start polling for new messages
    startMessagePolling();
}

function closeChatView() {
    // Stop polling
    stopMessagePolling();
    
    // Hide chat view
    document.getElementById('supportChatView').style.display = 'none';
    
    // Show support list
    document.getElementById('supportListView').style.display = 'flex';
    
    // Clear chat
    document.getElementById('supportChatMessages').innerHTML = '<div class="chat-date-divider"><span>Today</span></div>';
    document.getElementById('supportChatInput').value = '';
    
    currentConversationId = null;
    currentChatUser = null;
}

function loadChatMessages(conversationId) {
    const chatMessages = document.getElementById('supportChatMessages');
    
    // Show loading indicator
    chatMessages.innerHTML = '<div class="text-center text-primary py-4"><i class="fas fa-circle-notch fa-spin fa-2x"></i><p class="mt-2">Loading messages...</p></div>';

    fetch('/customer/chat/messages/' + conversationId)
        .then(response => response.json())
        .then(res => {
            if (res.success) {
                if (res.messages.length === 0) {
                    chatMessages.innerHTML = '<div class="chat-date-divider"><span>Today</span></div><div class="text-center text-muted py-4"><i class="fas fa-comments fa-2x mb-2 opacity-50"></i><p>No messages yet. Start the conversation!</p></div>';
                } else {
                    displayMessages(res.messages);
                }
            }
        })
        .catch(err => {
            chatMessages.innerHTML = '<div class="text-center text-danger py-4"><i class="fas fa-exclamation-circle fa-2x mb-2"></i><p>Failed to load messages</p></div>';
            console.error('Error loading messages:', err);
        });
}

function displayMessages(messages) {
    const chatMessages = document.getElementById('supportChatMessages');
    chatMessages.innerHTML = '<div class="chat-date-divider"><span>Today</span></div>';
    
    messages.forEach(msg => appendChatMessage(msg));
    scrollChatToBottom();
}

function appendChatMessage(msg) {
    const isCustomer = msg.sender_type === 'customer';
    const senderName = isCustomer ? 'You' : (msg.sender_name || (currentChatUser ? currentChatUser.name : 'Seller'));
    const time = new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

    // Check if message already exists (prevent duplicates)
    if (document.querySelector(`[data-message-id="${msg.id}"]`)) {
        return;
    }

    const senderAvatar = currentChatUser && currentChatUser.name 
        ? currentChatUser.name.charAt(0).toUpperCase() 
        : 'S';

    const messageDiv = document.createElement('div');
    messageDiv.className = `chat-message ${isCustomer ? 'sent' : 'received'}`;
    messageDiv.setAttribute('data-message-id', msg.id);
    
    messageDiv.innerHTML = `
        ${!isCustomer ? `<div class="chat-message-avatar">${senderAvatar}</div>` : ''}
        <div class="chat-message-content">
            <div class="chat-message-bubble">${escapeHtml(msg.message)}</div>
            <div class="chat-message-time">${time}</div>
        </div>
        ${isCustomer ? `<div class="chat-message-avatar">You</div>` : ''}
    `;
    
    document.getElementById('supportChatMessages').appendChild(messageDiv);
    scrollChatToBottom();
}

function sendChatMessage() {
    const chatInput = document.getElementById('supportChatInput');
    const chatSendBtn = document.getElementById('supportChatSendBtn');
    const message = chatInput.value.trim();
    
    if (message === '' || !currentConversationId) return;

    // Disable input and show loading
    chatInput.disabled = true;
    chatSendBtn.disabled = true;
    chatSendBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

    fetch('{{ route("chat.send") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            conversation_id: currentConversationId,
            message: message
        })
    })
    .then(response => response.json())
    .then(res => {
        chatInput.value = '';
        chatInput.disabled = false;
        chatInput.focus();
        chatSendBtn.disabled = false;
        chatSendBtn.innerHTML = '<i class="fas fa-paper-plane"></i>';
        
        // Append message immediately for better UX
        if (res.success && res.message) {
            appendChatMessage(res.message);
        }
    })
    .catch(err => {
        chatInput.disabled = false;
        chatInput.focus();
        chatSendBtn.disabled = false;
        chatSendBtn.innerHTML = '<i class="fas fa-paper-plane"></i>';
        
        alert('Failed to send message. Please try again.');
        console.error('Error sending message:', err);
    });
}

function scrollChatToBottom() {
    const container = document.getElementById('supportChatMessages');
    if (container) {
        container.scrollTop = container.scrollHeight;
    }
}

function startMessagePolling() {
    // Poll for new messages every 3 seconds
    messagePollingInterval = setInterval(() => {
        if (currentConversationId) {
            fetchMessagesQuietly(currentConversationId);
        }
    }, 3000);
}

function stopMessagePolling() {
    if (messagePollingInterval) {
        clearInterval(messagePollingInterval);
        messagePollingInterval = null;
    }
}

function fetchMessagesQuietly(conversationId) {
    fetch('/customer/chat/messages/' + conversationId)
        .then(response => response.json())
        .then(res => {
            if (res.success && res.messages) {
                // Only append new messages
                res.messages.forEach(msg => {
                    if (!document.querySelector(`[data-message-id="${msg.id}"]`)) {
                        appendChatMessage(msg);
                    }
                });
            }
        })
        .catch(err => {
            console.error('Error fetching messages:', err);
        });
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Handle Enter key to send message
document.addEventListener('DOMContentLoaded', function() {
    const chatInput = document.getElementById('supportChatInput');
    if (chatInput) {
        chatInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendChatMessage();
            }
        });
    }
});

function requestMeeting(type, id) {
    @auth
        // Find the seller/manufacturer data
        const data = type === 'seller' 
            ? sellersData.find(s => s.id === id)
            : manufacturersData.find(m => m.id === id);
        
        if (!data) {
            alert('Could not find ' + type + ' information');
            return;
        }

        // Open meeting modal
        openMeetingModal(type, id, data);
    @else
        alert('Please login to request a meeting');
        window.location.href = '/login';
    @endauth
}

function openMeetingModal(type, id, data) {
    const modal = document.getElementById('meetingModal');
    const backdrop = document.getElementById('supportBackdrop');
    
    // Set hidden fields
    document.getElementById('meetingType').value = type;
    document.getElementById('meetingId').value = id;
    
    // Set meeting with info
    const avatar = document.getElementById('meetingAvatar');
    if (data.logo) {
        avatar.innerHTML = `<img src="${data.logo}" alt="${data.name}">`;
    } else {
        avatar.textContent = data.name.charAt(0).toUpperCase();
    }
    document.getElementById('meetingName').textContent = data.name;
    
    // Set default date (tomorrow) and time (10:00 AM)
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    document.getElementById('meetingDate').value = tomorrow.toISOString().split('T')[0];
    document.getElementById('meetingTime').value = '10:00';
    
    // Show modal
    modal.classList.add('show');
    backdrop.classList.add('show');
    
    // Close support popup
    document.getElementById('customerSupportPopup').classList.remove('show');
}

function closeMeetingModal() {
    const modal = document.getElementById('meetingModal');
    const backdrop = document.getElementById('supportBackdrop');
    
    modal.classList.remove('show');
    backdrop.classList.remove('show');
    
    // Reset form
    document.getElementById('meetingRequestForm').reset();
}

// Handle meeting form submission
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('meetingRequestForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(form);
            const data = {
                type: formData.get('type'),
                id: formData.get('id'),
                title: formData.get('title'),
                description: formData.get('description'),
                date: formData.get('date'),
                time: formData.get('time'),
                duration: formData.get('duration'),
                meeting_type: formData.get('meeting_type')
            };
            
            // Show loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
            
            fetch('/api/meetings/request', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    alert('Meeting request sent successfully! The ' + data.type + ' will review and confirm your request.');
                    closeMeetingModal();
                } else {
                    alert(result.message || 'Failed to send meeting request. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error requesting meeting:', error);
                alert('Failed to send meeting request. Please try again.');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        });
    }
});

// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('supportSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const query = e.target.value.toLowerCase();
            const activeTab = document.querySelector('.support-tabs .nav-link.active').id;
            
            if (activeTab === 'sellers-tab') {
                const filtered = sellersData.filter(seller => 
                    seller.name.toLowerCase().includes(query)
                );
                renderSellers(filtered);
            } else {
                const filtered = manufacturersData.filter(manufacturer => 
                    manufacturer.name.toLowerCase().includes(query)
                );
                renderManufacturers(filtered);
            }
        });
    }
});
</script>
