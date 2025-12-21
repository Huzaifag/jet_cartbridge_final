<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\UserInquiry;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $selectedDate = $request->get('date', now()->format('Y-m-d'));
        $view = $request->get('view', 'meeting'); // meeting, call, video
        $status = $request->get('status', 'all'); // all, pending, confirmed, completed, cancelled
        
        // Get meetings for the selected date
        $meetings = Meeting::with(['customer', 'seller', 'manufacturer'])
            ->whereDate('scheduled_at', $selectedDate)
            ->when($status !== 'all', function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->orderBy('scheduled_at')
            ->get();

        // Get inquiries that need follow-up
        $inquiries = UserInquiry::with(['user', 'product', 'seller', 'manufacturer'])
            ->whereDate('created_at', $selectedDate)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get active conversations
        $conversations = Conversation::with(['customer', 'seller', 'messages' => function ($query) use ($selectedDate) {
                $query->whereDate('created_at', $selectedDate)->latest()->limit(1);
            }])
            ->whereHas('messages', function ($query) use ($selectedDate) {
                $query->whereDate('created_at', $selectedDate);
            })
            ->orderBy('updated_at', 'desc')
            ->get();

        // Get calendar data for the week
        $weekStart = Carbon::parse($selectedDate)->startOfWeek();
        $weekDays = collect(range(0, 6))->map(function ($day) use ($weekStart) {
            $date = $weekStart->copy()->addDays($day);
            return [
                'date' => $date->format('Y-m-d'),
                'day' => $date->format('D'),
                'dayNumber' => $date->format('j'),
                'month' => $date->format('M'),
                'isToday' => $date->isToday(),
                'isSelected' => $date->format('Y-m-d') === request('date', now()->format('Y-m-d')),
                'meetingCount' => Meeting::whereDate('scheduled_at', $date)->count(),
                'inquiryCount' => UserInquiry::whereDate('created_at', $date)->where('status', 'pending')->count(),
            ];
        });

        // Statistics
        $stats = [
            'total_meetings' => Meeting::whereDate('scheduled_at', $selectedDate)->count(),
            'confirmed_meetings' => Meeting::whereDate('scheduled_at', $selectedDate)->where('status', 'confirmed')->count(),
            'pending_meetings' => Meeting::whereDate('scheduled_at', $selectedDate)->where('status', 'pending')->count(),
            'completed_meetings' => Meeting::whereDate('scheduled_at', $selectedDate)->where('status', 'completed')->count(),
            'total_inquiries' => UserInquiry::whereDate('created_at', $selectedDate)->count(),
            'pending_inquiries' => UserInquiry::whereDate('created_at', $selectedDate)->where('status', 'pending')->count(),
            'active_chats' => Conversation::whereHas('messages', function ($query) use ($selectedDate) {
                $query->whereDate('created_at', $selectedDate);
            })->count(),
        ];

        return view('admin.appointments.index', compact(
            'meetings',
            'inquiries', 
            'conversations',
            'weekDays',
            'selectedDate',
            'view',
            'status',
            'stats'
        ));
    }

    public function show($id)
    {
        $meeting = Meeting::with(['customer', 'seller', 'manufacturer'])->findOrFail($id);
        
        return view('admin.appointments.show', compact('meeting'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'notes' => 'nullable|string|max:1000',
        ]);

        $meeting = Meeting::findOrFail($id);
        $meeting->update([
            'status' => $request->status,
            'admin_notes' => $request->notes,
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Meeting status updated successfully',
            'meeting' => $meeting->load(['customer', 'seller', 'manufacturer'])
        ]);
    }

    public function updateInquiryStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved,closed',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $inquiry = UserInquiry::findOrFail($id);
        $inquiry->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Inquiry status updated successfully',
            'inquiry' => $inquiry->load(['user', 'product', 'seller', 'manufacturer'])
        ]);
    }

    public function createMeeting(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'seller_id' => 'nullable|exists:sellers,id',
            'manufacturer_id' => 'nullable|exists:manufacturers,id',
            'meeting_type' => 'required|in:physical,video,call',
            'scheduled_at' => 'required|date|after:now',
            'duration' => 'required|integer|min:15|max:480',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $meeting = Meeting::create([
            'customer_id' => $request->customer_id,
            'seller_id' => $request->seller_id,
            'manufacturer_id' => $request->manufacturer_id,
            'meeting_type' => $request->meeting_type,
            'scheduled_at' => $request->scheduled_at,
            'duration' => $request->duration,
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'confirmed',
            'created_by_admin' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Meeting created successfully',
            'meeting' => $meeting->load(['customer', 'seller', 'manufacturer'])
        ]);
    }

    public function getCalendarData(Request $request)
    {
        $date = $request->get('date', now()->format('Y-m-d'));
        $startDate = Carbon::parse($date)->startOfMonth();
        $endDate = Carbon::parse($date)->endOfMonth();

        $meetings = Meeting::whereBetween('scheduled_at', [$startDate, $endDate])
            ->get()
            ->groupBy(function ($meeting) {
                return $meeting->scheduled_at->format('Y-m-d');
            });

        $inquiries = UserInquiry::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'pending')
            ->get()
            ->groupBy(function ($inquiry) {
                return $inquiry->created_at->format('Y-m-d');
            });

        $calendarData = [];
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dateStr = $date->format('Y-m-d');
            $calendarData[$dateStr] = [
                'meetings' => $meetings->get($dateStr, collect())->count(),
                'inquiries' => $inquiries->get($dateStr, collect())->count(),
                'total' => $meetings->get($dateStr, collect())->count() + $inquiries->get($dateStr, collect())->count(),
            ];
        }

        return response()->json($calendarData);
    }

    public function searchCustomers(Request $request)
    {
        $query = $request->get('q');
        
        $customers = User::where('role', 'customer')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%");
            })
            ->limit(10)
            ->get(['id', 'name', 'email']);

        return response()->json($customers);
    }

    public function showInquiry($id)
    {
        $inquiry = UserInquiry::with(['user', 'product', 'seller', 'manufacturer'])->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'inquiry' => $inquiry
        ]);
    }

    public function convertToLead(Request $request, $id)
    {
        $inquiry = UserInquiry::findOrFail($id);
        
        // Create a lead from the inquiry
        $lead = \App\Models\Lead::create([
            'user_id' => $inquiry->user_id,
            'product_id' => $inquiry->product_id,
            'seller_id' => $inquiry->seller_id,
            'manufacturer_id' => $inquiry->manufacturer_id,
            'source' => 'inquiry',
            'status' => 'new',
            'priority' => 'medium',
            'notes' => $inquiry->message,
            'inquiry_id' => $inquiry->id,
        ]);

        // Update inquiry status
        $inquiry->update([
            'status' => 'converted_to_lead',
            'admin_notes' => 'Converted to lead #' . $lead->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Inquiry converted to lead successfully',
            'lead_id' => $lead->id
        ]);
    }

    public function export(Request $request)
    {
        $date = $request->get('date', now()->format('Y-m-d'));
        $view = $request->get('view', 'meeting');
        
        // Generate CSV export
        $filename = "appointments_{$date}_{$view}.csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($date, $view) {
            $file = fopen('php://output', 'w');
            
            if ($view === 'meeting') {
                fputcsv($file, ['Date', 'Time', 'Customer', 'Title', 'Type', 'Status', 'Duration']);
                
                $meetings = Meeting::with(['customer'])
                    ->whereDate('scheduled_at', $date)
                    ->orderBy('scheduled_at')
                    ->get();
                
                foreach ($meetings as $meeting) {
                    fputcsv($file, [
                        $meeting->scheduled_at->format('Y-m-d'),
                        $meeting->scheduled_at->format('H:i'),
                        $meeting->customer->name,
                        $meeting->title,
                        $meeting->meeting_type,
                        $meeting->status,
                        $meeting->duration . ' min'
                    ]);
                }
            } elseif ($view === 'call') {
                fputcsv($file, ['Date', 'Time', 'Customer', 'Product', 'Type', 'Status', 'Message']);
                
                $inquiries = UserInquiry::with(['user', 'product'])
                    ->whereDate('created_at', $date)
                    ->orderBy('created_at')
                    ->get();
                
                foreach ($inquiries as $inquiry) {
                    fputcsv($file, [
                        $inquiry->created_at->format('Y-m-d'),
                        $inquiry->created_at->format('H:i'),
                        $inquiry->user->name,
                        $inquiry->product->name ?? 'General',
                        $inquiry->inquiry_type ?? 'general',
                        $inquiry->status,
                        substr($inquiry->message, 0, 100)
                    ]);
                }
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}