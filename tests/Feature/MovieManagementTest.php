<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Director;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('un administrador puede crear una pelicula con todos los campos obligatorios', function () {
    Storage::fake('public');

    $role = Role::firstOrCreate(['name' => 'admin']);
    $admin = User::factory()->create(['role_id' => $role->id]);
    $director = Director::factory()->create();
    $genre = Genre::factory()->create();

    // Enviamos el array con las claves exactas que espera tu DB y tu Request
    $response = $this->actingAs($admin)->post(route('movies.store'), [
        'title'       => 'Inception',
        'description' => 'Un thriller de ciencia ficción sobre el robo de secretos en sueños.',
        'year'        => 2010,
        'duration'    => 148,
        'director_id' => $director->id,
        'genres'      => [$genre->id], // Asegúrate de que sea un array
        'poster'      => UploadedFile::fake()->image('poster.jpg'),
    ]);


    $response->assertRedirect(route('movies.index'));
    $this->assertDatabaseHas('movies', ['title' => 'Inception']);
});
