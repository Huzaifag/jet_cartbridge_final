<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add order_number column (unique identifier for each order)
            $table->string('order_number')->unique()->after('id');

            // Add status column if it doesn't exist
            if (!Schema::hasColumn('orders', 'status')) {
                $table->string('status')->default('Order Placed')->after('order_number');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['order_number']);

            // Only drop status if we added it
            if (Schema::hasColumn('orders', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
