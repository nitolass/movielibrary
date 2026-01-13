<?php

use App\Models\Movie;
use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{assertDatabaseHas, assertDatabaseMissing};

uses(RefreshDatabase::class);

it('puedo crear una película en la base de datos', function () {
    // 1. Datos de prueba
    $datos = [
        'title'       => 'Inception',
        'description' => 'Un ladrón que roba secretos corporativos...',
        'year'        => 2010,
        // Asumo que 'poster' o 'image' es el campo para la foto según tus migraciones anteriores
        'poster'      => 'posters/inception.jpg'
    ];

    // 2. Acción: Crear directamente con el Modelo
    Movie::create($datos);

    // 3. Verificación
    assertDatabaseHas('movies', [
        'title' => 'Inception',
        'year'  => 2010
    ]);
});

it('puedo actualizar una película existente', function () {
    // Crear datos iniciales
    $movie = Movie::create([
        'title'       => 'Titulo Viejo',
        'description' => 'Descripción temporal',
        'year'        => 2000,
        'poster'      => 'temp.jpg'
    ]);

    // Actualizar
    $movie->update([
        'title' => 'Titulo Nuevo',
        'year'  => 2025
    ]);

    // Verificación
    assertDatabaseHas('movies', ['title' => 'Titulo Nuevo', 'year' => 2025]);

    // Verificamos también el objeto en memoria refrescado
    expect($movie->refresh()->title)->toBe('Titulo Nuevo');
});

it('puedo eliminar una película', function () {
    // 1. Crear
    $movie = Movie::create([
        'title'       => 'Película a borrar',
        'description' => '...',
        'year'        => 1999,
        'poster'      => '...'
    ]);

    // 2. Eliminar
    $movie->delete();

    // 3. Verificación: No debe estar en la base de datos
    assertDatabaseMissing('movies', [
        'id' => $movie->id
    ]);
});

it('puedo asignar géneros a una película (Relación Muchos a Muchos)', function () {
    // Este test es importante por tu tabla 'genre_movie'

    // 1. Crear Película y Género
    $movie = Movie::create(['title' => 'Matrix', 'year' => 1999, 'description' => '...', 'poster' => '...']);
    $genre = Genre::create(['name' => 'Ciencia Ficción', 'slug' => 'sci-fi']); // Ajusta los campos según tu tabla genres

    // 2. Acción: Vincular (attach)
    $movie->genres()->attach($genre->id);

    // 3. Verificación: Comprobar la tabla pivote
    assertDatabaseHas('genre_movie', [
        'movie_id' => $movie->id,
        'genre_id' => $genre->id
    ]);

    // Verificación: Comprobar la relación de Eloquent
    expect($movie->genres)->toHaveCount(1);
    expect($movie->genres->first()->name)->toBe('Ciencia Ficción');
});
