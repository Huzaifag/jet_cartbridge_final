@extends('seller.layouts.app')

@section('content')
<style>
    /* Custom Styles for Professional Chat Interface */
    .chat-container {
        min-height: 90vh;
        border-radius: 1rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        overflow: hidden;
        background-color: #ffffff;
    }

    #conversationSidebar {
        border-right: 1px solid #e9ecef;
        padding-right: 0;
        height: 100%;
    }

    .conversation-item {
        border: none;
        border-bottom: 1px solid #f8f9fa;
        padding: 1rem 1.5rem;
        cursor: pointer;
        transition: background-color 0.2s, border-left 0.2s;
        border-left: 4px solid transparent;
    }

    .conversation-item:hover,
    .conversation-item.active {
        background-color: #f8f9fa;
        border-left-color: #0d6efd;
    }

    .conversation-item.active {
        font-weight: 600;
    }

    #chatMessages {
        background-color: #f8f9fa;
        border: none;
        border-radius: 0.5rem;
        flex-grow: 1;
        padding: 1rem;
    }

    .message-bubble {
        padding: 0.75rem 1rem;
        border-radius: 1.25rem;
        max-width: 65%;
    }

    .seller-message .message-bubble {
        background-color: #0d6efd;
        color: white;
    }

    .customer-message .message-bubble {
        background-color: #e9ecef;
        color: #212529;
    }

    #messageInput {
        border-radius: 0.5rem 0 0 0.5rem;
    }

    #sendMessageBtn {
        border-radius: 0 0.5rem 0.5rem 0;
    }

    /* Typing indicator */
    .typing-indicator {
        display: inline-block;
        padding: 0.75rem 1rem;
        background-color: #e9ecef;
        border-radius: 1.25rem;
    }

    .typing-indicator span {
        height: 8px;
        width: 8px;
        background-color: #6c757d;
        border-radius: 50%;
        display: inline-block;
        margin: 0 2px;
        animation: typing 1.4s infinite;
    }

    .typing-indicator span:nth-child(2) {
        animation-delay: 0.2s;
    }

    .typing-indicator span:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes typing {
        0%, 60%, 100% {
            transform: translateY(0);
        }
        30% {
            transform: translateY(-10px);
        }
    }
</style>

<div class="container-fluid py-4">
    <div class="row chat-container">
        
        <div class="col-md-4 p-0 d-flex flex-column" id="conversationSidebar">
            <div class="p-4 border-bottom">
                <h4 class="mb-0 text-primary fw-bold">Conversations</h4>
            </div>
            <ul class="list-group list-group-flush" id="conversationList" style="flex-grow: 1; overflow-y: auto;">
                <li class="list-group-item text-center text-muted p-4">
                    <i class="fas fa-spinner fa-spin me-2"></i> Loading conversations...
                </li>
            </ul>
        </div>

        <div class="col-md-8 d-flex flex-column p-0" style="height: 100%;">
            <div class="p-3 border-bottom bg-white d-flex align-items-center">
                <h5 id="chatHeaderName" class="mb-0 text-muted">Select a Customer</h5>
            </div>
            
            <div class="flex-grow-1 p-3" id="chatMessages" style="overflow-y: auto;">
                <div class="text-center text-muted mt-5 pt-5">
                    <i class="fas fa-comments fa-3x mb-3 text-secondary"></i>
                    <p class="lead">Select a conversation to start chatting.</p>
                </div>
            </div>

            <div class="p-3 bg-white border-top">
                <div class="input-group">
                    <input type="text" id="messageInput" class="form-control form-control-lg" placeholder="Type your message..." disabled>
                    <button class="btn btn-primary btn-lg" id="sendMessageBtn" disabled>
                        <i class="fas fa-paper-plane me-1"></i> Send
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script>
$(document).ready(function() {
    let currentConversationId = null;
    let currentCustomerName = null;
    let pusher = null;
    let currentChannel = null;

    // 🔹 Initialize Pusher
    function initializePusher() {
        // Enable pusher logging for development (disable in production)
        Pusher.logToConsole = true;
        
        pusher = new Pusher('1631bf206e381798697b', {
            cluster: 'ap2',
            encrypted: true,
            authEndpoint: '/broadcasting/auth', // Laravel broadcasting auth endpoint
            auth: {
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            }
        });

        // Connection state monitoring
        pusher.connection.bind('connected', function() {
            console.log('Pusher connected successfully');
        });

        pusher.connection.bind('error', function(err) {
            console.error('Pusher connection error:', err);
        });
    }

    // Initialize Pusher on page load
    initializePusher();

    // 🔹 Fetch all conversations when page loads
    fetchConversations();

    function fetchConversations() {
        $.ajax({
            url: "{{ route('seller.chat.conversations') }}",
            method: 'GET',
            success: function(response) {
                $('#conversationList').empty();
                if (response.conversations.length === 0) {
                    $('#conversationList').append('<li class="list-group-item text-center text-muted p-4">No conversations yet.</li>');
                } else {
                    response.conversations.forEach(function(conv) {
                        const lastMessage = conv.last_message ? conv.last_message.substring(0, 30) + (conv.last_message.length > 30 ? '...' : '') : 'Start conversation...';
                        
                        $('#conversationList').append(`
                            <li class="conversation-item d-flex flex-column" data-id="${conv.id}" data-name="${conv.customer.name}">
                                <strong class="text-dark">${conv.customer.name}</strong>
                                <small class="text-secondary">${lastMessage}</small>
                            </li>
                        `);
                    });
                }
            },
            error: function() {
                $('#conversationList').html('<li class="list-group-item text-danger text-center p-4">Failed to load conversations.</li>');
            }
        });
    }

    // 🔹 Click a conversation to load its messages
    $(document).on('click', '.conversation-item', function() {
        currentConversationId = $(this).data('id');
        currentCustomerName = $(this).data('name');
        
        $('.conversation-item').removeClass('active');
        $(this).addClass('active');
        
        $('#chatHeaderName').text(currentCustomerName);
        $('#messageInput').prop('disabled', false).focus();
        $('#sendMessageBtn').prop('disabled', false);

        fetchMessages(currentConversationId);
        subscribeToChat(currentConversationId);
    });

    // 🔹 Fetch messages for the selected conversation
    function fetchMessages(conversationId) {
        $('#chatMessages').html('<div class="text-center text-primary mt-5"><i class="fas fa-circle-notch fa-spin fa-2x"></i><p class="mt-2">Loading messages...</p></div>');

        $.ajax({
            url: `/seller/chat/messages/${conversationId}`,
            method: 'GET',
            success: function(response) {
                $('#chatMessages').empty();
                if (response.messages.length === 0) {
                    $('#chatMessages').html('<div class="text-center text-muted mt-5"><p>No messages yet. Say hello!</p></div>');
                } else {
                    response.messages.forEach(function(msg) {
                        appendMessage(msg);
                    });
                    scrollToBottom();
                }
            },
            error: function() {
                $('#chatMessages').html('<div class="text-center text-danger mt-5">Failed to load messages.</div>');
            }
        });
    }

    // 🔹 Send a new message
    function sendMessage() {
        const message = $('#messageInput').val().trim();
        if (!message || !currentConversationId) return;

        $('#messageInput').prop('disabled', true);
        $('#sendMessageBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

        $.ajax({
            url: "{{ route('seller.chat.send') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                conversation_id: currentConversationId,
                message: message,
            },
            success: function(response) {
                $('#messageInput').val('');
                $('#messageInput').prop('disabled', false).focus();
                $('#sendMessageBtn').prop('disabled', false).html('<i class="fas fa-paper-plane me-1"></i> Send');
                
                // Append message immediately for better UX
                if (response.message) {
                    appendMessage(response.message);
                }
                
                fetchConversations(); // Refresh sidebar
            },
            error: function(xhr) {
                alert('Failed to send message: ' + (xhr.responseJSON?.message || 'Unknown error'));
                $('#messageInput').prop('disabled', false).focus();
                $('#sendMessageBtn').prop('disabled', false).html('<i class="fas fa-paper-plane me-1"></i> Send');
            }
        });
    }

    $('#sendMessageBtn').on('click', sendMessage);

    // 🔹 Allow Enter key to send message
    $('#messageInput').on('keypress', function(e) {
        if (e.which === 13 && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    // 🔹 Subscribe to real-time chat updates using Pusher
    function subscribeToChat(conversationId) {
        // Unsubscribe from previous channel if exists
        if (currentChannel) {
            pusher.unsubscribe(currentChannel.name);
        }

        // Subscribe to the conversation channel
        const channelName = `private-conversation.${conversationId}`;
        currentChannel = pusher.subscribe(channelName);

        // Listen for new messages
        currentChannel.bind('message.sent', function(data) {
            console.log('New message received:', data);
            
            // Only append if message is from customer (not seller)
            if (data.message && data.message.sender_type !== 'seller') {
                appendMessage(data.message);
                
                // Update conversation list
                fetchConversations();
            }
        });

        // Listen for typing indicator (optional)
        currentChannel.bind('user.typing', function(data) {
            console.log('User typing:', data);
            showTypingIndicator();
        });

        // Handle subscription errors
        currentChannel.bind('pusher:subscription_error', function(status) {
            console.error('Pusher subscription error:', status);
            alert('Unable to connect to real-time chat. Please refresh the page.');
        });

        currentChannel.bind('pusher:subscription_succeeded', function() {
            console.log('Successfully subscribed to channel:', channelName);
        });
    }

    // 🔹 Show typing indicator
    function showTypingIndicator() {
        if ($('#typingIndicator').length === 0) {
            $('#chatMessages').append(`
                <div id="typingIndicator" class="mb-3 text-start customer-message">
                    <div class="typing-indicator">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            `);
            scrollToBottom();
            
            // Remove after 3 seconds
            setTimeout(function() {
                $('#typingIndicator').fadeOut(300, function() {
                    $(this).remove();
                });
            }, 3000);
        }
    }

    // 🔹 Append message to chat
    function appendMessage(msg) {
        const isSeller = msg.sender_type === 'seller';
        const alignmentClass = isSeller ? 'text-end seller-message' : 'text-start customer-message';
        const time = new Date(msg.created_at).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });

        // Check if message already exists (prevent duplicates)
        if ($(`[data-message-id="${msg.id}"]`).length > 0) {
            return;
        }

        $('#chatMessages').append(`
            <div class="mb-3 ${alignmentClass}" data-message-id="${msg.id}">
                <div class="d-inline-block message-bubble shadow-sm">
                    ${escapeHtml(msg.message)}
                </div>
                <div class="d-block mt-1"><small class="text-muted">${time}</small></div>
            </div>
        `);

        scrollToBottom();
        
        // Hide welcome message
        $('.text-center.text-muted').hide();
    }

    // 🔹 Scroll to bottom of chat
    function scrollToBottom() {
        const chatMessages = $('#chatMessages');
        chatMessages.scrollTop(chatMessages[0].scrollHeight);
    }

    // 🔹 Escape HTML to prevent XSS
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }

    // 🔹 Subscribe to global notifications channel for new conversations
    const notificationsChannel = pusher.subscribe('private-seller.{{ auth()->id() }}');
    notificationsChannel.bind('conversation.created', function(data) {
        console.log('New conversation created:', data);
        fetchConversations();
    });

    // Clean up on page unload
    $(window).on('beforeunload', function() {
        if (pusher) {
            pusher.disconnect();
        }
    });
});
</script>
@endpush