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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('seller_id')->nullable()->constrained('sellers')->onDelete('set null');
            $table->foreignId('salesman_id')->nullable()->constrained('salesmen')->onDelete('set null');
            $table->string('email', 255)->index();
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
            $table->text('message');
            $table->enum('status', ['open', 'closed', 'pending'])->default('pending')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
