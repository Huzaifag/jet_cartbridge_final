<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_inquiries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contact_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('customer_id');
            $table->integer('quantity')->nullable();
            $table->decimal('target_price', 10, 2)->nullable();
            $table->string('destination')->nullable();
            $table->date('deadline')->nullable();
            $table->text('message')->nullable();
            $table->timestamps();

            // Foreign Keys (optional but recommended)
            $table->foreign('contact_id')->references('id')->on('user_contacts')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_inquiries');
    }
};
