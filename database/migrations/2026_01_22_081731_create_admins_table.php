<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $rolAdmin = \App\Models\Role::create(['name' => 'admin']);
        $rolUser  = \App\Models\Role::create(['name' => 'user']);
        $rolMantenimiento = \App\Models\Role::create(['name' => 'manteinance']);

        $usuario = \App\Models\User::create(['name'=>'admin',
            'email'=>'juan@admin.es',
            'surname'=>'admin surname',
            'password'=>bcrypt('12345678')]);
        $usuario->role_id = $rolAdmin->id;
        $usuario->save();
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
