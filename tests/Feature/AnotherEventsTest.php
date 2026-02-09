<?php

use App\Models\Movie;
use App\Models\Actor;
use App\Models\Director;
use App\Models\Genre;
use App\Models\User;
use App\Events\MovieCreated;
use App\Events\ActorCreated;
use App\Events\DirectorCreated;
use App\Events\GenreCreated;
use App\Events\UserCreated;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('events store models and define broadcast channels', function () {
    // 1. MovieCreated
    $movie = Movie::factory()->create();
    $eventMovie = new MovieCreated($movie);
    expect($eventMovie->movie->id)->toBe($movie->id);
    expect($eventMovie->broadcastOn()[0])->toBeInstanceOf(PrivateChannel::class);

    // 2. ActorCreated
    $actor = Actor::factory()->create();
    $eventActor = new ActorCreated($actor);
    expect($eventActor->actor->id)->toBe($actor->id);
    expect($eventActor->broadcastOn()[0])->toBeInstanceOf(PrivateChannel::class);

    // 3. DirectorCreated
    $director = Director::factory()->create();
    $eventDirector = new DirectorCreated($director);
    expect($eventDirector->director->id)->toBe($director->id);
    expect($eventDirector->broadcastOn()[0])->toBeInstanceOf(PrivateChannel::class);

    // 4. GenreCreated
    $genre = Genre::factory()->create();
    $eventGenre = new GenreCreated($genre);
    expect($eventGenre->genre->id)->toBe($genre->id);
    expect($eventGenre->broadcastOn()[0])->toBeInstanceOf(PrivateChannel::class);

    // 5. UserCreated
    $user = User::factory()->create();
    $eventUser = new UserCreated($user);
    expect($eventUser->user->id)->toBe($user->id);
    expect($eventUser->broadcastOn()[0])->toBeInstanceOf(PrivateChannel::class);
});
