@extends('seller.layouts.app')

@section('content')
<style>
    /* Custom Styles for Professional Chat Interface */
    .chat-container {
        min-height: 90vh; /* Make the chat area fill more of the screen */
        border-radius: 1rem; /* Rounded corners for a modern look */
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        overflow: hidden; /* Ensures content stays within the rounded corners */
        background-color: #ffffff; /* Clean white background */
    }

    /* Sidebar Styling */
    #conversationSidebar {
        border-right: 1px solid #e9ecef; /* Lighter divider line */
        padding-right: 0;
        height: 100%; /* Fill the container height */
    }

    .conversation-item {
        border: none;
        border-bottom: 1px solid #f8f9fa; /* Very light separation */
        padding: 1rem 1.5rem;
        cursor: pointer;
        transition: background-color 0.2s, border-left 0.2s;
        /* Custom line for active/hover */
        border-left: 4px solid transparent;
    }

    .conversation-item:hover,
    .conversation-item.active {
        background-color: #f8f9fa;
        border-left-color: #0d6efd; /* Primary color indicator */
    }

    .conversation-item.active {
        font-weight: 600;
    }

    /* Chat Messages Window Styling */
    #chatMessages {
        background-color: #f8f9fa; /* Soft background for message area */
        border: none; /* Remove default border */
        border-radius: 0.5rem;
        flex-grow: 1; /* Ensure it takes up available vertical space */
        padding: 1rem;
    }

    /* Individual Message Bubbles */
    .message-bubble {
        padding: 0.75rem 1rem;
        border-radius: 1.25rem; /* Pill-shaped bubbles */
        max-width: 65%; /* Max width for readability */
    }

    .seller-message .message-bubble {
        background-color: #0d6efd; /* Primary blue for seller */
        color: white;
    }

    .customer-message .message-bubble {
        background-color: #e9ecef; /* Light gray for customer */
        color: #212529;
    }

    /* Message Input Styling */
    #messageInput {
        border-radius: 0.5rem 0 0 0.5rem;
    }

    #sendMessageBtn {
        border-radius: 0 0.5rem 0.5rem 0;
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

<script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
<script>
$(document).ready(function() {
    let currentConversationId = null;
    let currentCustomerName = null;

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
                        // Truncate message for a cleaner list view
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
        
        // Update header and enable input
        $('#chatHeaderName').text(currentCustomerName);
        $('#messageInput').prop('disabled', false).focus(); // Focus on input
        $('#sendMessageBtn').prop('disabled', false);
        
        fetchMessages(currentConversationId);
    });

    // 🔹 Fetch messages for the selected conversation
    function fetchMessages(conversationId) {
        // Show loading indicator
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
                        const isSeller = msg.sender_type === 'seller';
                        const alignmentClass = isSeller ? 'text-end seller-message' : 'text-start customer-message';
                        const time = new Date(msg.created_at).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
                        
                        $('#chatMessages').append(`
                            <div class="mb-3 ${alignmentClass}">
                                <div class="d-inline-block message-bubble shadow-sm">
                                    ${msg.message}
                                </div>
                                <div class="d-block mt-1"><small class="text-muted">${time}</small></div>
                            </div>
                        `);
                    });
                    // Scroll to the bottom of the chat window
                    $('#chatMessages').scrollTop($('#chatMessages')[0].scrollHeight);
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
        
        // Disable input/button and show loading state
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
                // Re-enable input/button
                $('#messageInput').prop('disabled', false).focus();
                $('#sendMessageBtn').prop('disabled', false).html('<i class="fas fa-paper-plane me-1"></i> Send');
                
                fetchMessages(currentConversationId); // refresh chat to show new message
                fetchConversations(); // refresh sidebar to show new last message
            },
            error: function() {
                alert('Failed to send message');
                // Re-enable input/button
                $('#messageInput').prop('disabled', false).focus();
                $('#sendMessageBtn').prop('disabled', false).html('<i class="fas fa-paper-plane me-1"></i> Send');
            }
        });
    }

    $('#sendMessageBtn').on('click', sendMessage);

    // 🔹 Allow Enter key to send message
    $('#messageInput').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault(); // Prevent new line in input
            sendMessage();
        }
    });
});
</script>