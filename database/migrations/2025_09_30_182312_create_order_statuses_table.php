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
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');

            // Stage name
            $table->enum('stage', [
                'order_placed',
                'with_accountant',
                'invoice_stage',
                'in_production',
                'delivery',
                'delivered'
            ]);

            // Status of this stage
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');

            // When stage started/ended
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_statuses');
    }
};
