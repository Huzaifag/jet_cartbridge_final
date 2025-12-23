<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Education Information - limit lengths for indexed fields
            $table->string('institution_name', 150);                    // Already good
            $table->string('institution_logo')->nullable();             // Not indexed → can stay 255
            $table->string('degree', 100)->nullable();                  // Indexed → safe limit
            $table->string('field_of_study', 150)->nullable();          // Indexed → safe limit
            $table->string('location', 200)->nullable();                // Not indexed, but reasonable
            
            // Duration
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);
            
            // Additional Information
            $table->decimal('grade', 4, 2)->nullable(); // e.g., 3.85
            $table->string('grade_scale', 20)->nullable(); // e.g., '4.0', '10.0', '100'
            $table->text('description')->nullable();
            $table->json('activities')->nullable();
            $table->json('achievements')->nullable();
            
            // Verification
            $table->boolean('verified')->default(false);
            $table->string('verification_document')->nullable();
            
            // Display Order
            $table->integer('sort_order')->default(0);
            
            $table->timestamps();
            
            // Indexes - now all safe with utf8mb4
            $table->index('user_id');              // foreignId already indexes, but explicit is fine
            $table->index('institution_name');
            $table->index('degree');
            $table->index('field_of_study');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_educations');
    }
};