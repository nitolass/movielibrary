<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user store request validation', function () {
    $admin = App\Models\User::factory()->create(['role_id' => 1]); // Asume que ID 1 es admin

    $this->actingAs($admin)
        ->postJson('/api/users', [
            'name' => '',
            'email' => 'not-an-email',
            'password' => '123'
        ])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['name', 'email', 'password']);
});
