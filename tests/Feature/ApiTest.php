<?php

use App\Models\User;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Director;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('cobertura de rutas api publicas y protegidas', function () {
    $this->withoutExceptionHandling();
    // 1. Preparar datos necesarios
    $director = Director::factory()->create();
    $movie = Movie::factory()->create(['director_id' => $director->id]);
    $genre = Genre::factory()->create();
    $user = User::factory()->create();

    // --- RUTAS PÚBLICAS ---
    $this->getJson('/api/directors')->assertStatus(200);
    $this->getJson('/api/directors/' . $director->id)->assertStatus(200);

    // --- RUTAS PROTEGIDAS (Usamos actingAs) ---
    $this->actingAs($user, 'sanctum')->getJson('/api/movies')->assertStatus(200);
    $this->actingAs($user, 'sanctum')->getJson('/api/movies/' . $movie->id)->assertStatus(200);

    $this->actingAs($user, 'sanctum')->getJson('/api/genres')->assertStatus(200);
    $this->actingAs($user, 'sanctum')->getJson('/api/genres/' . $genre->id)->assertStatus(200);

    $this->actingAs($user, 'sanctum')->getJson('/api/user')->assertStatus(200);
});
