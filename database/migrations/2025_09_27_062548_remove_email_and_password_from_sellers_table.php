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
            if (Schema::hasColumn('sellers', 'email')) {
                $table->dropColumn('email');
            }
            if (Schema::hasColumn('sellers', 'password')) {
                $table->dropColumn('password');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->string('email')->unique()->nullable();   // or required if you want
            $table->string('password')->nullable(); // or required if you want
        });
    }
};
