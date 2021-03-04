<?php

namespace Database\Factories;

use App\Models\Degree;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DegreeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Degree::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    public function definition()
    {
        return [
            'degree_name' => $this->faker->name,
            'degree_description' => $this->faker->sentence,
            'department_id' => Department::all()->random(),
            'graduation_rate' => $this->faker->numberBetween(0, 100),
            'job_demand' => $this->faker->numberBetween(0, 100),
            'job_prospects' => $this->faker->jobTitle,
            'keywords' => $this->faker->sentence
        ];
    }
}
