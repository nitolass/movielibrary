<?php

use App\Admin\Users\Controllers\ProfileController;
use App\Admin\Users\Controllers\UserController;
use App\Http\Controllers\Admin\ActorController;
use App\Http\Controllers\Admin\DirectorController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\PublicCatalogController; // Asegúrate de que este archivo existe
use App\Http\Controllers\UserDashboardController; // Asegúrate de que este archivo existe
use App\Http\Middleware\IsAdminUserMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// 1. RUTA PÚBLICA (Landing Page)
Route::get('/', function () {
    return view('welcome');
});

// GRUPO GENERAL (Usuarios logueados)
Route::middleware(['auth', 'verified'])->group(function () {

    // -----------------------------------------------------------
    // 2. ZONA USUARIO (PEPE)
    // -----------------------------------------------------------

    // ✅ DASHBOARD DE USUARIO (Ruta específica)
    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');


    // Catálogo y Ficha (Público/Cliente)
    Route::controller(PublicCatalogController::class)->group(function () {
        Route::get('/catalogo', 'catalogo')->name('user.movies.index');
        Route::get('/pelicula/{movie}', 'show')->name('user.movies.show');
        Route::get('/unete', 'prompt')->name('public.prompt');
    });

    // Biblioteca Personal
    Route::controller(UserDashboardController::class)->group(function () {
        Route::get('/mis-favoritos', 'favorites')->name('user.favorites');
        Route::get('/ver-mas-tarde', 'watchLater')->name('user.watch_later');
        Route::get('/puntuadas', 'rated')->name('user.rated');
        Route::get('/historial', 'watched')->name('user.watched');
    });

    // Perfil (Común)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // -----------------------------------------------------------
    // 3. ZONA ADMIN (JUAN)
    // -----------------------------------------------------------
    Route::middleware([IsAdminUserMiddleware::class])->group(function () {

        // ✅ DASHBOARD DE ADMIN (Ruta específica)
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');


        // CRUD de Películas (Admin)
        Route::prefix('movies')->name('movies.')->group(function(){
            Route::get('/', [MovieController::class, 'index'])->name('index');
            Route::get('/create', [MovieController::class, 'create'])->name('create');
            Route::post('/store', [MovieController::class, 'store'])->name('store');
            Route::get('/{movie}/edit', [MovieController::class, 'edit'])->name('edit');
            Route::put('/{movie}', [MovieController::class, 'update'])->name('update');
            Route::delete('/{movie}', [MovieController::class, 'destroy'])->name('destroy');
            Route::get('/{movie}', [MovieController::class, 'show'])->name('show');
        });

        // CRUD de Usuarios
        Route::prefix('users')->name('admin.users.')->group(function(){
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/store', [UserController::class, 'store'])->name('store');
        });

        // CRUD de Géneros
        Route::prefix('admin/genres')->name('admin.genres.')->group(function () {
            Route::get('/', [GenreController::class, 'index'])->name('index');
            Route::get('/create', [GenreController::class, 'create'])->name('create');
            Route::post('/', [GenreController::class, 'store'])->name('store');
            Route::get('/{genre}/edit', [GenreController::class, 'edit'])->name('edit');
            Route::put('/{genre}', [GenreController::class, 'update'])->name('update');
            Route::delete('/{genre}', [GenreController::class, 'destroy'])->name('destroy');
        });

        // CRUD de Directores
        Route::prefix('directors')->name('directors.')->group(function(){
            Route::get('/', [DirectorController::class, 'index'])->name('index');
            Route::get('/create', [DirectorController::class, 'create'])->name('create');
            Route::post('/store', [DirectorController::class, 'store'])->name('store');
            Route::get('/{director}', [DirectorController::class, 'show'])->name('show');
            Route::get('/{director}/edit', [DirectorController::class, 'edit'])->name('edit');
            Route::put('/{director}', [DirectorController::class, 'update'])->name('update');
            Route::delete('/{director}', [DirectorController::class, 'destroy'])->name('destroy');
        });

        // CRUD de Actores
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
