<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{assertDatabaseHas, assertDatabaseMissing};

uses(RefreshDatabase::class);

it('puedo crear un usuario asignado a un rol', function () {
    $role = Role::create(['name' => 'admin']);

    $datosUsuario = [
        'name'     => 'Carlos',
        'surname'  => 'Ruiz', //
        'email'    => 'carlos@example.com',
        'password' => 'secret123',
        'role_id'  => $role->id
    ];

    User::create($datosUsuario);

    assertDatabaseHas('users', [
        'email'    => 'carlos@example.com',
        'surname'  => 'Ruiz',
        'role_id'  => $role->id
    ]);
});

it('puedo actualizar la información de un usuario', function () {
    $role = Role::create(['name' => 'user']);

    // Usamos create manual
    $user = User::create([
        'name'     => 'Nombre Antiguo',
        'surname'  => 'Apellido Antiguo',
        'email'    => 'old@example.com',
        'password' => '12345678',
        'role_id'  => $role->id
    ]);

    $user->update([
        'name'    => 'Nombre Nuevo',
        'surname' => 'Apellido Nuevo',
        'email'   => 'new@example.com'
    ]);

    // Verificación en DB
    assertDatabaseHas('users', [
        'id'      => $user->id,
        'email'   => 'new@example.com',
        'name'    => 'Nombre Nuevo',
        'surname' => 'Apellido Nuevo'
    ]);

    expect($user->refresh()->email)->toBe('new@example.com');
});

it('puedo eliminar un usuario', function () {
    $role = Role::create(['name' => 'guest']);
    $user = User::create([
        'name'     => 'A eliminar',
        'surname'  => 'Test', //
        'email'    => 'delete@example.com',
        'password' => '...',
        'role_id'  => $role->id
    ]);

    $user->delete();

    assertDatabaseMissing('users', [
        'email' => 'delete@example.com'
    ]);
});

it('funciona la relación entre usuario y rol', function () {
    $role = Role::create(['name' => 'SuperAdmin']);

    $user = User::create([
        'name'     => 'Admin',
        'surname'  => 'User',
        'email'    => 'admin@test.com',
        'password' => 'password',
        'role_id'  => $role->id
    ]);

    expect($user->role)->not->toBeNull();
    expect($user->role->name)->toBe('SuperAdmin');
});
