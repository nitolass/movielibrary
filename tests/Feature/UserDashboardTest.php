<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can view favorites', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user)->get(route('user.favorites'));
    $response->assertStatus(200);
});

test('user can view watch later', function () {
    $this->withoutExceptionHandling();
    $user = User::factory()->create();
    $response = $this->actingAs($user)->get(route('user.watch_later'));
    $response->assertStatus(200);
});

test('user can view rated movies', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user)->get(route('user.rated'));
    $response->assertStatus(200);
});

test('user can view watched history', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user)->get(route('user.watched'));
    $response->assertStatus(200);
});
