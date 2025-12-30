@extends('manufacturer.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Messages</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('manufacturer.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Messages</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card chat-application">
                <div class="d-lg-flex">
                    <!-- Chat Sidebar -->
                    <div class="chat-leftsidebar">
                        <div class="chat-leftsidebar-nav">
                            <ul class="nav nav-pills nav-justified bg-light-subtle">
                                <li class="nav-item">
                                    <a href="#chat" data-bs-toggle="tab" class="nav-link active">
                                        <i class="fas fa-comment-dots font-size-20 d-sm-none"></i>
                                        <span class="d-none d-sm-block">Chat</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#groups" data-bs-toggle="tab" class="nav-link">
                                        <i class="fas fa-users font-size-20 d-sm-none"></i>
                                        <span class="d-none d-sm-block">Groups</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#contacts" data-bs-toggle="tab" class="nav-link">
                                        <i class="fas fa-address-book font-size-20 d-sm-none"></i>
                                        <span class="d-none d-sm-block">Contacts</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content">
                            <!-- Chat Tab -->
                            <div class="tab-pane show active" id="chat">
                                <div class="chat-search-box">
                                    <div class="input-group bg-light-subtle rounded-3">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-link text-muted pr-1 ps-3" type="button">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control bg-light-subtle border-0" placeholder="Search messages...">
                                    </div>
                                </div>

                                <div class="chat-message-list">
                                    <ul class="list-unstyled chat-list">
                                        @forelse($conversations ?? [] as $conversation)
                                            <li class="chat-list-item {{ $loop->first ? 'active' : '' }}" data-conversation-id="{{ $conversation['id'] ?? 0 }}">
                                                <a href="#" class="chat-user-link">
                                                    <div class="d-flex">
                                                        <div class="chat-user-img align-self-center me-3 ms-0">
                                                            <img src="{{ $conversation['user_avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($conversation['user_name'] ?? 'User') . '&background=007bff&color=ffffff&size=40' }}" 
                                                                 class="rounded-circle avatar-xs" alt="{{ $conversation['user_name'] ?? 'User' }}">
                                                            <span class="user-status {{ $conversation['is_online'] ?? false ? 'online' : 'offline' }}"></span>
                                                        </div>
                                                        <div class="flex-1 overflow-hidden">
                                                            <h5 class="text-truncate font-size-15 mb-1">{{ $conversation['user_name'] ?? 'Unknown User' }}</h5>
                                                            <p class="chat-user-message text-truncate mb-0">{{ $conversation['last_message'] ?? 'No messages yet' }}</p>
                                                        </div>
                                                        <div class="font-size-11">
                                                            {{ $conversation['last_message_time'] ?? 'Now' }}
                                                            @if(($conversation['unread_count'] ?? 0) > 0)
                                                                <span class="badge bg-danger rounded-pill ms-1">{{ $conversation['unread_count'] }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        @empty
                                            <li class="text-center py-4">
                                                <i class="fas fa-comment-slash fa-2x text-muted mb-2"></i>
                                                <p class="text-muted">No conversations yet</p>
                                            </li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>

                            <!-- Groups Tab -->
                            <div class="tab-pane" id="groups">
                                <div class="chat-search-box">
                                    <div class="input-group bg-light-subtle rounded-3">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-link text-muted pr-1 ps-3" type="button">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control bg-light-subtle border-0" placeholder="Search groups...">
                                    </div>
                                </div>

                                <div class="chat-message-list">
                                    <ul class="list-unstyled chat-list">
                                        <li class="text-center py-4">
                                            <i class="fas fa-users fa-2x text-muted mb-2"></i>
                                            <p class="text-muted">Group chat feature coming soon</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Contacts Tab -->
                            <div class="tab-pane" id="contacts">
                                <div class="chat-search-box">
                                    <div class="input-group bg-light-subtle rounded-3">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-link text-muted pr-1 ps-3" type="button">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control bg-light-subtle border-0" placeholder="Search contacts...">
                                    </div>
                                </div>

                                <div class="chat-message-list">
                                    <ul class="list-unstyled chat-list">
                                        @forelse($contacts ?? [] as $contact)
                                            <li class="chat-list-item">
                                                <a href="#" class="chat-user-link" onclick="startNewChat('{{ $contact['id'] ?? 0 }}')">
                                                    <div class="d-flex">
                                                        <div class="chat-user-img align-self-center me-3 ms-0">
                                                            <img src="{{ $contact['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($contact['name'] ?? 'Contact') . '&background=007bff&color=ffffff&size=40' }}" 
                                                                 class="rounded-circle avatar-xs" alt="{{ $contact['name'] ?? 'Contact' }}">
                                                        </div>
                                                        <div class="flex-1 overflow-hidden">
                                                            <h5 class="text-truncate font-size-15 mb-1">{{ $contact['name'] ?? 'Unknown Contact' }}</h5>
                                                            <p class="chat-user-message text-truncate mb-0">{{ $contact['company'] ?? 'No company' }}</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        @empty
                                            <li class="text-center py-4">
                                                <i class="fas fa-address-book fa-2x text-muted mb-2"></i>
                                                <p class="text-muted">No contacts available</p>
                                            </li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Chat Area -->
                    <div class="w-100 user-chat">
                        <div class="card">
                            <div class="p-4 border-bottom">
                                <div class="row">
                                    <div class="col-md-4 col-9">
                                        <h5 class="font-size-15 mb-1" id="chatUserName">Select a conversation</h5>
                                        <p class="text-muted mb-0" id="chatUserStatus">
                                            <i class="fas fa-circle font-size-10 text-success me-1"></i>
                                            Online
                                        </p>
                                    </div>
                                    <div class="col-md-8 col-3">
                                        <ul class="list-inline user-chat-nav text-end mb-0">
                                            <li class="list-inline-item">
                                                <div class="dropdown">
                                                    <button class="btn nav-btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                    <div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-md">
                                                        <div class="search-box p-2">
                                                            <input type="text" class="form-control bg-light-subtle border-0" placeholder="Search messages...">
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-inline-item">
                                                <button type="button" class="btn nav-btn">
                                                    <i class="fas fa-phone-alt"></i>
                                                </button>
                                            </li>
                                            <li class="list-inline-item">
                                                <button type="button" class="btn nav-btn">
                                                    <i class="fas fa-video"></i>
                                                </button>
                                            </li>
                                            <li class="list-inline-item">
                                                <div class="dropdown">
                                                    <button class="btn nav-btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-h"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="#">View Contact</a></li>
                                                        <li><a class="dropdown-item" href="#">Media, Links and Docs</a></li>
                                                        <li><a class="dropdown-item" href="#">Search</a></li>
                                                        <li><a class="dropdown-item" href="#">Mute</a></li>
                                                        <li><a class="dropdown-item" href="#">Block</a></li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="chat-conversation p-3" id="chatConversation" style="height: 400px; overflow-y: auto;">
                                <ul class="list-unstyled mb-0" id="messagesList">
                                    <li class="text-center py-4">
                                        <p class="text-muted">Select a conversation to start messaging</p>
                                    </li>
                                </ul>
                            </div>

                            <div class="p-3 chat-input-section">
                                <form id="chatForm">
                                    <div class="row">
                                        <div class="col">
                                            <div class="position-relative">
                                                <input type="text" class="form-control chat-input bg-light-subtle border" 
                                                       placeholder="Enter Message..." id="messageInput">
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary chat-send">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.chat-application {
    height: 600px;
}

.chat-leftsidebar {
    width: 380px;
    border-right: 1px solid #f0f0f0;
    height: 600px;
    overflow-y: auto;
}

.chat-leftsidebar-nav .nav-pills .nav-link {
    border-radius: 0;
    padding: 15px 20px;
}

.chat-search-box {
    padding: 20px;
}

.chat-message-list {
    height: 460px;
    overflow-y: auto;
}

.chat-list-item {
    padding: 15px 20px;
    border-bottom: 1px solid #f0f0f0;
    cursor: pointer;
    transition: background-color 0.2s;
}

.chat-list-item:hover,
.chat-list-item.active {
    background-color: #f8f9fa;
}

.chat-user-link {
    text-decoration: none;
    color: inherit;
}

.user-status {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    border: 2px solid white;
}

.user-status.online {
    background-color: #28a745;
}

.user-status.offline {
    background-color: #6c757d;
}

.user-chat {
    flex: 1;
}

.nav-btn {
    background: none;
    border: none;
    color: #6c757d;
    padding: 8px;
    border-radius: 4px;
}

.nav-btn:hover {
    background-color: #f8f9fa;
    color: #495057;
}

.chat-input-section {
    border-top: 1px solid #f0f0f0;
}

.chat-send {
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.message-item {
    margin-bottom: 15px;
}

.message-item.right {
    text-align: right;
}

.message-content {
    display: inline-block;
    max-width: 70%;
    padding: 10px 15px;
    border-radius: 15px;
    background: #f8f9fa;
    position: relative;
}

.message-item.right .message-content {
    background: #007bff;
    color: white;
}

.message-time {
    font-size: 11px;
    color: #6c757d;
    margin-top: 5px;
}
</style>

<script>
// Chat functionality
let currentConversationId = null;

// Handle conversation selection
document.querySelectorAll('.chat-list-item').forEach(item => {
    item.addEventListener('click', function() {
        // Remove active class from all items
        document.querySelectorAll('.chat-list-item').forEach(i => i.classList.remove('active'));
        
        // Add active class to clicked item
        this.classList.add('active');
        
        // Get conversation data
        const conversationId = this.dataset.conversationId;
        const userName = this.querySelector('h5').textContent;
        
        // Update chat header
        document.getElementById('chatUserName').textContent = userName;
        
        // Load messages for this conversation
        loadMessages(conversationId);
        
        currentConversationId = conversationId;
    });
});

// Handle message sending
document.getElementById('chatForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const messageInput = document.getElementById('messageInput');
    const message = messageInput.value.trim();
    
    if (message && currentConversationId) {
        sendMessage(currentConversationId, message);
        messageInput.value = '';
    }
});

function loadMessages(conversationId) {
    // Simulate loading messages
    const messagesList = document.getElementById('messagesList');
    messagesList.innerHTML = `
        <li class="message-item">
            <div class="message-content">
                Hello! How can I help you today?
            </div>
            <div class="message-time">2 minutes ago</div>
        </li>
        <li class="message-item right">
            <div class="message-content">
                I'm interested in your products. Can you provide more details?
            </div>
            <div class="message-time">1 minute ago</div>
        </li>
    `;
}

function sendMessage(conversationId, message) {
    // Add message to UI immediately
    const messagesList = document.getElementById('messagesList');
    const messageElement = document.createElement('li');
    messageElement.className = 'message-item right';
    messageElement.innerHTML = `
        <div class="message-content">
            ${message}
        </div>
        <div class="message-time">Just now</div>
    `;
    messagesList.appendChild(messageElement);
    
    // Scroll to bottom
    document.getElementById('chatConversation').scrollTop = document.getElementById('chatConversation').scrollHeight;
    
    // Here you would typically send the message to your backend
    console.log('Sending message:', message, 'to conversation:', conversationId);
}

function startNewChat(contactId) {
    console.log('Starting new chat with contact:', contactId);
}
</script>
@endpush
@endsection