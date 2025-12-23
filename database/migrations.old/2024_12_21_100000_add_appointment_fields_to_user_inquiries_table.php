<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_inquiries', function (Blueprint $table) {
            // Add status column for inquiry management
            $table->enum('status', ['pending', 'in_progress', 'resolved', 'closed', 'converted_to_lead'])
                  ->default('pending')
                  ->after('message');
            
            // Add priority column for inquiry prioritization
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])
                  ->default('medium')
                  ->after('status');
            
            // Add inquiry type for categorization
            $table->string('inquiry_type')->nullable()->after('priority');
            
            // Add admin notes for internal tracking
            $table->text('admin_notes')->nullable()->after('inquiry_type');
            
            // Add follow-up date for scheduling
            $table->timestamp('follow_up_date')->nullable()->after('admin_notes');
            
            // Add assigned user for inquiry management
            $table->unsignedBigInteger('assigned_to')->nullable()->after('follow_up_date');
            
            // Add response tracking
            $table->timestamp('responded_at')->nullable()->after('assigned_to');
            $table->text('response')->nullable()->after('responded_at');
            
            // Add indexes for better performance
            $table->index(['status']);
            $table->index(['priority']);
            $table->index(['inquiry_type']);
            $table->index(['assigned_to']);
            $table->index(['follow_up_date']);
        });
    }

    public function down(): void
    {
        Schema::table('user_inquiries', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['priority']);
            $table->dropIndex(['inquiry_type']);
            $table->dropIndex(['assigned_to']);
            $table->dropIndex(['follow_up_date']);
            
            $table->dropColumn([
                'status',
                'priority',
                'inquiry_type',
                'admin_notes',
                'follow_up_date',
                'assigned_to',
                'responded_at',
                'response'
            ]);
        });
    }
};