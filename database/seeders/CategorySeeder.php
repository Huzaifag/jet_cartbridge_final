<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Ink Cartridges',
                'slug' => 'ink-cartridges',
                'description' => 'Cartridges for inkjet printers',
                'image' => 'categories/ink-cartridges.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Toner Cartridges',
                'slug' => 'toner-cartridges',
                'description' => 'Cartridges for laser printers',
                'image' => 'categories/toner-cartridges.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Paper',
                'slug' => 'paper',
                'description' => 'Photo and printing paper',
                'image' => 'categories/paper.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Printers',
                'slug' => 'printers',
                'description' => 'Inkjet and laser printers',
                'image' => 'categories/printers.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Accessories',
                'slug' => 'accessories',
                'description' => 'Printer accessories and supplies',
                'image' => 'categories/accessories.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Office Supplies',
                'slug' => 'office-supplies',
                'description' => 'Essential office supplies and stationery',
                'image' => 'categories/office-supplies.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Maintenance Kits',
                'slug' => 'maintenance-kits',
                'description' => 'Printer maintenance and cleaning kits',
                'image' => 'categories/maintenance-kits.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Specialty Papers',
                'slug' => 'specialty-papers',
                'description' => 'Specialty printing papers and media',
                'image' => 'categories/specialty-papers.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Ribbons',
                'slug' => 'ribbons',
                'description' => 'Printer ribbons for dot matrix and thermal printers',
                'image' => 'categories/ribbons.jpg',
                'is_active' => true,
            ],
            [
                'name' => 'Labels & Stickers',
                'slug' => 'labels-stickers',
                'description' => 'Printing labels and adhesive stickers',
                'image' => 'categories/labels-stickers.jpg',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
