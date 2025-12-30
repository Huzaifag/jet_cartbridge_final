<?php

namespace App\Http\Controllers\manufacturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ManufacturerLeadController extends Controller
{
    public function index(Request $request)
    {
        $manufacturer = Auth::user();
        
        // Sample leads data
        $leads = [
            [
                'id' => 1,
                'company_name' => 'TechStart Solutions',
                'contact_person' => 'Alex Johnson',
                'email' => 'alex@techstart.com',
                'phone' => '+1-555-0123',
                'source' => 'website',
                'status' => 'new',
                'priority' => 'high',
                'estimated_value' => 15000.00,
                'products_interested' => ['Wireless Headphones', 'Smart Watches'],
                'notes' => 'Interested in bulk purchase for employee gifts',
                'assigned_to' => 'John Smith',
                'created_at' => now()->subDays(1),
                'last_contact' => now()->subHours(6),
                'next_followup' => now()->addDays(2)
            ],
            [
                'id' => 2,
                'company_name' => 'Global Retail Corp',
                'contact_person' => 'Maria Garcia',
                'email' => 'maria@globalretail.com',
                'phone' => '+1-555-0456',
                'source' => 'referral',
                'status' => 'qualified',
                'priority' => 'medium',
                'estimated_value' => 25000.00,
                'products_interested' => ['Bluetooth Speakers', 'Phone Accessories'],
                'notes' => 'Looking for exclusive distribution rights',
                'assigned_to' => 'Sarah Johnson',
                'created_at' => now()->subDays(5),
                'last_contact' => now()->subDays(2),
                'next_followup' => now()->addDays(1)
            ],
            [
                'id' => 3,
                'company_name' => 'Innovation Hub',
                'contact_person' => 'David Chen',
                'email' => 'david@innovationhub.com',
                'phone' => '+1-555-0789',
                'source' => 'trade_show',
                'status' => 'proposal_sent',
                'priority' => 'high',
                'estimated_value' => 50000.00,
                'products_interested' => ['Smart Home Devices', 'IoT Sensors'],
                'notes' => 'Proposal sent for custom manufacturing project',
                'assigned_to' => 'Mike Wilson',
                'created_at' => now()->subDays(10),
                'last_contact' => now()->subDays(1),
                'next_followup' => now()->addDays(3)
            ]
        ];

        // Apply filters
        if ($request->has('status') && $request->status) {
            $leads = array_filter($leads, function($lead) use ($request) {
                return $lead['status'] === $request->status;
            });
        }

        if ($request->has('priority') && $request->priority) {
            $leads = array_filter($leads, function($lead) use ($request) {
                return $lead['priority'] === $request->priority;
            });
        }

        if ($request->has('source') && $request->source) {
            $leads = array_filter($leads, function($lead) use ($request) {
                return $lead['source'] === $request->source;
            });
        }

        // Lead statistics
        $leadStats = [
            'total_leads' => count($leads),
            'new_leads' => count(array_filter($leads, fn($l) => $l['status'] === 'new')),
            'qualified_leads' => count(array_filter($leads, fn($l) => $l['status'] === 'qualified')),
            'converted_leads' => count(array_filter($leads, fn($l) => $l['status'] === 'converted')),
            'total_estimated_value' => array_sum(array_column($leads, 'estimated_value')),
            'conversion_rate' => 23.5,
            'avg_deal_size' => 28500.00
        ];

        return view('manufacturer.leads.index', compact('leads', 'leadStats'));
    }

    public function create()
    {
        return view('manufacturer.leads.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'source' => 'required|in:website,referral,trade_show,cold_call,social_media,advertisement',
            'priority' => 'required|in:low,medium,high',
            'estimated_value' => 'nullable|numeric|min:0',
            'products_interested' => 'nullable|array',
            'notes' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Here you would save to database
        $lead = [
            'id' => rand(100, 999),
            'company_name' => $request->company_name,
            'contact_person' => $request->contact_person,
            'email' => $request->email,
            'phone' => $request->phone,
            'source' => $request->source,
            'status' => 'new',
            'priority' => $request->priority,
            'estimated_value' => $request->estimated_value ?? 0,
            'products_interested' => $request->products_interested ?? [],
            'notes' => $request->notes,
            'assigned_to' => Auth::user()->name,
            'created_at' => now()
        ];

        return response()->json([
            'success' => true,
            'message' => 'Lead created successfully',
            'lead' => $lead
        ]);
    }

    public function show($id)
    {
        // Sample lead details with activity history
        $lead = [
            'id' => $id,
            'company_name' => 'TechStart Solutions',
            'contact_person' => 'Alex Johnson',
            'email' => 'alex@techstart.com',
            'phone' => '+1-555-0123',
            'source' => 'website',
            'status' => 'qualified',
            'priority' => 'high',
            'estimated_value' => 15000.00,
            'products_interested' => ['Wireless Headphones', 'Smart Watches'],
            'notes' => 'Interested in bulk purchase for employee gifts',
            'assigned_to' => 'John Smith',
            'created_at' => now()->subDays(5),
            'last_contact' => now()->subHours(6),
            'next_followup' => now()->addDays(2),
            'activities' => [
                [
                    'type' => 'call',
                    'description' => 'Initial qualification call completed',
                    'date' => now()->subDays(1),
                    'user' => 'John Smith'
                ],
                [
                    'type' => 'email',
                    'description' => 'Sent product catalog and pricing information',
                    'date' => now()->subDays(2),
                    'user' => 'John Smith'
                ],
                [
                    'type' => 'meeting',
                    'description' => 'Scheduled demo meeting for next week',
                    'date' => now()->subDays(3),
                    'user' => 'John Smith'
                ]
            ],
            'documents' => [
                ['name' => 'Product Catalog.pdf', 'size' => '2.5 MB', 'date' => now()->subDays(2)],
                ['name' => 'Pricing Sheet.xlsx', 'size' => '1.2 MB', 'date' => now()->subDays(2)]
            ]
        ];

        return response()->json($lead);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'source' => 'required|in:website,referral,trade_show,cold_call,social_media,advertisement',
            'status' => 'required|in:new,contacted,qualified,proposal_sent,negotiation,converted,lost',
            'priority' => 'required|in:low,medium,high',
            'estimated_value' => 'nullable|numeric|min:0',
            'products_interested' => 'nullable|array',
            'notes' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Here you would update in database
        return response()->json([
            'success' => true,
            'message' => 'Lead updated successfully'
        ]);
    }

    public function destroy($id)
    {
        // Here you would delete from database
        return response()->json([
            'success' => true,
            'message' => 'Lead deleted successfully'
        ]);
    }

    public function addActivity(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:call,email,meeting,note,task',
            'description' => 'required|string|max:500',
            'date' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Here you would save activity to database
        $activity = [
            'id' => rand(1000, 9999),
            'lead_id' => $id,
            'type' => $request->type,
            'description' => $request->description,
            'date' => $request->date,
            'user' => Auth::user()->name,
            'created_at' => now()
        ];

        return response()->json([
            'success' => true,
            'message' => 'Activity added successfully',
            'activity' => $activity
        ]);
    }

    public function convertToCustomer($id)
    {
        // Here you would convert lead to customer
        return response()->json([
            'success' => true,
            'message' => 'Lead converted to customer successfully',
            'customer_id' => rand(100, 999)
        ]);
    }

    public function getLeadStats(Request $request)
    {
        $period = $request->get('period', '30');

        $stats = [
            'leads_by_source' => [
                'website' => rand(10, 30),
                'referral' => rand(5, 20),
                'trade_show' => rand(3, 15),
                'cold_call' => rand(2, 10),
                'social_media' => rand(5, 25),
                'advertisement' => rand(3, 12)
            ],
            'leads_by_status' => [
                'new' => rand(5, 15),
                'contacted' => rand(8, 20),
                'qualified' => rand(6, 18),
                'proposal_sent' => rand(4, 12),
                'negotiation' => rand(2, 8),
                'converted' => rand(3, 10),
                'lost' => rand(2, 8)
            ],
            'conversion_funnel' => [
                'total_leads' => 100,
                'contacted' => 85,
                'qualified' => 65,
                'proposal_sent' => 45,
                'negotiation' => 25,
                'converted' => 15
            ],
            'monthly_trend' => $this->generateMonthlyTrend($period)
        ];

        return response()->json($stats);
    }

    private function generateMonthlyTrend($period)
    {
        $trend = [];
        $months = min($period / 30, 12);

        for ($i = $months; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $trend[] = [
                'month' => $date->format('M Y'),
                'new_leads' => rand(10, 50),
                'converted' => rand(2, 15),
                'conversion_rate' => rand(15, 35)
            ];
        }

        return $trend;
    }

    public function exportLeads(Request $request)
    {
        $format = $request->get('format', 'excel');
        $status = $request->get('status', 'all');
        $dateRange = $request->get('date_range', '30');

        return response()->json([
            'success' => true,
            'message' => 'Leads exported successfully',
            'download_url' => '#',
            'filters' => [
                'format' => $format,
                'status' => $status,
                'date_range' => $dateRange
            ]
        ]);
    }
}