<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\DirectorController;
use App\Http\Controllers\Api\ActorController;

Route::name('api.')->group(function () {

    // --- RUTAS PÚBLICAS ---

    // Auth
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    // Lectura pública (opcional, si quieres que cualquiera vea el catálogo)
    Route::get('/directors', [DirectorController::class, 'index'])->name('directors.index');
    Route::get('/directors/{director}', [DirectorController::class, 'show'])->name('directors.show');

    Route::get('/actors', [ActorController::class, 'index'])->name('actors.index');
    Route::get('/actors/{actor}', [ActorController::class, 'show'])->name('actors.show');


    Route::middleware(['auth:sanctum'])->group(function () {

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/user', function (Request $request) {
            return $request->user();
        })->name('user');

        Route::apiResource('movies', MovieController::class);
        Route::apiResource('genres', GenreController::class);

        Route::post('/actors', [ActorController::class, 'store'])->name('actors.store');
        Route::post('/directors', [DirectorController::class, 'store'])->name('directors.store');

    });
});
