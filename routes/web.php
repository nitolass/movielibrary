<?php

use App\Admin\Users\Controllers\ProfileController;
use App\Admin\Users\Controllers\UserController;
use App\Http\Controllers\Admin\DirectorController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Middleware\IsAdminUserMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//CRUD DE PERFIL
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//CRUD DE USUARIOS
Route::group(['prefix' => 'users'], function(){
    Route::get('/', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/store', [UserController::class, 'store'])->name('admin.users.store');
});

//CRUD DE GÉNEROS
Route::middleware(['auth', IsAdminUserMiddleware::class])
    ->prefix('admin/genres')
    ->name('admin.genres.')
    ->group(function () {

        Route::get('/', [GenreController::class, 'index'])->name('index');
        Route::get('/create', [GenreController::class, 'create'])->name('create');
        Route::post('/', [GenreController::class, 'store'])->name('store');
        Route::get('/{genre}/edit', [GenreController::class, 'edit'])->name('edit');
        Route::put('/{genre}', [GenreController::class, 'update'])->name('update');
        Route::delete('/{genre}', [GenreController::class, 'destroy'])->name('destroy');
    });

//CRUD DIRECTORES
Route::group(['prefix' => 'directors', 'middleware' => ['auth', IsAdminUserMiddleware::class]], function(){
    Route::get('/', [DirectorController::class, 'index'])->name('directors.index');
    Route::get('/create', [DirectorController::class, 'create'])->name('directors.create');
    Route::post('/store', [DirectorController::class, 'store'])->name('directors.store');
    Route::get('/{director}/edit', [DirectorController::class, 'edit'])->name('directors.edit');
    Route::put('/{director}', [DirectorController::class, 'update'])->name('directors.update');
    Route::delete('/{director}', [DirectorController::class, 'destroy'])->name('directors.destroy');
});


//CRUD DE ACTORES
Route::group(['prefix' => 'actors', 'middleware' => [IsAdminUserMiddleware::class, 'auth']], function(){
    Route::get('/', [ActorController::class, 'index'])->name('actors.index');
    Route::get('/create', [ActorController::class, 'create'])->name('actors.create');
    Route::post('/store', [ActorController::class, 'store'])->name('actors.store');
    Route::get('/{actor}/edit', [ActorController::class, 'edit'])->name('actors.edit');
    Route::put('/{actor}', [ActorController::class, 'update'])->name('actors.update');
    Route::delete('/{actor}', [ActorController::class, 'destroy'])->name('actors.destroy');
    Route::get('/{actor}', [ActorController::class, 'show'])->name('actors.show');
});

//CRUD PELICULAS
Route::group(['prefix' => 'movies'], function(){
    Route::get('/', [MovieController::class, 'index'])->name('movies.index');
    Route::get('/create', [MovieController::class, 'create'])->name('movies.create');
    Route::post('/store', [MovieController::class, 'store'])->name('movies.store');
    Route::get('/{movie}/edit', [MovieController::class, 'edit'])->name('movies.edit');
    Route::put('/{movie}', [MovieController::class, 'update'])->name('movies.update');
    Route::delete('/{movie}', [MovieController::class, 'destroy'])->name('movies.destroy');
    Route::get('/{movie}', [MovieController::class, 'show'])->name('movies.show');
})->middleware(['auth', IsAdminUserMiddleware::class]);



//RUTAS DE MIDDLEWARE
Route::middleware(IsAdminUserMiddleware::class)->group(function(){

    Route::get('superadmin', function(){
        return "Super Admin Area";
    });
})->middleware('auth');

Route::get('no-superadmin', function(){
    return "No Super Admin Area";
});

require __DIR__.'/auth.php';
