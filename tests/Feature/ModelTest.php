<?php

use App\Models\Actor;
use App\Models\Director;
use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('actor model belongs to many movies', function () {
    $this->withoutExceptionHandling();
    $actor = Actor::factory()->create();
    $this->assertTrue(method_exists($actor, 'movies'));
    $this->assertInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsToMany::class, $actor->movies());
});

test('director model has many movies', function () {
    $director = Director::factory()->create();
    $this->assertTrue(method_exists($director, 'movies'));
    $this->assertNotNull($director->movies());
});
