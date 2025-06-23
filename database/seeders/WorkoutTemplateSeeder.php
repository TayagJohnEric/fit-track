<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExperienceLevel;
use App\Models\WorkoutTemplate;
use App\Models\WorkoutType;

class WorkoutTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
    $weightLifting = WorkoutType::where('name', 'Weight Lifting')->first();
        $homeWorkout = WorkoutType::where('name', 'Home Workout')->first();
        
        $beginner = ExperienceLevel::where('name', 'Beginner')->first();
        $intermediate = ExperienceLevel::where('name', 'Intermediate')->first();
        $advanced = ExperienceLevel::where('name', 'Advanced')->first();

        $templates = [
            // Weight Lifting Templates
            [
                'name' => 'Beginner Full Body Workout',
                'description' => 'A comprehensive full-body workout perfect for beginners',
                'workout_type_id' => $weightLifting->id,
                'experience_level_id' => $beginner->id,
                'duration_minutes' => 45,
                'difficulty_level' => 2,
            ],
            [
                'name' => 'Intermediate Push/Pull Split',
                'description' => 'Push and pull exercises for intermediate lifters',
                'workout_type_id' => $weightLifting->id,
                'experience_level_id' => $intermediate->id,
                'duration_minutes' => 60,
                'difficulty_level' => 3,
            ],
            [
                'name' => 'Advanced Powerlifting Program',
                'description' => 'Intensive powerlifting routine for advanced athletes',
                'workout_type_id' => $weightLifting->id,
                'experience_level_id' => $advanced->id,
                'duration_minutes' => 90,
                'difficulty_level' => 5,
            ],
            
            // Home Workout Templates
            [
                'name' => 'Beginner Bodyweight Basics',
                'description' => 'Simple bodyweight exercises you can do at home',
                'workout_type_id' => $homeWorkout->id,
                'experience_level_id' => $beginner->id,
                'duration_minutes' => 30,
                'difficulty_level' => 1,
            ],
            [
                'name' => 'Intermediate HIIT Circuit',
                'description' => 'High-intensity interval training circuit',
                'workout_type_id' => $homeWorkout->id,
                'experience_level_id' => $intermediate->id,
                'duration_minutes' => 40,
                'difficulty_level' => 3,
            ],
            [
                'name' => 'Advanced Calisthenics',
                'description' => 'Advanced bodyweight movements and progressions',
                'workout_type_id' => $homeWorkout->id,
                'experience_level_id' => $advanced->id,
                'duration_minutes' => 50,
                'difficulty_level' => 4,
            ],
        ];

        foreach ($templates as $template) {
            WorkoutTemplate::create($template);
        }
    }
}
