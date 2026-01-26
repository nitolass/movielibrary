<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guest can view the public catalog', function () {
    $this->withoutExceptionHandling();
    Movie::factory()->count(2)->create();

    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertViewHas('movies');
});

test('registered user can view their dashboard/movies list', function () {
    // Crear usuario normal
    $user = User::factory()->create();

    // Login y visitar la ruta de usuario
    // Segun vimos antes, tu ruta era 'user.movies.index'
    $response = $this->actingAs($user)->get(route('user.movies.index'));

    $response->assertStatus(200);
});
test('guest can see movie details', function () {
    $this->withoutExceptionHandling();
    // Creamos una peli
    $movie = \App\Models\Movie::factory()->create();

    // Probamos la ruta user.movies.show
    $response = $this->get(route('user.movies.show', $movie));

    $response->assertStatus(200);
    $response->assertViewHas('movie');
});

test('guest can see the prompt page', function () {
    $response = $this->get(route('public.prompt'));
    $response->assertStatus(200);
});
