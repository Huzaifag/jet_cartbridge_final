<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\DeliveryMan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Auth::user()->seller->deliverymen();

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

        $deliverymen = $query->paginate(9);
        return view('seller.employees.deliveryman.index', compact('deliverymen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('seller.employees.deliveryman.create');
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
            // ✅ Fixed: was 'accountants' — now 'deliverymen'
            $data['avatar'] = $request->file('avatar')->store('deliverymen', 'public');
        }

        $deliveryMan = DeliveryMan::create($data);

        $role = Role::firstOrCreate(['name' => 'deliveryman', 'guard_name' => 'web']);
        $user->assignRole($role);

        // ✅ Fixed route name: should match your route definition
        return redirect()->route('seller.employees.deliveryman.index')
            ->with('success', 'Deliveryman created successfully with linked user account.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DeliveryMan $deliveryMan)
    {
        if ($deliveryMan->seller_id !== Auth::user()->seller->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('seller.employees.deliveryman.show', compact('deliveryMan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeliveryMan $deliveryMan)
    {
        if ($deliveryMan->seller_id !== Auth::user()->seller->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('seller.employees.deliveryman.edit', compact('deliveryMan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DeliveryMan $deliveryMan)
    {
        if ($deliveryMan->seller_id !== Auth::user()->seller->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $deliveryMan->user_id,
            'phone' => 'nullable|string|max:20',
            'designation' => 'nullable|string|max:50',
            'salary' => 'nullable|numeric|min:0',
            'joining_date' => 'nullable|date',
            'avatar' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update User
        $user = $deliveryMan->user;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = $request->status;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        // Update DeliveryMan
        $data = $request->only(['name', 'email', 'phone', 'designation', 'salary', 'joining_date', 'status']);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('deliverymen', 'public');
        }

        $deliveryMan->update($data);

        return redirect()->route('seller.employees.deliveryman.index')
            ->with('success', 'Deliveryman updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeliveryMan $deliveryMan)
    {
        if ($deliveryMan->seller_id !== Auth::user()->seller->id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete associated user
        $deliveryMan->user->delete();

        // Delete deliveryman record
        $deliveryMan->delete();

        return redirect()->route('seller.employees.deliveryman.index')
            ->with('success', 'Deliveryman deleted successfully.');
    }
}