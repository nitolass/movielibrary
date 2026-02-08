<?php

use App\Http\Middleware\IsAdminUserMiddleware;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// Definimos una ruta temporal para probar el middleware
beforeEach(function () {
    Route::get('/test-admin-middleware', function () {
        return 'Admin Access Granted';
    })->middleware(['web', IsAdminUserMiddleware::class]);
});

test('admin can access protected route', function () {
    $role = Role::firstOrCreate(['name' => 'admin']);
    $admin = User::factory()->create(['role_id' => $role->id]);

    $this->actingAs($admin)
        ->get('/test-admin-middleware')
        ->assertStatus(200)
        ->assertSee('Admin Access Granted');
});

test('regular user is forbidden', function () {
    $role = Role::firstOrCreate(['name' => 'user']);
    $user = User::factory()->create(['role_id' => $role->id]);

    $this->actingAs($user)
        ->get('/test-admin-middleware')
        // Dependiendo de tu middleware, puede ser 403 o 302 (redirect home)
        // Probamos ambos por si acaso, o ajusta según tu lógica
        ->assertStatus(403);
});
