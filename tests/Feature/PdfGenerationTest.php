<?php

use App\Models\Movie;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can download watch later pdf', function () {
    $this->withoutExceptionHandling();
    $user = User::factory()->create();
    $movies = Movie::factory(3)->create();

    foreach($movies as $movie) {
        $user->watchLater()->attach($movie->id, ['type' => 'watch_later']);
    }

    $response = $this->actingAs($user)
        ->get(route('pdf.watchLater'));

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'application/pdf');
});

test('movie sheet pdf generates correctly', function () {
    $user = User::factory()->create();
    $movie = Movie::factory()->create();

    $response = $this->actingAs($user)
        ->get(route('pdf.movieSheet', $movie));

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'application/pdf');
});
