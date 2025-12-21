<?php

namespace App\Http\Controllers;

use App\Models\WorkExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class WorkExperienceController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    /**
     * Store a new work experience
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'employment_type' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'is_remote' => 'boolean',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
            'description' => 'nullable|string|max:2000',
            'responsibilities' => 'nullable|array',
            'responsibilities.*' => 'string|max:500',
            'achievements' => 'nullable|array',
            'achievements.*' => 'string|max:500',
            'skills_used' => 'nullable|array',
            'skills_used.*' => 'string|max:100',
            'company_website' => 'nullable|url|max:255',
            'industry' => 'nullable|string|max:255',
            'company_size' => 'nullable|string|max:50',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
        ]);

        // If this is current job, set other jobs as not current
        if ($validated['is_current']) {
            Auth::user()->workExperiences()->update(['is_current' => false]);
            $validated['end_date'] = null;
        }

        // Handle company logo upload
        if ($request->hasFile('company_logo')) {
            $validated['company_logo'] = $request->file('company_logo')
                ->store('company-logos', 'public');
        }

        $validated['user_id'] = Auth::id();

        WorkExperience::create($validated);

        return redirect()->route('profile.edit')
            ->with('success', 'Work experience added successfully!');
    }

    /**
     * Update work experience
     */
    public function update(Request $request, WorkExperience $workExperience)
    {
        $this->authorize('update', $workExperience);

        $validated = $request->validate([
            'job_title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'employment_type' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'is_remote' => 'boolean',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_current' => 'boolean',
            'description' => 'nullable|string|max:2000',
            'responsibilities' => 'nullable|array',
            'responsibilities.*' => 'string|max:500',
            'achievements' => 'nullable|array',
            'achievements.*' => 'string|max:500',
            'skills_used' => 'nullable|array',
            'skills_used.*' => 'string|max:100',
            'company_website' => 'nullable|url|max:255',
            'industry' => 'nullable|string|max:255',
            'company_size' => 'nullable|string|max:50',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
        ]);

        // If this is current job, set other jobs as not current
        if ($validated['is_current']) {
            Auth::user()->workExperiences()
                ->where('id', '!=', $workExperience->id)
                ->update(['is_current' => false]);
            $validated['end_date'] = null;
        }

        // Handle company logo upload
        if ($request->hasFile('company_logo')) {
            // Delete old logo
            if ($workExperience->company_logo) {
                Storage::disk('public')->delete($workExperience->company_logo);
            }
            
            $validated['company_logo'] = $request->file('company_logo')
                ->store('company-logos', 'public');
        }

        $workExperience->update($validated);

        return redirect()->route('profile.edit')
            ->with('success', 'Work experience updated successfully!');
    }

    /**
     * Delete work experience
     */
    public function destroy(WorkExperience $workExperience)
    {
        $this->authorize('delete', $workExperience);

        // Delete company logo if exists
        if ($workExperience->company_logo) {
            Storage::disk('public')->delete($workExperience->company_logo);
        }

        $workExperience->delete();

        return redirect()->route('profile.edit')
            ->with('success', 'Work experience deleted successfully!');
    }
}