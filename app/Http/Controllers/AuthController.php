<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('frontend.auth.login');
    }

    public function login(Request $request)
    {
        try {
            // 1. Validate Input
            $credentials = $request->validate([
                'email'    => 'required|email',
                'password' => 'required|string|min:8',
            ]);

            $remember = $request->filled('remember');

            // 2. Attempt Login
            if (Auth::attempt($credentials, $remember)) {
                $request->session()->regenerate(); // prevent session fixation

                return redirect()->intended('/profile')
                    ->with('success', 'Welcome back, ' . Auth::user()->name . '!');
            }

            // 3. Failed Login
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        } catch (\Exception $e) {
            Log::error('Login Error: ' . $e->getMessage());

            return back()->withErrors([
                'error' => 'Something went wrong, please try again later.',
            ]);
        }
    }
    public function showRegistrationForm()
    {
        return view('frontend.auth.register');
    }

    public function register(Request $request)
    {
        try {
            // 1. Validate Request
            $validator = Validator::make($request->all(), [
                'firstName'             => 'required|string|max:50',
                'lastName'              => 'required|string|max:50',
                'email'                 => 'required|email|unique:users,email',
                'password'              => 'required|string|min:8|confirmed',
                'userType'              => 'required|in:retailer,customer',
                'avatar'                => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $type = 'b2c';

            if($request->userType === 'retailer' ) {
                $type = 'b2b';
            }

            // 2. Handle Avatar Upload (if any)
            $avatarPath = null;
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
            }

            // 3. Create User
            $user = $user = User::create([
                'name'     => $request->firstName . ' ' . $request->lastName,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => $type,
                'avatar'   => $avatarPath,
            ]);

            Role::firstOrCreate(['name' => $request->userType]);
            $user->assignRole($request->userType);

            // 4. Success Response
            return redirect()->route('login')->with('success', 'Registration successful! You can now log in.');
        } catch (\Exception $e) {
            // Log error for debugging
            Log::error('Registration Error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Something went wrong during registration. Please try again later.');
        }
    }

    public function profile()
    {
        $user = auth()->user();
        return view('frontend.auth.profile', compact('user'));
    }

    function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'You have been logged out successfully.');
    }
}
