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
        Schema::create('food_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('name');
            $table->string('serving_size_description');
            $table->integer('serving_size_grams');
            $table->integer('calories_per_serving');
            $table->decimal('protein_grams_per_serving', 5, 1);
            $table->decimal('carb_grams_per_serving', 5, 1);
            $table->decimal('fat_grams_per_serving', 5, 1);
            $table->decimal('estimated_cost', 8, 2);
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_items');
    }
};
