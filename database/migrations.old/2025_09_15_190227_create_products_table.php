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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('sellers')->onDelete('cascade');
            // $table->foreignId('created_by')->nullable()->constrained('employees')->onDelete('set null');
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->integer('moq')->default(1); // Minimum Order Quantity
            $table->integer('stock_quantity')->default(0);
            $table->string('category');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->json('specifications')->nullable();
            $table->json('images')->nullable();
            $table->enum('status', ['active', 'inactive', 'out_of_stock'])->default('active');
            $table->boolean('is_featured')->default(false);
            $table->decimal('rating', 2, 1)->nullable();
            $table->enum('verification_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
