<?php

use App\Models\Movie;
use App\Models\User;
use App\Models\Role;
use App\Models\Genre;
use App\Models\Director;
use App\Livewire\SearchBar;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('search bar component works', function () {
    Movie::factory()->create(['title' => 'Inception']);

    Livewire::test(SearchBar::class)
        ->set('search', 'Incep')
        ->assertSee('Inception');
});

test('movie model relationships work', function () {
    $genre = Genre::factory()->create();
    $director = Director::factory()->create();

    $movie = Movie::factory()
        ->for($director)
        ->create();

    $movie->genres()->attach($genre);

    $movie->refresh();

    $this->assertTrue($movie->genres->contains($genre));
    $this->assertNotNull($movie->director);
});


test('user isAdmin method works', function () {
    $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
    $userAdmin = User::factory()->create(['role_id' => $roleAdmin->id]);

    $roleUser = Role::firstOrCreate(['name' => 'user']);
    $userNormal = User::factory()->create(['role_id' => $roleUser->id]);

    $this->assertTrue($userAdmin->isAdmin());
    $this->assertFalse($userNormal->isAdmin());
});

test('user favorites relationship works', function () {
    $user = User::factory()->create();
    $movie = Movie::factory()->create();

    $user->favorites()->attach($movie->id, ['type' => 'favorite']);

    $user->refresh();

    $this->assertTrue($user->favorites->contains($movie));
    $this->assertFalse($user->watchLater->contains($movie));
});
