<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Courses>
 */
class CoursesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_course' => $this->faker->jobTitle,
            'schedule' => $this->faker->time('H:i:s'),
            'start_date' => $this->faker->date('Y_m_d'),
            'end_date' => $this->faker->date('Y_m_d'),                          
        ];
    }
}
