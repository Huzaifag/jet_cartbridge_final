<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\WorkExperience;
use App\Models\UserEducation;
use App\Models\UserCertification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class UserProfileSeeder extends Seeder
{
    public function run()
    {
        // Find or create the user atiya@gmail.com
        $user = User::firstOrCreate(
            ['email' => 'atiya@gmail.com'],
            [
                'name' => 'Atiya Rahman',
                'password' => Hash::make('password123'),
                'role' => 'b2b',
                'email_verified_at' => now(),
            ]
        );

        // Assign seller role if not already assigned
        if (!$user->hasRole('seller')) {
            $user->assignRole('seller');
        }

        // Create comprehensive profile
        $profile = UserProfile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'first_name' => 'Atiya',
                'last_name' => 'Rahman',
                'phone' => '+1-555-0123',
                'date_of_birth' => '1985-03-15',
                'gender' => 'female',
                'bio' => 'Passionate business leader with over 10 years of experience in international trade and e-commerce. Specialized in building strategic partnerships and driving digital transformation in traditional industries.',
                'country' => 'United States',
                'state' => 'California',
                'city' => 'San Francisco',
                'address' => '123 Business District, Suite 456',
                'postal_code' => '94105',
                'latitude' => 37.7749,
                'longitude' => -122.4194,
                'job_title' => 'Senior Business Development Manager',
                'company' => 'Global Trade Solutions Inc.',
                'industry' => 'International Trade & E-commerce',
                'professional_summary' => 'Results-driven business development professional with a proven track record of expanding market presence in Asia-Pacific and North American markets. Expert in B2B relationship management, strategic partnerships, and digital marketplace optimization. Led cross-functional teams to achieve 300% revenue growth over 5 years.',
                'skills' => [
                    'Business Development',
                    'International Trade',
                    'E-commerce Strategy',
                    'Partnership Management',
                    'Market Analysis',
                    'Digital Marketing',
                    'Supply Chain Management',
                    'Negotiation',
                    'Project Management',
                    'Team Leadership'
                ],
                'website' => 'https://atiyarahman.com',
                'linkedin_url' => 'https://linkedin.com/in/atiya-rahman',
                'social_links' => [
                    ['platform' => 'Twitter', 'url' => 'https://twitter.com/atiya_rahman'],
                    ['platform' => 'Instagram', 'url' => 'https://instagram.com/atiya.business'],
                ],
                'profile_public' => true,
                'show_email' => true,
                'show_phone' => true,
                'show_location' => true,
                'email_verified' => true,
                'phone_verified' => true,
                'identity_verified' => true,
                'verified_at' => now(),
                'last_active_at' => now(),
                'profile_views' => 1247,
                'connection_count' => 156,
            ]
        );

        // Create work experiences
        $workExperiences = [
            [
                'job_title' => 'Senior Business Development Manager',
                'company_name' => 'Global Trade Solutions Inc.',
                'employment_type' => 'Full-time',
                'location' => 'San Francisco, CA',
                'is_remote' => false,
                'start_date' => '2020-01-15',
                'end_date' => null,
                'is_current' => true,
                'description' => 'Leading business development initiatives for international markets, focusing on Asia-Pacific expansion. Responsible for strategic partnerships, market analysis, and revenue growth strategies.',
                'responsibilities' => [
                    'Develop and execute business development strategies for international markets',
                    'Build and maintain relationships with key stakeholders and partners',
                    'Lead cross-functional teams to achieve revenue targets',
                    'Analyze market trends and competitive landscape',
                    'Negotiate high-value contracts and partnerships'
                ],
                'achievements' => [
                    'Increased international revenue by 300% over 4 years',
                    'Established partnerships with 50+ suppliers across 15 countries',
                    'Led digital transformation initiative resulting in 40% efficiency improvement',
                    'Won "Business Development Excellence Award" 2023'
                ],
                'skills_used' => [
                    'Business Development',
                    'International Trade',
                    'Partnership Management',
                    'Market Analysis',
                    'Team Leadership'
                ],
                'company_website' => 'https://globaltradesolutions.com',
                'industry' => 'International Trade',
                'company_size' => '201-500',
                'verified' => true,
                'sort_order' => 1,
            ],
            [
                'job_title' => 'Business Development Associate',
                'company_name' => 'TechCommerce Ltd.',
                'employment_type' => 'Full-time',
                'location' => 'New York, NY',
                'is_remote' => false,
                'start_date' => '2017-06-01',
                'end_date' => '2019-12-31',
                'is_current' => false,
                'description' => 'Focused on B2B e-commerce platform development and client acquisition. Worked closely with product and engineering teams to enhance platform capabilities.',
                'responsibilities' => [
                    'Identify and pursue new business opportunities',
                    'Manage client relationships and account growth',
                    'Collaborate with product team on feature development',
                    'Conduct market research and competitive analysis'
                ],
                'achievements' => [
                    'Acquired 25+ enterprise clients in first year',
                    'Contributed to 150% platform user growth',
                    'Developed client onboarding process reducing time-to-value by 60%'
                ],
                'skills_used' => [
                    'E-commerce',
                    'Client Management',
                    'Product Development',
                    'Market Research'
                ],
                'company_website' => 'https://techcommerce.com',
                'industry' => 'E-commerce Technology',
                'company_size' => '51-200',
                'verified' => true,
                'sort_order' => 2,
            ],
            [
                'job_title' => 'Sales Executive',
                'company_name' => 'Digital Marketplace Corp',
                'employment_type' => 'Full-time',
                'location' => 'Chicago, IL',
                'is_remote' => false,
                'start_date' => '2015-03-01',
                'end_date' => '2017-05-31',
                'is_current' => false,
                'description' => 'Entry-level position focused on B2B sales and customer relationship management. Gained foundational experience in digital marketplace operations.',
                'responsibilities' => [
                    'Generate leads through cold calling and networking',
                    'Present product demonstrations to potential clients',
                    'Maintain CRM system and sales pipeline',
                    'Provide customer support and account management'
                ],
                'achievements' => [
                    'Exceeded sales targets by 120% in final year',
                    'Maintained 95% customer satisfaction rating',
                    'Promoted to senior sales role within 18 months'
                ],
                'skills_used' => [
                    'Sales',
                    'Customer Relationship Management',
                    'Lead Generation',
                    'Product Demonstration'
                ],
                'industry' => 'Digital Marketplace',
                'company_size' => '11-50',
                'verified' => true,
                'sort_order' => 3,
            ]
        ];

        foreach ($workExperiences as $experience) {
            WorkExperience::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'company_name' => $experience['company_name'],
                    'job_title' => $experience['job_title']
                ],
                array_merge($experience, ['user_id' => $user->id])
            );
        }

        // Create education records
        $educations = [
            [
                'institution_name' => 'Stanford University',
                'degree' => 'Master of Business Administration',
                'field_of_study' => 'International Business',
                'location' => 'Stanford, CA',
                'start_date' => '2013-09-01',
                'end_date' => '2015-06-15',
                'is_current' => false,
                'grade' => 3.8,
                'grade_scale' => '4.0',
                'description' => 'Focused on international business strategy, global supply chain management, and digital transformation. Completed capstone project on emerging market entry strategies.',
                'activities' => [
                    'International Business Club - Vice President',
                    'Graduate Student Association - Member',
                    'Case Competition Team - Lead Analyst'
                ],
                'achievements' => [
                    'Dean\'s List - 4 consecutive semesters',
                    'Outstanding Leadership Award 2014',
                    'International Business Case Competition - 2nd Place'
                ],
                'verified' => true,
                'sort_order' => 1,
            ],
            [
                'institution_name' => 'University of California, Berkeley',
                'degree' => 'Bachelor of Science',
                'field_of_study' => 'Business Administration',
                'location' => 'Berkeley, CA',
                'start_date' => '2009-08-01',
                'end_date' => '2013-05-15',
                'is_current' => false,
                'grade' => 3.6,
                'grade_scale' => '4.0',
                'description' => 'Comprehensive business education with emphasis on marketing, finance, and operations management. Active in various student organizations and leadership roles.',
                'activities' => [
                    'Business Student Association - President',
                    'Marketing Club - Event Coordinator',
                    'Volunteer Tutor - Business Mathematics'
                ],
                'achievements' => [
                    'Magna Cum Laude Graduate',
                    'Outstanding Student Leader Award 2013',
                    'Business Plan Competition - Winner'
                ],
                'verified' => true,
                'sort_order' => 2,
            ]
        ];

        foreach ($educations as $education) {
            UserEducation::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'institution_name' => $education['institution_name'],
                    'degree' => $education['degree']
                ],
                array_merge($education, ['user_id' => $user->id])
            );
        }

        // Create certifications
        $certifications = [
            [
                'name' => 'Certified International Trade Professional (CITP)',
                'issuing_organization' => 'Forum for International Trade Training',
                'credential_id' => 'CITP-2022-4567',
                'credential_url' => 'https://fitt.ca/verify/CITP-2022-4567',
                'issue_date' => '2022-03-15',
                'expiration_date' => '2025-03-15',
                'does_not_expire' => false,
                'description' => 'Comprehensive certification covering international trade regulations, export/import procedures, and global business practices.',
                'skills' => [
                    'International Trade Regulations',
                    'Export/Import Procedures',
                    'Global Business Practices',
                    'Trade Finance'
                ],
                'verified' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Digital Marketing Professional',
                'issuing_organization' => 'Google',
                'credential_id' => 'GDM-2021-8901',
                'credential_url' => 'https://skillshop.exceedlms.com/student/path/18128',
                'issue_date' => '2021-08-20',
                'expiration_date' => null,
                'does_not_expire' => true,
                'description' => 'Advanced certification in digital marketing strategies, analytics, and campaign optimization.',
                'skills' => [
                    'Digital Marketing',
                    'Google Analytics',
                    'Campaign Optimization',
                    'SEO/SEM'
                ],
                'verified' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Project Management Professional (PMP)',
                'issuing_organization' => 'Project Management Institute',
                'credential_id' => 'PMP-2020-1234',
                'credential_url' => 'https://www.pmi.org/certifications/project-management-pmp',
                'issue_date' => '2020-11-10',
                'expiration_date' => '2023-11-10',
                'does_not_expire' => false,
                'description' => 'Globally recognized certification demonstrating project management expertise and leadership skills.',
                'skills' => [
                    'Project Management',
                    'Team Leadership',
                    'Risk Management',
                    'Agile Methodologies'
                ],
                'verified' => true,
                'sort_order' => 3,
            ]
        ];

        foreach ($certifications as $certification) {
            UserCertification::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'name' => $certification['name'],
                    'issuing_organization' => $certification['issuing_organization']
                ],
                array_merge($certification, ['user_id' => $user->id])
            );
        }

        $this->command->info('User profile data seeded successfully for atiya@gmail.com!');
        $this->command->info('Login credentials: atiya@gmail.com / password123');
    }
}