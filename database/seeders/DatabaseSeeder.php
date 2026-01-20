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
        // Crear Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Crear usuario administrador
        User::create([
            'name' => 'Admin',
            'surname' => 'Principal', // <--- FALTABA ESTO
            'email' => 'admin@moviehub.com', // He puesto este mail para coincidir con lo que te dije antes
            'password' => Hash::make('12345678'),
            'role_id' => $adminRole->id,
        ]);

        //  Crear usuario normal para pruebas
        User::create([
            'name' => 'Juan',
            'surname' => 'Pérez',
            'email' => 'juan@correo.com',
            'password' => Hash::make('12345678'),
            'role_id' => $userRole->id,
        ]);

        // 4. Crear datos base
        $genres = Genre::factory(10)->create();
        $directors = Director::factory(10)->create();
        $actors = Actor::factory(20)->create();

        //  Crear Películas y Relaciones
        Movie::factory(15)->create(function () use ($directors) {
            return ['director_id' => $directors->random()->id];
        })->each(function($movie) use ($genres, $actors) {

            // Relación N:M con Géneros
            // recibe ids y los saca con pluck
            $movie->genres()->attach($genres->random(rand(1, 3))->pluck('id'));

            // Relación N:M con Actores
            $movie->actors()->attach($actors->random(rand(2, 5))->pluck('id'));


        });
    }
}
