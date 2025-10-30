<?php

namespace App\Http\Controllers\manufacturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Manufacturer;
use Spatie\Permission\Models\Role;

class ManufacturerAuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('manufacturer.auth.register');
    }


    public function processStep1(Request $request)
    {
        try {
            $validated = $request->validate([
                'company_name' => 'required|string|max:255',
                'company_registration_number' => 'required|string|max:255',
                'company_address' => 'required|string',
                'company_city' => 'required|string|max:255',
                'company_state' => 'required|string|max:255',
                'company_country' => 'required|string|max:255',
                'company_postal_code' => 'required|string|max:20',
                'company_phone' => 'required|string|max:20',
                'company_website' => 'nullable|url|max:255',
            ], [
                'required' => 'The :attribute field is required.',
                'email' => 'Please enter a valid email address.',
                'url' => 'Please enter a valid URL.',
                'max' => 'The :attribute may not be greater than :max characters.',
            ]);

            // Store validated data in session
            session(['manufacturer_registration_step1' => $validated]);

            return response()->json([
                'success' => true,
                'message' => 'Step 1 completed',
                'data' => $validated
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    public function processStep2(Request $request)
    {
        try {
            $validated = $request->validate([
                'contact_person_name' => 'required|string|max:255',
                'contact_person_position' => 'required|string|max:255',
                'contact_person_email' => 'required|email|unique:sellers,contact_person_email',
                'contact_person_phone' => 'required|string|max:20',
                'business_type' => 'required|string|max:255',
                'main_products' => 'required|string',
                'years_in_business' => 'required|integer|min:0',
                'number_of_employees' => 'required|string',
                'annual_revenue' => 'required|string',
                'email' => 'required|email|unique:users,email', // 👈 check in users, not sellers
                'password' => 'required|min:8|confirmed',
            ]);

            // Convert main_products string → array
            $mainProducts = json_decode($validated['main_products'], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json([
                    'success' => false,
                    'errors' => ['main_products' => ['Please enter valid product names as JSON array.']]
                ], 422);
            }
            $validated['main_products'] = $mainProducts;

            // Store only seller fields in step2
            $manufacturerData = $validated;
            $email = $validated['email'];
            $password = $validated['password'];
            unset($manufacturerData['email'], $manufacturerData['password']);

            session([
                'manufacturer_registration_step2' => $manufacturerData,
                'manufacturer_registration_email' => $email,
                'manufacturer_registration_password' => Hash::make($password),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Step 2 completed',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        }
    }


    public function processStep3(Request $request)
    {
        try {
            $validated = $request->validate([
                'business_license' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'tax_certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'id_proof' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'company_profile' => 'nullable|file|mimes:pdf|max:2048',
            ]);

            $step1Data = session('manufacturer_registration_step1');
            $step2Data = session('manufacturer_registration_step2');
            $email = session('manufacturer_registration_email');
            $password = session('manufacturer_registration_password');

            if (!$step1Data || !$step2Data || !$email || !$password) {
                return response()->json([
                    'success' => false,
                    'errors' => ['general' => ['Previous steps missing, please restart']]
                ], 422);
            }

            // Store files
            $documentPaths = [];
            foreach ($validated as $key => $file) {
                $documentPaths[$key] = $file->store('manufacturer_documents', 'public');
            }

            DB::beginTransaction();
            try {
                // 1️⃣ Create user
                $user = User::create([
                    'name' => $step2Data['contact_person_name'],
                    'email' => $email,
                    'password' => $password,
                    'role' => 'b2b',
                ]);

                // 2️⃣ Create seller linked to user
                $manufacturer = Manufacturer::create(array_merge(
                    $step1Data,
                    $step2Data,
                    $documentPaths,
                    ['user_id' => $user->id]
                ));

                // 3️⃣ Assign role to user
                $role = Role::firstOrCreate(['name' => 'manufacturer']);
                if (!$user->hasRole('manufacturer')) {
                    $user->assignRole($role);
                }

                DB::commit();

                // Clear session
                session()->forget([
                    'manufacturer_registration_step1',
                    'manufacturer_registration_step2',
                    'manufacturer_registration_email',
                    'manufacturer_registration_password',
                ]);

                Auth::login($user);

                return response()->json([
                    'success' => true,
                    'message' => 'Registration successful',
                    'redirect' => route('manufacturer.dashboard'),
                ]);
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'errors' => ['general' => [$e->getMessage()]],
            ], 500);
        }
    }

}
