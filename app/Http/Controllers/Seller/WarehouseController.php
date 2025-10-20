<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WareHouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Auth::user()->seller->warehouses();

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by designation
        if ($request->filled('designation')) {
            $query->where('designation', $request->designation);
        }

        // Sorting
        if ($request->filled('sort')) {
            $query->orderBy($request->sort, 'asc');
        } else {
            $query->latest();
        }

        $warehouses = $query->paginate(9);
        return view('seller.employees.warehouse.index', compact('warehouses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('seller.employees.warehouse.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'designation' => 'nullable|string|max:50',
            'salary' => 'nullable|numeric|min:0',
            'joining_date' => 'nullable|date',
            'avatar' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (User::where('email', $request->email)->exists()) {
            return back()->withErrors(['email' => 'A user with this email already exists.'])->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'status' => $request->status,
        ]);

        $data = $request->only(['name', 'email', 'phone', 'designation', 'salary', 'joining_date', 'status']);
        $data['seller_id'] = Auth::user()->seller->id;
        $data['user_id'] = $user->id;

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('warehouse', 'public');
        }

        $warehouse = WareHouse::create($data);

        $role = Role::firstOrCreate(['name' => 'warehouse', 'guard_name' => 'web']);
        $user->assignRole($role);

        return redirect()->route('seller.employees.warehouse.index')
            ->with('success', 'Warehouse Manager created successfully with linked user account.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $wareHouse = Auth::user()->seller->warehouses()->findOrFail($id);

        return view('seller.employees.warehouse.show', compact('wareHouse'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $warehouse = Auth::user()->seller->warehouses()->findOrFail($id);

        return view('seller.employees.warehouse.edit', compact('warehouse'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $warehouse = Auth::user()->seller->warehouses()->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $warehouse->user_id,
            'phone' => 'nullable|string|max:20',
            'designation' => 'nullable|string|max:50',
            'salary' => 'nullable|numeric|min:0',
            'joining_date' => 'nullable|date',
            'avatar' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update User
        $user = $warehouse->user;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = $request->status;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        // Update Warehouse Manager
        $data = $request->only(['name', 'email', 'phone', 'designation', 'salary', 'joining_date', 'status']);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('warehouse', 'public');
        }

        $warehouse->update($data);

        return redirect()->route('seller.employees.warehouse.index')
            ->with('success', 'Warehouse Manager updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $warehouse = Auth::user()->seller->warehouses()->findOrFail($id);

        // Delete associated user
        $warehouse->user->delete();

        // Delete warehouse manager record
        $warehouse->delete();

        return redirect()->route('seller.employees.warehouse.index')
            ->with('success', 'Warehouse Manager deleted successfully.');
    }
}