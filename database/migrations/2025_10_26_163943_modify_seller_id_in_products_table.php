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
        Schema::table('products', function (Blueprint $table) {
            Schema::table('products', function (Blueprint $table) {
                // First, drop foreign key if it exists
                if (Schema::hasColumn('products', 'seller_id')) {
                    $table->dropForeign(['seller_id']); // drop FK constraint
                    $table->dropColumn('seller_id');    // remove column
                }

                // Add new nullable seller_id
                $table->unsignedBigInteger('seller_id')->nullable()->after('id');

                // Recreate foreign key if you have a sellers table
                $table->foreign('seller_id')
                    ->references('id')
                    ->on('sellers')
                    ->onDelete('set null');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            Schema::table('products', function (Blueprint $table) {
                // First, drop foreign key if it exists
                if (Schema::hasColumn('products', 'seller_id')) {
                    $table->dropForeign(['seller_id']); // drop FK constraint
                    $table->dropColumn('seller_id');    // remove column
                }
            });
        });
    }
};
