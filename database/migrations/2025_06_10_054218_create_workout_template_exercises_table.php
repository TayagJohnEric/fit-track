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
        Schema::create('workout_template_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained('workout_templates')->onDelete('cascade');
            $table->foreignId('exercise_id')->constrained()->onDelete('cascade');
            $table->integer('sets');
            $table->string('reps');
            $table->integer('duration_seconds')->nullable();
            $table->integer('rest_seconds');
            $table->integer('order_in_workout');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_template_exercises');
    }
};
