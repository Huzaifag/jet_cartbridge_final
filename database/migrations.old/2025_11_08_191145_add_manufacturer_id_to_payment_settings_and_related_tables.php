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
        // Add manufacturer_id to payment_settings (if not exists)
        if (!Schema::hasColumn('payment_settings', 'manufacturer_id')) {
            Schema::table('payment_settings', function (Blueprint $table) {
                $table->foreignId('manufacturer_id')->nullable()->after('seller_id')->constrained('manufacturers')->onDelete('cascade');
            });
        }
        
        // Make seller_id nullable in payment_settings
        Schema::table('payment_settings', function (Blueprint $table) {
            $table->foreignId('seller_id')->nullable()->change();
        });

        // Add manufacturer_id to notification_preferences
        if (!Schema::hasColumn('notification_preferences', 'manufacturer_id')) {
            Schema::table('notification_preferences', function (Blueprint $table) {
                $table->foreignId('manufacturer_id')->nullable()->after('seller_id')->constrained('manufacturers')->onDelete('cascade');
            });
        }
        
        // Make seller_id nullable in notification_preferences
        Schema::table('notification_preferences', function (Blueprint $table) {
            $table->unsignedBigInteger('seller_id')->nullable()->change();
        });

        // Add manufacturer_id to two_factor_settings (if not already exists)
        if (!Schema::hasColumn('two_factor_settings', 'manufacturer_id')) {
            Schema::table('two_factor_settings', function (Blueprint $table) {
                $table->foreignId('manufacturer_id')->nullable()->after('seller_id')->constrained('manufacturers')->onDelete('cascade');
            });
        }
        
        // Make seller_id nullable in two_factor_settings
        Schema::table('two_factor_settings', function (Blueprint $table) {
            $table->unsignedBigInteger('seller_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_settings', function (Blueprint $table) {
            $table->dropForeign(['manufacturer_id']);
            $table->dropColumn('manufacturer_id');
        });

        Schema::table('notification_preferences', function (Blueprint $table) {
            $table->dropForeign(['manufacturer_id']);
            $table->dropColumn('manufacturer_id');
        });

        if (Schema::hasColumn('two_factor_settings', 'manufacturer_id')) {
            Schema::table('two_factor_settings', function (Blueprint $table) {
                $table->dropForeign(['manufacturer_id']);
                $table->dropColumn('manufacturer_id');
            });
        }
    }
};
