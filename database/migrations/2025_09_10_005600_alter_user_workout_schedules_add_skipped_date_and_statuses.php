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
        // Add skipped_date column if it does not exist
        Schema::table('user_workout_schedules', function (Blueprint $table) {
            if (!Schema::hasColumn('user_workout_schedules', 'skipped_date')) {
                $table->timestamp('skipped_date')->nullable()->after('completion_date');
            }
        });

        // Expand enum values for status to include additional states used by the app
        // Note: This uses MySQL/MariaDB enum modification via raw SQL
        DB::statement("ALTER TABLE user_workout_schedules MODIFY COLUMN status ENUM('Scheduled','Completed','Skipped','Auto-Skipped','Pending','In Progress') NOT NULL DEFAULT 'Scheduled'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert enum back to original set
        DB::statement("ALTER TABLE user_workout_schedules MODIFY COLUMN status ENUM('Scheduled','Completed','Skipped') NOT NULL DEFAULT 'Scheduled'");

        // Drop skipped_date column if present
        Schema::table('user_workout_schedules', function (Blueprint $table) {
            if (Schema::hasColumn('user_workout_schedules', 'skipped_date')) {
                $table->dropColumn('skipped_date');
            }
        });
    }
};
