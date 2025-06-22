<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WorkoutType;
use App\Models\ExperienceLevel;
use App\Models\WorkoutTemplate;




class WorkoutTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $experienceLevels = ExperienceLevel::all()->keyBy('name');
        $workoutTypes = WorkoutType::all()->keyBy('name');

        $templates = [
            [
                'name' => 'Full Body Beginner',
                'description' => 'A simple full body workout for those starting out.',
                'experience_level' => 'Beginner',
                'workout_type' => 'Home Workout',
            ],
            [
                'name' => 'Intermediate Push Day',
                'description' => 'Push day focused on chest, shoulders, and triceps.',
                'experience_level' => 'Intermediate',
                'workout_type' => 'Weight Lifting',
            ],
            [
                'name' => 'Advanced Leg Blast',
                'description' => 'Intense leg workout for advanced athletes.',
                'experience_level' => 'Advanced',
                'workout_type' => 'Weight Lifting',
            ],
        ];

        foreach ($templates as $template) {
            WorkoutTemplate::create([
                'name' => $template['name'],
                'description' => $template['description'],
                'experience_level_id' => $experienceLevels[$template['experience_level']]->id,
                'workout_type_id' => $workoutTypes[$template['workout_type']]->id,
            ]);
        }
    }
}
