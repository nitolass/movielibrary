<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\{assertDatabaseHas, assertDatabaseMissing};

// Limpia la base de datos después de cada test
uses(RefreshDatabase::class);

it('puedo crear un usuario asignado a un rol', function () {
    // 1. Preparación: Necesitamos un Rol primero (por tu migración create_roles_table)
    $role = Role::create(['name' => 'admin']);

    $datosUsuario = [
        'name'     => 'Carlos Ruiz',
        'username' => 'cruiz99', // Campo añadido en tu migración extra
        'email'    => 'carlos@example.com',
        'password' => 'secret123', // Laravel lo hasheará automáticamente si está en $casts
        'role_id'  => $role->id
    ];

    // 2. Acción: Crear el usuario
    $user = User::create($datosUsuario);

    // 3. Verificación
    assertDatabaseHas('users', [
        'email'    => 'carlos@example.com',
        'username' => 'cruiz99',
        'role_id'  => $role->id
    ]);
});

it('puedo actualizar la información de un usuario', function () {
    // Crear datos base
    $role = Role::create(['name' => 'user']);
    $user = User::create([
        'name'     => 'Nombre Antiguo',
        'username' => 'old_user',
        'email'    => 'old@example.com',
        'password' => '12345678',
        'role_id'  => $role->id
    ]);

    // Actualizar
    $user->update([
        'name'  => 'Nombre Nuevo',
        'email' => 'new@example.com'
    ]);

    // Verificación en DB
    assertDatabaseHas('users', [
        'id'    => $user->id,
        'email' => 'new@example.com',
        'name'  => 'Nombre Nuevo'
    ]);

    // Verificación del objeto
    expect($user->refresh()->email)->toBe('new@example.com');
});

it('puedo eliminar un usuario', function () {
    // 1. Crear
    $role = Role::create(['name' => 'guest']);
    $user = User::create([
        'name'     => 'A eliminar',
        'username' => 'delete_me',
        'email'    => 'delete@example.com',
        'password' => '...',
        'role_id'  => $role->id
    ]);

    // 2. Eliminar
    $user->delete();

    // 3. Verificación
    assertDatabaseMissing('users', [
        'email' => 'delete@example.com'
    ]);
});

it('funciona la relación entre usuario y rol', function () {
    // Este test asegura que la clave foránea y el modelo están bien conectados

    // 1. Crear Rol y Usuario
    $role = Role::create(['name' => 'SuperAdmin']);
    $user = User::create([
        'name'     => 'Admin User',
        'username' => 'admin',
        'email'    => 'admin@test.com',
        'password' => 'password',
        'role_id'  => $role->id
    ]);

    // 2. Verificar que desde el usuario podemos acceder al nombre del rol
    // Esto prueba: $user->role() en tu modelo User
    expect($user->role)->not->toBeNull();
    expect($user->role->name)->toBe('SuperAdmin');
});
