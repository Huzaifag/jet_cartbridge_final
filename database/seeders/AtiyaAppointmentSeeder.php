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

class AtiyaAppointmentSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Seeding appointment demo data for atiya@gmail.com...');

        // Get the existing user atiya@gmail.com
        $atiyaUser = User::where('email', 'atiya@gmail.com')->first();
        
        if (!$atiyaUser) {
            $this->command->error('User atiya@gmail.com not found. Please run UserProfileSeeder first.');
            return;
        }

        // Get or create seller for Atiya
        $atiyaSeller = $this->getAtiyaSeller($atiyaUser);
        
        // Create demo customers
        $customers = $this->createDemoCustomers();
        
        // Create demo products for Atiya's company
        $products = $this->createAtiyaProducts($atiyaSeller);
        
        // Create demo meetings for Atiya
        $this->createAtiyaMeetings($customers, $atiyaSeller, $atiyaUser);
        
        // Create demo inquiries for Atiya's products
        $this->createAtiyaInquiries($customers, $products, $atiyaSeller);
        
        // Create demo conversations for Atiya
        $this->createAtiyaConversations($customers, $atiyaSeller, $atiyaUser);

        $this->command->info('Appointment demo data for atiya@gmail.com seeded successfully!');
    }

    private function getAtiyaSeller($atiyaUser)
    {
        // Get or create seller for Atiya
        $seller = Seller::where('user_id', $atiyaUser->id)->first();
        
        if (!$seller) {
            $seller = Seller::create([
                'user_id' => $atiyaUser->id,
                'company_name' => 'Global Trade Solutions Inc.',
                'contact_person' => 'Atiya Rahman',
                'email' => 'atiya@gmail.com',
                'phone' => '+1-555-0123',
                'slug' => 'global-trade-solutions-inc',
                'status' => 'active',
                'is_verified' => true,
                'description' => 'Leading international trade and e-commerce solutions provider.',
                'address' => '123 Business District, Suite 456, San Francisco, CA 94105',
            ]);
        }

        return $seller;
    }

    private function createDemoCustomers()
    {
        $customers = [];
        
        $customerData = [
            [
                'name' => 'James Mitchell',
                'email' => 'james.mitchell@techcorp.com',
                'phone' => '+1-555-1001',
                'company' => 'TechCorp Industries'
            ],
            [
                'name' => 'Maria Rodriguez',
                'email' => 'maria.rodriguez@innovateplus.com',
                'phone' => '+1-555-1002',
                'company' => 'InnovatePlus Solutions'
            ],
            [
                'name' => 'Robert Chen',
                'email' => 'robert.chen@globalmanufacturing.com',
                'phone' => '+1-555-1003',
                'company' => 'Global Manufacturing Ltd'
            ],
            [
                'name' => 'Jennifer Thompson',
                'email' => 'jennifer.thompson@smartsystems.com',
                'phone' => '+1-555-1004',
                'company' => 'Smart Systems Inc'
            ],
            [
                'name' => 'Ahmed Hassan',
                'email' => 'ahmed.hassan@middleeasttrading.com',
                'phone' => '+971-555-2001',
                'company' => 'Middle East Trading Co'
            ],
            [
                'name' => 'Sophie Laurent',
                'email' => 'sophie.laurent@europeanenterprises.com',
                'phone' => '+33-555-3001',
                'company' => 'European Enterprises SA'
            ]
        ];

        foreach ($customerData as $data) {
            $customer = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password123'),
                    'role' => 'b2b', // Changed from 'customer' to 'b2b'
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

    private function createAtiyaProducts($seller)
    {
        $products = [];
        
        $productData = [
            [
                'name' => 'International Trade Management Software',
                'description' => 'Comprehensive software solution for managing international trade operations, including documentation, compliance, and logistics tracking.',
                'b2c_price' => 4999.00,
                'b2b_price' => 3999.00,
                'category' => 'Software',
                'brand' => 'TradeFlow Pro'
            ],
            [
                'name' => 'Digital Marketplace Platform',
                'description' => 'Complete e-commerce platform solution for B2B marketplaces with multi-vendor support and advanced analytics.',
                'b2c_price' => 12999.00,
                'b2b_price' => 9999.00,
                'category' => 'Software',
                'brand' => 'MarketPlace Pro'
            ],
            [
                'name' => 'Supply Chain Analytics Dashboard',
                'description' => 'Advanced analytics dashboard for supply chain optimization and performance monitoring.',
                'b2c_price' => 2999.00,
                'b2b_price' => 2499.00,
                'category' => 'Analytics',
                'brand' => 'SupplyChain Insights'
            ],
            [
                'name' => 'Cross-Border Payment Gateway',
                'description' => 'Secure payment gateway solution for international transactions with multi-currency support.',
                'b2c_price' => 7999.00,
                'b2b_price' => 6499.00,
                'category' => 'FinTech',
                'brand' => 'GlobalPay Solutions'
            ],
            [
                'name' => 'Trade Compliance Automation Tool',
                'description' => 'Automated compliance checking and documentation tool for international trade regulations.',
                'b2c_price' => 3499.00,
                'b2b_price' => 2999.00,
                'category' => 'Compliance',
                'brand' => 'ComplianceGuard'
            ]
        ];

        foreach ($productData as $index => $data) {
            $product = Product::firstOrCreate(
                ['name' => $data['name']],
                [
                    'seller_id' => $seller->id,
                    'slug' => \Str::slug($data['name']),
                    'description' => $data['description'],
                    'b2c_price' => $data['b2c_price'],
                    'b2b_price' => $data['b2b_price'],
                    'category' => $data['category'],
                    'brand' => $data['brand'],
                    'status' => 'active',
                    'stock_quantity' => rand(5, 50),
                    'images' => ['products/atiya-product-' . ($index + 1) . '.jpg'],
                    'specifications' => [
                        'License Type' => 'Enterprise',
                        'Support' => '24/7 Premium Support',
                        'Updates' => 'Free for 1 year',
                        'Training' => 'Included'
                    ]
                ]
            );

            $products[] = $product;
        }

        return collect($products);
    }

    private function createAtiyaMeetings($customers, $seller, $atiyaUser)
    {
        $meetings = [
            [
                'customer' => $customers[0],
                'title' => 'Trade Management Software Demo',
                'description' => 'Comprehensive demonstration of our International Trade Management Software features and ROI benefits.',
                'meeting_type' => 'video',
                'status' => 'confirmed',
                'scheduled_at' => now()->addDays(1)->setHour(10)->setMinute(0),
                'duration' => 90,
                'location' => 'https://zoom.us/j/atiya-demo-001'
            ],
            [
                'customer' => $customers[1],
                'title' => 'Digital Marketplace Platform Consultation',
                'description' => 'Strategic consultation for implementing our B2B marketplace platform for InnovatePlus Solutions.',
                'meeting_type' => 'physical',
                'status' => 'pending',
                'scheduled_at' => now()->addDays(2)->setHour(14)->setMinute(30),
                'duration' => 120,
                'location' => 'Global Trade Solutions Inc Office, San Francisco'
            ],
            [
                'customer' => $customers[2],
                'title' => 'Supply Chain Analytics Implementation',
                'description' => 'Technical discussion about implementing supply chain analytics for Global Manufacturing Ltd operations.',
                'meeting_type' => 'video',
                'status' => 'completed',
                'scheduled_at' => now()->subDays(1)->setHour(9)->setMinute(0),
                'duration' => 60,
                'location' => 'Microsoft Teams Meeting'
            ],
            [
                'customer' => $customers[3],
                'title' => 'Payment Gateway Integration Planning',
                'description' => 'Planning session for integrating our cross-border payment gateway with Smart Systems existing infrastructure.',
                'meeting_type' => 'call',
                'status' => 'confirmed',
                'scheduled_at' => now()->addHours(6),
                'duration' => 45,
                'location' => 'Conference Call'
            ],
            [
                'customer' => $customers[4],
                'title' => 'Middle East Market Expansion Strategy',
                'description' => 'Strategic discussion about expanding digital trade solutions in the Middle East market.',
                'meeting_type' => 'video',
                'status' => 'pending',
                'scheduled_at' => now()->addDays(3)->setHour(16)->setMinute(0),
                'duration' => 75,
                'location' => 'Google Meet'
            ],
            [
                'customer' => $customers[5],
                'title' => 'European Compliance Requirements Review',
                'description' => 'Review of European trade compliance requirements and how our automation tool addresses them.',
                'meeting_type' => 'video',
                'status' => 'confirmed',
                'scheduled_at' => now()->addDays(4)->setHour(11)->setMinute(0),
                'duration' => 60,
                'location' => 'Zoom Meeting'
            ]
        ];

        foreach ($meetings as $meetingData) {
            Meeting::create([
                'customer_id' => $meetingData['customer']->id,
                'seller_id' => $seller->id,
                'sender_id' => $atiyaUser->id,
                'receiver_id' => $meetingData['customer']->id,
                'title' => $meetingData['title'],
                'description' => $meetingData['description'],
                'meeting_type' => $meetingData['meeting_type'],
                'status' => $meetingData['status'],
                'scheduled_at' => $meetingData['scheduled_at'],
                'duration' => $meetingData['duration'],
                'location' => $meetingData['location'],
                'created_by_admin' => false,
                'room_name' => 'meeting_atiya_' . \Str::random(8) . '_' . time(),
            ]);
        }

        $this->command->info('Created ' . count($meetings) . ' demo meetings for Atiya');
    }

    private function createAtiyaInquiries($customers, $products, $seller)
    {
        // First create user contacts for each customer
        $contacts = [];
        foreach ($customers as $customer) {
            $contact = \App\Models\UserContact::firstOrCreate([
                'user_id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
            ], [
                'mobile' => $customer->profile?->phone ?? '+1-555-0000',
                'city' => $customer->profile?->city ?? 'Unknown City',
                'state' => $customer->profile?->state ?? 'Unknown State',
                'status' => 'active',
            ]);
            $contacts[$customer->id] = $contact;
        }

        $inquiries = [
            [
                'customer' => $customers[0],
                'product' => $products[0],
                'message' => 'We are looking to implement a comprehensive trade management solution for our international operations. Can you provide pricing for 50 user licenses and implementation timeline?',
                'quantity' => 50,
                'target_price' => 150000.00,
                'status' => 'pending',
                'priority' => 'high',
                'inquiry_type' => 'enterprise_solution',
                'created_at' => now()->subHours(3)
            ],
            [
                'customer' => $customers[1],
                'product' => $products[1],
                'message' => 'Interested in your Digital Marketplace Platform. We need a solution that can handle 10,000+ vendors and 100,000+ products. What are the scalability options?',
                'quantity' => 1,
                'target_price' => 8000.00,
                'status' => 'in_progress',
                'priority' => 'high',
                'inquiry_type' => 'scalability',
                'admin_notes' => 'Scheduled technical demo. Customer very interested in enterprise features.',
                'created_at' => now()->subDays(1)
            ],
            [
                'customer' => $customers[2],
                'product' => $products[2],
                'message' => 'Our manufacturing operations span across 15 countries. We need supply chain analytics that can provide real-time visibility. Does your solution support multi-location tracking?',
                'quantity' => 15,
                'target_price' => 35000.00,
                'status' => 'resolved',
                'priority' => 'medium',
                'inquiry_type' => 'multi_location',
                'admin_notes' => 'Provided detailed technical specifications. Customer satisfied with multi-location capabilities.',
                'response' => 'Yes, our Supply Chain Analytics Dashboard supports unlimited locations with real-time tracking. I\'ve sent you the technical documentation and case studies.',
                'responded_at' => now()->subHours(8),
                'created_at' => now()->subDays(2)
            ],
            [
                'customer' => $customers[3],
                'product' => $products[3],
                'message' => 'We process payments in 25+ currencies and need a solution that can handle high-volume transactions with competitive rates. What are your transaction fees?',
                'quantity' => 1,
                'status' => 'pending',
                'priority' => 'urgent',
                'inquiry_type' => 'pricing',
                'created_at' => now()->subHours(1)
            ],
            [
                'customer' => $customers[4],
                'product' => $products[4],
                'message' => 'Middle East trade regulations are complex and frequently changing. How does your compliance tool stay updated with the latest requirements?',
                'quantity' => 1,
                'target_price' => 2500.00,
                'status' => 'pending',
                'priority' => 'medium',
                'inquiry_type' => 'compliance',
                'created_at' => now()->subHours(5)
            ],
            [
                'customer' => $customers[5],
                'product' => $products[0], // Use first product instead of null
                'message' => 'We are expanding our operations to include digital trade solutions. Can you provide a comprehensive overview of all your products and how they integrate together?',
                'status' => 'in_progress',
                'priority' => 'medium',
                'inquiry_type' => 'general',
                'admin_notes' => 'Sent product catalog and integration overview. Scheduled follow-up call.',
                'created_at' => now()->subDays(1)->subHours(4)
            ]
        ];

        foreach ($inquiries as $inquiryData) {
            UserInquiry::create([
                'contact_id' => $contacts[$inquiryData['customer']->id]->id,
                'customer_id' => $inquiryData['customer']->id,
                'product_id' => $inquiryData['product']->id,
                'seller_id' => $seller->id,
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

        $this->command->info('Created ' . count($inquiries) . ' demo inquiries for Atiya');
    }

    private function createAtiyaConversations($customers, $seller, $atiyaUser)
    {
        $conversations = [
            [
                'customer' => $customers[0],
                'messages' => [
                    ['sender' => 'customer', 'message' => 'Hi Atiya, I attended your webinar on international trade digitization. Very impressive!', 'time' => now()->subHours(4)],
                    ['sender' => 'seller', 'message' => 'Thank you James! I\'m glad you found it valuable. How can I help you with your trade operations?', 'time' => now()->subHours(3)->subMinutes(45)],
                    ['sender' => 'customer', 'message' => 'We\'re looking to automate our trade documentation process. Currently everything is manual and it\'s becoming a bottleneck.', 'time' => now()->subHours(3)->subMinutes(30)],
                    ['sender' => 'seller', 'message' => 'That\'s exactly what our Trade Management Software addresses. It can reduce documentation time by 80%. Would you like to see a demo?', 'time' => now()->subHours(3)],
                    ['sender' => 'customer', 'message' => 'Absolutely! When would be a good time?', 'time' => now()->subHours(2)->subMinutes(45)],
                ]
            ],
            [
                'customer' => $customers[1],
                'messages' => [
                    ['sender' => 'customer', 'message' => 'Atiya, we met at the Digital Commerce Summit. I\'m Maria from InnovatePlus.', 'time' => now()->subHours(2)],
                    ['sender' => 'seller', 'message' => 'Hi Maria! Great to hear from you. I remember our conversation about marketplace platforms. How\'s your project progressing?', 'time' => now()->subHours(1)->subMinutes(45)],
                    ['sender' => 'customer', 'message' => 'We\'ve got approval for the budget. Your marketplace solution seems perfect for our needs. Can we discuss implementation?', 'time' => now()->subHours(1)->subMinutes(30)],
                    ['sender' => 'seller', 'message' => 'Fantastic news! I\'d love to discuss the implementation roadmap. Are you available for a detailed consultation this week?', 'time' => now()->subHours(1)],
                ]
            ],
            [
                'customer' => $customers[2],
                'messages' => [
                    ['sender' => 'customer', 'message' => 'Atiya, your supply chain analytics demo was excellent. We\'d like to move forward with a pilot program.', 'time' => now()->subDays(1)->subHours(2)],
                    ['sender' => 'seller', 'message' => 'That\'s wonderful to hear, Robert! A pilot program is a great way to demonstrate ROI. What scope are you thinking for the pilot?', 'time' => now()->subDays(1)->subHours(1)->subMinutes(30)],
                    ['sender' => 'customer', 'message' => 'We\'d like to start with our Asia-Pacific operations - about 5 locations and 200 SKUs.', 'time' => now()->subDays(1)->subHours(1)],
                    ['sender' => 'seller', 'message' => 'Perfect scope for a pilot. I\'ll prepare a detailed proposal with timeline and success metrics. Expect it by tomorrow.', 'time' => now()->subDays(1)->subMinutes(30)],
                ]
            ],
            [
                'customer' => $customers[4],
                'messages' => [
                    ['sender' => 'customer', 'message' => 'As-salamu alaykum Atiya. I\'m Ahmed from Middle East Trading. We need solutions for regional compliance.', 'time' => now()->subHours(6)],
                    ['sender' => 'seller', 'message' => 'Wa alaykumu s-salamu Ahmed! I\'d be happy to help with Middle East compliance requirements. Which countries are you primarily trading with?', 'time' => now()->subHours(5)->subMinutes(30)],
                    ['sender' => 'customer', 'message' => 'Mainly UAE, Saudi Arabia, Qatar, and Kuwait. The regulations keep changing and it\'s hard to keep up.', 'time' => now()->subHours(5)],
                    ['sender' => 'seller', 'message' => 'I completely understand. Our compliance tool has specific modules for GCC countries with real-time regulatory updates. Let me show you how it works.', 'time' => now()->subHours(4)->subMinutes(30)],
                ]
            ]
        ];

        foreach ($conversations as $convData) {
            $conversation = Conversation::create([
                'customer_id' => $convData['customer']->id,
                'seller_id' => $seller->id,
                'created_at' => $convData['messages'][0]['time'],
                'updated_at' => end($convData['messages'])['time'],
            ]);

            foreach ($convData['messages'] as $msgData) {
                Message::create([
                    'conversation_id' => $conversation->id,
                    'customer_id' => $convData['customer']->id,
                    'seller_id' => $seller->id,
                    'sender_type' => $msgData['sender'],
                    'message' => $msgData['message'],
                    'is_read' => true,
                    'created_at' => $msgData['time'],
                    'updated_at' => $msgData['time'],
                ]);
            }
        }

        $this->command->info('Created ' . count($conversations) . ' demo conversations for Atiya');
    }
}