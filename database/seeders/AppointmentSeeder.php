<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Meeting;
use App\Models\UserInquiry;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Product;
use App\Models\Seller;
use App\Models\Manufacturer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AppointmentSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Seeding appointment demo data...');

        // Create demo customers if they don't exist
        $customers = $this->createDemoCustomers();
        
        // Create demo sellers and manufacturers
        $sellers = $this->createDemoSellers();
        $manufacturers = $this->createDemoManufacturers();
        
        // Create demo products
        $products = $this->createDemoProducts($sellers, $manufacturers);
        
        // Create demo meetings
        $this->createDemoMeetings($customers, $sellers, $manufacturers);
        
        // Create demo inquiries
        $this->createDemoInquiries($customers, $products, $sellers, $manufacturers);
        
        // Create demo conversations
        $this->createDemoConversations($customers, $sellers, $manufacturers);

        $this->command->info('Appointment demo data seeded successfully!');
    }

    private function createDemoCustomers()
    {
        $customers = [];
        
        $customerData = [
            [
                'name' => 'John Smith',
                'email' => 'john.smith@example.com',
                'phone' => '+1-555-0101',
                'company' => 'Smith Industries'
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@example.com',
                'phone' => '+1-555-0102',
                'company' => 'Johnson Enterprises'
            ],
            [
                'name' => 'Michael Brown',
                'email' => 'michael.brown@example.com',
                'phone' => '+1-555-0103',
                'company' => 'Brown Corp'
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily.davis@example.com',
                'phone' => '+1-555-0104',
                'company' => 'Davis Solutions'
            ],
            [
                'name' => 'David Wilson',
                'email' => 'david.wilson@example.com',
                'phone' => '+1-555-0105',
                'company' => 'Wilson Tech'
            ],
            [
                'name' => 'Lisa Anderson',
                'email' => 'lisa.anderson@example.com',
                'phone' => '+1-555-0106',
                'company' => 'Anderson Group'
            ]
        ];

        foreach ($customerData as $data) {
            $customer = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password123'),
                    'role' => 'customer',
                    'email_verified_at' => now(),
                ]
            );

            // Create customer profile
            $customer->profile()->updateOrCreate([], [
                'first_name' => explode(' ', $data['name'])[0],
                'last_name' => explode(' ', $data['name'])[1] ?? '',
                'phone' => $data['phone'],
                'company' => $data['company'],
                'profile_public' => true,
                'show_email' => true,
                'show_phone' => true,
            ]);

            $customers[] = $customer;
        }

        return collect($customers);
    }

    private function createDemoSellers()
    {
        $sellers = [];
        
        $sellerData = [
            [
                'company_name' => 'Tech Solutions Inc',
                'contact_person' => 'Robert Tech',
                'email' => 'robert@techsolutions.com',
                'phone' => '+1-555-0201'
            ],
            [
                'company_name' => 'Global Supplies Co',
                'contact_person' => 'Maria Global',
                'email' => 'maria@globalsupplies.com',
                'phone' => '+1-555-0202'
            ]
        ];

        foreach ($sellerData as $data) {
            // Create user first
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['contact_person'],
                    'password' => Hash::make('password123'),
                    'role' => 'seller',
                    'email_verified_at' => now(),
                ]
            );

            // Create seller
            $seller = Seller::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'company_name' => $data['company_name'],
                    'contact_person' => $data['contact_person'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'slug' => \Str::slug($data['company_name']),
                    'status' => 'active',
                    'is_verified' => true,
                ]
            );

            $sellers[] = $seller;
        }

        return collect($sellers);
    }

    private function createDemoManufacturers()
    {
        $manufacturers = [];
        
        $manufacturerData = [
            [
                'company_name' => 'Premium Manufacturing Ltd',
                'contact_person' => 'James Premium',
                'email' => 'james@premiummanufacturing.com',
                'phone' => '+1-555-0301'
            ]
        ];

        foreach ($manufacturerData as $data) {
            // Create user first
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['contact_person'],
                    'password' => Hash::make('password123'),
                    'role' => 'manufacturer',
                    'email_verified_at' => now(),
                ]
            );

            // Create manufacturer
            $manufacturer = Manufacturer::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'company_name' => $data['company_name'],
                    'contact_person' => $data['contact_person'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'slug' => \Str::slug($data['company_name']),
                    'status' => 'active',
                    'is_verified' => true,
                ]
            );

            $manufacturers[] = $manufacturer;
        }

        return collect($manufacturers);
    }

    private function createDemoProducts($sellers, $manufacturers)
    {
        $products = [];
        
        $productData = [
            [
                'name' => 'Industrial Printer Model X1',
                'description' => 'High-quality industrial printer suitable for large-scale printing operations.',
                'b2c_price' => 2500.00,
                'b2b_price' => 2200.00,
                'category' => 'Electronics',
                'brand' => 'PrintTech'
            ],
            [
                'name' => 'Office Furniture Set',
                'description' => 'Complete office furniture set including desk, chair, and storage units.',
                'b2c_price' => 1200.00,
                'b2b_price' => 1000.00,
                'category' => 'Furniture',
                'brand' => 'OfficePro'
            ],
            [
                'name' => 'Manufacturing Equipment A1',
                'description' => 'Advanced manufacturing equipment for precision operations.',
                'b2c_price' => 15000.00,
                'b2b_price' => 13500.00,
                'category' => 'Machinery',
                'brand' => 'ManufactureTech'
            ]
        ];

        foreach ($productData as $index => $data) {
            $owner = $index < 2 ? $sellers->first() : $manufacturers->first();
            $ownerType = $index < 2 ? Seller::class : Manufacturer::class;
            
            $product = Product::firstOrCreate(
                ['name' => $data['name']],
                [
                    'owner_type' => $ownerType,
                    'owner_id' => $owner->id,
                    'seller_id' => $index < 2 ? $owner->id : null,
                    'manufacturer_id' => $index >= 2 ? $owner->id : null,
                    'slug' => \Str::slug($data['name']),
                    'description' => $data['description'],
                    'b2c_price' => $data['b2c_price'],
                    'b2b_price' => $data['b2b_price'],
                    'category' => $data['category'],
                    'brand' => $data['brand'],
                    'status' => 'active',
                    'stock_quantity' => rand(10, 100),
                    'images' => ['products/demo-product-' . ($index + 1) . '.jpg'],
                ]
            );

            $products[] = $product;
        }

        return collect($products);
    }

    private function createDemoMeetings($customers, $sellers, $manufacturers)
    {
        $meetings = [
            [
                'customer' => $customers[0],
                'seller' => $sellers[0],
                'title' => 'Product Demo - Industrial Printer',
                'description' => 'Demonstration of the Industrial Printer Model X1 features and capabilities.',
                'meeting_type' => 'physical',
                'status' => 'confirmed',
                'scheduled_at' => now()->addDays(1)->setHour(10)->setMinute(0),
                'duration' => 60,
                'location' => 'Tech Solutions Inc Office, 123 Business St'
            ],
            [
                'customer' => $customers[1],
                'seller' => $sellers[0],
                'title' => 'Office Furniture Consultation',
                'description' => 'Consultation for office furniture requirements and customization options.',
                'meeting_type' => 'video',
                'status' => 'pending',
                'scheduled_at' => now()->addDays(2)->setHour(14)->setMinute(30),
                'duration' => 45,
                'location' => 'https://meet.google.com/abc-defg-hij'
            ],
            [
                'customer' => $customers[2],
                'manufacturer' => $manufacturers[0],
                'title' => 'Manufacturing Equipment Discussion',
                'description' => 'Technical discussion about manufacturing equipment specifications and pricing.',
                'meeting_type' => 'call',
                'status' => 'completed',
                'scheduled_at' => now()->subDays(1)->setHour(9)->setMinute(0),
                'duration' => 30,
                'location' => 'Phone Call'
            ],
            [
                'customer' => $customers[3],
                'seller' => $sellers[1],
                'title' => 'Bulk Order Discussion',
                'description' => 'Discussion about bulk order requirements and volume discounts.',
                'meeting_type' => 'physical',
                'status' => 'confirmed',
                'scheduled_at' => now()->addHours(4),
                'duration' => 90,
                'location' => 'Global Supplies Co Showroom'
            ],
            [
                'customer' => $customers[4],
                'seller' => $sellers[0],
                'title' => 'Follow-up Meeting',
                'description' => 'Follow-up meeting to discuss previous inquiry and next steps.',
                'meeting_type' => 'video',
                'status' => 'pending',
                'scheduled_at' => now()->addDays(3)->setHour(16)->setMinute(0),
                'duration' => 30,
                'location' => 'Zoom Meeting'
            ],
            [
                'customer' => $customers[5],
                'manufacturer' => $manufacturers[0],
                'title' => 'Technical Specifications Review',
                'description' => 'Review of technical specifications and compliance requirements.',
                'meeting_type' => 'physical',
                'status' => 'cancelled',
                'scheduled_at' => now()->subDays(2)->setHour(11)->setMinute(0),
                'duration' => 60,
                'location' => 'Premium Manufacturing Ltd Factory'
            ]
        ];

        foreach ($meetings as $meetingData) {
            Meeting::create([
                'customer_id' => $meetingData['customer']->id,
                'seller_id' => $meetingData['seller']->id ?? null,
                'manufacturer_id' => $meetingData['manufacturer']->id ?? null,
                'title' => $meetingData['title'],
                'description' => $meetingData['description'],
                'meeting_type' => $meetingData['meeting_type'],
                'status' => $meetingData['status'],
                'scheduled_at' => $meetingData['scheduled_at'],
                'duration' => $meetingData['duration'],
                'location' => $meetingData['location'],
                'created_by_admin' => rand(0, 1) == 1,
                'room_name' => 'meeting_' . \Str::random(12) . '_' . time(),
            ]);
        }

        $this->command->info('Created ' . count($meetings) . ' demo meetings');
    }

    private function createDemoInquiries($customers, $products, $sellers, $manufacturers)
    {
        $inquiries = [
            [
                'customer' => $customers[0],
                'product' => $products[0],
                'seller' => $sellers[0],
                'message' => 'I am interested in purchasing 5 units of the Industrial Printer Model X1. Could you provide bulk pricing and delivery timeline?',
                'quantity' => 5,
                'target_price' => 2000.00,
                'status' => 'pending',
                'priority' => 'high',
                'inquiry_type' => 'bulk_order',
                'created_at' => now()->subHours(2)
            ],
            [
                'customer' => $customers[1],
                'product' => $products[1],
                'seller' => $sellers[0],
                'message' => 'We are setting up a new office and need complete furniture sets for 20 employees. Can you customize the colors and provide installation?',
                'quantity' => 20,
                'target_price' => 800.00,
                'status' => 'in_progress',
                'priority' => 'medium',
                'inquiry_type' => 'customization',
                'admin_notes' => 'Customer contacted via phone. Scheduled meeting for detailed discussion.',
                'created_at' => now()->subDays(1)
            ],
            [
                'customer' => $customers[2],
                'product' => $products[2],
                'manufacturer' => $manufacturers[0],
                'message' => 'Looking for manufacturing equipment with specific technical requirements. Need equipment that can handle precision operations with tolerance of ±0.001mm.',
                'quantity' => 1,
                'target_price' => 12000.00,
                'status' => 'resolved',
                'priority' => 'urgent',
                'inquiry_type' => 'technical',
                'admin_notes' => 'Technical specifications provided. Customer satisfied with the solution.',
                'response' => 'Our Manufacturing Equipment A1 meets your precision requirements. Technical documentation has been sent to your email.',
                'responded_at' => now()->subHours(6),
                'created_at' => now()->subDays(2)
            ],
            [
                'customer' => $customers[3],
                'product' => null,
                'seller' => $sellers[1],
                'message' => 'General inquiry about your product catalog and services. We are a growing company looking for reliable suppliers.',
                'status' => 'pending',
                'priority' => 'low',
                'inquiry_type' => 'general',
                'created_at' => now()->subHours(8)
            ],
            [
                'customer' => $customers[4],
                'product' => $products[0],
                'seller' => $sellers[0],
                'message' => 'Need urgent replacement for our current printer. What is the fastest delivery option available?',
                'quantity' => 1,
                'deadline' => now()->addDays(7)->format('Y-m-d'),
                'status' => 'pending',
                'priority' => 'urgent',
                'inquiry_type' => 'urgent_order',
                'created_at' => now()->subMinutes(30)
            ],
            [
                'customer' => $customers[5],
                'product' => $products[1],
                'seller' => $sellers[0],
                'message' => 'Interested in the office furniture set. Can you provide warranty information and maintenance services?',
                'quantity' => 3,
                'status' => 'closed',
                'priority' => 'low',
                'inquiry_type' => 'information',
                'admin_notes' => 'Customer decided to go with a different supplier.',
                'created_at' => now()->subDays(3)
            ]
        ];

        foreach ($inquiries as $inquiryData) {
            UserInquiry::create([
                'customer_id' => $inquiryData['customer']->id,
                'product_id' => $inquiryData['product']->id ?? null,
                'seller_id' => $inquiryData['seller']->id ?? null,
                'manufacturer_id' => $inquiryData['manufacturer']->id ?? null,
                'message' => $inquiryData['message'],
                'quantity' => $inquiryData['quantity'] ?? null,
                'target_price' => $inquiryData['target_price'] ?? null,
                'deadline' => $inquiryData['deadline'] ?? null,
                'status' => $inquiryData['status'],
                'priority' => $inquiryData['priority'],
                'inquiry_type' => $inquiryData['inquiry_type'],
                'admin_notes' => $inquiryData['admin_notes'] ?? null,
                'response' => $inquiryData['response'] ?? null,
                'responded_at' => $inquiryData['responded_at'] ?? null,
                'created_at' => $inquiryData['created_at'],
                'updated_at' => $inquiryData['created_at'],
            ]);
        }

        $this->command->info('Created ' . count($inquiries) . ' demo inquiries');
    }

    private function createDemoConversations($customers, $sellers, $manufacturers)
    {
        $conversations = [
            [
                'customer' => $customers[0],
                'seller' => $sellers[0],
                'messages' => [
                    ['sender' => 'customer', 'message' => 'Hello, I saw your industrial printer and I\'m interested in learning more.', 'time' => now()->subHours(3)],
                    ['sender' => 'seller', 'message' => 'Hi! Thank you for your interest. I\'d be happy to help you with information about our Industrial Printer Model X1.', 'time' => now()->subHours(2)->subMinutes(45)],
                    ['sender' => 'customer', 'message' => 'What are the key features and what kind of volume can it handle?', 'time' => now()->subHours(2)->subMinutes(30)],
                    ['sender' => 'seller', 'message' => 'It can handle up to 10,000 pages per day with high-quality output. Would you like to schedule a demo?', 'time' => now()->subHours(2)],
                ]
            ],
            [
                'customer' => $customers[1],
                'seller' => $sellers[1],
                'messages' => [
                    ['sender' => 'customer', 'message' => 'Hi, I need a quote for office furniture for our new branch.', 'time' => now()->subHours(1)],
                    ['sender' => 'seller', 'message' => 'Hello! I\'d be glad to help you with that. How many workstations do you need?', 'time' => now()->subMinutes(45)],
                    ['sender' => 'customer', 'message' => 'We need furniture for about 15 employees.', 'time' => now()->subMinutes(30)],
                ]
            ],
            [
                'customer' => $customers[2],
                'manufacturer' => $manufacturers[0],
                'messages' => [
                    ['sender' => 'customer', 'message' => 'I\'m looking for manufacturing equipment with specific precision requirements.', 'time' => now()->subDays(1)],
                    ['sender' => 'manufacturer', 'message' => 'We specialize in precision manufacturing equipment. What are your specific requirements?', 'time' => now()->subDays(1)->addHours(2)],
                    ['sender' => 'customer', 'message' => 'I need equipment that can maintain ±0.001mm tolerance for automotive parts.', 'time' => now()->subDays(1)->addHours(3)],
                    ['sender' => 'manufacturer', 'message' => 'Our Equipment A1 can definitely meet those specifications. Let me send you the technical details.', 'time' => now()->subDays(1)->addHours(4)],
                ]
            ]
        ];

        foreach ($conversations as $convData) {
            $conversation = Conversation::create([
                'customer_id' => $convData['customer']->id,
                'seller_id' => $convData['seller']->id ?? null,
                'manufacturer_id' => $convData['manufacturer']->id ?? null,
                'status' => 'active',
                'created_at' => $convData['messages'][0]['time'],
                'updated_at' => end($convData['messages'])['time'],
            ]);

            foreach ($convData['messages'] as $msgData) {
                $senderId = $msgData['sender'] === 'customer' ? 
                    $convData['customer']->id : 
                    ($convData['seller']->user_id ?? $convData['manufacturer']->user_id);

                Message::create([
                    'conversation_id' => $conversation->id,
                    'sender_id' => $senderId,
                    'message' => $msgData['message'],
                    'created_at' => $msgData['time'],
                    'updated_at' => $msgData['time'],
                ]);
            }
        }

        $this->command->info('Created ' . count($conversations) . ' demo conversations');
    }
}