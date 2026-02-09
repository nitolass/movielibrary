<?php

use App\Models\{User, Role, Movie, Actor, Director, Genre, Review};
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Creamos los roles necesarios
    $this->adminRole = Role::firstOrCreate(['name' => 'admin']);
    $this->editorRole = Role::firstOrCreate(['name' => 'editor']);
    $this->userRole = Role::firstOrCreate(['name' => 'user']);

    // Creamos los usuarios de prueba
    $this->admin = User::factory()->create(['role_id' => $this->adminRole->id]);
    $this->editor = User::factory()->create(['role_id' => $this->editorRole->id]);
    $this->user = User::factory()->create(['role_id' => $this->userRole->id]);
});

/* --- MOVIE POLICY --- */
test('movie policy rules', function () {
    $movie = Movie::factory()->create();

    // Before (Admin)
    expect($this->admin->can('create', Movie::class))->toBeTrue();

    // Editor (Puede crear y editar, pero NO borrar)
    expect($this->editor->can('create', Movie::class))->toBeTrue();
    expect($this->editor->can('update', $movie))->toBeTrue();
    expect($this->editor->can('delete', $movie))->toBeFalse();

    // User (No puede nada de gestión)
    expect($this->user->can('create', Movie::class))->toBeFalse();
    expect($this->user->can('delete', $movie))->toBeFalse();
    expect($this->user->can('restore', $movie))->toBeFalse();
    expect($this->user->can('forceDelete', $movie))->toBeFalse();
});

/* --- REVIEW POLICY --- */
test('review policy rules', function () {
    $myReview = Review::factory()->create(['user_id' => $this->user->id]);
    $otherReview = Review::factory()->create();

    // Propietario puede editar/borrar la suya
    expect($this->user->can('update', $myReview))->toBeTrue();
    expect($this->user->can('delete', $myReview))->toBeTrue();

    // No puede editar la de otro
    expect($this->user->can('update', $otherReview))->toBeFalse();

    // Admin puede editar cualquier review
    expect($this->admin->can('update', $otherReview))->toBeTrue();
});

test('review policy denies unauthorized users', function () {
    $user1 = User::factory()->create(['role_id' => $this->userRole->id]);
    $user2 = User::factory()->create(['role_id' => $this->userRole->id]);

    $reviewOfUser2 = Review::factory()->create(['user_id' => $user2->id]);

    // Caso denegado: Usuario 1 intenta editar/borrar la de Usuario 2
    expect($user1->can('update', $reviewOfUser2))->toBeFalse();
    expect($user1->can('delete', $reviewOfUser2))->toBeFalse();
});

/* --- ACTOR POLICY --- */
test('actor policy rules', function () {
    $actor = Actor::factory()->create();

    // ViewAny (Null/Invitado)
    expect((new \App\Policies\ActorPolicy)->viewAny(null))->toBeTrue();

    // Editor puede crear/update
    expect($this->editor->can('create', Actor::class))->toBeTrue();
    expect($this->editor->can('update', $actor))->toBeTrue();

    // Editor NO puede borrar (Solo admin)
    expect($this->editor->can('delete', $actor))->toBeFalse();
    expect($this->admin->can('delete', $actor))->toBeTrue();
});

/* --- USER POLICY --- */
test('user policy rules', function () {
    $otherUser = User::factory()->create();

    // Un usuario puede gestionar su propio perfil
    expect($this->user->can('view', $this->user))->toBeTrue();
    expect($this->user->can('update', $this->user))->toBeTrue();
    expect($this->user->can('delete', $this->user))->toBeTrue();

    // Pero NO el de otro
    expect($this->user->can('view', $otherUser))->toBeFalse();
    expect($this->user->can('viewAny', User::class))->toBeFalse();

    // Restore/ForceDelete siempre False para no admin
    expect($this->user->can('restore', $otherUser))->toBeFalse();
});

/* --- DIRECTOR & GENRE POLICIES --- */
test('director and genre policies', function () {
    $director = Director::factory()->create();
    $genre = Genre::factory()->create();

    // Público puede ver
    expect((new \App\Policies\DirectorPolicy)->viewAny(null))->toBeTrue();
    expect((new \App\Policies\GenrePolicy)->view(null, $genre))->toBeTrue();

    // Solo admin puede crear/borrar
    expect($this->user->can('create', Director::class))->toBeFalse();
    expect($this->admin->can('create', Genre::class))->toBeTrue();
});

test('director policy denies regular user', function () {
    $user = User::factory()->create(['role_id' => $this->userRole->id]);
    expect($user->can('create', App\Models\Director::class))->toBeFalse();
});
