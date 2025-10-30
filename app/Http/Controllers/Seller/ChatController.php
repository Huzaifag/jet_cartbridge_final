<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Seller chat page — loads all conversations in sidebar
     */
    public function index()
    {
        $seller = Auth::user()->seller;

        // Get all customer chats for this seller
        $conversations = Conversation::with('customer')
            ->where('seller_id', $seller->id)
            ->latest()
            ->get();

        return view('seller.chat.index', compact('conversations'));
    }

    /**
     * Fetch all conversations for AJAX refresh
     */
    public function fetchConversations()
    {
        $seller = Auth::user()->seller;

        $conversations = Conversation::with('customer')
            ->where('seller_id', $seller->id)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'conversations' => $conversations,
        ]);
    }

    /**
     * Fetch all messages for a conversation
     */
    public function fetchMessages($conversationId)
    {
        $seller = Auth::user()->seller;

        $conversation = Conversation::with(['messages' => function ($query) {
            $query->orderBy('created_at', 'asc');
        }, 'customer'])
            ->where('id', $conversationId)
            ->where('seller_id', $seller->id)
            ->firstOrFail();

        // Mark all customer messages as read
        Message::where('conversation_id', $conversationId)
            ->where('sender_type', 'customer')
            ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'messages' => $conversation->messages,
            'customer' => $conversation->customer,
        ]);
    }

    /**
     * Send message (Seller → Customer)
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'message' => 'required|string',
        ]);

        $seller = Auth::user()->seller;
        $conversation = Conversation::findOrFail($request->conversation_id);

        if ($conversation->seller_id != $seller->id) {
            return response()->json(['success' => false, 'error' => 'Unauthorized'], 403);
        }

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'customer_id' => $conversation->customer_id,
            'seller_id' => $conversation->seller_id,
            'sender_type' => 'seller',
            'message' => $request->message,
        ]);

        $conversation->update([
            'last_message' => $request->message,
            'last_message_sender' => 'seller',
        ]);

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }
}
