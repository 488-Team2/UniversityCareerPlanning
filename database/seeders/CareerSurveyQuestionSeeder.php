<?php

namespace Database\Seeders;

use App\Models\CareerSurveyQuestion;
use Illuminate\Database\Seeder;

class CareerSurveyQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CareerSurveyQuestion::factory(20)->create();
    }
}
