<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Campo para Directores
        Schema::table('directors', function (Blueprint $table) {
            $table->float('score')->default(0)->after('name');
        });

        // Campo para Actores
        Schema::table('actors', function (Blueprint $table) {
            $table->float('score')->default(0)->after('name');
        });

        // Campo para Usuarios
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('last_login_at')->nullable()->after('remember_token');
        });
    }

    public function down(): void
    {
        Schema::table('directors', function (Blueprint $table) { $table->dropColumn('score'); });
        Schema::table('actors', function (Blueprint $table) { $table->dropColumn('score'); });
        Schema::table('users', function (Blueprint $table) { $table->dropColumn('last_login_at'); });
    }
};
