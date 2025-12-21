<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\WorkExperience;
use App\Models\UserEducation;
use App\Models\UserCertification;
use App\Models\UserConnection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserProfileController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
        ];
    }

    /**
     * Display the user's profile
     */
    public function show(User $user = null)
    {
        $user = $user ?? Auth::user();
        $isOwnProfile = Auth::id() === $user->id;
        
        // Load relationships
        $user->load([
            'profile',
            'workExperiences' => function ($query) {
                $query->orderByDate();
            },
            'educations' => function ($query) {
                $query->orderByDate();
            },
            'certifications' => function ($query) {
                $query->active()->orderByDate();
            },
            'connections.connectedUser.profile',
            'reviews.product',
            'seller.products' => function ($query) {
                $query->where('status', 'active')->latest()->take(6);
            }
        ]);

        // Check if profiles are connected
        $connectionStatus = null;
        if (!$isOwnProfile) {
            $connection = UserConnection::where('user_id', Auth::id())
                ->where('connected_user_id', $user->id)
                ->first();
            
            $connectionStatus = $connection ? $connection->status : 'none';
            
            // Increment profile views if viewing someone else's profile
            $user->profile?->incrementProfileViews();
        }

        // Get user's posted products (if seller)
        $postedProducts = collect();
        if ($user->seller) {
            $postedProducts = $user->seller->products()
                ->where('status', 'active')
                ->with('reviews')
                ->latest()
                ->take(12)
                ->get();
        }

        // Get recent activity
        $recentActivity = $this->getRecentActivity($user);

        return view('profile.show', compact(
            'user',
            'isOwnProfile',
            'connectionStatus',
            'postedProducts',
            'recentActivity'
        ));
    }

    /**
     * Show the form for editing the user's profile
     */
    public function edit()
    {
        $user = Auth::user();
        $user->load('profile', 'workExperiences', 'educations', 'certifications');
        
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's basic profile information
     */
    public function updateBasic(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'bio' => 'nullable|string|max:1000',
            'job_title' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'industry' => 'nullable|string|max:255',
            'professional_summary' => 'nullable|string|max:2000',
            'website' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'country' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'postal_code' => 'nullable|string|max:20',
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:100',
            'social_links' => 'nullable|array',
            'social_links.*.platform' => 'required_with:social_links|string|max:50',
            'social_links.*.url' => 'required_with:social_links|url|max:255',
        ]);

        // Update user basic info
        $user->update([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
        ]);

        // Update or create profile
        $profileData = collect($validated)->except(['email'])->toArray();
        
        if ($user->profile) {
            $user->profile->update($profileData);
        } else {
            $user->profile()->create($profileData);
        }

        return redirect()->route('user.profile')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Update profile pictures
     */
    public function updatePictures(Request $request)
    {
        $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $user = Auth::user();
        $profile = $user->profile ?? $user->profile()->create([]);

        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture
            if ($profile->profile_picture) {
                Storage::disk('public')->delete($profile->profile_picture);
            }

            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $profile->update(['profile_picture' => $path]);
        }

        if ($request->hasFile('cover_photo')) {
            // Delete old cover photo
            if ($profile->cover_photo) {
                Storage::disk('public')->delete($profile->cover_photo);
            }

            $path = $request->file('cover_photo')->store('cover-photos', 'public');
            $profile->update(['cover_photo' => $path]);
        }

        return redirect()->route('profile.edit')
            ->with('success', 'Pictures updated successfully!');
    }

    /**
     * Update privacy settings
     */
    public function updatePrivacy(Request $request)
    {
        $validated = $request->validate([
            'profile_public' => 'boolean',
            'show_email' => 'boolean',
            'show_phone' => 'boolean',
            'show_location' => 'boolean',
        ]);

        $user = Auth::user();
        $profile = $user->profile ?? $user->profile()->create([]);
        
        $profile->update($validated);

        return redirect()->route('profile.edit')
            ->with('success', 'Privacy settings updated successfully!');
    }

    /**
     * Change password
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.edit')
            ->with('success', 'Password changed successfully!');
    }

    /**
     * Get recent activity for a user
     */
    private function getRecentActivity($user)
    {
        $activities = collect();

        // Recent reviews
        $recentReviews = $user->reviews()
            ->with('product')
            ->latest()
            ->take(5)
            ->get()
            ->filter(function ($review) {
                return $review->product !== null; // Filter out reviews with deleted products
            })
            ->map(function ($review) {
                return [
                    'type' => 'review',
                    'title' => 'Reviewed ' . $review->product->name,
                    'description' => \Str::limit($review->comment, 100),
                    'date' => $review->created_at,
                    'url' => route('product.show', $review->product->slug),
                ];
            });

        $activities = $activities->merge($recentReviews);

        // Recent products (if seller)
        if ($user->seller) {
            $recentProducts = $user->seller->products()
                ->where('status', 'active')
                ->latest()
                ->take(3)
                ->get()
                ->map(function ($product) {
                    return [
                        'type' => 'product',
                        'title' => 'Posted ' . $product->name,
                        'description' => \Str::limit($product->description, 100),
                        'date' => $product->created_at,
                        'url' => route('product.show', $product->slug),
                    ];
                });

            $activities = $activities->merge($recentProducts);
        }

        return $activities->sortByDesc('date')->take(10);
    }

    /**
     * Send connection request
     */
    public function sendConnectionRequest(Request $request, User $user)
    {
        $request->validate([
            'message' => 'nullable|string|max:500',
            'connection_type' => 'nullable|string|max:100',
        ]);

        $currentUser = Auth::user();

        // Check if connection already exists
        $existingConnection = UserConnection::where('user_id', $currentUser->id)
            ->where('connected_user_id', $user->id)
            ->first();

        if ($existingConnection) {
            return back()->with('error', 'Connection request already sent or you are already connected.');
        }

        UserConnection::create([
            'user_id' => $currentUser->id,
            'connected_user_id' => $user->id,
            'message' => $request->message,
            'connection_type' => $request->connection_type,
            'status' => 'pending',
            'requested_at' => now(),
        ]);

        return back()->with('success', 'Connection request sent successfully!');
    }

    /**
     * Respond to connection request
     */
    public function respondToConnection(Request $request, UserConnection $connection)
    {
        $this->authorize('update', $connection);

        $request->validate([
            'action' => 'required|in:accept,decline,block',
        ]);

        switch ($request->action) {
            case 'accept':
                $connection->accept();
                $message = 'Connection request accepted!';
                break;
            case 'decline':
                $connection->decline();
                $message = 'Connection request declined.';
                break;
            case 'block':
                $connection->block();
                $message = 'User blocked successfully.';
                break;
        }

        return back()->with('success', $message);
    }

    /**
     * List user's connections
     */
    public function connections()
    {
        $user = Auth::user();
        
        $connections = $user->connections()
            ->with('connectedUser.profile')
            ->paginate(20);

        $pendingRequests = $user->pendingConnections()
            ->with('user.profile')
            ->latest()
            ->get();

        return view('profile.connections', compact('connections', 'pendingRequests'));
    }
}