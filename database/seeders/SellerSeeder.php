<?php

namespace Database\Seeders;

use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class SellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        
        // Business types array
        $businessTypes = [
            'Manufacturing',
            'Wholesale',
            'Retail',
            'E-commerce',
            'Distribution',
            'Import/Export',
            'Technology',
            'Services'
        ];

        // Main products categories
        $mainProductsOptions = [
            ['Electronics', 'Computers', 'Mobile Phones'],
            ['Clothing', 'Fashion', 'Accessories'],
            ['Home & Garden', 'Furniture', 'Decor'],
            ['Sports', 'Fitness', 'Outdoor'],
            ['Books', 'Media', 'Entertainment'],
            ['Health', 'Beauty', 'Personal Care'],
            ['Automotive', 'Parts', 'Accessories'],
            ['Food', 'Beverages', 'Groceries']
        ];

        // Create 20 random sellers with associated users
        for ($i = 0; $i < 20; $i++) {
            $companyName = $faker->company();
            $contactPersonName = $faker->name();
            $contactPersonEmail = $faker->unique()->safeEmail();
            
            // Create associated user first
            $user = User::create([
                'name' => $contactPersonName,
                'email' => $contactPersonEmail,
                'email_verified_at' => $faker->optional(0.8)->dateTimeBetween('-1 year', 'now'),
                'password' => Hash::make('password123'),
            ]);
            
            // Create seller with user association
            Seller::create([
                'user_id' => $user->id,
                'company_name' => $companyName,
                'company_registration_number' => $faker->numerify('REG-####-####'),
                'company_address' => $faker->streetAddress(),
                'company_city' => $faker->city(),
                'company_state' => $faker->state(),
                'company_country' => $faker->country(),
                'company_postal_code' => $faker->postcode(),
                'latitude' => $faker->latitude(),
                'longitude' => $faker->longitude(),
                'is_premium' => $faker->boolean(30), // 30% chance of being premium
                'company_phone' => $faker->phoneNumber(),
                'company_website' => $faker->optional(0.7)->url(), // 70% chance of having website
                'contact_person_name' => $contactPersonName,
                'contact_person_position' => $faker->jobTitle(),
                'contact_person_email' => $contactPersonEmail,
                'contact_person_phone' => $faker->phoneNumber(),
                'business_type' => $faker->randomElement($businessTypes),
                'main_products' => $faker->randomElement($mainProductsOptions),
                'years_in_business' => $faker->numberBetween(1, 50),
                'number_of_employees' => $faker->numberBetween(1, 1000),
                'annual_revenue' => $faker->numberBetween(50000, 10000000),

                'status' => $faker->randomElement(['pending', 'approved', 'rejected']),
                'business_license' => $faker->optional(0.8)->numerify('LIC-####-####'),
                'tax_certificate' => $faker->optional(0.8)->numerify('TAX-####-####'),
                'id_proof' => $faker->optional(0.9)->numerify('ID-####-####'),
                'company_profile' => $faker->optional(0.6)->paragraph(3)
            ]);
        }

        $this->command->info('Created 20 random sellers with associated users successfully!');
    }
}