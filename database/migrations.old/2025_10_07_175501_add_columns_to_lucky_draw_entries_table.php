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
            $table->foreignId('lucky_draw_id')->after('id')->constrained('lucky_draws')->onDelete('cascade');
            $table->foreignId('customer_id')->after('lucky_draw_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('order_id')->after('customer_id')->constrained('orders')->onDelete('cascade');
            $table->string('entry_code', 20)->unique()->after('order_id');
            $table->boolean('is_winner')->default(false)->after('entry_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lucky_draw_entries', function (Blueprint $table) {
            $table->dropForeign(['lucky_draw_id']);
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['order_id']);
            $table->dropColumn(['lucky_draw_id', 'customer_id', 'order_id', 'entry_code', 'is_winner']);
        });
    }
};
