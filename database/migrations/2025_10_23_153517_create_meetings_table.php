<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();

            // Who requested the meeting
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');

            // Who receives the request
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');

            // Unique room name used for Jitsi / meeting room
            $table->string('room_name')->unique();

            // Optional: title/message for the meeting request
            $table->string('title')->nullable();
            $table->text('message')->nullable();

            // meeting status
            $table->enum('status', ['pending', 'accepted', 'rejected', 'cancelled'])
                  ->default('pending');

            // optional scheduled time (if you want scheduling later)
            $table->timestamp('scheduled_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
}
