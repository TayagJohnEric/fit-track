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
        Schema::create('workout_templates', function (Blueprint $table) {
            $table->id();
             $table->string('name');
            $table->text('description');
            $table->foreignId('experience_level_id')->constrained()->onDelete('restrict');
            $table->foreignId('workout_type_id')->constrained()->onDelete('restrict');
            $table->integer('duration_minutes')->default(30);
            $table->integer('difficulty_level')->default(1); // 1-5
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_templates');
    }
};
