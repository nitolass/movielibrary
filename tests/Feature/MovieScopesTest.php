<?php

use App\Models\{Movie, Genre, Director, Review};

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('movie model scopes coverage', function () {
    $genre = Genre::factory()->create(['name' => 'Acción']);
    $director = Director::factory()->create(['nationality' => 'ES']);
    $movie = Movie::factory()->create([
        'title' => 'Origen',
        'year' => 2010,
        'duration' => 140,
        'score' => 9.5,
        'director_id' => $director->id
    ]);
    $movie->genres()->attach($genre);
    Review::factory()->count(3)->create(['movie_id' => $movie->id]);

    // Ejecutamos todos los scopes para cubrir las líneas
    expect(Movie::search('Origen')->count())->toBe(1);
    expect(Movie::byGenres([$genre->id])->count())->toBe(1);
    expect(Movie::acclaimed()->count())->toBe(1);
    expect(Movie::mostReviewed()->count())->toBe(1);
    expect(Movie::byDirectorCountry('ES')->count())->toBe(1);
    expect(Movie::recent()->count())->toBe(1);
    expect(Movie::classics()->count())->toBe(0);
    expect(Movie::durationBetween(100, 200)->count())->toBe(1);

    // Probar el "return $query" de los ifs iniciales
    expect(Movie::search(null)->count())->toBe(1);
    expect(Movie::byGenres([])->count())->toBe(1);
});
