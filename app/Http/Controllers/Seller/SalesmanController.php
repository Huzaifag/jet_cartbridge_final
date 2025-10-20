<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Salesman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class SalesmanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Auth::user()->seller->salesmen();

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

        $salesmen = $query->paginate(9);
        return view('seller.employees.salesman.index', compact('salesmen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('seller.employees.salesman.create');
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

        // 🔹 Step 4: Prepare Salesman Data
        $data = $request->only(['name', 'email', 'phone', 'designation', 'salary', 'joining_date', 'status']);
        $data['seller_id'] = Auth::user()->seller->id;
        $data['user_id'] = $user->id;

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('salesman', 'public');
        }

        // 🔹 Step 5: Create Salesman
        $salesman = Salesman::create($data); // ✅ Fixed: was $accountant

        // 🔹 Step 6: Assign Role
        $role = Role::firstOrCreate(['name' => 'salesman', 'guard_name' => 'web']);
        $user->assignRole($role);

        // 🔹 Step 7: Redirect with success message
        return redirect()->route('seller.employees.salesman.index')
            ->with('success', 'Salesman created successfully with linked user account.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Salesman $salesman)
    {
        // Ensure the salesman belongs to the current seller
        if ($salesman->seller_id !== Auth::user()->seller->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('seller.employees.salesman.show', compact('salesman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Salesman $salesman)
    {
        // Ensure the salesman belongs to the current seller
        if ($salesman->seller_id !== Auth::user()->seller->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('seller.employees.salesman.edit', compact('salesman')); // ✅ Moved outside if
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Salesman $salesman)
    {
        // Ensure the salesman belongs to the current seller
        if ($salesman->seller_id !== Auth::user()->seller->id) {
            abort(403, 'Unauthorized action.');
        }

        // 🔹 Validate Inputs
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $salesman->user_id, // ✅ Fixed: was $accountant
            'phone' => 'nullable|string|max:20',
            'designation' => 'nullable|string|max:50',
            'salary' => 'nullable|numeric|min:0',
            'joining_date' => 'nullable|date',
            'avatar' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // 🔹 Update User
        $user = $salesman->user;
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        // 🔹 Update Salesman
        $data = $request->only(['name', 'email', 'phone', 'designation', 'salary', 'joining_date', 'status']);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('salesman', 'public');
        }

        $salesman->update($data); // ✅ Fixed: was $accountant

        return redirect()->route('seller.employees.salesman.index')
            ->with('success', 'Salesman updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salesman $salesman)
    {
        // Ensure the salesman belongs to the current seller
        if ($salesman->seller_id !== Auth::user()->seller->id) {
            abort(403, 'Unauthorized action.');
        }

        // 🔹 Delete associated user
        $salesman->user->delete();

        // 🔹 Delete salesman record
        $salesman->delete();

        return redirect()->route('seller.employees.salesman.index')
            ->with('success', 'Salesman deleted successfully.');
    }
}