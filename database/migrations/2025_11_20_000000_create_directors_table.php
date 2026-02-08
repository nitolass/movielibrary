<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('directors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('biography')->nullable();

            // CORRECCIÓN: Usamos 'date' para que acepte "1990-05-20"
            $table->date('birth_date')->nullable();

            $table->string('nationality')->nullable();
            $table->string('photo')->nullable();

            // CAMPOS QUE ESTABAN EN LOS OTROS ARCHIVOS (INTEGRADOS AQUÍ)
            $table->boolean('is_active')->default(true);
            $table->decimal('score', 3, 1)->default(0); // Usamos decimal para notas (ej: 8.5)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('directors');
    }
};
