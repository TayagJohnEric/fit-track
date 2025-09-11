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
        Schema::create('user_workout_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('template_id')->constrained('workout_templates')->onDelete('cascade');
            $table->date('assigned_date');

            // Expanded status values (from second migration)
            $table->enum('status', [
                'Scheduled',
                'Completed',
                'Skipped',
                'Auto-Skipped',
                'Pending',
                'In Progress'
            ])->default('Scheduled');

            $table->timestamp('completion_date')->nullable();
            $table->timestamp('skipped_date')->nullable(); // merged in
            $table->text('user_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_workout_schedules');
    }
};
