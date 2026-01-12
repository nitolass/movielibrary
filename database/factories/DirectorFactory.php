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
            'bio' => $this->faker->paragraph(),
            'birth_year' => $this->faker->year(),
            'nationality' => $this->faker->country(),
            'photo' => 'directors/' . $this->faker->image('public/storage/directors',400,300,null,false),
        ];
    }
}
