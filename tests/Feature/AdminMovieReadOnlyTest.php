<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Movie;
use App\Models\Director;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('cobertura lectura movie controller', function () {
    $role = Role::firstOrCreate(['name' => 'admin']);
    $admin = User::factory()->create(['role_id' => $role->id]);
    $movie = Movie::factory()->create(['director_id' => Director::factory()]);

    $this->actingAs($admin)->get(route('movies.index'))->assertOk();
    $this->actingAs($admin)->get(route('movies.show', $movie))->assertOk();
    $this->actingAs($admin)->get(route('movies.edit', $movie))->assertOk();
});
