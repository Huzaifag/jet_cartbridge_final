<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            // Add fields for lead splitting
            $table->foreignId('assigned_to_salesman_id')->nullable()->after('salesman_id')->constrained('salesmen')->onDelete('set null');
            $table->foreignId('split_from_salesman_id')->nullable()->after('assigned_to_salesman_id')->constrained('salesmen')->onDelete('set null');
            $table->timestamp('assigned_at')->nullable()->after('split_from_salesman_id');
            $table->text('split_notes')->nullable()->after('assigned_at');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium')->after('split_notes');
            $table->timestamp('followed_up_at')->nullable()->after('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropForeign(['assigned_to_salesman_id']);
            $table->dropForeign(['split_from_salesman_id']);
            $table->dropColumn([
                'assigned_to_salesman_id',
                'split_from_salesman_id',
                'assigned_at',
                'split_notes',
                'priority',
                'followed_up_at'
            ]);
        });
    }
};
