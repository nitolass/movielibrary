<?php

use App\Models\Genre;
use App\Models\Movie;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('catalog filter request validation works', function () {
    // 1. Probar éxito con filtros válidos
    $genre = Genre::factory()->create();

    $this->get(route('user.movies.index', [
        'search' => 'Inception',
        'genres' => [$genre->id],
        'min_time' => 90,
        'max_time' => 180,
        'filter' => 'popular',
        'sort' => 'recent'
    ]))->assertStatus(200);

    // 2. Probar fallo (validación de max_time menor que min_time)
    $this->get(route('user.movies.index', [
        'min_time' => 200,
        'max_time' => 100
    ]))->assertSessionHasErrors(['max_time']);

    // 3. Probar filtro inexistente
    $this->get(route('user.movies.index', 'filter=malo  ', [
        'filter' => 'malo'
    ]))->assertSessionHasErrors(['filter']);
});
