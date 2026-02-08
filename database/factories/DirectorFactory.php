<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DirectorFactory extends Factory
{
    protected $model = \App\Models\Director::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'biography' => $this->faker->paragraph(),
            'birth_date' => $this->faker->year(),
            'nationality' => $this->faker->country(),
            'photo' => null,
            'score' => $this->faker->randomFloat(1, 0, 10),
        ];
    }
}
