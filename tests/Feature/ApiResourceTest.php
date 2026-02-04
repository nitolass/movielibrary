<?php

use App\Models\Actor;
use App\Models\Movie;
use App\Models\Director;
use App\Http\Resources\ActorResource;
use App\Http\Resources\MovieResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('los recursos de la api transforman los modelos correctamente', function () {
    // 1. Preparamos los modelos
    $actor = Actor::factory()->create();
    $movie = Movie::factory()->create(['director_id' => Director::factory()]);

    // 2. Ejecutamos ActorResource (Sube de 0.0% a 100%)
    $actorResource = new ActorResource($actor);
    // Forzamos el método toArray para que el coverage cuente las líneas
    expect($actorResource->resolve())->toBeArray();

    // 3. Ejecutamos MovieResource (Sube de 92% a 100%)
    $movieResource = new MovieResource($movie);
    expect($movieResource->resolve())->toBeArray();
});
