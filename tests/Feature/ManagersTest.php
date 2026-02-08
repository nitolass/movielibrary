<?php

use App\Models\User;
use App\Models\Role;
use App\Livewire\ActorManager;
use App\Livewire\GenreManager;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $role = Role::firstOrCreate(['name' => 'admin']);
    $this->admin = User::factory()->create(['role_id' => $role->id]);
});

// --- ACTOR MANAGER ---
test('actor manager component renders', function () {
    // CORRECCIÓN: Usamos la URL directa '/admin/actors' para no confundirnos con la ruta antigua
    $this->actingAs($this->admin)
        ->get('/admin/actors')
        ->assertSeeLivewire(ActorManager::class);
});

test('can create actor via livewire', function () {
    Livewire::actingAs($this->admin)
        ->test(ActorManager::class)
        ->set('name', 'Livewire Actor')
        ->set('nationality', 'Test')
        ->set('birth_year', '1990')
        ->call('store')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('actors', ['name' => 'Livewire Actor']);
});

// --- GENRE MANAGER ---
test('genre manager component renders', function () {
    // CORRECCIÓN: Usamos la URL directa '/admin/genres'
    $this->actingAs($this->admin)
        ->get('/admin/genres')
        ->assertSeeLivewire(GenreManager::class);
});

test('can create genre via livewire', function () {
    Livewire::actingAs($this->admin)
        ->test(GenreManager::class)
        ->set('name', 'Livewire Genre')
        ->call('store')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('genres', ['name' => 'Livewire Genre']);
});
