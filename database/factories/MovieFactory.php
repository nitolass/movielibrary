<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    protected $model = \App\Models\Movie::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'year' => $this->faker->year,
            'description' => $this->faker->paragraph,
            'duration' => $this->faker->numberBetween(80, 180),
            'age_rating' => $this->faker->numberBetween(0, 18),
            'country' => $this->faker->country,
            'poster' => 'default-poster.jpg',
        ];
    }
}
