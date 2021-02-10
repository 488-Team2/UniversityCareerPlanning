<?php

namespace Database\Seeders;

use App\Models\CareerSurveyResponse;
use Illuminate\Database\Seeder;

class CareerSurveyResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CareerSurveyResponse::factory(400)->create();
    }
}
