<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $role = Role::firstOrCreate(['name' => 'admin']);
    $this->admin = User::factory()->create(['role_id' => $role->id]);
});

test('admin can list users', function () {
    User::factory()->count(3)->create();

    $response = $this->actingAs($this->admin)->get(route('admin.users.index'));

    $response->assertStatus(200);
    $response->assertViewHas('users');
});

test('admin can store a new user', function () {
    $role = Role::firstOrCreate(['name' => 'user']);

    // Esto prueba UserStoreRequest (que estaba al 0%)
    $response = $this->actingAs($this->admin)->post(route('admin.users.store'), [
        'name' => 'Nuevo',
        'surname' => 'Usuario',
        'email' => 'nuevo@test.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role_id' => $role->id,
    ]);

    $response->assertRedirect(route('admin.users.index'));
    $this->assertDatabaseHas('users', ['email' => 'nuevo@test.com']);
});

test('validate user creation', function () {
    // Probamos validación fallida
    $response = $this->actingAs($this->admin)->post(route('admin.users.store'), [
        'name' => '', // Vacío
    ]);

    $response->assertSessionHasErrors('name');
});

test('admin can update a user', function () {
    $this->withoutExceptionHandling();
    $user = User::factory()->create();
    $role = Role::firstOrCreate(['name' => 'editor']);

    $response = $this->actingAs($this->admin)->put(route('admin.users.update', $user), [
        'name' => 'Editado',
        'surname' => 'EditadoSurname',
        'email' => $user->email,
        'role_id' => $role->id
    ]);

    $response->assertRedirect(route('admin.users.index'));
    $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Editado']);
});

test('admin can delete a user', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($this->admin)->delete(route('admin.users.destroy', $user));

    $response->assertRedirect(route('admin.users.index'));
    $this->assertDatabaseMissing('users', ['id' => $user->id]);
});
