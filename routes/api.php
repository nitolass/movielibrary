<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\DirectorController;

// Rutas públicas
Route::post('/login', [AuthController::class, 'login']);

Route::get('/directors', [DirectorController::class, 'index']);
Route::get('/directors/{director}', [DirectorController::class, 'show']);


// Rutas protegidas
Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('movies', MovieController::class);

    Route::apiResource('genres', GenreController::class);
});
