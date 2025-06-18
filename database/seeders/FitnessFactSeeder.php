<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FitnessFact;


class FitnessFactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $facts = [
            [
                'fact_text' => 'Strength training can increase your resting metabolic rate by up to 7%, helping you burn more calories even at rest.',
                'category' => 'Strength Training',
            ],
            [
                'fact_text' => 'Aerobic exercise, like running or cycling, improves cardiovascular health by strengthening the heart and reducing blood pressure.',
                'category' => 'Cardio',
            ],
            [
                'fact_text' => 'Stretching regularly can improve flexibility and reduce the risk of injury by up to 30% during physical activities.',
                'category' => 'Flexibility',
            ],
            [
                'fact_text' => 'High-intensity interval training (HIIT) can burn up to 25-30% more calories than other forms of exercise in the same amount of time.',
                'category' => 'HIIT',
            ],
            [
                'fact_text' => 'Hydration is critical: even 2% dehydration can reduce exercise performance by up to 10%.',
                'category' => 'Nutrition',
            ],
            [
                'fact_text' => 'Getting 7-9 hours of sleep per night enhances muscle recovery and improves athletic performance.',
                'category' => 'Recovery',
            ],
            [
                'fact_text' => 'Compound exercises like squats and deadlifts engage multiple muscle groups, leading to greater strength gains than isolation exercises.',
                'category' => 'Strength Training',
            ],
            [
                'fact_text' => 'Regular exercise can reduce symptoms of anxiety and depression by boosting endorphin levels in the brain.',
                'category' => 'Mental Health',
            ],
            [
                'fact_text' => 'Consuming protein within 30 minutes post-workout can optimize muscle repair and growth.',
                'category' => 'Nutrition',
            ],
            [
                'fact_text' => 'Core strength training improves posture and reduces the risk of lower back pain by up to 40%.',
                'category' => 'Core Training',
            ],
        ];

        foreach ($facts as $fact) {
            FitnessFact::create([
                'fact_text' => $fact['fact_text'],
                'category' => $fact['category'],
            ]);
        }
    }
}
