<?php

namespace Database\Factories;

use App\Models\Degree;
use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Job::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'job_name' => $this->faker->company,
            'job_description' => $this->faker->sentences(3),
            'job_link' => $this->faker->url,
            'degree_id' => Degree::factory()
        ];
    }
}
