<?php

use App\Models\Movie;
use App\Models\Genre;
use App\Models\Director;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{assertDatabaseHas, assertDatabaseMissing};

uses(RefreshDatabase::class);

it('puedo crear una película en la base de datos', function () {

    Movie::factory()->create([
        'title' => 'Inception',
        'year'  => '2010',
    ]);

    // 3.
    assertDatabaseHas('movies', [
        'title' => 'Inception',
        'year'  => '2010'
    ]);
});

it('puedo actualizar una película existente', function () {
    $movie = Movie::factory()->create([
        'title' => 'Titulo Viejo',
        'year'  => '2000',
    ]);

    $movie->update([
        'title' => 'Titulo Nuevo',
        'year'  => '2025'
    ]);

    assertDatabaseHas('movies', ['title' => 'Titulo Nuevo', 'year' => '2025']);

    expect($movie->refresh()->title)->toBe('Titulo Nuevo');
});

it('puedo eliminar una película', function () {
    $movie = Movie::factory()->create();

    $movie->delete();

    assertDatabaseMissing('movies', [
        'id' => $movie->id
    ]);
});

it('puedo asignar géneros a una película (Relación Muchos a Muchos)', function () {
    $movie = Movie::factory()->create(['title' => 'Matrix']);


    $genre = Genre::factory()->create(['name' => 'Ciencia Ficción']);

    $movie->genres()->attach($genre->id);

    assertDatabaseHas('genre_movie', [
        'movie_id' => $movie->id,
        'genre_id' => $genre->id
    ]);


    expect($movie->refresh()->genres)->toHaveCount(1);
    expect($movie->genres->first()->name)->toBe('Ciencia Ficción');
});
