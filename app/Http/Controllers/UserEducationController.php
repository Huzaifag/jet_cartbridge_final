<?php

namespace App\Http\Controllers;

use App\Models\UserEducation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserEducationController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    /**
     * Store a new education
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'institution_name' => 'required|string|max:255',
            'degree' => 'nullable|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
            'grade' => 'nullable|numeric|min:0',
            'grade_scale' => 'nullable|string|max:20',
            'description' => 'nullable|string|max:1000',
            'activities' => 'nullable|array',
            'activities.*' => 'string|max:255',
            'achievements' => 'nullable|array',
            'achievements.*' => 'string|max:255',
            'institution_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
        ]);

        // If this is current education, set end_date to null
        if ($validated['is_current']) {
            $validated['end_date'] = null;
        }

        // Handle institution logo upload
        if ($request->hasFile('institution_logo')) {
            $validated['institution_logo'] = $request->file('institution_logo')
                ->store('institution-logos', 'public');
        }

        $validated['user_id'] = Auth::id();

        UserEducation::create($validated);

        return redirect()->route('profile.edit')
            ->with('success', 'Education added successfully!');
    }

    /**
     * Update education
     */
    public function update(Request $request, UserEducation $education)
    {
        $this->authorize('update', $education);

        $validated = $request->validate([
            'institution_name' => 'required|string|max:255',
            'degree' => 'nullable|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
            'grade' => 'nullable|numeric|min:0',
            'grade_scale' => 'nullable|string|max:20',
            'description' => 'nullable|string|max:1000',
            'activities' => 'nullable|array',
            'activities.*' => 'string|max:255',
            'achievements' => 'nullable|array',
            'achievements.*' => 'string|max:255',
            'institution_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
        ]);

        // If this is current education, set end_date to null
        if ($validated['is_current']) {
            $validated['end_date'] = null;
        }

        // Handle institution logo upload
        if ($request->hasFile('institution_logo')) {
            // Delete old logo
            if ($education->institution_logo) {
                Storage::disk('public')->delete($education->institution_logo);
            }
            
            $validated['institution_logo'] = $request->file('institution_logo')
                ->store('institution-logos', 'public');
        }

        $education->update($validated);

        return redirect()->route('profile.edit')
            ->with('success', 'Education updated successfully!');
    }

    /**
     * Delete education
     */
    public function destroy(UserEducation $education)
    {
        $this->authorize('delete', $education);

        // Delete institution logo if exists
        if ($education->institution_logo) {
            Storage::disk('public')->delete($education->institution_logo);
        }

        $education->delete();

        return redirect()->route('profile.edit')
            ->with('success', 'Education deleted successfully!');
    }
}