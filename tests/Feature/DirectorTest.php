<?php

use App\Models\User;
use App\Models\Role;
use App\Models\Director;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function createAdminForDirector() {
    $role = Role::firstOrCreate(['name' => 'admin']);
    return User::factory()->create(['role_id' => $role->id]);
}

test('admin can list directors', function () {
    $admin = createAdminForDirector();
    Director::factory()->count(3)->create();

    $response = $this->actingAs($admin)->get(route('directors.index'));
    $response->assertStatus(200);
});

test('admin can create a director', function () {
    $admin = createAdminForDirector();

    $response = $this->actingAs($admin)->post(route('directors.store'), [
        'name' => 'Quentin',
        'surname' => 'Tarantino',
    ]);

    $response->assertRedirect(route('directors.index'));
    $this->assertDatabaseHas('directors', ['name' => 'Quentin']);
});

test('admin can delete a director', function () {
    $admin = createAdminForDirector();
    $director = Director::factory()->create();

    $response = $this->actingAs($admin)->delete(route('directors.destroy', $director));

    $response->assertRedirect(route('directors.index'));
    $this->assertDatabaseMissing('directors', ['id' => $director->id]);
});
test('admin can see the create director form', function () {
    $admin = createAdminForDirector();
    $response = $this->actingAs($admin)->get(route('directors.create'));
    $response->assertStatus(200);
});

test('admin can see the edit director form', function () {
    $admin = createAdminForDirector();
    $director = Director::factory()->create();

    $response = $this->actingAs($admin)->get(route('directors.edit', $director));
    $response->assertStatus(200);
});
test('admin can see create director form', function () {
    $admin = createAdminForDirector();
    $response = $this->actingAs($admin)->get(route('directors.create'));
    $response->assertStatus(200);
});

test('admin can see edit director form', function () {
    $admin = createAdminForDirector();
    $director = \App\Models\Director::factory()->create();

    $response = $this->actingAs($admin)->get(route('directors.edit', $director));
    $response->assertStatus(200);
});
