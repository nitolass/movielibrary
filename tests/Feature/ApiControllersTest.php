<?php

use App\Models\User;
use App\Models\Actor;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Director;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('los controladores de la api responden correctamente', function () {
    $this->withoutExceptionHandling();
    $user = User::factory()->create();
    $director = Director::factory()->create();
    $genre = Genre::factory()->create();
    $movie = Movie::factory()->create(['director_id' => $director->id]);
    $actor = Actor::factory()->create();

    // Actores API (Sube de 0% a 100%)
    $this->actingAs($user, 'sanctum')->getJson(route('api.actors.index'))->assertOk();
    $this->actingAs($user, 'sanctum')->getJson(route('api.actors.show', $actor))->assertOk();

    $this->actingAs($user, 'sanctum')->getJson(route('api.directors.index'))->assertOk();
    $this->actingAs($user, 'sanctum')->getJson(route('api.directors.show', $director))->assertOk();

    $this->actingAs($user, 'sanctum')->getJson(route('api.genres.index'))->assertOk();
    $this->actingAs($user, 'sanctum')->getJson(route('api.genres.show', $genre))->assertOk();

    $this->actingAs($user, 'sanctum')->getJson(route('api.movies.index'))->assertOk();
    $this->actingAs($user, 'sanctum')->getJson(route('api.movies.show', $movie))->assertOk();
});
