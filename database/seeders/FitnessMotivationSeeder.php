<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FitnessMotivation;

class FitnessMotivationSeeder extends Seeder
{
    public function run()
    {
 FitnessMotivation::create([
            'quote' => 'The groundwork for all happiness is good health.',
            'author' => 'Leigh Hunt',
        ]);

        FitnessMotivation::create([
            'quote' => 'Take care of your body. It\'s the only place you have to live.',
            'author' => 'Jim Rohn',
        ]);

        FitnessMotivation::create([
            'quote' => 'Strength does not come from physical capacity. It comes from an indomitable will.',
            'author' => 'Mahatma Gandhi',
        ]);

        FitnessMotivation::create([
            'quote' => 'The only bad workout is the one that didn’t happen.',
            'author' => null,
        ]);

        FitnessMotivation::create([
            'quote' => 'Your body can stand almost anything. It’s your mind that you have to convince.',
            'author' => null,
        ]);

        FitnessMotivation::create([
            'quote' => 'Fitness is not about being better than someone else. It’s about being better than you used to be.',
            'author' => null,
        ]);

        FitnessMotivation::create([
            'quote' => 'You don’t have to be extreme, just consistent.',
            'author' => null,
        ]);

        FitnessMotivation::create([
            'quote' => 'The pain you feel today will be the strength you feel tomorrow.',
            'author' => null,
        ]);

        FitnessMotivation::create([
            'quote' => 'No pain, no gain.',
            'author' => 'Jane Fonda',
        ]);

        FitnessMotivation::create([
            'quote' => 'The only bad workout is the one that didn’t happen.',
            'author' => null,
        ]);

        FitnessMotivation::create([
            'quote' => 'Push yourself, because no one else is going to do it for you.',
            'author' => null,
        ]);

        FitnessMotivation::create([
            'quote' => 'Strength does not come from the physical capacity. It comes from an indomitable will.',
            'author' => 'Mahatma Gandhi',
        ]);

        FitnessMotivation::create([
            'quote' => 'Take care of your body. It’s the only place you have to live.',
            'author' => 'Jim Rohn',
        ]);

        FitnessMotivation::create([
            'quote' => 'We are what we repeatedly do. Excellence, then, is not an act, but a habit.',
            'author' => 'Will Durant',
        ]);

        FitnessMotivation::create([
            'quote' => 'You miss 100% of the shots you don’t take.',
            'author' => 'Wayne Gretzky',
        ]);

        FitnessMotivation::create([
            'quote' => 'Discipline is the bridge between goals and accomplishment.',
            'author' => 'Jim Rohn',
        ]);

        FitnessMotivation::create([
            'quote' => 'Whether you think you can, or you think you can’t – you’re right.',
            'author' => 'Henry Ford',
        ]);

        FitnessMotivation::create([
            'quote' => 'Your body can stand almost anything. It’s your mind that you have to convince.',
            'author' => null,
        ]);
    }
}