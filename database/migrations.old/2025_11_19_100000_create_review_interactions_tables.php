<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Review Likes Table
        Schema::create('review_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['review_id', 'user_id']);
        });

        // Review Comments Table
        Schema::create('review_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('comment');
            $table->timestamps();

            $table->index(['review_id', 'created_at']);
        });

        // Review Shares Table (for tracking)
        Schema::create('review_shares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('platform'); // whatsapp, facebook, twitter, copy
            $table->timestamps();

            $table->index(['review_id', 'platform']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('review_shares');
        Schema::dropIfExists('review_comments');
        Schema::dropIfExists('review_likes');
    }
};
