<?php

namespace App\Http\Controllers\manufacturer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManufacturerAccountantController extends Controller
{
    public function index()
    {
        $manufacturer = auth()->user()->manufacturer;
        $accountants = \App\Models\Accountant::where('manufacturer_id', $manufacturer->id)
            ->latest()
            ->paginate(10);

        return view('manufacturer.employees.accountant.index', compact('accountants'));
    }

    public function create()
    {
        return view('manufacturer.employees.accountant.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'designation' => 'nullable|string|max:50',
            'salary' => 'nullable|numeric|min:0',
            'joining_date' => 'nullable|date',
            'status' => 'required|in:active,inactive'
        ]);

        $manufacturer = auth()->user()->manufacturer;

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'status' => $validated['status'] ?? 'active',
        ]);

        \App\Models\Accountant::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'designation' => $validated['designation'] ?? null,
            'salary' => $validated['salary'] ?? null,
            'joining_date' => $validated['joining_date'] ?? null,
            'status' => $validated['status'] ?? 'active',
            'manufacturer_id' => $manufacturer->id,
            'user_id' => $user->id,
        ]);

        $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'accountant', 'guard_name' => 'web']);
        $user->assignRole($role);

        return redirect()->route('manufacturer.employees.accountant.index')
            ->with('success', 'Accountant created successfully');
    }

    public function edit(User $accountant)
    {
        return view('manufacturer.employees.accountant.edit', compact('accountant'));
    }

    public function update(Request $request, User $accountant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $accountant->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|min:8|confirmed'
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone']
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $accountant->update($data);

        return redirect()->route('manufacturer.employees.accountant.index')
            ->with('success', 'Accountant updated successfully');
    }

    public function destroy(User $accountant)
    {
        $accountant->delete();

        return redirect()->route('manufacturer.employees.accountant.index')
            ->with('success', 'Accountant deleted successfully');
    }
}
