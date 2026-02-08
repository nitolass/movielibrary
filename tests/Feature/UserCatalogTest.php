<?php

use App\Models\User;
use App\Models\Movie;
use App\Models\Director;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// --- 1. VER EL CATÁLOGO ---
test('any user can see the movie catalog', function () {
    $director = Director::factory()->create();
    Movie::factory()->count(3)->create(['director_id' => $director->id]);

    $response = $this->get(route('user.movies.index'));

    $response->assertStatus(200);
    $response->assertSee(Movie::first()->title);
});

// --- 2. AÑADIR A FAVORITOS ---
test('authenticated user can toggle a movie as favorite', function () {
    $user = User::factory()->create();
    $director = Director::factory()->create();
    $movie = Movie::factory()->create(['director_id' => $director->id]);

    // Hacemos el POST a la ruta que tienes en tu web.php
    $response = $this->actingAs($user)
        ->post(route('user.toggle.favorite', $movie));

    $response->assertStatus(302); // Redirige de vuelta

    // Verificamos que se guardó en la tabla pivote (ajusta el nombre si es distinto)
    $this->assertDatabaseHas('movie_user', [
        'user_id' => $user->id,
        'movie_id' => $movie->id,
    ]);
});

// --- 3. AÑADIR A VER MÁS TARDE ---
test('authenticated user can toggle watch later', function () {
    $user = User::factory()->create();
    $director = Director::factory()->create();
    $movie = Movie::factory()->create(['director_id' => $director->id]);

    $response = $this->actingAs($user)
        ->post(route('user.toggle.watchLater', $movie));

    $response->assertStatus(302);
});

// --- 4. MARCAR COMO VISTA ---
test('authenticated user can toggle watched status', function () {
    $user = User::factory()->create();
    $director = Director::factory()->create();
    $movie = Movie::factory()->create(['director_id' => $director->id]);

    $response = $this->actingAs($user)
        ->post(route('user.toggle.watched', $movie));

    $response->assertStatus(302);
});

// --- 5. VER SUS PUNTUADAS (LIVEWIRE) ---
test('user can see their rated movies page', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->get(route('user.reviews.index'));

    $response->assertStatus(200);
});
