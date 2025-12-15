<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            // Printer & Office Categories
            [
                'name' => 'Ink Cartridges',
                'slug' => 'ink-cartridges',
                'description' => 'Cartridges for inkjet printers',
                'image' => 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Toner Cartridges',
                'slug' => 'toner-cartridges',
                'description' => 'Cartridges for laser printers',
                'image' => 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=400&auto=format&fit=crop&crop=left',
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Paper',
                'slug' => 'paper',
                'description' => 'Photo and printing paper',
                'image' => 'https://images.unsplash.com/photo-1509869175650-a1d97972541a?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Printers',
                'slug' => 'printers',
                'description' => 'Inkjet and laser printers',
                'image' => 'https://images.unsplash.com/photo-1551650975-87deedd944c3?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Accessories',
                'slug' => 'accessories',
                'description' => 'Printer accessories and supplies',
                'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Office Supplies',
                'slug' => 'office-supplies',
                'description' => 'Essential office supplies and stationery',
                'image' => 'https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Maintenance Kits',
                'slug' => 'maintenance-kits',
                'description' => 'Printer maintenance and cleaning kits',
                'image' => 'https://images.unsplash.com/photo-1572025443061-3f53d8b8a2ec?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Specialty Papers',
                'slug' => 'specialty-papers',
                'description' => 'Specialty printing papers and media',
                'image' => 'https://images.unsplash.com/photo-1509869175650-a1d97972541a?w=400&auto=format&fit=crop&crop=right',
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Ribbons',
                'slug' => 'ribbons',
                'description' => 'Printer ribbons for dot matrix and thermal printers',
                'image' => 'https://images.unsplash.com/photo-1572025443061-3f53d8b8a2ec?w=400&auto=format&fit=crop&crop=top',
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Labels & Stickers',
                'slug' => 'labels-stickers',
                'description' => 'Printing labels and adhesive stickers',
                'image' => 'https://images.unsplash.com/photo-1509316785289-025f5b846b35?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => null,
            ],

            // New Categories
            [
                'name' => 'Clothing',
                'slug' => 'clothing',
                'description' => 'Fashion clothing for men, women, and kids',
                'image' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Mobile Phones',
                'slug' => 'mobile-phones',
                'description' => 'Smartphones, feature phones, and accessories',
                'image' => 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Watches',
                'slug' => 'watches',
                'description' => 'Wrist watches, smartwatches, and timepieces',
                'image' => 'https://images.unsplash.com/photo-1523170335258-f5ed11844a49?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Consumer electronics and gadgets',
                'image' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Home & Kitchen',
                'slug' => 'home-kitchen',
                'description' => 'Home appliances, kitchenware, and furniture',
                'image' => 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Sports & Outdoors',
                'slug' => 'sports-outdoors',
                'description' => 'Sports equipment and outdoor gear',
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Beauty & Personal Care',
                'slug' => 'beauty-personal-care',
                'description' => 'Cosmetics, skincare, and grooming products',
                'image' => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Books',
                'slug' => 'books',
                'description' => 'Books, magazines, and educational materials',
                'image' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Footwear',
                'slug' => 'footwear',
                'description' => 'Shoes, sandals, and footwear for all occasions',
                'image' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Jewelry',
                'slug' => 'jewelry',
                'description' => 'Necklaces, rings, bracelets, and earrings',
                'image' => 'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Toys & Games',
                'slug' => 'toys-games',
                'description' => 'Children toys, board games, and video games',
                'image' => 'https://images.unsplash.com/photo-1522869635100-9f4c5e86aa37?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Automotive',
                'slug' => 'automotive',
                'description' => 'Car accessories, parts, and maintenance products',
                'image' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Health & Wellness',
                'slug' => 'health-wellness',
                'description' => 'Vitamins, supplements, and wellness products',
                'image' => 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Furniture',
                'slug' => 'furniture',
                'description' => 'Home and office furniture',
                'image' => 'https://images.unsplash.com/photo-1556228453-efd6c1ff04f6?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => null,
            ],
            [
                'name' => 'Bags & Luggage',
                'slug' => 'bags-luggage',
                'description' => 'Handbags, backpacks, suitcases, and travel bags',
                'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400&auto=format&fit=crop&crop=top',
                'is_active' => true,
                'parent_id' => null,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Now let's add some sub-categories
        $subCategories = [
            // Clothing Sub-categories
            [
                'name' => 'Men\'s Clothing',
                'slug' => 'mens-clothing',
                'description' => 'Clothing for men',
                'image' => 'https://images.unsplash.com/photo-1552374196-c4e7ffc6e126?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => 11, // Assuming Clothing is id 11
            ],
            [
                'name' => 'Women\'s Clothing',
                'slug' => 'womens-clothing',
                'description' => 'Clothing for women',
                'image' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => 11,
            ],
            [
                'name' => 'Kids\' Clothing',
                'slug' => 'kids-clothing',
                'description' => 'Clothing for children',
                'image' => 'https://images.unsplash.com/photo-1558769132-cb894596f3f5?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => 11,
            ],

            // Electronics Sub-categories
            [
                'name' => 'Laptops & Computers',
                'slug' => 'laptops-computers',
                'description' => 'Laptops, desktops, and computer accessories',
                'image' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => 14, // Assuming Electronics is id 14
            ],
            [
                'name' => 'Audio & Headphones',
                'slug' => 'audio-headphones',
                'description' => 'Headphones, speakers, and audio equipment',
                'image' => 'https://images.unsplash.com/photo-1583394838336-acd977736f90?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => 14,
            ],
            [
                'name' => 'Cameras & Photography',
                'slug' => 'cameras-photography',
                'description' => 'Digital cameras, lenses, and photography gear',
                'image' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => 14,
            ],

            // Home & Kitchen Sub-categories
            [
                'name' => 'Kitchen Appliances',
                'slug' => 'kitchen-appliances',
                'description' => 'Kitchen gadgets and appliances',
                'image' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => 15, // Assuming Home & Kitchen is id 15
            ],
            [
                'name' => 'Home Decor',
                'slug' => 'home-decor',
                'description' => 'Home decoration items and accessories',
                'image' => 'https://images.unsplash.com/photo-1519710164239-da123dc03ef4?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => 15,
            ],
            [
                'name' => 'Bedding & Bath',
                'slug' => 'bedding-bath',
                'description' => 'Bed sheets, towels, and bath accessories',
                'image' => 'https://images.unsplash.com/photo-1556228578-9c360e1d8d34?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => 15,
            ],

            // Mobile Phones Sub-categories
            [
                'name' => 'Smartphones',
                'slug' => 'smartphones',
                'description' => 'Latest smartphones from all brands',
                'image' => 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=400&auto=format&fit=crop&crop=top',
                'is_active' => true,
                'parent_id' => 12, // Assuming Mobile Phones is id 12
            ],
            [
                'name' => 'Tablets',
                'slug' => 'tablets',
                'description' => 'Tablets and iPad devices',
                'image' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => 12,
            ],
            [
                'name' => 'Mobile Accessories',
                'slug' => 'mobile-accessories',
                'description' => 'Cases, chargers, and phone accessories',
                'image' => 'https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=400&auto=format&fit=crop',
                'is_active' => true,
                'parent_id' => 12,
            ],
        ];

        foreach ($subCategories as $subCategory) {
            Category::create($subCategory);
        }
    }
}