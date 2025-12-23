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
        Schema::table('sellers', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable()->after('company_postal_code');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            $table->boolean('is_premium')->default(false)->after('longitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'is_premium']);
        });
    }
};
