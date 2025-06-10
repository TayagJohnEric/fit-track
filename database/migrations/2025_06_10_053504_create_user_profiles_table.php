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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
             $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->enum('sex', ['Male', 'Female', 'Other']);
            $table->decimal('height_cm', 5, 1);
            $table->decimal('current_weight_kg', 5, 1);
            $table->decimal('daily_budget', 8, 2)->nullable();
            $table->foreignId('fitness_goal_id')->constrained()->onDelete('restrict');
            $table->foreignId('experience_level_id')->constrained()->onDelete('restrict');
            $table->foreignId('preferred_workout_type_id')->constrained('workout_types')->onDelete('restrict');
            $table->timestamp('last_profile_update')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
