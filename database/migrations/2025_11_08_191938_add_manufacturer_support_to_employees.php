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
        // Add manufacturer_id to accountants table
        if (!Schema::hasColumn('accountants', 'manufacturer_id')) {
            Schema::table('accountants', function (Blueprint $table) {
                $table->foreignId('manufacturer_id')->nullable()->after('seller_id')->constrained('manufacturers')->onDelete('cascade');
                $table->foreignId('seller_id')->nullable()->change();
            });
        }

        // Add manufacturer_id to salesmen table
        if (!Schema::hasColumn('salesmen', 'manufacturer_id')) {
            Schema::table('salesmen', function (Blueprint $table) {
                $table->foreignId('manufacturer_id')->nullable()->after('seller_id')->constrained('manufacturers')->onDelete('cascade');
                $table->foreignId('seller_id')->nullable()->change();
            });
        }

        // Add manufacturer_id to warehouses table
        if (!Schema::hasColumn('warehouses', 'manufacturer_id')) {
            Schema::table('warehouses', function (Blueprint $table) {
                $table->foreignId('manufacturer_id')->nullable()->after('seller_id')->constrained('manufacturers')->onDelete('cascade');
                $table->foreignId('seller_id')->nullable()->change();
            });
        }

        // Add manufacturer_id to delivery_men table
        if (!Schema::hasColumn('delivery_men', 'manufacturer_id')) {
            Schema::table('delivery_men', function (Blueprint $table) {
                $table->foreignId('manufacturer_id')->nullable()->after('seller_id')->constrained('manufacturers')->onDelete('cascade');
                $table->foreignId('seller_id')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accountants', function (Blueprint $table) {
            $table->dropForeign(['manufacturer_id']);
            $table->dropColumn('manufacturer_id');
        });

        Schema::table('salesmen', function (Blueprint $table) {
            $table->dropForeign(['manufacturer_id']);
            $table->dropColumn('manufacturer_id');
        });

        Schema::table('warehouses', function (Blueprint $table) {
            $table->dropForeign(['manufacturer_id']);
            $table->dropColumn('manufacturer_id');
        });

        Schema::table('delivery_men', function (Blueprint $table) {
            $table->dropForeign(['manufacturer_id']);
            $table->dropColumn('manufacturer_id');
        });
    }
};
