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
            $table->dropColumn('price');
            $table->dropColumn('moq');

            // Add new pricing fields
            $table->decimal('b2c_price', 10, 2)->nullable()->after('description');
            $table->decimal('b2c_compare_price', 10, 2)->nullable()->after('b2c_price');
            $table->decimal('b2b_price', 10, 2)->nullable()->after('b2c_compare_price');
            $table->integer('b2b_moq')->nullable()->after('b2b_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['b2c_price', 'b2c_compare_price', 'b2b_price', 'b2b_moq']);
            $table->decimal('price', 10, 2)->nullable()->after('description');
            $table->integer('moq')->nullable()->after('price');
        });
    }
};
