<?php

use App\Models\{User, Review, Movie, Role};
use App\Http\Controllers\Api\AuthController;
use App\Livewire\UserReviews;
use Livewire\Livewire;
use Illuminate\Support\Facades\Hash;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('auth controller coverage booster', function () {
    $role = Role::firstOrCreate(['name' => 'admin']);
    $user = User::factory()->create(['email' => 'test@test.com', 'password' => Hash::make('password123'), 'role_id' => $role->id]);

    // 1. Login Fallido (Cubre el 401)
    $this->postJson('/api/login', ['email' => 'test@test.com', 'password' => 'wrong'])
        ->assertStatus(401);

    // 2. Registro con fallos (Cubre validación)
    $this->postJson('/api/register', [])->assertStatus(422);

    // 3. Logout
    $token = $user->createToken('test')->plainTextToken;
    $this->withHeader('Authorization', 'Bearer ' . $token)
        ->postJson('/api/logout')
        ->assertStatus(200);
});

test('user reviews component complete flow', function () {
    $user = User::factory()->create();
    $movie = Movie::factory()->create();
    $review = Review::factory()->create(['user_id' => $user->id, 'movie_id' => $movie->id]);

    Livewire::actingAs($user)
        ->test(UserReviews::class)
        // 1. Entrar en modo edición
        ->call('edit', $review->id)
        ->assertSet('isEditing', true)
        // 2. Cancelar edición
        ->call('cancel')
        ->assertSet('isEditing', false)
        // 3. Update exitoso
        ->call('edit', $review->id)
        ->set('content', 'Nuevo contenido validado')
        ->set('rating', 5)
        ->call('update')
        ->assertHasNoErrors()
        // 4. Borrar
        ->call('delete', $review->id);

    $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
}); ;
