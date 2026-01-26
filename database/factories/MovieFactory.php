<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Director; // Importante

class MovieFactory extends Factory
{
    protected $model = \App\Models\Movie::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'director_id' => Director::factory(),
            'year' => $this->faker->year,
            'description' => $this->faker->paragraph,
            'duration' => $this->faker->numberBetween(80, 180),
            'poster' => null,
        ];
    }
}
