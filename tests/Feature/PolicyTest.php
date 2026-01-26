<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;

uses(RefreshDatabase::class);

function createAdminForPolicy() {
    $role = Role::firstOrCreate(['name' => 'admin']);
    return User::factory()->create(['role_id' => $role->id]);
}

function createUserForPolicy() {
    $role = Role::firstOrCreate(['name' => 'user']);
    return User::factory()->create(['role_id' => $role->id]);
}

// --- MOVIE POLICY TESTS ---

test('admin can create, update and delete movies', function () {
    $admin = createAdminForPolicy();
    $movie = Movie::factory()->create();

    $this->actingAs($admin);

    expect($admin->can('create', Movie::class))->toBeTrue();
    expect($admin->can('update', $movie))->toBeTrue();
    expect($admin->can('delete', $movie))->toBeTrue();
});

test('regular user CANNOT create, update or delete movies', function () {
    $user = createUserForPolicy();
    $movie = Movie::factory()->create();

    $this->actingAs($user);

    expect($user->can('create', Movie::class))->toBeFalse();
    expect($user->can('update', $movie))->toBeFalse();
    expect($user->can('delete', $movie))->toBeFalse();
});

test('guest can view movies but nothing else', function () {
    $movie = Movie::factory()->create();

    // Sin login (Guest)
    // Para Policies con ?User, null significa guest
    $response = Gate::forUser(null)->allows('view', $movie);
    expect($response)->toBeTrue();

    $response = Gate::forUser(null)->allows('create', Movie::class);
    expect($response)->toBeFalse();
});

// --- USER POLICY TESTS ---

test('admin can manage users', function () {
    $this->withoutExceptionHandling();
    $admin = createAdminForPolicy();
    $targetUser = createUserForPolicy();

    $this->actingAs($admin);

    expect($admin->can('viewAny', User::class))->toBeTrue();
    expect($admin->can('create', User::class))->toBeTrue();
    expect($admin->can('delete', $targetUser))->toBeTrue();
});

test('regular user CANNOT manage users', function () {
    $user = createUserForPolicy();
    $targetUser = createUserForPolicy();

    $this->actingAs($user);

    expect($user->can('viewAny', User::class))->toBeFalse();
    expect($user->can('create', User::class))->toBeFalse();
    expect($user->can('delete', $targetUser))->toBeFalse();
});
