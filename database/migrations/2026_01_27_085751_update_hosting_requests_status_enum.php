<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: First, expand the enum to include BOTH 'accepted' and 'approved'
        DB::statement("ALTER TABLE hosting_requests MODIFY COLUMN status ENUM('pending', 'accepted', 'approved', 'denied') DEFAULT 'pending'");

        // Step 2: Now update 'accepted' records to 'approved'
        DB::table('hosting_requests')
            ->where('status', 'accepted')
            ->update(['status' => 'approved']);

        // Step 3: Remove 'accepted' from the enum, keeping only 'approved'
        DB::statement("ALTER TABLE hosting_requests MODIFY COLUMN status ENUM('pending', 'approved', 'denied') DEFAULT 'pending'");

        // Step 4: Add new columns
        Schema::table('hosting_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('hosting_requests', 'reviewed_at')) {
                $table->timestamp('reviewed_at')->nullable()->after('reason');
            }
            if (!Schema::hasColumn('hosting_requests', 'reviewed_by')) {
                $table->foreignId('reviewed_by')->nullable()->after('reviewed_at')->constrained('users')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove new columns
        Schema::table('hosting_requests', function (Blueprint $table) {
            if (Schema::hasColumn('hosting_requests', 'reviewed_by')) {
                $table->dropForeign(['reviewed_by']);
                $table->dropColumn('reviewed_by');
            }
            if (Schema::hasColumn('hosting_requests', 'reviewed_at')) {
                $table->dropColumn('reviewed_at');
            }
        });

        // Restore original enum with 'accepted'
        DB::statement("ALTER TABLE hosting_requests MODIFY COLUMN status ENUM('pending', 'accepted', 'approved', 'denied') DEFAULT 'pending'");

        DB::table('hosting_requests')
            ->where('status', 'approved')
            ->update(['status' => 'accepted']);

        DB::statement("ALTER TABLE hosting_requests MODIFY COLUMN status ENUM('pending', 'accepted', 'denied') DEFAULT 'pending'");
    }
};
