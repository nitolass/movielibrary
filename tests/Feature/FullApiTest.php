<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Movie;
use App\Models\Director;
use App\Models\Actor;
use App\Models\Genre;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

// --- SETUP INICIAL ---
beforeEach(function () {
    // Creamos un Admin para poder probar las rutas protegidas
    $role = Role::firstOrCreate(['name' => 'admin']);
    $this->admin = User::factory()->create([
        'role_id' => $role->id,
        'password' => bcrypt('password'), // Fijamos password para test de login
        'email' => 'admin@api.com'
    ]);
});

// =========================================================================
// 1. TEST DE AUTENTICACIÓN (LOGIN/LOGOUT)
// =========================================================================
test('api login works', function () {
    // Probamos la ruta pública de login
    $response = $this->postJson('/api/login', [
        'email' => 'admin@api.com',
        'password' => 'password'
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure(['access_token']); // <--- CORREGIDO
});

test('api logout works', function () {
    Sanctum::actingAs($this->admin);

    $response = $this->postJson('/api/logout');

    $response->assertStatus(200);
});

test('api user profile works', function () {
    Sanctum::actingAs($this->admin);

    $response = $this->getJson('/api/user');

    $response->assertStatus(200)
        ->assertJsonFragment(['email' => 'admin@api.com']);
});


// =========================================================================
// 2. TEST DE RUTAS PÚBLICAS (Lectura sin Token)
// =========================================================================

test('public api lists (index) work without token', function () {
    $this->withoutExceptionHandling();
    // Creamos datos dummy
    Director::factory()->create();
    Actor::factory()->create();
    Genre::factory()->create();
    Movie::factory()->create();

    // Probamos que se pueden ver sin estar logueado (Sanctum no activo aquí)
    $this->getJson('/api/directors')->assertStatus(200);
    $this->getJson('/api/actors')->assertStatus(200);
    $this->getJson('/api/genres')->assertStatus(200);
    $this->getJson('/api/movies')->assertStatus(200);
});

test('public api details (show) work without token', function () {
    $director = Director::factory()->create();
    $actor = Actor::factory()->create();
    $genre = Genre::factory()->create();
    $movie = Movie::factory()->create();

    $this->getJson("/api/directors/{$director->id}")->assertStatus(200);
    $this->getJson("/api/actors/{$actor->id}")->assertStatus(200);
    $this->getJson("/api/genres/{$genre->id}")->assertStatus(200);
    $this->getJson("/api/movies/{$movie->id}")->assertStatus(200);
});


// =========================================================================
// 3. TEST DE RUTAS PROTEGIDAS (Escritura con Token de Admin)
// =========================================================================

test('api users crud (protected)', function () {
    $this->withoutExceptionHandling();
    Sanctum::actingAs($this->admin);

    // Index
    $this->getJson('/api/users')->assertStatus(200);

    // Store
    $role = Role::firstOrCreate(['name' => 'user']);
    $response = $this->postJson('/api/users', [
        'name' => 'New API User',
        'surname' => 'User', // Ahora sí validado
        'email' => 'newapi@test.com',
        'password' => '12345678',
        'role_id' => $role->id
    ]);
    $response->assertStatus(201); // Created

    // Update
    $user = User::factory()->create();
    $this->putJson("/api/users/{$user->id}", [
        'name' => 'Updated Name',
        'surname' => 'Up',
        'email' => $user->email,
        'role_id' => $role->id
    ])->assertStatus(200);

    // Destroy
    // CAMBIO AQUÍ: assertStatus(204) en lugar de 200
    $this->deleteJson("/api/users/{$user->id}")->assertStatus(204);
});

test('api movies write operations (protected)', function () {
    Sanctum::actingAs($this->admin);
    $director = Director::factory()->create();
    $genre = Genre::factory()->create();

    // Store
    $response = $this->postJson('/api/movies', [
        'title' => 'API Movie',
        'year' => 2024,
        'duration' => 120,
        'description' => 'Test',
        'director_id' => $director->id,
        'genre_id' => $genre->id // Si tu validación lo requiere
    ]);
    // A veces create devuelve 201, a veces 200, ajusta si falla
    $response->assertSuccessful();

    // Update
    $movie = Movie::factory()->create();
    $this->putJson("/api/movies/{$movie->id}", [
        'title' => 'Updated API Movie',
        'year' => 2025,
        'duration' => 130,
        'director_id' => $director->id
    ])->assertStatus(200);

    // Destroy
    $this->deleteJson("/api/movies/{$movie->id}")->assertStatus(204);
});

test('api directors write operations (protected)', function () {
    Sanctum::actingAs($this->admin);

    // Store
    $this->postJson('/api/directors', [
        'name' => 'API Director',
        'nationality' => 'USA',
        'birth_date' => '1980-01-01'
    ])->assertSuccessful();

    // Update
    $director = Director::factory()->create();
    $this->putJson("/api/directors/{$director->id}", ['name' => 'Updated Dir'])
        ->assertStatus(200);

    // Destroy
    $this->deleteJson("/api/directors/{$director->id}")->assertStatus(200);
});

test('api actors write operations (protected)', function () {
    Sanctum::actingAs($this->admin);

    // Store
    $this->postJson('/api/actors', [
        'name' => 'API Actor',
        'nationality' => 'USA',
        'birth_date' => '1990-01-01'
    ])->assertSuccessful();

    // Update
    $actor = Actor::factory()->create();
    $this->putJson("/api/actors/{$actor->id}", ['name' => 'Updated Actor'])
        ->assertStatus(200);

    // Destroy
    $this->deleteJson("/api/actors/{$actor->id}")->assertStatus(200);
});

test('api genres write operations (protected)', function () {
    Sanctum::actingAs($this->admin);

    // Store
    $this->postJson('/api/genres', ['name' => 'API Genre'])->assertSuccessful();

    // Update
    $genre = Genre::factory()->create();
    $this->putJson("/api/genres/{$genre->id}", ['name' => 'Updated Genre'])->assertStatus(200);

    // Destroy
    $this->deleteJson("/api/genres/{$genre->id}")->assertStatus(200);
});

test('api reviews crud (protected)', function () {
    Sanctum::actingAs($this->admin);

    $movie = Movie::factory()->create();

    // Store
    $response = $this->postJson('/api/reviews', [
        'user_id' => $this->admin->id,
        'movie_id' => $movie->id,
        'rating' => 5,
        'content' => 'Great movie'
    ]);
    $response->assertSuccessful();

    // Creamos una reseña para editar/borrar
    $review = Review::create([
        'user_id' => $this->admin->id,
        'movie_id' => $movie->id,
        'rating' => 4,
        'content' => 'Old content'
    ]);

    // Update
    $this->putJson("/api/reviews/{$review->id}", [
        'rating' => 3,
        'content' => 'Updated content',
        'user_id' => $this->admin->id,
        'movie_id' => $movie->id
    ])->assertStatus(200);

    // Destroy
    $this->deleteJson("/api/reviews/{$review->id}")->assertStatus(200);
});
