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

    // Lectura pública (index y show)
    // Se definen fuera del grupo middleware auth:sanctum
    Route::get('/directors', [DirectorController::class, 'index']);
    Route::get('/directors/{director}', [DirectorController::class, 'show']);

    Route::get('/actors', [ActorController::class, 'index']);
    Route::get('/actors/{actor}', [ActorController::class, 'show']);

    Route::get('/movies', [MovieController::class, 'index']);
    Route::get('/movies/{movie}', [MovieController::class, 'show']);


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
        Route::apiResource('genres', GenreController::class);
        Route::apiResource('actors', ActorController::class)->except(['index', 'show']);
        Route::apiResource('directors', DirectorController::class)->except(['index', 'show']);
        Route::apiResource('reviews', \App\Http\Controllers\Api\ReviewController::class);

    });
});
