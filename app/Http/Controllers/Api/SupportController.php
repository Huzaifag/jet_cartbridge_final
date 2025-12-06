<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\Manufacturer;
use App\Models\Conversation;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    /**
     * Get list of sellers
     */
    public function getSellers()
    {
        try {
            $sellers = Seller::with('user')
                ->select('id', 'company_name', 'user_id')
                ->get()
                ->map(function($seller) {
                    return [
                        'id' => $seller->id,
                        'name' => $seller->company_name,
                        'logo' => $seller->user && $seller->user->avatar ? asset('storage/' . $seller->user->avatar) : null,
                        'rating' => 4.5, // You can calculate this from reviews
                    ];
                });

            return response()->json([
                'success' => true,
                'sellers' => $sellers
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load sellers',
                'error' => $e->getMessage(),
                'sellers' => []
            ], 500);
        }
    }

    /**
     * Get list of manufacturers
     */
    public function getManufacturers()
    {
        try {
            $manufacturers = Manufacturer::with('user')
                ->select('id', 'company_name', 'user_id')
                ->get()
                ->map(function($manufacturer) {
                    return [
                        'id' => $manufacturer->id,
                        'name' => $manufacturer->company_name,
                        'logo' => $manufacturer->user && $manufacturer->user->avatar ? asset('storage/' . $manufacturer->user->avatar) : null,
                        'rating' => 4.7, // You can calculate this from reviews
                    ];
                });

            return response()->json([
                'success' => true,
                'manufacturers' => $manufacturers
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load manufacturers',
                'error' => $e->getMessage(),
                'manufacturers' => []
            ], 500);
        }
    }

    /**
     * Create or get conversation
     */
    public function createConversation(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login first'
            ], 401);
        }

        $request->validate([
            'type' => 'required|in:seller,manufacturer',
            'id' => 'required|integer'
        ]);

        $customerId = Auth::id();
        $type = $request->type;
        $id = $request->id;

        // Get the user_id based on type
        if ($type === 'seller') {
            $seller = Seller::find($id);
            if (!$seller) {
                return response()->json([
                    'success' => false,
                    'message' => 'Seller not found'
                ], 404);
            }
            $receiverId = $seller->user_id;
        } else {
            $manufacturer = Manufacturer::find($id);
            if (!$manufacturer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Manufacturer not found'
                ], 404);
            }
            $receiverId = $manufacturer->user_id;
        }

        // Check if conversation already exists
        $conversation = Conversation::where(function($query) use ($customerId, $receiverId) {
            $query->where('customer_id', $customerId)
                  ->where('seller_id', $receiverId);
        })->orWhere(function($query) use ($customerId, $receiverId) {
            $query->where('customer_id', $receiverId)
                  ->where('seller_id', $customerId);
        })->first();

        if (!$conversation) {
            // Create new conversation
            $conversation = Conversation::create([
                'customer_id' => $customerId,
                'seller_id' => $receiverId,
            ]);
        }

        return response()->json([
            'success' => true,
            'conversation_id' => $conversation->id,
            'message' => 'Conversation created successfully'
        ]);
    }

    /**
     * Request a meeting
     */
    public function requestMeeting(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login first'
            ], 401);
        }

        $request->validate([
            'type' => 'required|in:seller,manufacturer',
            'id' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'duration' => 'nullable|integer|in:30,60,90,120',
            'meeting_type' => 'nullable|in:video,audio,in-person'
        ]);

        $senderId = Auth::id();
        $type = $request->type;
        $id = $request->id;

        // Get the user_id based on type
        if ($type === 'seller') {
            $seller = Seller::find($id);
            if (!$seller) {
                return response()->json([
                    'success' => false,
                    'message' => 'Seller not found'
                ], 404);
            }
            $receiverId = $seller->user_id;
        } else {
            $manufacturer = Manufacturer::find($id);
            if (!$manufacturer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Manufacturer not found'
                ], 404);
            }
            $receiverId = $manufacturer->user_id;
        }

        // Combine date and time for scheduled_at
        $scheduledAt = $request->date . ' ' . $request->time;
        
        // Create meeting request with message containing all details
        $meetingMessage = "Meeting Type: " . ($request->meeting_type ?? 'video') . "\n";
        $meetingMessage .= "Duration: " . ($request->duration ?? 60) . " minutes\n";
        $meetingMessage .= "Description: " . $request->description;
        
        $meeting = Meeting::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'title' => $request->title,
            'message' => $meetingMessage,
            'status' => Meeting::STATUS_PENDING,
            'scheduled_at' => $scheduledAt,
        ]);

        return response()->json([
            'success' => true,
            'meeting_id' => $meeting->id,
            'message' => 'Meeting request sent successfully'
        ]);
    }
}
