<?php

use App\Models\User;
use App\Models\Movie;
use App\Models\Review;
use App\Models\Director;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('flujo completo de reseñas para maximizar cobertura', function () {
    $this->withoutExceptionHandling();
    $adminRole = Role::firstOrCreate(['name' => 'admin']);
    $admin = User::factory()->create(['role_id' => $adminRole->id]);
    $user = User::factory()->create();
    $movie = Movie::factory()->create(['director_id' => Director::factory()]);

    $this->actingAs($user)->post(route('reviews.store', $movie), [
        'rating' => 5,
        'content' => 'Excelente película, me ha encantado el final.'
    ])->assertRedirect();

    $this->assertDatabaseHas('reviews', ['content' => 'Excelente película, me ha encantado el final.']);


    $review = Review::first();
    $this->actingAs($admin)->delete(route('reviews.destroy', $review))->assertRedirect();

    $this->assertDatabaseMissing('reviews', ['id' => $review->id]);
});
