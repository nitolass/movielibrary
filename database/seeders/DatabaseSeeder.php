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

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear roles
        $admin_role = Role::create(['name' => 'admin']);
        $user_role = Role::create(['name' => 'user']);

        // Crear usuario administrador
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role_id' => $admin_role->id,
        ]);

        // generos
        $genres = Genre::factory(5)->create();

        // directores
        $directors = Director::factory(5)->create();

        // actores
        $actors = Actor::factory(10)->create();

        // peliculas n:m
        $movies = Movie::factory(10)->create()->each(function($movie) use ($genres, $directors, $actors) {
            // relacion generos randoms
            $movie->genres()->attach($genres->random(rand(1,3))->pluck('id')->toArray());

            // relacion directores randoms
            $movie->directors()->attach($directors->random(rand(1,2))->pluck('id')->toArray());

            // relacion actores randoms
            $movie->actors()->attach($actors->random(rand(2,5))->pluck('id')->toArray());
        });
    }
}
