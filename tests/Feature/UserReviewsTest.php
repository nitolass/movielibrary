<?php

use App\Models\User;
use App\Models\Review;
use App\Models\Movie;
use App\Livewire\UserReviews;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user reviews component renders correctly', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Livewire::test(UserReviews::class)
        ->assertStatus(200);
});

test('user can see their reviews', function () {
    $user = User::factory()->create();
    $movie = Movie::factory()->create(['title' => 'My Movie']);
    Review::factory()->create([
        'user_id' => $user->id,
        'movie_id' => $movie->id,
        'content' => 'Amazing movie'
    ]);

    $this->actingAs($user);

    Livewire::test(UserReviews::class)
        ->assertSee('Amazing movie')
        ->assertSee('My Movie');
});

test('user can delete their own review', function () {
    $user = User::factory()->create();
    $review = Review::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user);

    Livewire::test(UserReviews::class)
        ->call('delete', $review->id); // O destroy($id) según tu componente

    $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
});

test('user reviews component coverage booster', function () {
    $user = User::factory()->create();
    $movie = Movie::factory()->create();

    // Creamos un par de reviews para el usuario
    $review = Review::factory()->create([
        'user_id' => $user->id,
        'movie_id' => $movie->id,
        'content' => 'Review para borrar'
    ]);

    Livewire::actingAs($user)
        ->test(UserReviews::class)
        ->assertSee($movie->title)
        ->call('delete', $review->id); // Asegúrate que el método se llame delete

    $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
});
