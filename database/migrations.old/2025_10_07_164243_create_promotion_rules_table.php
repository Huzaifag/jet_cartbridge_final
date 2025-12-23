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
        Schema::create('promotion_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promotion_id')->constrained('promotions')->onDelete('cascade');
            $table->integer('buy_quantity')->default(0);
            $table->integer('get_quantity')->default(0);
            $table->foreignId('applicable_product_id')->nullable()->constrained('products')->onDelete('set null');
            $table->string('applicable_tag')->nullable(); // if linked to tag instead of single product
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_rules');
    }
};
