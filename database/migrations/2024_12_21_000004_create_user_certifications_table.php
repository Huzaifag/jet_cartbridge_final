<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_certifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Certification Information - limit lengths for safety and indexing
            $table->string('name', 200);                        // Long enough for most cert names
            $table->string('issuing_organization', 150);        // Indexed → must be limited
            $table->string('organization_logo')->nullable();    // URL/path, not indexed
            $table->string('credential_id', 100)->nullable();   // Usually short codes
            $table->string('credential_url')->nullable();       // Full URL, not indexed
            
            // Dates
            $table->date('issue_date');
            $table->date('expiration_date')->nullable();
            $table->boolean('does_not_expire')->default(false);
            
            // Additional Information
            $table->text('description')->nullable();
            $table->json('skills')->nullable();
            
            // Verification
            $table->boolean('verified')->default(false);
            $table->string('verification_document')->nullable();
            
            // Display Order
            $table->integer('sort_order')->default(0);
            
            $table->timestamps();
            
            // Indexes - now safe with utf8mb4
            $table->index('user_id');                   // Already indexed by foreign key, but explicit is fine
            $table->index('issuing_organization');      // Now on VARCHAR(150) → max 600 bytes
            $table->index('issue_date');
            $table->index('expiration_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_certifications');
    }
};