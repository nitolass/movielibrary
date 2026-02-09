<?php

use App\Models\{User, Role};
use App\Livewire\UserManager;
use Livewire\Livewire;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('user manager can create and edit users with verification', function () {
    $admin = User::factory()->create(['role_id' => Role::firstOrCreate(['name' => 'admin'])->id]);
    $role = Role::firstOrCreate(['name' => 'user']);

    Livewire::actingAs($admin)
        ->test(UserManager::class)
        // 1. Abrir modal
        ->call('create')
        ->assertSet('isModalOpen', true)
        // 2. Store con verified = true
        ->set('name', 'New')
        ->set('surname', 'User')
        ->set('email', 'new@user.com')
        ->set('role_id', $role->id)
        ->set('password', 'password123')
        ->set('password_confirmation', 'password123')
        ->set('verified', true)
        ->call('store')
        // 3. Editar
        ->call('edit', User::where('email', 'new@user.com')->first()->id)
        ->set('verified', false) // Quitar verificación
        ->call('update')
        ->assertHasNoErrors();

    $this->assertDatabaseHas('users', ['email' => 'new@user.com', 'email_verified_at' => null]);
});
