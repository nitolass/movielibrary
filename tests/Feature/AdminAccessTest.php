<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('non-admin cannot access admin routes', function () {
    $role = Role::firstOrCreate(['name' => 'user']);
    $user = User::factory()->create(['role_id' => $role->id]);

    // Intentamos entrar al dashboard de admin
    $response = $this->actingAs($user)->get(route('admin.dashboard'));

    // Debe ser 403 (Forbidden) o 302 (Redirect) dependiendo de tu middleware
    // Asumimos 403 o redirect a home
    $response->assertStatus(403);
});

test('admin can access admin routes', function () {
    $role = Role::firstOrCreate(['name' => 'admin']);
    $admin = User::factory()->create(['role_id' => $role->id]);

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));

    $response->assertStatus(200);
});
