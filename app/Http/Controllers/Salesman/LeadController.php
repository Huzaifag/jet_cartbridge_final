<?php

namespace App\Http\Controllers\Salesman;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Salesman;
use App\Models\UserInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeadController extends Controller
{
    /**
     * Display a listing of leads for the salesman
     */
    public function index(Request $request)
    {
        $salesman = Auth::user()->salesman;
        
        $query = Lead::with(['buyer', 'product', 'seller', 'assignedToSalesman', 'splitFromSalesman'])
            ->myLeads($salesman->id);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%")
                  ->orWhereHas('buyer', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $leads = $query->latest()->paginate(15);

        // Get statistics
        $stats = [
            'total' => Lead::myLeads($salesman->id)->count(),
            'pending' => Lead::myLeads($salesman->id)->where('status', 'pending')->count(),
            'in_progress' => Lead::myLeads($salesman->id)->where('status', 'in_progress')->count(),
            'converted' => Lead::myLeads($salesman->id)->where('status', 'converted')->count(),
            'high_priority' => Lead::myLeads($salesman->id)->where('priority', 'high')->count(),
        ];

        // Get team salesmen for splitting
        $teamSalesmen = Salesman::where('seller_id', $salesman->seller_id)
            ->where('id', '!=', $salesman->id)
            ->where('status', 'active')
            ->get();

        return view('salesman.leads.index', compact('leads', 'stats', 'teamSalesmen'));
    }

    /**
     * Display the specified lead
     */
    public function show($id)
    {
        $salesman = Auth::user()->salesman;
        
        $lead = Lead::with(['buyer', 'product', 'seller', 'assignedToSalesman', 'splitFromSalesman'])
            ->myLeads($salesman->id)
            ->findOrFail($id);

        // Get team salesmen for splitting
        $teamSalesmen = Salesman::where('seller_id', $salesman->seller_id)
            ->where('id', '!=', $salesman->id)
            ->where('status', 'active')
            ->get();

        return view('salesman.leads.show', compact('lead', 'teamSalesmen'));
    }

    /**
     * Update lead status
     */
    public function updateStatus(Request $request, $id)
    {
        $salesman = Auth::user()->salesman;
        
        $lead = Lead::myLeads($salesman->id)->findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,in_progress,converted,lost',
        ]);

        $lead->update([
            'status' => $request->status,
            'followed_up_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Lead status updated successfully!');
    }

    /**
     * Update lead priority
     */
    public function updatePriority(Request $request, $id)
    {
        $salesman = Auth::user()->salesman;
        
        $lead = Lead::myLeads($salesman->id)->findOrFail($id);

        $request->validate([
            'priority' => 'required|in:low,medium,high,urgent',
        ]);

        $lead->update(['priority' => $request->priority]);

        return redirect()->back()->with('success', 'Lead priority updated successfully!');
    }

    /**
     * Split/Assign lead to another salesman
     */
    public function split(Request $request, $id)
    {
        $salesman = Auth::user()->salesman;
        
        $lead = Lead::myLeads($salesman->id)->findOrFail($id);

        $request->validate([
            'assigned_to_salesman_id' => 'required|exists:salesmen,id',
            'split_notes' => 'nullable|string|max:500',
        ]);

        // Verify the target salesman is from the same company
        $targetSalesman = Salesman::where('id', $request->assigned_to_salesman_id)
            ->where('seller_id', $salesman->seller_id)
            ->where('status', 'active')
            ->firstOrFail();

        $lead->update([
            'assigned_to_salesman_id' => $targetSalesman->id,
            'split_from_salesman_id' => $salesman->id,
            'assigned_at' => now(),
            'split_notes' => $request->split_notes,
        ]);

        return redirect()->route('salesman.leads.index')
            ->with('success', "Lead successfully assigned to {$targetSalesman->user->name}!");
    }

    /**
     * Mark lead as followed up
     */
    public function markFollowedUp($id)
    {
        $salesman = Auth::user()->salesman;
        
        $lead = Lead::myLeads($salesman->id)->findOrFail($id);

        $lead->update(['followed_up_at' => now()]);

        return redirect()->back()->with('success', 'Lead marked as followed up!');
    }

    /**
     * Convert UserInquiry to Lead
     */
    public function convertInquiryToLead($inquiryId)
    {
        $salesman = Auth::user()->salesman;
        
        $inquiry = UserInquiry::where('seller_id', $salesman->seller_id)
            ->findOrFail($inquiryId);

        // Check if lead already exists
        $existingLead = Lead::where('buyer_id', $inquiry->customer_id)
            ->where('product_id', $inquiry->product_id)
            ->where('seller_id', $inquiry->seller_id)
            ->first();

        if ($existingLead) {
            return redirect()->back()->with('info', 'This inquiry is already converted to a lead.');
        }

        // Create lead from inquiry
        $lead = Lead::create([
            'seller_id' => $inquiry->seller_id,
            'buyer_id' => $inquiry->customer_id,
            'salesman_id' => $salesman->id,
            'product_id' => $inquiry->product_id,
            'email' => $inquiry->customer->email ?? null,
            'message' => $inquiry->message,
            'status' => 'pending',
            'priority' => 'medium',
        ]);

        return redirect()->route('salesman.leads.show', $lead->id)
            ->with('success', 'Inquiry converted to lead successfully!');
    }
}
