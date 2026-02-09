<?php

use App\Models\Movie;
use App\Models\Genre;
use App\Models\Director;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('public catalog filters and request validation work', function () {
    // 1. Setup de datos
    $genre = Genre::factory()->create(['name' => 'Acción']);
    $director = Director::factory()->create(['nationality' => 'ES']);
    $movie = Movie::factory()->create([
        'title' => 'Inception',
        'score' => 9.5,
        'duration' => 140,
        'director_id' => $director->id
    ]);
    $movie->genres()->attach($genre);

    // 2. Test de ruta exitosa con todos los filtros (Cubre CatalogFilterRequest y Scopes)
    $this->get(route('user.movies.index', [
        'search' => 'Inception',
        'genres' => [$genre->id],
        'filter' => 'top_rated',
        'min_time' => 100,
        'max_time' => 200,
        'country' => 'ES',
        'sort' => 'recent'
    ]))->assertStatus(200);

    // 3. Test de validación fallida (Cubre las reglas del FormRequest)
    // Intentamos que max_time sea menor que min_time
    $this->get(route('user.movies.index', [
        'min_time' => 200,
        'max_time' => 100
    ]))->assertSessionHasErrors(['max_time']);

    // 4. Test de ruta Show y Prompt (Cubre el resto del controlador)
    $this->get(route('user.movies.show', $movie))->assertStatus(200);
    $this->get(route('public.prompt'))->assertStatus(200);
});
