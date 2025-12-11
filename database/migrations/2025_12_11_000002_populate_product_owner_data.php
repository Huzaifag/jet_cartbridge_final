<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update products that have seller_id but no owner data
        DB::statement("
            UPDATE products 
            SET owner_type = 'App\\\\Models\\\\Seller', owner_id = seller_id 
            WHERE seller_id IS NOT NULL AND owner_type IS NULL
        ");

        // Update products that have manufacturer_id but no owner data
        DB::statement("
            UPDATE products 
            SET owner_type = 'App\\\\Models\\\\Manufacturer', owner_id = manufacturer_id 
            WHERE manufacturer_id IS NOT NULL AND owner_type IS NULL
        ");

        // For any remaining products without owner data, try to assign to seller if seller_id exists
        DB::statement("
            UPDATE products 
            SET owner_type = 'App\\\\Models\\\\Seller', owner_id = seller_id 
            WHERE seller_id IS NOT NULL AND owner_type IS NULL
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reset owner columns
        DB::statement("UPDATE products SET owner_type = NULL, owner_id = NULL");
    }
};