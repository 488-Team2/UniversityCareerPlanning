<?php

namespace Database\Seeders;

use App\Models\CareerSurveyAnswer;
use App\Models\CareerSurveyQuestion;
use App\Models\CareerSurveyResponse;
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
        CareerSurveyQuestion::factory(48)->create()->each(function ($question) {
            //Make responses for each question
            $responses = CareerSurveyResponse::factory(20)->make();
            $question->careerSurveyResponses()->saveMany($responses);
        });
    }
}
