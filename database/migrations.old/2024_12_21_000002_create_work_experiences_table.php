<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('work_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Job Information
            $table->string('job_title', 200);                    // Reasonable length
            $table->string('company_name', 150);                 // Indexed - safe limit
            $table->string('company_logo')->nullable();
            $table->string('employment_type')->nullable();
            $table->string('location', 200)->nullable();        // City/State/Country combo
            $table->boolean('is_remote')->default(false);
            
            // Duration
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);
            
            // Description
            $table->text('description')->nullable();
            $table->json('responsibilities')->nullable();
            $table->json('achievements')->nullable();
            $table->json('skills_used')->nullable();
            
            // Company Information
            $table->string('company_website')->nullable();
            $table->string('industry', 100)->nullable();        // Indexed - safe limit
            $table->string('company_size')->nullable();
            
            // Verification
            $table->boolean('verified')->default(false);
            $table->string('verification_document')->nullable();
            
            // Display Order
            $table->integer('sort_order')->default(0);
            
            $table->timestamps();
            
            // Indexes
            $table->index(['user_id', 'is_current']);
            $table->index('company_name');
            $table->index('industry');
            $table->index(['start_date', 'end_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('work_experiences');
    }
};