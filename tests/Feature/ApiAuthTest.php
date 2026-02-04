<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('un usuario puede loguearse en la api y obtener un token', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => Hash::make('password123'),
    ]);

    $response = $this->postJson('/api/login', [
        'email' => 'test@example.com',
        'password' => 'password123',
    ]);

    $response->assertStatus(200);

    // Cambiamos 'token' por 'access_token' que es lo que devuelve tu controlador
    $response->assertJsonStructure([
        'message',
        'access_token',
        'token_type',
        'user'
    ]);
});

test('un usuario puede cerrar sesión en la api', function () {
    $user = User::factory()->create();

    $token = $user->createToken('test-token')->plainTextToken;

    $response = $this->withHeader('Authorization', 'Bearer ' . $token)
        ->postJson('/api/logout');

    $response->assertStatus(200);

    $this->assertCount(0, $user->tokens);
});
