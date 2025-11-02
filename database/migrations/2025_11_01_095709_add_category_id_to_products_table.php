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
            Schema::table('products', function (Blueprint $table) {
                // Add the foreign key column
                $table->unsignedBigInteger('category_id')->nullable()->after('id');
    
                // Define foreign key constraint
                $table->foreign('category_id')
                      ->references('id')
                      ->on('categories')
                      ->onDelete('set null'); // or 'cascade' if you want to delete products when category is deleted
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
             // Drop foreign key first, then the column
             $table->dropForeign(['category_id']);
             $table->dropColumn('category_id');
        });
    }
};
