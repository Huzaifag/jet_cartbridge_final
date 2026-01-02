<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;

class MigrateProductOwnership extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:migrate-ownership';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate existing products to use polymorphic ownership';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting product ownership migration...');

        // Check if polymorphic columns exist
        if (!Schema::hasColumn('products', 'owner_type') || !Schema::hasColumn('products', 'owner_id')) {
            $this->error('Polymorphic columns (owner_type, owner_id) do not exist. Please run the migration first.');
            return 1;
        }

        // Migrate products with seller_id
        $sellerProducts = DB::table('products')
            ->whereNotNull('seller_id')
            ->whereNull('owner_type')
            ->count();

        if ($sellerProducts > 0) {
            DB::table('products')
                ->whereNotNull('seller_id')
                ->whereNull('owner_type')
                ->update([
                    'owner_type' => 'App\\Models\\Seller',
                    'owner_id' => DB::raw('seller_id')
                ]);

            $this->info("Migrated {$sellerProducts} seller products.");
        }

        // Migrate products with manufacturer_id
        $manufacturerProducts = DB::table('products')
            ->whereNotNull('manufacturer_id')
            ->whereNull('seller_id')
            ->whereNull('owner_type')
            ->count();

        if ($manufacturerProducts > 0) {
            DB::table('products')
                ->whereNotNull('manufacturer_id')
                ->whereNull('seller_id')
                ->whereNull('owner_type')
                ->update([
                    'owner_type' => 'App\\Models\\Manufacturer',
                    'owner_id' => DB::raw('manufacturer_id')
                ]);

            $this->info("Migrated {$manufacturerProducts} manufacturer products.");
        }

        // Check for orphaned products
        $orphanedProducts = DB::table('products')
            ->whereNull('owner_type')
            ->count();

        if ($orphanedProducts > 0) {
            $this->warn("Found {$orphanedProducts} products without valid ownership. These may need manual review.");
        }

        $this->info('Product ownership migration completed successfully!');
        return 0;
    }
}