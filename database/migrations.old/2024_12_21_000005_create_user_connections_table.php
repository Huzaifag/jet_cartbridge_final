<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_connections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('connected_user_id')->constrained('users')->onDelete('cascade');
            
            // Connection Status
            $table->enum('status', ['pending', 'accepted', 'declined', 'blocked'])->default('pending');
            $table->text('message')->nullable(); // Connection request message
            
            // Connection Type
            $table->string('connection_type')->nullable(); // colleague, client, supplier, partner, etc.
            
            // Timestamps
            $table->timestamp('requested_at')->useCurrent();
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index(['user_id', 'status']);
            $table->index(['connected_user_id', 'status']);
            $table->unique(['user_id', 'connected_user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_connections');
    }
};