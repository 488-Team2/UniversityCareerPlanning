<?php

namespace Database\Factories;

use App\Models\CareerSurveyAnswer;
use App\Models\CareerSurveyQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;

class CareerSurveyAnswerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CareerSurveyAnswer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'answer_text' => $this->faker->sentence
        ];
    }
}
