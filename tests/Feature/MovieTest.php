<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Director;
use App\Models\Actor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

// --- AYUDAS ---
function createAdmin() {
    // Creamos el rol si no existe para evitar duplicados
    $role = Role::firstOrCreate(['name' => 'admin']);
    return User::factory()->create(['role_id' => $role->id]);
}

// --- TESTS ---

test('admin can see the movies list (index)', function () {
    $admin = createAdmin();
    // Necesitamos crear datos relacionados para evitar errores al cargar la vista
    $director = Director::factory()->create();
    Movie::factory()->count(3)->create(['director_id' => $director->id]);

    $response = $this->actingAs($admin)->get(route('movies.index'));

    $response->assertStatus(200);
    $response->assertViewIs('admin.movies.index');
    $response->assertViewHas('movies');
});

test('admin can see the create form', function () {
    $admin = createAdmin();

    $response = $this->actingAs($admin)->get(route('movies.create'));

    $response->assertStatus(200);
    $response->assertViewIs('admin.movies.create');
    // Verificamos que se pasen las variables necesarias para los select
    $response->assertViewHas(['genres', 'directors', 'actors']);
});

test('admin can store a new movie with relationships and image', function () {
    $admin = createAdmin();
    Storage::fake('public');

    // Datos previos necesarios
    $director = Director::factory()->create();
    $genre = Genre::factory()->create();
    $actor = Actor::factory()->create();

    $response = $this->actingAs($admin)->post(route('movies.store'), [
        // Campos obligatorios según tu MovieRequest
        'title'       => 'Inception',
        'year'        => '2010',
        'description' => 'Un sueño dentro de un sueño.',
        'duration'    => 148,
        'age_rating'  => 12,
        'country'     => 'USA',
        'director_id' => $director->id,

        // Relaciones (arrays)
        'genres'      => [$genre->id],
        'actors'      => [$actor->id],

        // Archivo
        'poster'      => UploadedFile::fake()->image('poster.jpg')
    ]);

    // Redirección según tu controlador
    $response->assertRedirect(route('movies.index'));
    $response->assertSessionHas('success');

    // Verificar BD
    $this->assertDatabaseHas('movies', [
        'title' => 'Inception',
        'director_id' => $director->id
    ]);

    // Verificar que se guardó el archivo
    $movie = Movie::where('title', 'Inception')->first();
    expect($movie->poster)->not->toBeNull();
    Storage::disk('public')->assertExists($movie->poster);

    // Verificar relaciones (Pivot tables)
    // Asumiendo que las tablas pivot siguen la convención de Laravel
    $this->assertDatabaseHas('genre_movie', [
        'movie_id' => $movie->id,
        'genre_id' => $genre->id
    ]);
});

test('admin can see the edit form', function () {
    $admin = createAdmin();
    $director = Director::factory()->create();
    $movie = Movie::factory()->create(['director_id' => $director->id]);

    $response = $this->actingAs($admin)->get(route('movies.edit', $movie));

    $response->assertStatus(200);
    $response->assertViewIs('admin.movies.edit');
});

test('admin can update a movie', function () {
    $admin = createAdmin();
    Storage::fake('public');

    $director = Director::factory()->create();
    $movie = Movie::factory()->create(['director_id' => $director->id]);

    // Nuevos datos
    $newDirector = Director::factory()->create();

    $response = $this->actingAs($admin)->put(route('movies.update', $movie), [
        'title'       => 'Inception Updated',
        'year'        => '2011',
        'description' => 'Descripcion actualizada',
        'duration'    => 150,
        'age_rating'  => 16,
        'country'     => 'UK',
        'director_id' => $newDirector->id,
        // Enviamos arrays vacíos para probar desvinculación o llenos para probar cambio
        'genres'      => [],
        'actors'      => [],
        // No enviamos poster para ver si mantiene el viejo o no falla
    ]);

    $response->assertRedirect(route('movies.index'));

    $this->assertDatabaseHas('movies', [
        'id' => $movie->id,
        'title' => 'Inception Updated',
        'director_id' => $newDirector->id
    ]);
});

test('admin can delete a movie', function () {
    $admin = createAdmin();
    $director = Director::factory()->create();
    $movie = Movie::factory()->create(['director_id' => $director->id]);

    $response = $this->actingAs($admin)->delete(route('movies.destroy', $movie));

    $response->assertRedirect(route('movies.index'));
    $this->assertDatabaseMissing('movies', ['id' => $movie->id]);
});
