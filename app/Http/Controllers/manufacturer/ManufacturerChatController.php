<?php

namespace App\Http\Controllers\manufacturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ManufacturerChatController extends Controller
{
    public function index()
    {
        $manufacturer = Auth::user();
        
        // Sample conversations data
        $conversations = [
            [
                'id' => 1,
                'user_name' => 'John Smith',
                'user_avatar' => null,
                'last_message' => 'Thank you for the quick response!',
                'last_message_time' => '2m',
                'unread_count' => 0,
                'is_online' => true
            ],
            [
                'id' => 2,
                'user_name' => 'Sarah Johnson',
                'user_avatar' => null,
                'last_message' => 'When will the order be shipped?',
                'last_message_time' => '15m',
                'unread_count' => 2,
                'is_online' => false
            ],
            [
                'id' => 3,
                'user_name' => 'Mike Wilson',
                'user_avatar' => null,
                'last_message' => 'I need a bulk quote for 500 units',
                'last_message_time' => '1h',
                'unread_count' => 1,
                'is_online' => true
            ],
            [
                'id' => 4,
                'user_name' => 'Emily Davis',
                'user_avatar' => null,
                'last_message' => 'Great! I\'ll place the order today.',
                'last_message_time' => '3h',
                'unread_count' => 0,
                'is_online' => false
            ]
        ];

        // Sample contacts data
        $contacts = [
            [
                'id' => 1,
                'name' => 'ABC Electronics',
                'avatar' => null,
                'company' => 'Electronics Retailer'
            ],
            [
                'id' => 2,
                'name' => 'Tech Solutions Inc',
                'avatar' => null,
                'company' => 'IT Services'
            ],
            [
                'id' => 3,
                'name' => 'Global Partners',
                'avatar' => null,
                'company' => 'Business Partners'
            ]
        ];

        return view('manufacturer.chat.index', compact('conversations', 'contacts'));
    }

    public function getConversation($conversationId)
    {
        // Sample messages for the conversation
        $messages = [
            [
                'id' => 1,
                'sender_id' => 2, // Customer
                'sender_name' => 'John Smith',
                'message' => 'Hello, I\'m interested in your wireless headphones.',
                'timestamp' => now()->subHours(2)->format('H:i'),
                'is_own_message' => false
            ],
            [
                'id' => 2,
                'sender_id' => 1, // Manufacturer
                'sender_name' => 'You',
                'message' => 'Hi John! Thank you for your interest. We have several models available. What\'s your budget range?',
                'timestamp' => now()->subHours(2)->addMinutes(5)->format('H:i'),
                'is_own_message' => true
            ],
            [
                'id' => 3,
                'sender_id' => 2,
                'sender_name' => 'John Smith',
                'message' => 'I\'m looking for something around $100-150 per unit. I need about 50 units.',
                'timestamp' => now()->subHours(1)->format('H:i'),
                'is_own_message' => false
            ],
            [
                'id' => 4,
                'sender_id' => 1,
                'sender_name' => 'You',
                'message' => 'Perfect! Our Model X-200 would be ideal for your needs. It\'s $125 per unit with bulk pricing. Let me send you the specifications.',
                'timestamp' => now()->subHours(1)->addMinutes(10)->format('H:i'),
                'is_own_message' => true
            ]
        ];

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'conversation_info' => [
                'id' => $conversationId,
                'user_name' => 'John Smith',
                'is_online' => true,
                'last_seen' => 'Online now'
            ]
        ]);
    }

    public function sendMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'conversation_id' => 'required|integer',
            'message' => 'required|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Here you would save the message to database
        $message = [
            'id' => rand(1000, 9999),
            'sender_id' => Auth::id(),
            'sender_name' => 'You',
            'message' => $request->message,
            'timestamp' => now()->format('H:i'),
            'is_own_message' => true,
            'conversation_id' => $request->conversation_id
        ];

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    public function startNewConversation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact_id' => 'required|integer',
            'message' => 'required|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Here you would create a new conversation
        $conversation = [
            'id' => rand(100, 999),
            'contact_id' => $request->contact_id,
            'created_at' => now()
        ];

        return response()->json([
            'success' => true,
            'conversation' => $conversation,
            'message' => 'Conversation started successfully'
        ]);
    }

    public function searchMessages(Request $request)
    {
        $query = $request->get('query', '');
        $conversationId = $request->get('conversation_id');

        // Sample search results
        $results = [
            [
                'id' => 1,
                'message' => 'I need a bulk quote for 500 units',
                'sender_name' => 'Mike Wilson',
                'timestamp' => now()->subDays(2)->format('M d, H:i'),
                'conversation_id' => 3
            ],
            [
                'id' => 2,
                'message' => 'Perfect! Our Model X-200 would be ideal',
                'sender_name' => 'You',
                'timestamp' => now()->subHours(1)->format('M d, H:i'),
                'conversation_id' => 1
            ]
        ];

        return response()->json([
            'success' => true,
            'results' => $results,
            'query' => $query
        ]);
    }

    public function markAsRead(Request $request)
    {
        $conversationId = $request->get('conversation_id');

        // Here you would mark messages as read in database
        return response()->json([
            'success' => true,
            'message' => 'Messages marked as read'
        ]);
    }

    public function getUnreadCount()
    {
        // Sample unread count
        $unreadCount = rand(0, 10);

        return response()->json([
            'success' => true,
            'unread_count' => $unreadCount
        ]);
    }

    public function deleteConversation($conversationId)
    {
        // Here you would delete the conversation from database
        return response()->json([
            'success' => true,
            'message' => 'Conversation deleted successfully'
        ]);
    }

    public function blockUser(Request $request)
    {
        $userId = $request->get('user_id');

        // Here you would block the user
        return response()->json([
            'success' => true,
            'message' => 'User blocked successfully'
        ]);
    }

    public function unblockUser(Request $request)
    {
        $userId = $request->get('user_id');

        // Here you would unblock the user
        return response()->json([
            'success' => true,
            'message' => 'User unblocked successfully'
        ]);
    }

    public function exportChat(Request $request)
    {
        $conversationId = $request->get('conversation_id');
        $format = $request->get('format', 'pdf');

        // Here you would generate and return the chat export
        return response()->json([
            'success' => true,
            'message' => 'Chat exported successfully',
            'download_url' => '#'
        ]);
    }
}