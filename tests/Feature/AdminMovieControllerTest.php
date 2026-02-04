<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Director;
use App\Models\Actor;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    Storage::fake('public');
    // Preparamos al admin para todos los tests
    $this->adminRole = Role::firstOrCreate(['name' => 'admin']);
    $this->admin = User::factory()->create(['role_id' => $this->adminRole->id]);
});

test('un administrador puede ver el listado completo de películas', function () {
    $this->withoutExceptionHandling();
    Movie::factory()->count(3)->create(['director_id' => Director::factory()]);

    $response = $this->actingAs($this->admin)
        ->get(route('movies.index', ['search' => '']));

    $response->assertStatus(200)
        ->assertViewIs('admin.movies.index')
        ->assertViewHas('movies');
});

test('un administrador puede ver el formulario de creación', function () {
    $response = $this->actingAs($this->admin)
        ->get(route('movies.create'));

    $response->assertStatus(200)
        ->assertViewHasAll(['genres', 'directors', 'actors']);
});

test('un administrador puede registrar una película con todos sus campos y relaciones', function () {
    $director = Director::factory()->create();
    $genres = Genre::factory()->count(2)->create();
    $actors = Actor::factory()->count(2)->create();
    $poster = UploadedFile::fake()->image('poster_estreno.jpg');

    $movieData = [
        'title' => 'Pelicula de Prueba 85',
        'description' => 'Una descripción detallada para asegurar que el coverage cubra el modelo y el request.',
        'year' => 2024,
        'duration' => 120,
        'director_id' => $director->id,
        'genres' => $genres->pluck('id')->toArray(),
        'actors' => $actors->pluck('id')->toArray(),
        'poster' => $poster,
    ];

    $response = $this->actingAs($this->admin)
        ->post(route('movies.store'), $movieData);

    $response->assertRedirect(route('movies.index'));

    // Verificamos DB y relaciones
    $this->assertDatabaseHas('movies', ['title' => 'Pelicula de Prueba 85']);
    $movie = Movie::where('title', 'Pelicula de Prueba 85')->first();
    expect($movie->genres)->toHaveCount(2);
    expect($movie->actors)->toHaveCount(2);

    // Verificamos que el poster se guardó físicamente
    Storage::disk('public')->assertExists($movie->poster);
});

test('un administrador puede ver el detalle de una película específica', function () {
    $movie = Movie::factory()->create(['director_id' => Director::factory()]);

    $response = $this->actingAs($this->admin)
        ->get(route('movies.show', $movie));

    $response->assertStatus(200)
        ->assertViewIs('admin.movies.show')
        ->assertViewHas('movie');
});

test('un administrador puede actualizar una película y cambiar el poster', function () {
    $movie = Movie::factory()->create(['director_id' => Director::factory()]);
    $newGenre = Genre::factory()->create();
    $newPoster = UploadedFile::fake()->image('nuevo_poster.jpg');

    $updateData = [
        'title' => 'Título Editado',
        'description' => 'Nueva descripción actualizada.',
        'year' => 2025,
        'duration' => 130,
        'director_id' => $movie->director_id,
        'genres' => [$newGenre->id],
    ];

    $response = $this->actingAs($this->admin)
        ->put(route('movies.update', $movie), array_merge($updateData, ['poster' => $newPoster]));

    $response->assertRedirect(route('movies.index'));
    $this->assertDatabaseHas('movies', ['title' => 'Título Editado']);
});

test('un administrador puede eliminar una película y su poster desaparece del disco', function () {
    $movie = Movie::factory()->create([
        'director_id' => Director::factory(),
        'poster' => 'posters/test_image.jpg'
    ]);
    Storage::disk('public')->put('posters/test_image.jpg', 'fake content');

    $response = $this->actingAs($this->admin)
        ->delete(route('movies.destroy', $movie));

    $response->assertRedirect(route('movies.index'));
    $this->assertDatabaseMissing('movies', ['id' => $movie->id]);
    Storage::disk('public')->assertMissing('posters/test_image.jpg');
});
