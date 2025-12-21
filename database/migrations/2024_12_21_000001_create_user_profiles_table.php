<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Basic Profile Information
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->text('bio')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('cover_photo')->nullable();

            // Location Information - Limit lengths for indexed columns
            $table->string('country', 100)->nullable();   // Safe for indexing (400 bytes max)
            $table->string('state', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('address', 200)->nullable();    // Slightly longer if needed
            $table->string('postal_code', 50)->nullable();

            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Professional Information
            $table->string('job_title')->nullable();
            $table->string('company')->nullable();
            $table->string('industry', 100)->nullable();   // Indexed below, so limit it too
            $table->text('professional_summary')->nullable();
            $table->json('skills')->nullable();
            $table->string('website')->nullable();
            $table->string('linkedin_url')->nullable();

            // Social Media Links
            $table->json('social_links')->nullable();

            // Privacy Settings
            $table->boolean('profile_public')->default(true);
            $table->boolean('show_email')->default(false);
            $table->boolean('show_phone')->default(false);
            $table->boolean('show_location')->default(true);

            // Verification Status
            $table->boolean('email_verified')->default(false);
            $table->boolean('phone_verified')->default(false);
            $table->boolean('identity_verified')->default(false);
            $table->timestamp('verified_at')->nullable();

            // Activity Tracking
            $table->timestamp('last_active_at')->nullable();
            $table->integer('profile_views')->default(0);
            $table->integer('connection_count')->default(0);

            $table->timestamps();

            // Indexes
            $table->index('user_id');                  // foreignId already indexes this, but explicit is fine
            $table->index('country');
            $table->index('industry');
            $table->index('profile_public');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
};