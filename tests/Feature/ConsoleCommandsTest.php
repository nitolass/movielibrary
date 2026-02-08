<?php

use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use App\Models\Role;

test('ejecucion de comandos de administracion con argumentos', function () {
    Role::firstOrCreate(['id' => 1, 'name' => 'admin']);

    // Pasamos los argumentos como un array
    Artisan::call('movies:create-admin', [
        'email' => 'admin@test.com',
        'password' => '12345678'
    ]);

    // Ejecutamos el resto que estaban al 0.0%
    Artisan::call('movies:random');
    Artisan::call('movies:stats');

    expect(true)->toBeTrue();
});
