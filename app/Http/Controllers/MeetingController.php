<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function customerRequest(Request $request)
    {
        $request->validate([
            'seller_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'title' => 'required|string|max:255',
            'message' => 'nullable|string',
            'scheduled_at' => 'required|date|after:now',
        ]);

        $meeting = Meeting::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->seller_id,
            'title' => $request->title,
            'message' => $request->message,
            'scheduled_at' => $request->scheduled_at,
        ]);

        return response()->json([
            'success' => true,
            'meeting' => $meeting,
            'message' => 'Meeting request sent successfully!',
        ]);
    }

    public function accept($id)
    {
        $meeting = Meeting::findOrFail($id);

        // Ensure only receiver can accept
        if ($meeting->receiver_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ]);
        }

        // If room_name not set (or empty), generate one now
        if (empty($meeting->room_name)) {
            $meeting->room_name = 'meeting_' . \Illuminate\Support\Str::random(12) . '_' . time();
        }

        // Update meeting status and room name
        $meeting->update([
            'status' => Meeting::STATUS_ACCEPTED,
            'room_name' => $meeting->room_name,
        ]);

        // Return success with redirect URL
        return response()->json([
            'success' => true,
            'message' => 'Meeting accepted successfully.',
            'redirect_url' => route('meeting.join', $meeting->room_name),
        ]);
    }


    public function reject($id)
    {
        $meeting = Meeting::findOrFail($id);

        if ($meeting->receiver_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized']);
        }

        $meeting->update(['status' => 'rejected']);

        return response()->json(['success' => true]);
    }

    public function join($room_name)
    {
        $meeting = Meeting::where('room_name', $room_name)->firstOrFail();

        // Optional: restrict access only to sender or receiver
        if (!in_array(auth()->id(), [$meeting->sender_id, $meeting->receiver_id])) {
            abort(403, 'Unauthorized access to this meeting.');
        }

        // Pass the room name and user info to the Jitsi view
        return view('frontend.meeting.index', [
            'meeting' => $meeting,
            'roomName' => $room_name,
            'user' => auth()->user(),
        ]);
    }


}
