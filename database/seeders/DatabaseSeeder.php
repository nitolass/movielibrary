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

    public function run(): void
    {
        // 1. CREAR ROLES (Usamos firstOrCreate para evitar duplicados)
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole  = Role::firstOrCreate(['name' => 'user']);
        $modRole   = Role::firstOrCreate(['name' => 'moderador']);
        $editRole  = Role::firstOrCreate(['name' => 'editor']);
        $guestRole = Role::firstOrCreate(['name' => 'guest']);

        // 2. CREAR USUARIOS CON SUS ROLES CORRECTOS

        // --- ADMIN (juan@admin.es) ---
        User::firstOrCreate(
            ['email' => 'juan@admin.es'],
            [
                'name' => 'Juan Admin',
                'surname' => 'Admin Surname',
                'password' => Hash::make('12345678'),
                'role_id' => $adminRole->id, // <--- ROL ADMIN
            ]
        );

        // --- EDITOR (juan@editor.es) ---
        // ESTE ES EL QUE NECESITABAS
        User::firstOrCreate(
            ['email' => 'juan@editor.es'],
            [
                'name' => 'Juan Editor',
                'surname' => 'Editor Surname',
                'password' => Hash::make('12345678'),
                'role_id' => $editRole->id, // <--- ROL EDITOR
            ]
        );

        // --- MODERADOR (juan@moderador.es) ---
        User::firstOrCreate(
            ['email' => 'juan@moderador.es'],
            [
                'name' => 'Juan Moderador',
                'surname' => 'Mod Surname',
                'password' => Hash::make('12345678'),
                'role_id' => $modRole->id, // <--- ROL MODERADOR
            ]
        );

        // --- USUARIO NORMAL (juan@correo.com) ---
        User::firstOrCreate(
            ['email' => 'juan@correo.com'],
            [
                'name' => 'Juan User',
                'surname' => 'Pérez',
                'password' => Hash::make('12345678'),
                'role_id' => $userRole->id, // <--- ROL USER
            ]
        );

        // 3. GÉNEROS
        $genreNames = [
            'Acción', 'Aventura', 'Comedia', 'Drama', 'Fantasía',
            'Terror', 'Ciencia Ficción', 'Musical', 'Misterio', 'Romance'
        ];

        $genres = collect();
        foreach ($genreNames as $name) {
            $genres->push(Genre::firstOrCreate(
                ['name' => $name],
                ['description' => 'Películas del género ' . $name]
            ));
        }

        // 4. FACTORIES (Datos falsos masivos)
        $directors = Director::factory(10)->create();
        $actors = Actor::factory(30)->create();

        Movie::factory(30)->create(function () use ($directors) {
            return ['director_id' => $directors->random()->id];
        })->each(function($movie) use ($genres, $actors) {

            // Géneros aleatorios
            $movie->genres()->attach($genres->random(rand(1, 3))->pluck('id'));

            // Actores aleatorios
            $randomActors = $actors->random(rand(2, 5));
            foreach ($randomActors as $actor) {
                $movie->actors()->attach($actor->id, [
                    'character_name' => fake()->name()
                ]);
            }
        });
    }
}
