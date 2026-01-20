<?php

use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{assertDatabaseHas, assertDatabaseMissing};

uses(RefreshDatabase::class);

it('puedo crear un género', function () {
    // 1. Datos
    $datos = [
        'name' => 'Ciencia Ficción',
        'description' => 'Películas sobre el futuro y tecnología.'
    ];

    // 2. Acción
    Genre::create($datos);

    // 3. Verificación
    assertDatabaseHas('genres', [
        'name' => 'Ciencia Ficción'
    ]);
});

it('puedo actualizar un género', function () {
    $genre = Genre::create([
        'name' => 'Terror',
        'description' => 'Miedo'
    ]);

    $genre->update([
        'name' => 'Horror',
        'description' => 'Miedo intenso'
    ]);

    assertDatabaseHas('genres', ['name' => 'Horror']);
    expect($genre->refresh()->description)->toBe('Miedo intenso');
});

it('puedo eliminar un género', function () {
    $genre = Genre::create(['name' => 'Comedia']);

    $genre->delete();

    assertDatabaseMissing('genres', ['id' => $genre->id]);
});

// TEST EXTRA: Validación de unicidad (si tu migración lo pide)
// Si no tienes 'unique' en la migración, este test no es necesario, pero es buena práctica.
it('puedo crear géneros con nombres distintos', function () {
    Genre::create(['name' => 'Acción']);
    Genre::create(['name' => 'Drama']);

    expect(Genre::count())->toBe(2);
});
