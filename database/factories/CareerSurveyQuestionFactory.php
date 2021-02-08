<?php

namespace Database\Factories;

use App\Models\CareerSurveyQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

class CareerSurveyQuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CareerSurveyQuestion::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'question_text' => $this->faker->sentence . "?"
        ];
    }
}
