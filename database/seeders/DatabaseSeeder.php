<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
                UserSeeder::class,
                CareerSurveyQuestionSeeder::class,
                DepartmentSeeder::class,
                DegreeSeeder::class,
                SessionSeeder::class
            ]
        );
    }
}
