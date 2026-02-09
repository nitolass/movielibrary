<?php

use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('movies reset command works', function () {
    // Creamos datos
    Movie::factory()->create();
    User::factory()->create();

    // Ejecutamos el comando con la pregunta exacta
    $this->artisan('movies:reset')
        ->expectsConfirmation('¿Seguro que quieres borrar TODA la base de datos y empezar de cero?', 'yes')
        ->assertExitCode(0);

    // Verificamos que se vació
    $this->assertDatabaseCount('movies', 0);
});

test('movies seed demo command works', function () {
    // Nota: El signature en tu archivo es movies:seed-demo
    $this->artisan('movies:seed-demo')
        ->assertSuccessful()
        ->assertExitCode(0);
});

test('movies show command works', function () {
    $movie = Movie::factory()->create(['title' => 'Inception']);

    $this->artisan('movies:show', ['id' => $movie->id])
        ->expectsOutputToContain('Ficha Técnica: Inception')
        ->assertSuccessful();
});

test('movies show command fails if movie not found', function () {
    $this->artisan('movies:show', ['id' => 999])
        ->expectsOutputToContain('No se encontró ninguna película con ID: 999')
        ->assertOk(); // El comando termina bien aunque no encuentre la peli
});
