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
                'title'       => $this->faker->sentence,
                'description' => $this->faker->paragraph,
                'year'        => $this->faker->year,
                'duration'    => $this->faker->numberBetween(80, 210),
                'director_id' => Director::factory(),
                'poster'      => null,
                'score'       => $this->faker->randomFloat(1, 0, 10),
            ];
        }
    }
