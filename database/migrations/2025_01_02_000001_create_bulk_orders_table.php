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
        Schema::create('bulk_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('seller_id')->constrained()->onDelete('cascade');
            $table->string('order_number')->unique();
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['pending', 'accepted', 'rejected', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');
            $table->text('delivery_address');
            $table->date('delivery_date')->nullable();
            $table->text('notes')->nullable();
            $table->text('seller_response')->nullable();
            $table->timestamp('seller_response_date')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['seller_id', 'status']);
            $table->index('order_number');
        });

        Schema::create('bulk_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bulk_order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('unit_price', 8, 2);
            $table->decimal('total_price', 10, 2);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('bulk_order_id');
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bulk_order_items');
        Schema::dropIfExists('bulk_orders');
    }
};