<?php

namespace App\Http\Controllers\manufacturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ManufacturerContactBookController extends Controller
{
    public function index(Request $request)
    {
        $manufacturer = Auth::user();
        
        // Sample contacts data - replace with actual database queries
        $contacts = [
            [
                'id' => 1,
                'name' => 'John Smith',
                'company' => 'ABC Electronics',
                'email' => 'john@abcelectronics.com',
                'phone' => '+1-555-0123',
                'location' => 'New York, USA',
                'type' => 'customer',
                'status' => 'active',
                'avatar' => null,
                'created_at' => now()->subDays(5)
            ],
            [
                'id' => 2,
                'name' => 'Sarah Johnson',
                'company' => 'Tech Solutions Inc',
                'email' => 'sarah@techsolutions.com',
                'phone' => '+1-555-0456',
                'location' => 'California, USA',
                'type' => 'supplier',
                'status' => 'active',
                'avatar' => null,
                'created_at' => now()->subDays(10)
            ],
            [
                'id' => 3,
                'name' => 'Michael Brown',
                'company' => 'Global Partners',
                'email' => 'michael@globalpartners.com',
                'phone' => '+1-555-0789',
                'location' => 'Texas, USA',
                'type' => 'partner',
                'status' => 'active',
                'avatar' => null,
                'created_at' => now()->subDays(15)
            ],
            [
                'id' => 4,
                'name' => 'Emily Davis',
                'company' => 'Future Innovations',
                'email' => 'emily@futureinnovations.com',
                'phone' => '+1-555-0321',
                'location' => 'Florida, USA',
                'type' => 'lead',
                'status' => 'inactive',
                'avatar' => null,
                'created_at' => now()->subDays(20)
            ]
        ];

        // Apply filters if provided
        if ($request->has('type') && $request->type) {
            $contacts = array_filter($contacts, function($contact) use ($request) {
                return $contact['type'] === $request->type;
            });
        }

        if ($request->has('status') && $request->status) {
            $contacts = array_filter($contacts, function($contact) use ($request) {
                return $contact['status'] === $request->status;
            });
        }

        if ($request->has('search') && $request->search) {
            $searchTerm = strtolower($request->search);
            $contacts = array_filter($contacts, function($contact) use ($searchTerm) {
                return strpos(strtolower($contact['name']), $searchTerm) !== false ||
                       strpos(strtolower($contact['company']), $searchTerm) !== false ||
                       strpos(strtolower($contact['email']), $searchTerm) !== false;
            });
        }

        return view('manufacturer.contact-book.index', compact('contacts'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'type' => 'required|in:customer,supplier,partner,lead',
            'status' => 'required|in:active,inactive',
            'address' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Here you would save to database
        // For now, return success response
        return response()->json([
            'success' => true,
            'message' => 'Contact added successfully',
            'contact' => [
                'id' => rand(100, 999),
                'name' => $request->name,
                'email' => $request->email,
                'company' => $request->company,
                'phone' => $request->phone,
                'type' => $request->type,
                'status' => $request->status,
                'address' => $request->address,
                'notes' => $request->notes,
                'created_at' => now()
            ]
        ]);
    }

    public function show($id)
    {
        // Sample contact details
        $contact = [
            'id' => $id,
            'name' => 'John Smith',
            'company' => 'ABC Electronics',
            'email' => 'john@abcelectronics.com',
            'phone' => '+1-555-0123',
            'location' => 'New York, USA',
            'type' => 'customer',
            'status' => 'active',
            'address' => '123 Business St, New York, NY 10001',
            'notes' => 'Important customer with high volume orders',
            'avatar' => null,
            'created_at' => now()->subDays(5),
            'last_contact' => now()->subDays(2),
            'total_orders' => 15,
            'total_spent' => 25000.00
        ];

        return response()->json($contact);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'type' => 'required|in:customer,supplier,partner,lead',
            'status' => 'required|in:active,inactive',
            'address' => 'nullable|string|max:500',
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
            'message' => 'Contact updated successfully'
        ]);
    }

    public function destroy($id)
    {
        // Here you would delete from database
        return response()->json([
            'success' => true,
            'message' => 'Contact deleted successfully'
        ]);
    }

    public function export(Request $request)
    {
        $format = $request->get('format', 'csv');
        
        // Here you would generate and return the export file
        return response()->json([
            'success' => true,
            'message' => 'Contacts exported successfully',
            'download_url' => '#'
        ]);
    }

    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:csv,xlsx|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Here you would process the import file
        return response()->json([
            'success' => true,
            'message' => 'Contacts imported successfully',
            'imported_count' => rand(10, 50)
        ]);
    }
}