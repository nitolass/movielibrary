<?php

use App\Models\User;
use App\Models\Role;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('movies create admin command full coverage', function () {
    // 0. Preparar el entorno (Rol 1 para admin)
    Role::firstOrCreate(['id' => 1, 'name' => 'admin']);

    // CAMINO A: Crear usuario nuevo
    $this->artisan('movies:create-admin', [
        'email'    => 'nuevo@admin.com',
        'password' => 'secret123',
    ])
        ->expectsOutputToContain('Administrador creado correctamente')
        ->assertExitCode(0);

    // CAMINO B: El usuario ya es admin y actualiza contraseña
    $this->artisan('movies:create-admin', [
        'email'    => 'nuevo@admin.com',
        'password' => 'nueva_pass',
    ])
        ->expectsOutputToContain('YA existe')
        ->expectsConfirmation('¿Deseas actualizar solo su contraseña?', 'yes')
        ->expectsOutputToContain('Contraseña actualizada correctamente')
        ->assertExitCode(0);

    // CAMINO C: Existe pero no es admin y CANCELAMOS promoción
    $userNormal = User::factory()->create(['email' => 'normal@user.com', 'role_id' => 2]);
    $this->artisan('movies:create-admin', [
        'email'    => 'normal@user.com',
        'password' => 'pass',
    ])
        ->expectsOutputToContain('NO es administrador')
        ->expectsConfirmation('¿Quieres actualizar su contraseña y convertirlo en Administrador?', 'no')
        ->expectsOutputToContain('Operación cancelada')
        ->assertExitCode(0);
});
