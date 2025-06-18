<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Allergy;


class AllergySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allergies = [
            ['name' => 'Peanuts'],
            ['name' => 'Tree Nuts'],
            ['name' => 'Milk'],
            ['name' => 'Eggs'],
            ['name' => 'Fish'],
            ['name' => 'Shellfish'],
            ['name' => 'Soy'],
            ['name' => 'Wheat'],
            ['name' => 'Gluten'],
            ['name' => 'Sesame'],
            ['name' => 'Sulfites'],
        ];

        foreach ($allergies as $allergy) {
            Allergy::create($allergy);
        }
    }
}
