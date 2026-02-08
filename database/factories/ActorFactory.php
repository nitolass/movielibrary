<?php

namespace Database\Factories;

use App\Models\Actor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActorFactory extends Factory
{
    protected $model = Actor::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'biography' => $this->faker->paragraph,
            'birth_year' => $this->faker->year,
            'nationality' => $this->faker->country,
            'photo' => null,
            'score' => $this->faker->randomFloat(1, 0, 10),
        ];
    }
}
