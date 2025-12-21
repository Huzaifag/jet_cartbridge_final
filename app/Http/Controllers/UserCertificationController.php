<?php

namespace App\Http\Controllers;

use App\Models\UserCertification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserCertificationController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    /**
     * Store a new certification
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'issuing_organization' => 'required|string|max:255',
            'credential_id' => 'nullable|string|max:255',
            'credential_url' => 'nullable|url|max:255',
            'issue_date' => 'required|date',
            'expiration_date' => 'nullable|date|after:issue_date',
            'does_not_expire' => 'boolean',
            'description' => 'nullable|string|max:1000',
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:100',
            'organization_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
        ]);

        // If does not expire, set expiration_date to null
        if ($validated['does_not_expire']) {
            $validated['expiration_date'] = null;
        }

        // Handle organization logo upload
        if ($request->hasFile('organization_logo')) {
            $validated['organization_logo'] = $request->file('organization_logo')
                ->store('organization-logos', 'public');
        }

        $validated['user_id'] = Auth::id();

        UserCertification::create($validated);

        return redirect()->route('profile.edit')
            ->with('success', 'Certification added successfully!');
    }

    /**
     * Update certification
     */
    public function update(Request $request, UserCertification $certification)
    {
        $this->authorize('update', $certification);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'issuing_organization' => 'required|string|max:255',
            'credential_id' => 'nullable|string|max:255',
            'credential_url' => 'nullable|url|max:255',
            'issue_date' => 'required|date',
            'expiration_date' => 'nullable|date|after:issue_date',
            'does_not_expire' => 'boolean',
            'description' => 'nullable|string|max:1000',
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:100',
            'organization_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
        ]);

        // If does not expire, set expiration_date to null
        if ($validated['does_not_expire']) {
            $validated['expiration_date'] = null;
        }

        // Handle organization logo upload
        if ($request->hasFile('organization_logo')) {
            // Delete old logo
            if ($certification->organization_logo) {
                Storage::disk('public')->delete($certification->organization_logo);
            }
            
            $validated['organization_logo'] = $request->file('organization_logo')
                ->store('organization-logos', 'public');
        }

        $certification->update($validated);

        return redirect()->route('profile.edit')
            ->with('success', 'Certification updated successfully!');
    }

    /**
     * Delete certification
     */
    public function destroy(UserCertification $certification)
    {
        $this->authorize('delete', $certification);

        // Delete organization logo if exists
        if ($certification->organization_logo) {
            Storage::disk('public')->delete($certification->organization_logo);
        }

        $certification->delete();

        return redirect()->route('profile.edit')
            ->with('success', 'Certification deleted successfully!');
    }
}