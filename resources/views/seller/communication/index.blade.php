@extends('seller.layouts.app')
@section('content')
    <style>
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background: white;
            border-radius: var(--border-radius);
            padding: 20px 25px;
            box-shadow: var(--shadow);
        }

        .welcome-message h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 5px;
        }

        .welcome-message p {
            color: var(--gray);
            font-size: 16px;
        }

        .date-display {
            background: var(--primary-light);
            padding: 10px 15px;
            border-radius: 30px;
            color: var(--primary);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            border: none;
            margin-bottom: 25px;
            transition: var(--transition);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: white;
            border-bottom: 1px solid var(--light-gray);
            padding: 20px 25px;
            font-weight: 600;
            font-size: 18px;
            color: var(--primary-dark);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
        }

        .card-body {
            padding: 25px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 13px;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-outline-primary {
            background: transparent;
            border: 1px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            color: white;
        }

        .btn-outline-success,
        .btn-outline-info {
            background: transparent;
            border: 1px solid;
        }

        .btn-outline-success {
            border-color: #28a745;
            color: #28a745;
        }

        .btn-outline-success:hover {
            background: #28a745;
            color: white;
        }

        .btn-outline-info {
            border-color: #17a2b8;
            color: #17a2b8;
        }

        .btn-outline-info:hover {
            background: #17a2b8;
            color: white;
        }

        .list-group-item {
            padding: 15px 20px;
            border: 1px solid var(--light-gray);
            border-radius: 10px !important;
            margin-bottom: 10px;
            transition: var(--transition);
            cursor: pointer;
        }

        .list-group-item:hover {
            background: var(--primary-light);
            border-color: var(--primary);
        }

        .list-group-item.active {
            background: var(--primary-light);
            border-left: 4px solid var(--primary);
        }

        .contact-name {
            font-weight: 600;
            color: var(--dark);
        }

        .badge {
            padding: 6px 10px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
        }

        .chat-container {
            display: flex;
            flex-direction: column;
            height: 600px;
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
        }

        .chat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 25px;
            border-bottom: 1px solid var(--light-gray);
            background: white;
        }

        .chat-user {
            display: flex;
            align-items: center;
        }

        .chat-user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            margin-right: 15px;
            font-size: 18px;
        }

        .chat-user-info h3 {
            font-weight: 600;
            margin-bottom: 4px;
            color: var(--dark);
        }

        .chat-user-info p {
            font-size: 14px;
            color: var(--gray);
        }

        .chat-actions {
            display: flex;
            gap: 12px;
        }

        .action-btn {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--light);
            color: var(--dark);
            cursor: pointer;
            transition: var(--transition);
        }

        .action-btn:hover {
            background: var(--primary);
            color: white;
            transform: scale(1.1);
        }

        .chat-messages {
            flex-grow: 1;
            padding: 25px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
            background-color: #f9fafc;
        }

        .message {
            display: flex;
            max-width: 75%;
        }

        .message.received {
            align-self: flex-start;
        }

        .message.sent {
            align-self: flex-end;
        }

        .message-content {
            padding: 15px 20px;
            border-radius: 18px;
            box-shadow: var(--shadow);
        }

        .message.received .message-content {
            background: white;
            border-top-left-radius: 4px;
        }

        .message.sent .message-content {
            background: var(--primary);
            color: white;
            border-top-right-radius: 4px;
        }

        .message-time {
            font-size: 12px;
            margin-top: 8px;
            opacity: 0.8;
        }

        .chat-input {
            display: flex;
            align-items: center;
            padding: 20px;
            border-top: 1px solid var(--light-gray);
            gap: 15px;
            background: white;
        }

        .chat-input input {
            flex-grow: 1;
            padding: 15px 20px;
            border: 1px solid var(--light-gray);
            border-radius: 30px;
            font-size: 15px;
            transition: var(--transition);
        }

        .chat-input input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }

        .chat-input-actions {
            display: flex;
            gap: 12px;
        }

        .chat-input-btn {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--light);
            color: var(--dark);
            cursor: pointer;
            transition: var(--transition);
        }

        .chat-input-btn:hover {
            background: var(--primary);
            color: white;
        }

        .send-btn {
            background: var(--primary);
            color: white;
        }

        .send-btn:hover {
            background: var(--primary-dark);
        }

        .meeting-section {
            background: white;
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--shadow);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-header h2 {
            font-size: 20px;
            font-weight: 600;
            color: var(--primary-dark);
        }

        .view-all {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: var(--transition);
        }

        .view-all:hover {
            color: var(--primary-dark);
            gap: 8px;
        }

        .meeting-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
        }

        .meeting-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: var(--shadow);
            border-left: 4px solid var(--primary);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .meeting-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .meeting-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }

        .meeting-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .meeting-title {
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--dark);
        }

        .meeting-time {
            font-size: 14px;
            color: var(--gray);
        }

        .meeting-status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-upcoming {
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary);
        }

        .status-completed {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .meeting-members {
            display: flex;
            margin-top: 15px;
        }

        .member-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            border: 2px solid white;
            margin-left: -10px;
            background: var(--light-gray);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            color: var(--dark);
        }

        .member-avatar:first-child {
            margin-left: 0;
        }

        .meeting-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .scheduler-form {
            background: var(--primary-light);
            border-radius: var(--border-radius);
            padding: 25px;
            margin-top: 25px;
            display: none;
        }

        .scheduler-form.show {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: 500;
            margin-bottom: 8px;
            color: var(--dark);
            display: block;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--light-gray);
            border-radius: 8px;
            font-size: 15px;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 992px) {
            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .meeting-cards {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .chat-user-info h3 {
                font-size: 16px;
            }

            .message {
                max-width: 85%;
            }

            .meeting-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>


    <div class="container-fluid">
        <div class="dashboard-header">
            <div class="welcome-message">
                <h1>Welcome, John Doe!</h1>
                <p>Manage your communications efficiently today.</p>
            </div>
            <div class="date-display">
                <i class="fas fa-calendar"></i> Monday, October 16, 2023 10:30 AM PKT
            </div>
        </div>

        <!-- Chat Section -->
        <div class="row mt-4">
            <div class="col-md-4">
                <!-- Contact List Section -->
                <div class="card">
                    <div class="card-header flex-column align-items-start" style="display: flex;">
                        <div class="mb-2">
                            <h5>Contacts</h5>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-outline-primary me-2 active" data-filter="all">All</button>
                            <button class="btn btn-sm btn-outline-success" data-filter="buyers">Buyers</button>
                            <button class="btn btn-sm btn-outline-info" data-filter="support">Support</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush contact-list">
                            <li class="list-group-item contact active" data-category="buyers">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="contact-name">Emma Smith</span>
                                        <small class="d-block text-muted">Buyer - Online</small>
                                    </div>
                                    <span class="badge bg-success">2</span>
                                </div>
                            </li>
                            <li class="list-group-item contact" data-category="buyers">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="contact-name">Michael Johnson</span>
                                        <small class="d-block text-muted">Buyer - Offline</small>
                                    </div>
                                    <span class="badge bg-danger">1</span>
                                </div>
                            </li>
                            <li class="list-group-item contact" data-category="support">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="contact-name">Sarah Davis</span>
                                        <small class="d-block text-muted">Support - Online</small>
                                    </div>
                                    <span class="badge bg-warning">3</span>
                                </div>
                            </li>
                            <li class="list-group-item contact" data-category="support">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="contact-name">Liam Taylor</span>
                                        <small class="d-block text-muted">Support - Offline</small>
                                    </div>
                                    <span class="badge bg-secondary">0</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Real-Time Chat
                    </div>
                    <div class="card-body">
                        <div class="chat-container">
                            <div class="chat-header">
                                <div class="chat-user">
                                    <div class="chat-user-avatar">ES</div>
                                    <div class="chat-user-info">
                                        <h3 id="chat-user-name">Emma Smith</h3>
                                        <p id="chat-user-status">Online</p>
                                    </div>
                                </div>
                                <div class="chat-actions">
                                    <div class="action-btn" id="voice-call-btn">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div class="action-btn" id="video-call-btn">
                                        <i class="fas fa-video"></i>
                                    </div>
                                    <div class="action-btn">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-messages" id="chat-messages">
                                <div class="message received">
                                    <div class="message-content">
                                        <p>Hi there! I'm interested in your premium service package.</p>
                                        <div class="message-time">10:15 AM</div>
                                    </div>
                                </div>
                                <div class="message sent">
                                    <div class="message-content">
                                        <p>Hello Emma! I'd be happy to tell you more about our premium services. What
                                            specifically are you looking for?</p>
                                        <div class="message-time">10:17 AM</div>
                                    </div>
                                </div>
                                <div class="message received">
                                    <div class="message-content">
                                        <p>We need a solution that can handle at least 500 users with high availability.
                                        </p>
                                        <div class="message-time">10:20 AM</div>
                                    </div>
                                </div>
                                <div class="message sent">
                                    <div class="message-content">
                                        <p>Our enterprise plan would be perfect for that. It supports up to 1000 users
                                            with 99.9% uptime guarantee.</p>
                                        <div class="message-time">10:22 AM</div>
                                    </div>
                                </div>
                                <div class="message received">
                                    <div class="message-content">
                                        <p>That sounds great! Can we schedule a demo for tomorrow?</p>
                                        <div class="message-time">10:24 AM</div>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-input">
                                <div class="chat-input-actions">
                                    <div class="chat-input-btn">
                                        <i class="fas fa-paperclip"></i>
                                    </div>
                                    <div class="chat-input-btn" id="schedule-meeting-btn">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                </div>
                                <input type="text" placeholder="Type a message..." id="chat-input">
                                <div class="chat-input-btn send-btn" id="send-message-btn">
                                    <i class="fas fa-paper-plane"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Meeting Scheduler Section -->
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Meeting Scheduler
                        <button class="btn btn-primary btn-sm float-end" id="toggle-scheduler">Schedule New
                            Meeting</button>
                    </div>
                    <div class="scheduler-form" id="scheduler-form">
                        <form id="meeting-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meeting-title">Meeting Title</label>
                                        <input type="text" class="form-control" id="meeting-title" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meeting-date">Date & Time</label>
                                        <input type="datetime-local" class="form-control" id="meeting-date" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meeting-duration">Duration (minutes)</label>
                                        <input type="number" class="form-control" id="meeting-duration" min="15" max="240"
                                            value="60" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="meeting-participants">Participants</label>
                                        <input type="text" class="form-control" id="meeting-participants"
                                            placeholder="e.g., ES, MJ, JD" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="meeting-description">Description</label>
                                <textarea class="form-control" id="meeting-description" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Schedule Meeting</button>
                            <button type="button" class="btn btn-secondary mt-3 ms-2" id="cancel-scheduler">Cancel</button>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="meeting-section">
                            <div class="section-header">
                                <h2>Scheduled Meetings</h2>
                                <a href="#" class="view-all">View All <i class="fas fa-chevron-right"></i></a>
                            </div>
                            <div class="meeting-cards" id="meeting-cards">
                                <div class="meeting-card">
                                    <div class="meeting-card-header">
                                        <div>
                                            <div class="meeting-title">Product Demo with Emma</div>
                                            <div class="meeting-time">Today, 3:00 PM - 4:00 PM</div>
                                        </div>
                                        <span class="meeting-status status-upcoming">Upcoming</span>
                                    </div>
                                    <p>Showing the enterprise features and capabilities</p>
                                    <div class="meeting-members">
                                        <div class="member-avatar">ES</div>
                                        <div class="member-avatar">JD</div>
                                        <div class="member-avatar">+2</div>
                                    </div>
                                    <div class="meeting-actions">
                                        <button class="btn btn-primary" onclick="joinMeeting('Product Demo with Emma')"><i
                                                class="fas fa-video"></i>
                                            Join</button>
                                        <button class="btn btn-outline"><i class="fas fa-clock"></i> Remind Me</button>
                                    </div>
                                </div>
                                <div class="meeting-card">
                                    <div class="meeting-card-header">
                                        <div>
                                            <div class="meeting-title">Quarterly Review</div>
                                            <div class="meeting-time">Tomorrow, 10:00 AM - 11:30 AM</div>
                                        </div>
                                        <span class="meeting-status status-upcoming">Upcoming</span>
                                    </div>
                                    <p>Q3 performance review and planning for next quarter</p>
                                    <div class="meeting-members">
                                        <div class="member-avatar">MJ</div>
                                        <div class="member-avatar">SD</div>
                                        <div class="member-avatar">LT</div>
                                        <div class="member-avatar">+3</div>
                                    </div>
                                    <div class="meeting-actions">
                                        <button class="btn btn-outline"><i class="fas fa-clock"></i> Remind Me</button>
                                    </div>
                                </div>
                                <div class="meeting-card">
                                    <div class="meeting-card-header">
                                        <div>
                                            <div class="meeting-title">Contract Discussion</div>
                                            <div class="meeting-time">Oct 18, 1:00 PM - 2:00 PM</div>
                                        </div>
                                        <span class="meeting-status status-upcoming">Upcoming</span>
                                    </div>
                                    <p>Finalizing the contract terms and conditions</p>
                                    <div class="meeting-members">
                                        <div class="member-avatar">RW</div>
                                        <div class="member-avatar">JD</div>
                                    </div>
                                    <div class="meeting-actions">
                                        <button class="btn btn-outline"><i class="fas fa-clock"></i> Remind Me</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const chatMessages = document.getElementById('chat-messages');
            const chatInput = document.getElementById('chat-input');
            const sendMessageBtn = document.getElementById('send-message-btn');
            const chatUserName = document.getElementById('chat-user-name');
            const chatUserStatus = document.getElementById('chat-user-status');
            const voiceCallBtn = document.getElementById('voice-call-btn');
            const videoCallBtn = document.getElementById('video-call-btn');
            const scheduleMeetingBtn = document.getElementById('schedule-meeting-btn');
            const toggleScheduler = document.getElementById('toggle-scheduler');
            const cancelScheduler = document.getElementById('cancel-scheduler');
            const meetingForm = document.getElementById('meeting-form');
            const schedulerForm = document.getElementById('scheduler-form');
            const meetingCards = document.getElementById('meeting-cards');
            const contacts = document.querySelectorAll('.contact');
            const filterButtons = document.querySelectorAll('[data-filter]');

            // Auto-scroll to bottom of chat
            chatMessages.scrollTop = chatMessages.scrollHeight;

            // Send message function
            function sendMessage() {
                const message = chatInput.value.trim();
                if (message) {
                    const now = new Date();
                    const time = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                    const messageElement = document.createElement('div');
                    messageElement.className = 'message sent';
                    messageElement.innerHTML = `
                            <div class="message-content">
                                <p>${message}</p>
                                <div class="message-time">${time}</div>
                            </div>
                        `;

                    chatMessages.appendChild(messageElement);
                    chatInput.value = '';

                    // Auto scroll to bottom
                    chatMessages.scrollTop = chatMessages.scrollHeight;

                    // Simulate reply after a short delay
                    setTimeout(() => {
                        const replyElement = document.createElement('div');
                        replyElement.className = 'message received';
                        replyElement.innerHTML = `
                                <div class="message-content">
                                    <p>Thanks for your message. I'll get back to you shortly.</p>
                                    <div class="message-time">${new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</div>
                                </div>
                            `;

                        chatMessages.appendChild(replyElement);
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    }, 1000);
                }
            }

            // Send message on button click
            sendMessageBtn.addEventListener('click', sendMessage);

            // Send message on Enter key
            chatInput.addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    sendMessage();
                }
            });

            // Contact selection
            contacts.forEach(contact => {
                contact.addEventListener('click', function () {
                    contacts.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');

                    // Update chat header with selected contact
                    const contactName = this.querySelector('.contact-name').textContent;
                    chatUserName.textContent = contactName;
                    chatUserStatus.textContent = this.querySelector('small').textContent.split(' - ')[1];

                    // Clear chat and show placeholder
                    chatMessages.innerHTML = `
                            <div class="message received">
                                <div class="message-content">
                                    <p>This is the beginning of your conversation with ${contactName}</p>
                                    <div class="message-time">Now</div>
                                </div>
                            </div>
                        `;
                });
            });

            // Filter contacts
            filterButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const filter = this.getAttribute('data-filter');
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    contacts.forEach(contact => {
                        if (filter === 'all') {
                            contact.style.display = 'flex';
                        } else {
                            contact.style.display = contact.getAttribute('data-category') === filter ? 'flex' : 'none';
                        }
                    });
                });
            });

            // Voice/Video Call
            voiceCallBtn.addEventListener('click', () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Voice Call',
                    text: `Starting voice call with ${chatUserName.textContent}. This would initiate a WebRTC call in a real application.`,
                    confirmButtonText: 'Join'
                });
            });

            videoCallBtn.addEventListener('click', () => {
                Swal.fire({
                    icon: 'info',
                    title: 'Video Call',
                    text: `Starting video call with ${chatUserName.textContent}. This would initiate a WebRTC call in a real application.`,
                    confirmButtonText: 'Join'
                });
            });

            // Meeting Scheduler
            toggleScheduler.addEventListener('click', () => {
                schedulerForm.classList.add('show');
            });

            cancelScheduler.addEventListener('click', () => {
                schedulerForm.classList.remove('show');
                meetingForm.reset();
            });

            meetingForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const title = document.getElementById('meeting-title').value;
                const dateTime = new Date(document.getElementById('meeting-date').value);
                const duration = document.getElementById('meeting-duration').value;
                const participants = document.getElementById('meeting-participants').value.split(',').map(p => p.trim());
                const description = document.getElementById('meeting-description').value;

                const endTime = new Date(dateTime.getTime() + duration * 60000);
                const meetingCard = document.createElement('div');
                meetingCard.className = 'meeting-card';
                meetingCard.innerHTML = `
                        <div class="meeting-card-header">
                            <div>
                                <div class="meeting-title">${title}</div>
                                <div class="meeting-time">${dateTime.toLocaleString()} - ${endTime.toLocaleString()}</div>
                            </div>
                            <span class="meeting-status status-upcoming">Upcoming</span>
                        </div>
                        <p>${description}</p>
                        <div class="meeting-members">
                            ${participants.map(p => `<div class="member-avatar">${p.charAt(0) + (p.split(' ')[1] ? p.split(' ')[1].charAt(0) : '')}</div>`).join('')}
                        </div>
                        <div class="meeting-actions">
                            <button class="btn btn-primary" onclick="joinMeeting('${title}')"><i class="fas fa-video"></i> Join</button>
                            <button class="btn btn-outline"><i class="fas fa-clock"></i> Remind Me</button>
                        </div>
                    `;
                meetingCards.appendChild(meetingCard);

                Swal.fire({
                    icon: 'success',
                    title: 'Meeting Scheduled',
                    text: `Meeting "${title}" has been scheduled for ${dateTime.toLocaleString()}.`
                });

                schedulerForm.classList.remove('show');
                meetingForm.reset();
            });

            window.joinMeeting = function (title) {
                Swal.fire({
                    icon: 'info',
                    title: 'Join Meeting',
                    text: `Joining ${title}. This would launch the video call interface in a real application.`,
                    confirmButtonText: 'Join'
                });
            };
        });
    </script>
@endsection
