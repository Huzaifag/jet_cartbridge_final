<?php

namespace App\Http\Controllers\manufacturer;

use App\Http\Controllers\Controller;
use App\Models\Salesman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class ManufacturerSalesmanController extends Controller
{
    public function index(Request $request)
    {
        $query = Salesman::where('manufacturer_id', Auth::user()->manufacturer->id);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('designation')) {
            $query->where('designation', $request->designation);
        }

        $salesmen = $query->latest()->paginate(9);
        return view('manufacturer.employees.salesman.index', compact('salesmen'));
    }

    public function create()
    {
        return view('manufacturer.employees.salesman.create');
    }

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

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'status' => $request->status,
        ]);

        $data = $request->only(['name', 'email', 'phone', 'designation', 'salary', 'joining_date', 'status']);
        $data['manufacturer_id'] = Auth::user()->manufacturer->id;
        $data['user_id'] = $user->id;

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('salesman', 'public');
        }

        Salesman::create($data);

        $role = Role::firstOrCreate(['name' => 'salesman', 'guard_name' => 'web']);
        $user->assignRole($role);

        return redirect()->route('manufacturer.employees.salesman.index')
            ->with('success', 'Salesman created successfully.');
    }

    public function show(Salesman $salesman)
    {
        if ($salesman->manufacturer_id !== Auth::user()->manufacturer->id) {
            abort(403);
        }
        return view('manufacturer.employees.salesman.show', compact('salesman'));
    }

    public function edit(Salesman $salesman)
    {
        if ($salesman->manufacturer_id !== Auth::user()->manufacturer->id) {
            abort(403);
        }
        return view('manufacturer.employees.salesman.edit', compact('salesman'));
    }

    public function update(Request $request, Salesman $salesman)
    {
        if ($salesman->manufacturer_id !== Auth::user()->manufacturer->id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $salesman->user_id,
            'phone' => 'nullable|string|max:20',
            'designation' => 'nullable|string|max:50',
            'salary' => 'nullable|numeric|min:0',
            'joining_date' => 'nullable|date',
            'avatar' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = $salesman->user;
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        $data = $request->only(['name', 'email', 'phone', 'designation', 'salary', 'joining_date', 'status']);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('salesman', 'public');
        }

        $salesman->update($data);

        return redirect()->route('manufacturer.employees.salesman.index')
            ->with('success', 'Salesman updated successfully.');
    }

    public function destroy(Salesman $salesman)
    {
        if ($salesman->manufacturer_id !== Auth::user()->manufacturer->id) {
            abort(403);
        }

        $salesman->user->delete();
        $salesman->delete();

        return redirect()->route('manufacturer.employees.salesman.index')
            ->with('success', 'Salesman deleted successfully.');
    }
}
