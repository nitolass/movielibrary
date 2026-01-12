<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Director;

class DirectorSeeder extends Seeder
{
    public function run(): void
    {
        Director::factory()->count(10)->create();
    }
}
