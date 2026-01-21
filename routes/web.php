<?php

use App\Admin\Users\Controllers\ProfileController;
use App\Admin\Users\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ActorController;
use App\Http\Controllers\Admin\DirectorController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Middleware\IsAdminUserMiddleware;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    // Crud de perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Crud de peliculas
    Route::prefix('movies')->name('movies.')->group(function(){
        Route::get('/', [MovieController::class, 'index'])->name('index');
        Route::get('/{movie}', [MovieController::class, 'show'])->name('show');
    });


    Route::middleware([IsAdminUserMiddleware::class])->group(function () {
        // Crud de peliculas. (ADMIN)
        Route::prefix('movies')->name('movies.')->group(function(){
            Route::get('/create', [MovieController::class, 'create'])->name('create');
            Route::post('/store', [MovieController::class, 'store'])->name('store');
            Route::get('/{movie}/edit', [MovieController::class, 'edit'])->name('edit');
            Route::put('/{movie}', [MovieController::class, 'update'])->name('update');
            Route::delete('/{movie}', [MovieController::class, 'destroy'])->name('destroy');
        });

        // Crud de usuarios
        Route::prefix('users')->name('admin.users.')->group(function(){
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/store', [UserController::class, 'store'])->name('store');
        });

        // Crud de generos
        Route::prefix('admin/genres')->name('admin.genres.')->group(function () {
            Route::get('/', [GenreController::class, 'index'])->name('index');
            Route::get('/create', [GenreController::class, 'create'])->name('create');
            Route::post('/', [GenreController::class, 'store'])->name('store');
            Route::get('/{genre}/edit', [GenreController::class, 'edit'])->name('edit');
            Route::put('/{genre}', [GenreController::class, 'update'])->name('update');
            Route::delete('/{genre}', [GenreController::class, 'destroy'])->name('destroy');
        });

        // Crud de directores
        Route::prefix('directors')->name('directors.')->group(function(){
            Route::get('/', [DirectorController::class, 'index'])->name('index');
            Route::get('/create', [DirectorController::class, 'create'])->name('create');
            Route::post('/store', [DirectorController::class, 'store'])->name('store');
            Route::get('/{director}', [DirectorController::class, 'show'])->name('show');
            Route::get('/{director}/edit', [DirectorController::class, 'edit'])->name('edit');
            Route::put('/{director}', [DirectorController::class, 'update'])->name('update');
            Route::delete('/{director}', [DirectorController::class, 'destroy'])->name('destroy');
        });

        // Crud de actores
        Route::prefix('actors')->name('actors.')->group(function(){
            Route::get('/', [ActorController::class, 'index'])->name('index');
            Route::get('/create', [ActorController::class, 'create'])->name('create');
            Route::post('/store', [ActorController::class, 'store'])->name('store');
            Route::get('/{actor}/edit', [ActorController::class, 'edit'])->name('edit');
            Route::put('/{actor}', [ActorController::class, 'update'])->name('update');
            Route::delete('/{actor}', [ActorController::class, 'destroy'])->name('destroy');
            Route::get('/{actor}', [ActorController::class, 'show'])->name('show');
        });
    });
});

require __DIR__.'/auth.php';
