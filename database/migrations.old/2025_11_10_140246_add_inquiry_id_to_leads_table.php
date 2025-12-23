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
        Schema::table('leads', function (Blueprint $table) {
            $table->foreignId('inquiry_id')->nullable()->after('id')->constrained('user_inquiries')->onDelete('cascade');
            $table->string('buyer_name')->nullable()->after('buyer_id');
            $table->string('buyer_phone')->nullable()->after('buyer_name');
            $table->integer('quantity')->nullable()->after('message');
            $table->decimal('target_price', 10, 2)->nullable()->after('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropForeign(['inquiry_id']);
            $table->dropColumn(['inquiry_id', 'buyer_name', 'buyer_phone', 'quantity', 'target_price']);
        });
    }
};
