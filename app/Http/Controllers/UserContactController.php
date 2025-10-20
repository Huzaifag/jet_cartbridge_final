<?php

namespace App\Http\Controllers;

use App\Models\UserContact;
use Illuminate\Http\Request;

class UserContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userContacts = auth()->user()->contacts;
        return view('frontend.pages.user-contact', compact('userContacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'mobile'        => 'required|string|max:20',
            'location_type' => 'required|string|max:50',
            'address'       => 'nullable|string|max:500',
            'city'          => 'nullable|string|max:100',
            'state'         => 'nullable|string|max:100',
        ]);

        $validated['user_id'] = auth()->id();

        // Make all other contacts inactive for this user
        UserContact::where('user_id', auth()->id())->update(['status' => 'inactive']);

        // Create the new one as active
        $validated['status'] = 'active';

        UserContact::create($validated);

        return redirect()
            ->route('user.contacts.index')
            ->with('success', 'Contact created successfully and set as active!');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
