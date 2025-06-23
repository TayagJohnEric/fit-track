<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserNutritionGoalsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_nutrition_goals', function (Blueprint $table) {
            $table->id(); // id: bigIncrements
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // FK to users.id
            $table->integer('target_calories');
            $table->integer('target_protein_grams');
            $table->integer('target_carb_grams');
            $table->integer('target_fat_grams');
            $table->timestamp('last_updated')->nullable(); // optional timestamp
            $table->timestamps(); // includes created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_nutrition_goals');
    }
}
