<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Genre;
use App\Models\Director;
use App\Models\Actor;
use App\Models\Movie;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);
        $manteinanceRole = Role::firstOrCreate(['name' => 'manteinance']);

        User::create([
            'name' => 'Admin',
            'surname' => 'Principal',
            'email' => 'admin@moviehub.com',
            'password' => Hash::make('12345678'),
            'role_id' => $adminRole->id,
        ]);

        User::create([
            'name' => 'Juan',
            'surname' => 'Pérez',
            'email' => 'juan@correo.com',
            'password' => Hash::make('12345678'),
            'role_id' => $userRole->id,
        ]);


        $genreNames = [
            'Acción', 'Aventura', 'Comedia', 'Drama', 'Fantasía',
            'Terror', 'Ciencia Ficción', 'Musical', 'Misterio', 'Romance'
        ];

        $genres = collect();
        foreach ($genreNames as $name) {
            $genres->push(Genre::create([
                'name' => $name,
                'description' => 'Películas del género ' . $name
            ]));
        }

        $directors = Director::factory(10)->create();
        $actors = Actor::factory(30)->create();

        Movie::factory(30)->create(function () use ($directors) {
            return ['director_id' => $directors->random()->id];
        })->each(function($movie) use ($genres, $actors) {

            $movie->genres()->attach($genres->random(rand(1, 3))->pluck('id'));


            $randomActors = $actors->random(rand(2, 5));

            foreach ($randomActors as $actor) {
                $movie->actors()->attach($actor->id, [
                    'character_name' => fake()->name()
                ]);
            }
        });
    }
}
