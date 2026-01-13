<?php

use App\Models\Director;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{assertDatabaseHas, assertDatabaseMissing};

// Limpia la base de datos después de cada test
uses(RefreshDatabase::class);

it('puedo crear un director en la base de datos', function () {
    // 1. Datos de prueba
    $datos = [
        'name'       => 'Quentin Tarantino',
        'biography'    => 'Director famoso por sus diálogos.',
        'birth_year'   => 1963,
        'nationality' => 'USA',
        'photo'         => 'fotos/tarantino.jpg'
    ];

    // 2. Acción: Usamos el Modelo directamente, sin rutas
    Director::create($datos);

    // 3. Verificación: ¿Está en la tabla 'directors'?
    assertDatabaseHas('directors', [
        'name' => 'Quentin Tarantino',
        'birth_year' => 1963
    ]);
});

it('puedo actualizar un director existente', function () {
    $director = Director::create([
        'name' => 'Nombre Viejo',
        'biography' => 'Bio',
        'birth_year' => 1990,
        'nationality' => 'Test',
        'photo' => 'test.jpg'
    ]);

    $director->update([
        'name' => 'New Name'
    ]);

    assertDatabaseHas('directors', ['name' => 'New Name']);
    expect($director->refresh()->name)->toBe('New Name');
});

it('puedo eliminar un director', function () {
    // 1. Crear
    $director = Director::create([
        'name' => 'A borrar',
        'biography' => '...',
        'birth_year' => 2000,
        'nationality' => '...',
        'photo' => '...'
    ]);

    // 2. Eliminar
    $director->delete();

    // 3. Verificación: No debe estar en la base de datos
    assertDatabaseMissing('directors', [
        'id' => $director->id
    ]);
});
