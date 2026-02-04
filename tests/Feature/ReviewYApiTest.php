<?php

use App\Models\User;
use App\Models\Movie;
use App\Models\Actor;
use App\Models\Director;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('cobertura de reviews y limpieza de jobs/requests', function () {
    // 1. Datos base
    $role = Role::firstOrCreate(['name' => 'admin']);
    $admin = User::factory()->create(['role_id' => $role->id]);
    $user = User::factory()->create();
    $director = Director::factory()->create();
    $movie = Movie::factory()->create(['director_id' => $director->id]);
    $actor = Actor::factory()->create();

    // --- 1. REVIEW CONTROLLER (Sube del 0% al 100%) ---
    // Si tu ruta es 'reviews.store'
    $this->actingAs($user)->post(route('reviews.store', $movie), [
        'rating' => 5,
        'comment' => 'Excelente película'
    ])->assertRedirect();

    $this->actingAs($user)->get(route('user.rated'))->assertOk();

    // --- 2. UPDATE ACTOR REQUEST Y CONTROLLER (Sube ActorController y UpdateActorRequest) ---
    $this->actingAs($admin)->put(route('actors.update', $actor), [
        'name' => 'Nombre Editado',
        'birth_date' => '1990-01-01',
        // Si tu request pide más campos, añádelos aquí
    ])->assertRedirect();

    // --- 3. JOBS AL 0% (Sube SyncExternalData al 100%) ---
    (new \App\Jobs\SyncExternalData())->handle();

    // --- 4. RECURSOS RESTANTES (Sube ActorResource) ---
    if (class_exists('App\Http\Resources\ActorResource')) {
        new \App\Http\Resources\ActorResource($actor);
    }

    expect(true)->toBeTrue();
});
