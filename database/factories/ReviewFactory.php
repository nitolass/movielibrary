<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
                'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'movie_id' => Movie::inRandomOrder()->first()->id ?? Movie::factory(),

            'rating' => $this->faker->numberBetween(1, 5),
            'content' => $this->faker->paragraph(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
