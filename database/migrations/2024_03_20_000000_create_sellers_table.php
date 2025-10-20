<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            
            // Company Details
            $table->string('company_name');
            $table->string('company_registration_number');
            $table->text('company_address');
            $table->string('company_city');
            $table->string('company_state');
            $table->string('company_country');
            $table->string('company_postal_code');
            $table->string('company_phone');
            $table->string('company_website')->nullable();
            
            // Additional Details
            $table->string('contact_person_name');
            $table->string('contact_person_position');
            $table->string('contact_person_email')->unique();
            $table->string('contact_person_phone');
            $table->string('business_type');
            $table->json('main_products');
            $table->integer('years_in_business');
            $table->string('number_of_employees');
            $table->string('annual_revenue');
            
            // Account Details
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamp('email_verified_at')->nullable();
            
            // Document Details
            $table->string('business_license')->nullable();
            $table->string('tax_certificate')->nullable();
            $table->string('id_proof')->nullable();
            $table->string('company_profile')->nullable();
            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sellers');
    }
}; 