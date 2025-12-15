<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Seller;
use App\Models\Salesman;
use App\Models\DeliveryMan;
use App\Models\Accountant;
use App\Models\WareHouse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $sellerId = 4; // Associate with seller ID 4

        // Check if seller exists
        $seller = Seller::find($sellerId);
        if (!$seller) {
            $this->command->error("Seller with ID {$sellerId} not found!");
            return;
        }

        $this->command->info("Creating employees for seller: {$seller->company_name}");

        // Create 5 Salesmen
        for ($i = 0; $i < 5; $i++) {
            $name = $faker->name();
            $email = $faker->unique()->safeEmail();
            
            // Create user first
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'email_verified_at' => $faker->optional(0.8)->dateTimeBetween('-1 year', 'now'),
                'password' => Hash::make('password123'),
            ]);

            // Create salesman
            Salesman::create([
                'seller_id' => $sellerId,
                'user_id' => $user->id,
                'name' => $name,
                'email' => $email,
                'phone' => $faker->phoneNumber(),
                'designation' => $faker->randomElement(['Sales Executive', 'Senior Sales Manager', 'Sales Representative', 'Account Manager']),
                'salary' => $faker->numberBetween(30000, 80000),
                'joining_date' => $faker->dateTimeBetween('-2 years', 'now'),
                'status' => $faker->randomElement(['active', 'inactive']),
            ]);
        }

        // Create 5 Delivery Men
        for ($i = 0; $i < 5; $i++) {
            $name = $faker->name();
            $email = $faker->unique()->safeEmail();
            
            // Create user first
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'email_verified_at' => $faker->optional(0.8)->dateTimeBetween('-1 year', 'now'),
                'password' => Hash::make('password123'),
            ]);

            // Create delivery man
            DeliveryMan::create([
                'seller_id' => $sellerId,
                'user_id' => $user->id,
                'name' => $name,
                'email' => $email,
                'phone' => $faker->phoneNumber(),
                'designation' => $faker->randomElement(['Delivery Driver', 'Courier', 'Logistics Coordinator', 'Delivery Supervisor']),
                'salary' => $faker->numberBetween(25000, 50000),
                'joining_date' => $faker->dateTimeBetween('-2 years', 'now'),
                'status' => $faker->randomElement(['active', 'inactive']),
            ]);
        }

        // Create 5 Accountants
        for ($i = 0; $i < 5; $i++) {
            $name = $faker->name();
            $email = $faker->unique()->safeEmail();
            
            // Create user first
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'email_verified_at' => $faker->optional(0.8)->dateTimeBetween('-1 year', 'now'),
                'password' => Hash::make('password123'),
            ]);

            // Create accountant
            Accountant::create([
                'seller_id' => $sellerId,
                'user_id' => $user->id,
                'name' => $name,
                'email' => $email,
                'phone' => $faker->phoneNumber(),
                'designation' => $faker->randomElement(['Junior Accountant', 'Senior Accountant', 'Finance Manager', 'Accounts Payable Clerk']),
                'salary' => $faker->numberBetween(35000, 75000),
                'joining_date' => $faker->dateTimeBetween('-2 years', 'now'),
                'status' => $faker->randomElement(['active', 'inactive']),
            ]);
        }

        // Create 5 Warehouse Managers
        for ($i = 0; $i < 5; $i++) {
            $name = $faker->name();
            $email = $faker->unique()->safeEmail();
            
            // Create user first
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'email_verified_at' => $faker->optional(0.8)->dateTimeBetween('-1 year', 'now'),
                'password' => Hash::make('password123'),
            ]);

            // Create warehouse manager
            WareHouse::create([
                'seller_id' => $sellerId,
                'user_id' => $user->id,
                'name' => $name,
                'email' => $email,
                'phone' => $faker->phoneNumber(),
                'designation' => $faker->randomElement(['Warehouse Manager', 'Inventory Supervisor', 'Stock Controller', 'Warehouse Coordinator']),
                'salary' => $faker->numberBetween(40000, 70000),
                'joining_date' => $faker->dateTimeBetween('-2 years', 'now'),
                'status' => $faker->randomElement(['active', 'inactive']),
            ]);
        }

        $this->command->info('Successfully created 20 employees (5 each type) for seller ID ' . $sellerId);
        $this->command->info('- 5 Salesmen');
        $this->command->info('- 5 Delivery Men');
        $this->command->info('- 5 Accountants');
        $this->command->info('- 5 Warehouse Managers');
    }
}