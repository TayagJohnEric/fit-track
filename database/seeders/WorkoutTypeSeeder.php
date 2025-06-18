<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WorkoutType;


class WorkoutTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workoutTypes = [
            ['name' => 'Weight Lifting'],
            ['name' => 'Home Workout'],
        ];

        foreach ($workoutTypes as $workoutType) {
            WorkoutType::create($workoutType);
        }
    }
}
