<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// Función auxiliar para crear un admin
function createAdminForGenre() {
    $role = Role::firstOrCreate(['name' => 'admin']);
    return User::factory()->create(['role_id' => $role->id]);
}

test('admin can see genres list', function () {
    $admin = createAdminForGenre();
    Genre::factory()->count(3)->create();

    $response = $this->actingAs($admin)->get(route('admin.genres.index'));

    $response->assertStatus(200);
    $response->assertViewHas('genres');
});

test('admin can see create genre form', function () {
    $admin = createAdminForGenre();

    $response = $this->actingAs($admin)->get(route('admin.genres.create'));

    $response->assertStatus(200);
});

test('admin can create a genre', function () {
    $this->withoutExceptionHandling();
    $admin = createAdminForGenre();

    $response = $this->actingAs($admin)->post(route('admin.genres.store'), [
        'name' => 'Ciencia Ficción'
    ]);

    $response->assertRedirect(route('admin.genres.index'));

    // Verificamos base de datos
    $this->assertDatabaseHas('genres', ['name' => 'Ciencia Ficción']);
});

test('admin can see edit genre form', function () {
    $this->withoutExceptionHandling();
    $admin = createAdminForGenre();
    $genre = Genre::factory()->create();

    $response = $this->actingAs($admin)->get(route('admin.genres.edit', $genre));

    $response->assertStatus(200);
});

test('admin can update a genre', function () {
    $admin = createAdminForGenre();
    $genre = Genre::factory()->create();

    $response = $this->actingAs($admin)->put(route('admin.genres.update', $genre), [
        'name' => 'Terror Updated'
    ]);

    $response->assertRedirect(route('admin.genres.index'));

    $this->assertDatabaseHas('genres', [
        'id' => $genre->id,
        'name' => 'Terror Updated'
    ]);
});

test('admin can delete a genre', function () {
    $admin = createAdminForGenre();
    $genre = Genre::factory()->create();

    $response = $this->actingAs($admin)->delete(route('admin.genres.destroy', $genre));

    $response->assertRedirect(route('admin.genres.index'));
    $this->assertDatabaseMissing('genres', ['id' => $genre->id]);
});
