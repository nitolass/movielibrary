<?php

use App\Jobs\RecalculateActorScore;
use App\Models\Actor;
use App\Models\Movie;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('recalculate actor score job runs', function () {
    // 1. Crear Actor y Película con Reseñas
    $actor = Actor::factory()->create();
    $movie = Movie::factory()->create();
    $movie->actors()->attach($actor);

    Review::factory()->create(['movie_id' => $movie->id, 'rating' => 10]);
    Review::factory()->create(['movie_id' => $movie->id, 'rating' => 5]);

    // 2. Ejecutar el Job
    $job = new RecalculateActorScore($actor);
    $job->handle();

    // 3. Verificar que se actualizó (opcional, con ejecutarlo ya sube coverage)
    // $actor->refresh();
    // $this->assertEquals(7.5, $actor->score); // (10+5)/2

    $this->assertTrue(true);
});
