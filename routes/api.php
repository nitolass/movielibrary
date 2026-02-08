<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\DirectorController;
use App\Http\Controllers\Api\ActorController;
use App\Http\Controllers\Api\UserController;

Route::name('api.')->group(function () {

    // --- RUTAS PÚBLICAS ---
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::get('/directors', [DirectorController::class, 'index'])->name('directors.index');
    Route::get('/directors/{director}', [DirectorController::class, 'show'])->name('directors.show');

    Route::get('/actors', [ActorController::class, 'index'])->name('actors.index');
    Route::get('/actors/{actor}', [ActorController::class, 'show'])->name('actors.show');

    Route::get('/genres', [GenreController::class, 'index'])->name('genres.index');
    Route::get('/genres/{genre}', [GenreController::class, 'show'])->name('genres.show');

    Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
    Route::get('/movies/{movie}', [MovieController::class, 'show'])->name('movies.show');


    // --- RUTAS PROTEGIDAS (Requieren Token) ---
    Route::middleware(['auth:sanctum'])->group(function () {

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Perfil del usuario logueado
        Route::get('/user', function (Request $request) {
            return new \App\Http\Resources\UserResource($request->user());
        })->name('user.profile');

        // CRUD DE USUARIOS (El controlador protege que sea solo Admin)
        Route::apiResource('users', UserController::class);
        Route::apiResource('movies', MovieController::class)->except(['index', 'show']);
        Route::apiResource('genres', GenreController::class)-> except(['index', 'show']);
        Route::apiResource('actors', ActorController::class)->except(['index', 'show']);
        Route::apiResource('directors', DirectorController::class)->except(['index', 'show']);
        Route::apiResource('reviews', \App\Http\Controllers\Api\ReviewController::class);

    });
});
