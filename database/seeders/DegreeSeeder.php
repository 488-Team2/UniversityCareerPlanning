<?php

namespace Database\Seeders;

use App\Models\Degree;
use App\Models\Department;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class DegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = Http::get('https://www.keene.edu/catalog/api/programs/');
        $decoded = json_decode($response->body(), true);
        $degreeCollection = collect($decoded['data']);
        $degreeCollection->each(function ($item) {
            $faker = Faker::create();
            Degree::create([
                'degree_name' => $item['name'],
                'department_id' => Department::firstOrCreate([
                    'department_name' => $item['disciplines'][0]['name'],
                ]),
                'degree_description' => $faker->sentence,
                'degree_type' => $item['classification']['name'],
                'graduation_rate' => $faker->numberBetween(0, 100),
                'job_demand' => $faker->numberBetween(0, 100),
                'job_prospects' => $faker->jobTitle,
                'keywords' => $item['disciplines'][0]['name']
            ]);
        });
    }
}
