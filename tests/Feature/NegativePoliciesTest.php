<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Movie;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('regular user cannot delete other users', function () {
    $roleUser = Role::firstOrCreate(['name' => 'user']);
    $user1 = User::factory()->create(['role_id' => $roleUser->id]);
    $user2 = User::factory()->create(['role_id' => $roleUser->id]);

    // Usuario 1 intenta borrar a Usuario 2
    $this->assertFalse($user1->can('delete', $user2));
});

test('regular user cannot create movies', function () {
    $roleUser = Role::firstOrCreate(['name' => 'user']);
    $user = User::factory()->create(['role_id' => $roleUser->id]);

    $this->assertFalse($user->can('create', Movie::class));
    $this->assertFalse($user->can('update', new Movie));
    $this->assertFalse($user->can('delete', new Movie));
});

test('user cannot edit other users reviews', function () {
    $roleUser = Role::firstOrCreate(['name' => 'user']);
    $owner = User::factory()->create(['role_id' => $roleUser->id]);
    $other = User::factory()->create(['role_id' => $roleUser->id]);

    $review = Review::factory()->create(['user_id' => $owner->id]);

    // El otro usuario NO debe poder editarla
    $this->assertFalse($other->can('update', $review));
    $this->assertFalse($other->can('delete', $review));

    // El dueño SÍ debe poder
    $this->assertTrue($owner->can('update', $review));
});
