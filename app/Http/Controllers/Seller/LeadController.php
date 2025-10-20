<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index()
    {
        $leads = Lead::where('seller_id', auth()->id())->with('salesman', 'product')->get();
        $salesmen = auth()->user()->salesmen; // Assuming a seller has many salesmen relationship
        return view('seller.leads.index', compact('leads', 'salesmen'));
    }

    public function assign($leadId)
    {
        // Logic to assign the lead to a team member
        return redirect()->route('seller.leads')->with('success', 'Lead assigned successfully.');
    }
}
