<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exercise;

class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exercises = [
            [
                'name' => 'Bench Press',
                'description' => 'Lie on a flat bench, grip the barbell shoulder-width apart, lower it to your chest, and press it back up.',
                'muscle_group' => 'Chest',
                'equipment_needed' => 'Barbell, Bench',
                'video_url' => 'https://example.com/bench-press-video',
            ],
            [
                'name' => 'Squat',
                'description' => 'Stand with feet shoulder-width apart, barbell on upper back, lower hips until thighs are parallel to the ground, then push back up.',
                'muscle_group' => 'Quads',
                'equipment_needed' => 'Barbell, Rack',
                'video_url' => 'https://example.com/squat-video',
            ],
            [
                'name' => 'Deadlift',
                'description' => 'Stand with feet hip-width apart, grip barbell, keep back straight, lift by extending hips and knees, lower back down.',
                'muscle_group' => 'Back',
                'equipment_needed' => 'Barbell, Plates',
                'video_url' => 'https://example.com/deadlift-video',
            ],
            [
                'name' => 'Push-Ups',
                'description' => 'Start in a plank position, hands shoulder-width apart, lower chest to just above the ground, then push back up.',
                'muscle_group' => 'Chest',
                'equipment_needed' => 'None',
                'video_url' => 'https://example.com/push-ups-video',
            ],
            [
                'name' => 'Bodyweight Squats',
                'description' => 'Stand with feet shoulder-width apart, lower hips as if sitting back into a chair, keep chest up, then stand back up.',
                'muscle_group' => 'Quads',
                'equipment_needed' => 'None',
                'video_url' => 'https://example.com/bodyweight-squats-video',
            ],
            [
                'name' => 'Plank',
                'description' => 'Hold a forearm plank position with elbows under shoulders, body in a straight line, engage core, and hold for time.',
                'muscle_group' => 'Core',
                'equipment_needed' => 'None',
                'video_url' => 'https://example.com/plank-video',
            ],
        ];

        foreach ($exercises as $exercise) {
            Exercise::create($exercise);
        }
    }
}