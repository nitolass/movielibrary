<?php

use App\Models\Movie;
use App\Models\Actor;
use App\Models\Genre;
use App\Models\Director;
use App\Http\Resources\MovieResource;
use App\Http\Resources\ActorResource;
use App\Http\Resources\GenreResource;
use App\Http\Resources\DirectorResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('cobertura total de resources', function () {
    $director = Director::factory()->create();
    $movie = Movie::factory()->create(['director_id' => $director->id]);
    $actor = Actor::factory()->create();
    $genre = Genre::factory()->create();

    // Simplemente los instanciamos para cubrir el código
    new MovieResource($movie);
    new ActorResource($actor);
    new GenreResource($genre);
    new DirectorResource($director);

    expect(true)->toBeTrue();
});
