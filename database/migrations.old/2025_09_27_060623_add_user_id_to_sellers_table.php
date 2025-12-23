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
            // Add the column (nullable first if migrating existing data)
            $table->unsignedBigInteger('user_id')->nullable()->after('id');

            // Add foreign key reference
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade'); // if user is deleted, seller profile also goes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
