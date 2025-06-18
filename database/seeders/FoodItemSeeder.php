<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FoodItem;


class FoodItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $foodItems = [
            [
                'creator_user_id' => null,
                'name' => 'Chicken Breast',
                'serving_size_description' => '1 piece (100g)',
                'serving_size_grams' => 100,
                'calories_per_serving' => 165,
                'protein_grams_per_serving' => 31.0,
                'carb_grams_per_serving' => 0.0,
                'fat_grams_per_serving' => 3.6,
                'estimated_cost' => 60.00,
                'image_url' => null,
            ],
            [
                'creator_user_id' => null,
                'name' => 'Boiled Egg',
                'serving_size_description' => '1 large egg (50g)',
                'serving_size_grams' => 50,
                'calories_per_serving' => 78,
                'protein_grams_per_serving' => 6.3,
                'carb_grams_per_serving' => 0.6,
                'fat_grams_per_serving' => 5.3,
                'estimated_cost' => 8.00,
                'image_url' => null,
            ],
            [
                'creator_user_id' => null,
                'name' => 'Brown Rice',
                'serving_size_description' => '1 cup cooked (195g)',
                'serving_size_grams' => 195,
                'calories_per_serving' => 216,
                'protein_grams_per_serving' => 5.0,
                'carb_grams_per_serving' => 44.8,
                'fat_grams_per_serving' => 1.8,
                'estimated_cost' => 20.00,
                'image_url' => null,
            ],
            [
                'creator_user_id' => null,
                'name' => 'Banana',
                'serving_size_description' => '1 medium (118g)',
                'serving_size_grams' => 118,
                'calories_per_serving' => 105,
                'protein_grams_per_serving' => 1.3,
                'carb_grams_per_serving' => 27.0,
                'fat_grams_per_serving' => 0.3,
                'estimated_cost' => 12.00,
                'image_url' => null,
            ],
            [
                'creator_user_id' => null,
                'name' => 'Tuna in Water (Canned)',
                'serving_size_description' => '1 can (165g)',
                'serving_size_grams' => 165,
                'calories_per_serving' => 191,
                'protein_grams_per_serving' => 42.0,
                'carb_grams_per_serving' => 0.0,
                'fat_grams_per_serving' => 1.4,
                'estimated_cost' => 40.00,
                'image_url' => null,
            ],
        ];

        foreach ($foodItems as $item) {
            FoodItem::create($item);
        }
    }
}
