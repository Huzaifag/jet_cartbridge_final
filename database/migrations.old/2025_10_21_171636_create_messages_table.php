<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();

            // customer (user) who sends/receives messages
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');

            // seller involved in the chat
            $table->foreignId('seller_id')->constrained('sellers')->onDelete('cascade');

            // who sent this message (could be 'customer' or 'seller')
            $table->enum('sender_type', ['customer', 'seller']);

            // actual message text
            $table->text('message')->nullable();

            // optional file (like image)
            $table->string('attachment')->nullable();

            // to mark message as read/unread
            $table->boolean('is_read')->default(false);

            //Conversation id
            $table->foreignId('conversation_id')
                  ->nullable()
                  ->constrained('conversations')
                  ->onDelete('cascade');
        

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
