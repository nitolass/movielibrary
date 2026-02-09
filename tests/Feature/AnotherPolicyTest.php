<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('policies negative cases', function () {
    $user = App\Models\User::factory()->create(); // Usuario normal
    $otherUser = App\Models\User::factory()->create();
    $movie = App\Models\Movie::factory()->create();
    $review = App\Models\Review::factory()->create(['user_id' => $otherUser->id]);

    // MoviePolicy: Usuario normal no puede crear ni editar pelis
    expect($user->can('create', App\Models\Movie::class))->toBeFalse();
    expect($user->can('update', $movie))->toBeFalse();

    // ReviewPolicy: Usuario no puede editar reviews de otros
    expect($user->can('update', $review))->toBeFalse();
    expect($user->can('delete', $review))->toBeFalse();

    // UserPolicy: Usuario no puede borrar a otros
    expect($user->can('delete', $otherUser))->toBeFalse();
});
