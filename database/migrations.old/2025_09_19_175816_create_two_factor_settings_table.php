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
        Schema::create('two_factor_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id');
            $table->boolean('is_enabled')->default(false);
            $table->enum('method', ['sms', 'email', 'authenticator_app'])->nullable();
            $table->timestamps();

            $table->foreign('seller_id')
                  ->references('id')
                  ->on('sellers')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('two_factor_settings');
    }
};
