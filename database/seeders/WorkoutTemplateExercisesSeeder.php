<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkoutTemplate;
use App\Models\Exercise;
use App\Models\WorkoutTemplateExercise;

class WorkoutTemplateExercisesSeeder extends Seeder
{
    public function run(): void
    {
        // Get all workout templates and exercises from the database
        $templates = WorkoutTemplate::all();
        $exercises = Exercise::all()->keyBy('name'); // Store exercises using their name as the key for easy lookup

        // Define the exercises to assign to each workout template
        $templateExercises = [
            'Beginner Full Body Workout' => [
                ['exercise' => 'Bench Press', 'sets' => 3, 'reps' => '10-12', 'rest_seconds' => 60, 'order_in_workout' => 1],
                ['exercise' => 'Squat', 'sets' => 3, 'reps' => '10-12', 'rest_seconds' => 60, 'order_in_workout' => 2],
                ['exercise' => 'Deadlift', 'sets' => 3, 'reps' => '8-10', 'rest_seconds' => 90, 'order_in_workout' => 3],
            ],
            'Intermediate Push/Pull Split' => [
                ['exercise' => 'Bench Press', 'sets' => 4, 'reps' => '8-10', 'rest_seconds' => 90, 'order_in_workout' => 1],
                ['exercise' => 'Deadlift', 'sets' => 4, 'reps' => '6-8', 'rest_seconds' => 120, 'order_in_workout' => 2],
            ],
            'Advanced Powerlifting Program' => [
                ['exercise' => 'Squat', 'sets' => 5, 'reps' => '4-6', 'rest_seconds' => 180, 'order_in_workout' => 1],
                ['exercise' => 'Bench Press', 'sets' => 5, 'reps' => '4-6', 'rest_seconds' => 180, 'order_in_workout' => 2],
                ['exercise' => 'Deadlift', 'sets' => 5, 'reps' => '3-5', 'rest_seconds' => 180, 'order_in_workout' => 3],
            ],
            'Beginner Bodyweight Basics' => [
                ['exercise' => 'Push-Ups', 'sets' => 3, 'reps' => '10-15', 'rest_seconds' => 60, 'order_in_workout' => 1],
                ['exercise' => 'Bodyweight Squats', 'sets' => 3, 'reps' => '12-15', 'rest_seconds' => 60, 'order_in_workout' => 2],
                ['exercise' => 'Plank', 'sets' => 3, 'reps' => '30s', 'duration_seconds' => 30, 'rest_seconds' => 30, 'order_in_workout' => 3],
            ],
            'Intermediate HIIT Circuit' => [
                ['exercise' => 'Push-Ups', 'sets' => 4, 'reps' => '15-20', 'rest_seconds' => 30, 'order_in_workout' => 1],
                ['exercise' => 'Bodyweight Squats', 'sets' => 4, 'reps' => '20', 'rest_seconds' => 30, 'order_in_workout' => 2],
                ['exercise' => 'Plank', 'sets' => 4, 'reps' => '45s', 'duration_seconds' => 45, 'rest_seconds' => 30, 'order_in_workout' => 3],
            ],
            'Advanced Calisthenics' => [
                ['exercise' => 'Push-Ups', 'sets' => 5, 'reps' => '20-25', 'rest_seconds' => 45, 'order_in_workout' => 1],
                ['exercise' => 'Bodyweight Squats', 'sets' => 5, 'reps' => '25-30', 'rest_seconds' => 45, 'order_in_workout' => 2],
                ['exercise' => 'Plank', 'sets' => 5, 'reps' => '60s', 'duration_seconds' => 60, 'rest_seconds' => 45, 'order_in_workout' => 3],
            ],
        ];

        // Loop through each workout template
        foreach ($templateExercises as $templateName => $exerciseList) {
            // Find the corresponding template by name
            $template = $templates->firstWhere('name', $templateName);

            if (!$template) {
                // If the template name is not found, skip to the next
                echo "⚠️ Workout template not found: {$templateName}\n";
                continue;
            }

            // Loop through the exercises assigned to this template
            foreach ($exerciseList as $exerciseData) {
                // Try to find the exercise by name
                $exercise = $exercises[$exerciseData['exercise']] ?? null;

                if (!$exercise) {
                    // Skip this if the exercise name doesn't match any in the database
                    echo "⚠️ Exercise not found: {$exerciseData['exercise']}\n";
                    continue;
                }

                // Create the workout_template_exercise record
                WorkoutTemplateExercise::create([
                    'template_id' => $template->id,
                    'exercise_id' => $exercise->id,
                    'sets' => $exerciseData['sets'],
                    'reps' => $exerciseData['reps'],
                    'duration_seconds' => $exerciseData['duration_seconds'] ?? null, // Optional
                    'rest_seconds' => $exerciseData['rest_seconds'],
                    'order_in_workout' => $exerciseData['order_in_workout'],
                ]);
            }
        }
    }
}
