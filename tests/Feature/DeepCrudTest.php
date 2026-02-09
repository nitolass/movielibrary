<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Actor;
use App\Models\Director;
use App\Models\Genre;
use App\Livewire\UserManager;
use App\Livewire\ActorManager;
use App\Livewire\DirectorManager;
use App\Livewire\GenreManager;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $role = Role::firstOrCreate(['name' => 'admin']);
    $this->admin = User::factory()->create(['role_id' => $role->id]);
});

// --- USER MANAGER CRUD ---
test('user manager can edit and update user', function () {
    $user = User::factory()->create(['name' => 'Old Name']);

    Livewire::actingAs($this->admin)
        ->test(UserManager::class)
        ->call('edit', $user->id) // Cargar datos en el formulario
        ->set('name', 'New Name')
        ->call('update'); // Guardar cambios

    $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'New Name']);
});

test('user manager can delete user', function () {
    $user = User::factory()->create();

    Livewire::actingAs($this->admin)
        ->test(UserManager::class)
        ->call('delete', $user->id); // O confirmDelete/destroy según tu código

    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});

// --- ACTOR MANAGER CRUD ---
test('actor manager can edit and delete', function () {
    $actor = Actor::factory()->create(['name' => 'Old Actor']);

    Livewire::actingAs($this->admin)
        ->test(ActorManager::class)
        ->call('edit', $actor->id)
        ->set('name', 'Updated Actor')
        ->call('update');

    $this->assertDatabaseHas('actors', ['id' => $actor->id, 'name' => 'Updated Actor']);

    // Delete
    Livewire::actingAs($this->admin)
        ->test(ActorManager::class)
        ->call('delete', $actor->id);

    $this->assertDatabaseMissing('actors', ['id' => $actor->id]);
});

// --- DIRECTOR MANAGER CRUD ---
test('director manager can edit and delete', function () {
    $director = Director::factory()->create(['name' => 'Old Director']);

    Livewire::actingAs($this->admin)
        ->test(DirectorManager::class)
        ->call('edit', $director->id)
        ->set('name', 'Updated Director')
        ->call('update');

    $this->assertDatabaseHas('directors', ['id' => $director->id, 'name' => 'Updated Director']);

    // Delete
    Livewire::actingAs($this->admin)
        ->test(DirectorManager::class)
        ->call('delete', $director->id);

    $this->assertDatabaseMissing('directors', ['id' => $director->id]);
});

// --- GENRE MANAGER CRUD ---
test('genre manager can edit and delete', function () {
    $this->withoutExceptionHandling();
    $genre = Genre::factory()->create(['name' => 'Old Genre']);

    Livewire::actingAs($this->admin)
        ->test(GenreManager::class)
        ->call('edit', $genre->id)
        ->set('name', 'New Genre')
        ->call('update');

    $this->assertDatabaseHas('genres', ['id' => $genre->id, 'name' => 'New Genre']);

    Livewire::actingAs($this->admin)
        ->test(GenreManager::class)
        ->call('delete', $genre->id);

    $this->assertDatabaseMissing('genres', ['id' => $genre->id]);
});
