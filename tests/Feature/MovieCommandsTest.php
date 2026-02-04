<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('los comandos de movies funcionan', function () {
    \App\Models\Director::factory()->create();
    \App\Models\Movie::factory()->create(['director_id' => 1]);

    $this->artisan('movies:stats')->assertExitCode(0);
    $this->artisan('movies:clean')->assertExitCode(0);
    $this->artisan('movies:top')->assertExitCode(0);



});
