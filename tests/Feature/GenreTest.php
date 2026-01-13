<?php

use App\Models\Genre;
use App\Models\Role;
use App\Models\User;
use function Pest\Laravel\{actingAs, get, post, put, delete, assertDatabaseHas, assertDatabaseMissing};

beforeEach(function () {
    // 1. Aseguramos que existe el rol admin
    $role = Role::firstOrCreate(['name' => 'admin']);

    // 2. Creamos un usuario con ese rol
    $this->adminUser = User::factory()->create([
        'role_id' => $role->id
    ]);

    // 3. Nos logueamos como admin
    actingAs($this->adminUser);
});

it('puede listar los géneros (como admin)', function () {
    Genre::factory()->count(3)->create();

    // Tu ruta es admin.genres.index
    get(route('admin.genres.index'))
        ->assertStatus(200);
});

it('puede crear un nuevo género', function () {
    $this->withoutExceptionHandling();
    $data = [
        'name' => 'Ciencia Ficción',
        'description' => 'Futuro y espacio.'
    ];

    post(route('admin.genres.store'), $data)
        ->assertRedirect(route('admin.genres.index'));

    assertDatabaseHas('genres', ['name' => 'Ciencia Ficción']);
});

it('puede actualizar un género', function () {
    $this->withoutExceptionHandling();

    $genre = Genre::factory()->create();

    $updatedData = [
        'name' => 'Terror',
        'description' => 'Miedo actualizado.'
    ];

    put(route('admin.genres.update', $genre), $updatedData)
        ->assertRedirect(route('admin.genres.index'));

    assertDatabaseHas('genres', ['id' => $genre->id, 'name' => 'Terror']);
});

it('puede eliminar un género', function () {
    $genre = Genre::factory()->create();

    delete(route('admin.genres.destroy', $genre))
        ->assertRedirect(route('admin.genres.index'));

    assertDatabaseMissing('genres', ['id' => $genre->id]);
});
