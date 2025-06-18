<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class FoodItemAllergiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $foodItemAllergies = [
            [
                'food_item_id' => 2, // Boiled Egg
                'allergy_id' => 4,   // Eggs
            ],
            [
                'food_item_id' => 5, // Tuna in Water (Canned)
                'allergy_id' => 5,   // Fish
            ],
            [
                'food_item_id' => 3, // Brown Rice
                'allergy_id' => 9,   // Gluten (assuming possible gluten content)
            ],
        ];

        foreach ($foodItemAllergies as $relation) {
            DB::table('food_item_allergies')->insert([
                'food_item_id' => $relation['food_item_id'],
                'allergy_id' => $relation['allergy_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
