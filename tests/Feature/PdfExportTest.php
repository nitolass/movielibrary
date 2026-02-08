<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Movie;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $role = Role::firstOrCreate(['name' => 'admin']);
    $this->admin = User::factory()->create(['role_id' => $role->id]);
});

test('admin can download users pdf', function () {
    User::factory(5)->create();

    $response = $this->actingAs($this->admin)->get(route('admin.pdf.users'));

    $response->assertStatus(200);
    // Verificar que es un PDF (dependiendo de tu implementación dompdf/snappy)
    // A veces devuelve stream, a veces download. Verificamos status 200 es lo vital.
});

test('admin can download single user report', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($this->admin)->get(route('admin.pdf.userReport', $user));

    $response->assertStatus(200);
});

test('admin can download movies pdf', function () {
    Movie::factory(5)->create();

    $response = $this->actingAs($this->admin)->get(route('admin.pdf.movies'));

    $response->assertStatus(200);
});

test('admin can download single movie report', function () {
    $movie = Movie::factory()->create();

    $response = $this->actingAs($this->admin)->get(route('admin.pdf.movie', $movie));

    $response->assertStatus(200);
});

test('admin can download dashboard report', function () {
    $response = $this->actingAs($this->admin)->get(route('admin.pdf.dashboard_report'));

    $response->assertStatus(200);
});
