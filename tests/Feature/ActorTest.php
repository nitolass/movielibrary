<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Actor;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// Función auxiliar para crear admin
function createAdminForActor() {
    // Si tienes roles, creamos uno, si no, usa el factory normal
    $role = Role::firstOrCreate(['name' => 'admin']);
    return User::factory()->create(['role_id' => $role->id]);
}

test('admin can list actors', function () {
    $admin = createAdminForActor();
    Actor::factory()->count(3)->create();

    $response = $this->actingAs($admin)->get(route('actors.index'));
    $response->assertStatus(200);
});

test('admin can create an actor', function () {
    $admin = createAdminForActor();

    // OJO: Ajusta 'name' y 'surname' si tu BD tiene otros campos
    $response = $this->actingAs($admin)->post(route('actors.store'), [
        'name' => 'Brad',
        'surname' => 'Pitt',
    ]);

    $response->assertRedirect(route('actors.index'));
    $this->assertDatabaseHas('actors', ['name' => 'Brad']);
});

test('admin can delete an actor', function () {
    $admin = createAdminForActor();
    $actor = Actor::factory()->create();

    $response = $this->actingAs($admin)->delete(route('actors.destroy', $actor));

    $response->assertRedirect(route('actors.index'));
    $this->assertDatabaseMissing('actors', ['id' => $actor->id]);
});
test('admin can see the create actor form', function () {
    $admin = createAdminForActor();
    $response = $this->actingAs($admin)->get(route('actors.create'));
    $response->assertStatus(200);
});

test('admin can see the edit actor form', function () {
    $admin = createAdminForActor();
    $actor = Actor::factory()->create();

    $response = $this->actingAs($admin)->get(route('actors.edit', $actor));
    $response->assertStatus(200);
});
test('admin can see create actor form', function () {
    $admin = createAdminForActor();
    // Si falla, prueba con 'admin.actors.create'
    $response = $this->actingAs($admin)->get(route('actors.create'));
    $response->assertStatus(200);
});

test('admin can see edit actor form', function () {
    $admin = createAdminForActor();
    $actor = \App\Models\Actor::factory()->create();

    $response = $this->actingAs($admin)->get(route('actors.edit', $actor));
    $response->assertStatus(200);
});
