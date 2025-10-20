<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Accountant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AccountantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Auth::user()->seller->accountants();

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

        $accountants = $query->paginate(9);
        return view('seller.employees.accountant.index', compact('accountants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('seller.employees.accountant.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 🔹 Step 1: Validate Inputs
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

        // 🔹 Step 2: Double-check if User already exists (for extra safety)
        if (User::where('email', $request->email)->exists()) {
            return back()->withErrors(['email' => 'A user with this email already exists.'])->withInput();
        }

        // 🔹 Step 3: Create New User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'status' => $request->status,
        ]);

        // 🔹 Step 4: Prepare Accountant Data
        $data = $request->only(['name', 'email', 'phone', 'designation', 'salary', 'joining_date', 'status']);
        $data['seller_id'] = Auth::user()->seller->id;
        $data['user_id'] = $user->id;

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('accountants', 'public');
        }

        // 🔹 Step 5: Create Accountant
        $accountant = Accountant::create($data);

        // 🔹 Step 6: Assign Role
        $role = Role::firstOrCreate(['name' => 'Accountant', 'guard_name' => 'web']);
        $user->assignRole($role);

        // 🔹 Step 7: Redirect with success message
        return redirect()->route('seller.employees.accountant.index')
            ->with('success', 'Accountant created successfully with linked user account.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Accountant $accountant)
    {
        // Ensure the accountant belongs to the current seller
        if ($accountant->seller_id !== Auth::user()->seller->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('seller.employees.accountant.show', compact('accountant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Accountant $accountant)
    {
        // Ensure the accountant belongs to the current seller
        if ($accountant->seller_id !== Auth::user()->seller->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('seller.employees.accountant.edit', compact('accountant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Accountant $accountant)
    {
        // Ensure the accountant belongs to the current seller
        if ($accountant->seller_id !== Auth::user()->seller->id) {
            abort(403, 'Unauthorized action.');
        }

        // 🔹 Validate Inputs
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $accountant->user_id,
            'phone' => 'nullable|string|max:20',
            'designation' => 'nullable|string|max:50',
            'salary' => 'nullable|numeric|min:0',
            'joining_date' => 'nullable|date',
            'avatar' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
            'password' => 'nullable|string|min:8|confirmed', // Optional password update
        ]);

        // 🔹 Update User
        $user = $accountant->user;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = $request->status;

        // Only update password if provided
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        // 🔹 Update Accountant
        $data = $request->only(['name', 'email', 'phone', 'designation', 'salary', 'joining_date', 'status']);

        if ($request->hasFile('avatar')) {
            // Optionally delete old avatar if needed
            $data['avatar'] = $request->file('avatar')->store('accountants', 'public');
        }

        $accountant->update($data);

        return redirect()->route('seller.employees.accountant.index')
            ->with('success', 'Accountant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Accountant $accountant)
    {
        // Ensure the accountant belongs to the current seller
        if ($accountant->seller_id !== Auth::user()->seller->id) {
            abort(403, 'Unauthorized action.');
        }

        // 🔹 Delete associated user (optional: you might want to soft-delete or deactivate instead)
        $accountant->user->delete();

        // 🔹 Delete accountant record
        $accountant->delete();

        return redirect()->route('seller.employees.accountant.index')
            ->with('success', 'Accountant deleted successfully.');
    }
}