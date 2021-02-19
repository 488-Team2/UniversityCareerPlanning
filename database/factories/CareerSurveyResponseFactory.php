<?php

namespace Database\Factories;

use App\Models\CareerSurveyQuestion;
use App\Models\CareerSurveyResponse;
use App\Models\Session;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CareerSurveyResponseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CareerSurveyResponse::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->random(),
            'session_id' => Session::factory(),
            'response_code' => $this->faker->numberBetween(1, 4)
        ];
    }
}
