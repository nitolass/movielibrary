<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('genre_id')->constrained();
            $table->string('title');
            $table->string('description');
            $table->string('year');
            $table->integer('duration')->comment('duration in minutes');
            $table->integer('age_rating');
            $table->string('country');
            $table->string('poster');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movies');
    }
};
