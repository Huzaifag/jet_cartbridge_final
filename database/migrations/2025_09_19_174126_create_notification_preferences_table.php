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
        Schema::create('notification_preferences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id');

            // Order Notifications
            $table->boolean('order_email')->default(false);
            $table->boolean('order_sms')->default(false);
            $table->boolean('order_push')->default(false);

            // Inquiry Notifications
            $table->boolean('inquiry_email')->default(false);
            $table->boolean('inquiry_sms')->default(false);
            $table->boolean('inquiry_push')->default(false);

            // Promotions / Offers
            $table->boolean('promotions_notifications')->default(false);
            $table->boolean('promotions_email')->default(false);
            $table->boolean('promotions_sms')->default(false);

            // Payment Updates
            $table->boolean('payment_email')->default(false);
            $table->boolean('payment_sms')->default(false);
            $table->boolean('payment_push')->default(false);

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
        Schema::dropIfExists('notification_preferences');
    }
};
