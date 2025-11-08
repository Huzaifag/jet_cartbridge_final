<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, change the enum to include BOTH old and new stage names
        DB::statement("ALTER TABLE order_statuses MODIFY COLUMN stage ENUM(
            'order_placed',
            'with_accountant',
            'invoice_stage',
            'in_production',
            'delivery',
            'salesman_review',
            'accountant_billing',
            'warehouse_dispatch',
            'out_for_delivery',
            'delivered'
        ) NOT NULL");

        // Now update existing data to new stage names
        DB::table('order_statuses')->where('stage', 'with_accountant')->update(['stage' => 'accountant_billing']);
        DB::table('order_statuses')->where('stage', 'invoice_stage')->update(['stage' => 'accountant_billing']);
        DB::table('order_statuses')->where('stage', 'in_production')->update(['stage' => 'warehouse_dispatch']);
        DB::table('order_statuses')->where('stage', 'delivery')->update(['stage' => 'out_for_delivery']);

        // Finally, remove old stage names from enum
        DB::statement("ALTER TABLE order_statuses MODIFY COLUMN stage ENUM(
            'order_placed',
            'salesman_review',
            'accountant_billing',
            'warehouse_dispatch',
            'out_for_delivery',
            'delivered'
        ) NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert data back to old stage names
        DB::table('order_statuses')->where('stage', 'salesman_review')->update(['stage' => 'order_placed']);
        DB::table('order_statuses')->where('stage', 'accountant_billing')->update(['stage' => 'with_accountant']);
        DB::table('order_statuses')->where('stage', 'warehouse_dispatch')->update(['stage' => 'in_production']);
        DB::table('order_statuses')->where('stage', 'out_for_delivery')->update(['stage' => 'delivery']);

        // Revert enum to old values
        DB::statement("ALTER TABLE order_statuses MODIFY COLUMN stage ENUM(
            'order_placed',
            'with_accountant',
            'invoice_stage',
            'in_production',
            'delivery',
            'delivered'
        ) NOT NULL");
    }
};
