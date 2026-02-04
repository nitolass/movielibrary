<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function createAdminUser() {
    $role = Role::firstOrCreate(['name' => 'admin']);
    return User::factory()->create(['role_id' => $role->id]);
}

test('admin can list users', function () {
    $admin = createAdminUser();
    User::factory()->count(3)->create();

    $response = $this->actingAs($admin)->get(route('admin.users.index'));

    $response->assertStatus(200);
    $response->assertViewHas('users');
});

test('admin can see create user form', function () {
    $admin = createAdminUser();

    $response = $this->actingAs($admin)->get(route('admin.users.create'));

    $response->assertStatus(200);
});

test('admin can store a new user', function () {
    $admin = createAdminUser();
    $roleUser = Role::firstOrCreate(['name' => 'user']);

    // 1. Visitamos primero la página de crear (para que Laravel sepa cuál es "atrás")
    $this->actingAs($admin)->get(route('admin.users.create'));

    $response = $this->actingAs($admin)->from(route('admin.users.create'))->post(route('admin.users.store'), [
        'name' => 'Nuevo Usuario',
        'surname' => 'Test', // OJO: Asegúrate de que este campo existe en tu validación y modelo
        'email' => 'nuevo@test.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role_id' => $roleUser->id,
    ]);

    // --- BLOQUE DE DEPURACIÓN ---
    // Si hay errores de validación, esto te los mostrará en la terminal
    if (session('errors')) {
        dump(session('errors')->all());
    }
    // ----------------------------

    $response->assertRedirect(route('admin.users.index'));
    $this->assertDatabaseHas('users', ['email' => 'nuevo@test.com']);
});
