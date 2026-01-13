<?php

use App\Models\Actor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{assertDatabaseHas, assertDatabaseMissing};

uses(RefreshDatabase::class);

it('puedo crear un actor', function () {
    Actor::create([
        'name'        => 'Brad Pitt',
        'biography'   => 'Actor de Hollywood',
        'birth_year'  => 1963,
        'nationality' => 'USA',
        'photo'       => 'brad.jpg'
    ]);

    assertDatabaseHas('actors', [
        'name' => 'Brad Pitt'
    ]);
});

it('puedo actualizar un actor', function () {
    $actor = Actor::create([
        'name' => 'Leonardo',
        'birth_year' => 1974,
        'nationality' => 'USA'
    ]);

    $actor->update([
        'name' => 'Leonardo DiCaprio'
    ]);

    assertDatabaseHas('actors', ['name' => 'Leonardo DiCaprio']);
    expect($actor->refresh()->name)->toBe('Leonardo DiCaprio');
});

it('puedo eliminar un actor', function () {
    $actor = Actor::create([
        'name' => 'Actor Extra',
        'nationality' => 'Desconocida'
    ]);

    $actor->delete();

    assertDatabaseMissing('actors', [
        'id' => $actor->id
    ]);
});
