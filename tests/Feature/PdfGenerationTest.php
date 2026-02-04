<?php

use App\Models\User;
use App\Models\Role; // Asegúrate de importar tu modelo de Role
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin can download a pdf list of all users', function () {
    $this->withoutExceptionHandling();

    $admin = createAdminForPdf();
    User::factory(5)->create();

    // Fíjate bien en el nombre de la ruta, debe coincidir con el ->name() de web.php
    // En tu mensaje anterior dijiste que se llamaba 'pdf.admin-user-list' (con guiones)
    $response = $this->actingAs($admin)
        ->get(route('pdf.admin-user-list'));

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'application/pdf');
});

test('admin can download a specific user report pdf', function () {
    $this->withoutExceptionHandling();

    $admin = createAdminForPdf();
    $targetUser = User::factory()->create();

    // Esto funcionará si en web.php el ->name() es 'pdf.admin-user-report'
    $response = $this->actingAs($admin)
        ->get(route('pdf.admin-user-report', $targetUser));

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'application/pdf');
});
// --- HELPER PARA CREAR ADMIN ---
function createAdminForPdf()
{
    // Ajusta esto según tu lógica de Roles
    $role = Role::firstOrCreate(['name' => 'admin']);

    return User::factory()->create([
        'role_id' => $role->id
    ]);
}
