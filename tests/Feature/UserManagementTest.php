<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('un administrador puede crear nuevos usuarios', function () {
    $role = Role::firstOrCreate(['name' => 'admin']);
    $admin = User::factory()->create(['role_id' => $role->id]);

    $response = $this->actingAs($admin)->post(route('admin.users.store'), [
        'name' => 'Juan',
        'surname' => 'Pérez',
        'email' => 'juan.perez@example.com',
        'password' => '12345678',
        'password_confirmation' => '12345678',
        'role_id' => $role->id
    ]);

    $response->assertRedirect(route('admin.users.index'));

    $this->assertDatabaseHas('users', [
        'email' => 'juan.perez@example.com',
        'name' => 'Juan'
    ]);
});
