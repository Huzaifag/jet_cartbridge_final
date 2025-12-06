<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained()->onDelete('cascade');
            $table->string('employee_type'); // salesman, accountant, warehouse, deliveryman
            $table->unsignedBigInteger('employee_id');
            $table->string('activity_type'); // order_created, invoice_generated, product_dispatched, delivery_completed, lead_converted, etc.
            $table->text('description');
            $table->string('reference_type')->nullable(); // Order, Lead, Product, etc.
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->json('metadata')->nullable(); // Additional data
            $table->timestamps();

            $table->index(['seller_id', 'employee_type', 'created_at']);
            $table->index(['employee_type', 'employee_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_activities');
    }
};
