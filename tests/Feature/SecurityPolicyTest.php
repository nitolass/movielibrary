<?php

use App\Models\User;
use App\Models\Movie;
use App\Models\Director;

test('un usuario no administrador no puede borrar peliculas', function () {
    $user = User::factory()->create(); // Usuario normal
    $movie = Movie::factory()->create(['director_id' => Director::factory()]);

    // Este test activa el IsAdminUserMiddleware y la MoviePolicy (Unauthorized)
    $response = $this->actingAs($user)->delete(route('movies.destroy', $movie));

    // Debería ser redirigido o recibir un 403
    $response->assertStatus(403);
});
