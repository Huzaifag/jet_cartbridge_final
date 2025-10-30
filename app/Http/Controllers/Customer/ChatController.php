<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Seller;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Start a new conversation or get existing one
     */
    public function startConversation(Request $request)
    {
        $request->validate([
            'seller_id' => 'required|exists:sellers,id',
        ]);

        $customerId = Auth::id();

        // Check if conversation already exists between this customer & seller
        $conversation = Conversation::where('customer_id', $customerId)
            ->where('seller_id', $request->seller_id)
            ->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'customer_id' => $customerId,
                'seller_id' => $request->seller_id,
            ]);
        }

        return response()->json([
            'success' => true,
            'conversation' => $conversation,
        ]);
    }

    /**
     * Send a message
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'message' => 'required|string',
        ]);

        $conversation = Conversation::findOrFail($request->conversation_id);

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'customer_id' => $conversation->customer_id,
            'seller_id' => $conversation->seller_id,
            'sender_type' => 'customer',
            'message' => $request->message,
        ]);

        // Update last message info
        $conversation->update([
            'last_message' => $request->message,
            'last_message_sender' => 'customer',
        ]);

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    /**
     * Fetch messages of a conversation
     */
    public function fetchMessages($conversationId)
    {
        $conversation = Conversation::with(['messages' => function ($query) {
            $query->orderBy('created_at', 'asc');
        }])->findOrFail($conversationId);

        return response()->json([
            'success' => true,
            'messages' => $conversation->messages,
        ]);
    }

    /**
     * Fetch all conversations of the current customer
     */
    public function fetchConversations()
    {
        $customerId = Auth::id();

        $conversations = Conversation::with('seller')
            ->where('customer_id', $customerId)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'conversations' => $conversations,
        ]);
    }
}
