<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Director;
use App\Livewire\DirectorManager;
use App\Livewire\UserManager;
use App\Livewire\UserDetail;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $role = Role::firstOrCreate(['name' => 'admin']);
    $this->admin = User::factory()->create(['role_id' => $role->id]);
});

// --- DIRECTOR MANAGER (Estaba al 0%) ---
test('director manager renders', function () {
    $this->actingAs($this->admin)
        ->get('/admin/directors') // URL directa
        ->assertSeeLivewire(DirectorManager::class);
});

test('can create director via livewire', function () {
    Livewire::actingAs($this->admin)
        ->test(DirectorManager::class)
        ->set('name', 'Nolan')
        ->set('nationality', 'UK')
        ->set('birth_year', '1970')
        ->call('store') // O 'save'
        ->assertHasNoErrors();

    $this->assertDatabaseHas('directors', ['name' => 'Nolan']);
});

// --- USER MANAGER (Estaba al 0%) ---
test('user manager renders', function () {
    $this->actingAs($this->admin)
        ->get('/admin/users') // URL directa (Livewire)
        ->assertSeeLivewire(UserManager::class);
});

test('user manager can delete user', function () {
    $userToDelete = User::factory()->create();

    Livewire::actingAs($this->admin)
        ->test(UserManager::class)
        ->call('delete', $userToDelete->id); // Asumo que el metodo es delete($id) o confirmDelete

    $this->assertDatabaseMissing('users', ['id' => $userToDelete->id]);
});

test('user detail renders', function () {
    $user = User::factory()->create();
    $this->actingAs($this->admin)
        ->get("/admin/users/{$user->id}")
        ->assertSeeLivewire(UserDetail::class);
});
