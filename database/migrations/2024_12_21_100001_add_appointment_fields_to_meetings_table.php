<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('meetings', function (Blueprint $table) {
            // Add customer relationship
            $table->unsignedBigInteger('customer_id')->nullable()->after('receiver_id');
            
            // Add seller and manufacturer relationships
            $table->unsignedBigInteger('seller_id')->nullable()->after('customer_id');
            $table->unsignedBigInteger('manufacturer_id')->nullable()->after('seller_id');
            
            // Add meeting details
            $table->text('description')->nullable()->after('message');
            $table->enum('meeting_type', ['physical', 'video', 'call'])->default('physical')->after('description');
            $table->integer('duration')->nullable()->after('meeting_type'); // in minutes
            $table->string('location')->nullable()->after('duration');
            
            // Add admin management fields
            $table->text('admin_notes')->nullable()->after('location');
            $table->boolean('created_by_admin')->default(false)->after('admin_notes');
            
            // Update status enum to include new values
            $table->dropColumn('status');
        });
        
        // Re-add status column with new enum values
        Schema::table('meetings', function (Blueprint $table) {
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])
                  ->default('pending')
                  ->after('created_by_admin');
        });
        
        // Add foreign key constraints
        Schema::table('meetings', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('sellers')->onDelete('set null');
            $table->foreign('manufacturer_id')->references('id')->on('manufacturers')->onDelete('set null');
            
            // Add indexes for better performance
            $table->index(['status']);
            $table->index(['meeting_type']);
            $table->index(['scheduled_at']);
            $table->index(['customer_id']);
            $table->index(['seller_id']);
            $table->index(['manufacturer_id']);
        });
    }

    public function down(): void
    {
        Schema::table('meetings', function (Blueprint $table) {
            // Drop foreign keys first
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['seller_id']);
            $table->dropForeign(['manufacturer_id']);
            
            // Drop indexes
            $table->dropIndex(['status']);
            $table->dropIndex(['meeting_type']);
            $table->dropIndex(['scheduled_at']);
            $table->dropIndex(['customer_id']);
            $table->dropIndex(['seller_id']);
            $table->dropIndex(['manufacturer_id']);
            
            // Drop columns
            $table->dropColumn([
                'customer_id',
                'seller_id',
                'manufacturer_id',
                'description',
                'meeting_type',
                'duration',
                'location',
                'admin_notes',
                'created_by_admin',
                'status'
            ]);
        });
        
        // Re-add original status column
        Schema::table('meetings', function (Blueprint $table) {
            $table->enum('status', ['pending', 'accepted', 'rejected', 'cancelled'])
                  ->default('pending')
                  ->after('scheduled_at');
        });
    }
};