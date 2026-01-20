<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('directors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('biography')->nullable();
            $table->year('birth_year')->nullable();
            $table->string('nationality')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('directors');
    }
};
