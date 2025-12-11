<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Add polymorphic columns
            $table->string('owner_type')->nullable()->after('id');
            $table->unsignedBigInteger('owner_id')->nullable()->after('owner_type');
            
            // Add index for polymorphic relationship
            $table->index(['owner_type', 'owner_id']);
        });

        // Migrate existing data
        DB::statement("
            UPDATE products 
            SET owner_type = 'App\\\\Models\\\\Seller', owner_id = seller_id 
            WHERE seller_id IS NOT NULL
        ");

        DB::statement("
            UPDATE products 
            SET owner_type = 'App\\\\Models\\\\Manufacturer', owner_id = manufacturer_id 
            WHERE manufacturer_id IS NOT NULL AND owner_type IS NULL
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['owner_type', 'owner_id']);
            $table->dropColumn(['owner_type', 'owner_id']);
        });
    }
};