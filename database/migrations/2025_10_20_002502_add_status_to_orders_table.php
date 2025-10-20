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
         Schema::table('orders', function (Blueprint $table) {
            $table->enum('status', [
                'Order Placed',
                'Confirmed',
                'Accounting',
                'Invoiced',
                'In Production',
                'Packed',
                'Shipped',
                'Delivered'
            ])->default('Order Placed')->after('id'); // or after any column you prefer
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
