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
        Schema::table('lucky_draw_entries', function (Blueprint $table) {
            // Check if column doesn't exist before adding
            if (!Schema::hasColumn('lucky_draw_entries', 'promotion_id')) {
                $table->foreignId('promotion_id')->nullable()->constrained('promotions')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lucky_draw_entries', function (Blueprint $table) {
            if (Schema::hasColumn('lucky_draw_entries', 'promotion_id')) {
                $table->dropForeign(['promotion_id']);
                $table->dropColumn('promotion_id');
            }
        });
    }
};
