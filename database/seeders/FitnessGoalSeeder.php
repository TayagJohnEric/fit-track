<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FitnessGoal;


class FitnessGoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fitnessGoals = [
            ['name' => 'Weight Loss'],
            ['name' => 'Muscle Gain'],
        ];

        foreach ($fitnessGoals as $fitnessGoal) {
            FitnessGoal::create($fitnessGoal);
        }
    }
}
