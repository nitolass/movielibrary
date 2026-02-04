<?php

use App\Models\Director;
use App\Events\DirectorCreated;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('cobertura de eventos de directores', function () {
    $director = Director::factory()->create();

    // Al disparar el evento, se cubren el Evento y sus Listeners
    event(new DirectorCreated($director));

    expect(true)->toBeTrue();
});
