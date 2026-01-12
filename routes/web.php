<?php

use App\Admin\Users\Controllers\ProfileController;
use App\Admin\Users\Controllers\UserController;
use App\Http\Controllers\Admin\ActorController;
use App\Http\Controllers\Admin\DirectorController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\MovieController;
// Asegúrate de importar tu controlador de Reviews cuando lo crees
// use App\Http\Controllers\ReviewController;
use App\Http\Middleware\IsAdminUserMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (No requiere iniciar sesión)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| RUTAS PRIVADAS (Requiere iniciar sesión)
|--------------------------------------------------------------------------
| Todas las rutas aquí dentro están protegidas. Si entras sin loguearte,
| te manda al login. Esto soluciona el error de la Sidebar.
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // --- DASHBOARD ---
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // --- PERFIL DE USUARIO ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- PELÍCULAS (MOVIES) ---
    // He quitado el middleware de Admin para que puedas verlas como usuario normal.
    // Si quieres que SOLO el admin pueda crear/borrar, avísame para separarlo.
    Route::prefix('movies')->name('movies.')->group(function(){
        Route::get('/', [MovieController::class, 'index'])->name('index');
        Route::get('/create', [MovieController::class, 'create'])->name('create');
        Route::post('/store', [MovieController::class, 'store'])->name('store');
        Route::get('/{movie}', [MovieController::class, 'show'])->name('show'); // Ver detalle
        Route::get('/{movie}/edit', [MovieController::class, 'edit'])->name('edit');
        Route::put('/{movie}', [MovieController::class, 'update'])->name('update');
        Route::delete('/{movie}', [MovieController::class, 'destroy'])->name('destroy');
    });


    /*
    |--------------------------------------------------------------------------
    | ÁREA DE ADMINISTRACIÓN (Solo usuarios con rol Admin)
    |--------------------------------------------------------------------------
    */
    Route::middleware([IsAdminUserMiddleware::class])->group(function () {

        // CRUD DE USUARIOS
        Route::prefix('users')->name('admin.users.')->group(function(){
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/store', [UserController::class, 'store'])->name('store');
        });

        // CRUD DE GÉNEROS
        Route::prefix('admin/genres')->name('admin.genres.')->group(function () {
            Route::get('/', [GenreController::class, 'index'])->name('index');
            Route::get('/create', [GenreController::class, 'create'])->name('create');
            Route::post('/', [GenreController::class, 'store'])->name('store');
            Route::get('/{genre}/edit', [GenreController::class, 'edit'])->name('edit');
            Route::put('/{genre}', [GenreController::class, 'update'])->name('update');
            Route::delete('/{genre}', [GenreController::class, 'destroy'])->name('destroy');
        });

        // CRUD DIRECTORES
        Route::prefix('directors')->name('directors.')->group(function(){
            Route::get('/', [DirectorController::class, 'index'])->name('index');
            Route::get('/create', [DirectorController::class, 'create'])->name('create');
            Route::post('/store', [DirectorController::class, 'store'])->name('store');
            Route::get('/{director}/edit', [DirectorController::class, 'edit'])->name('edit');
            Route::put('/{director}', [DirectorController::class, 'update'])->name('update');
            Route::delete('/{director}', [DirectorController::class, 'destroy'])->name('destroy');
        });

        // CRUD DE ACTORES
        Route::prefix('actors')->name('actors.')->group(function(){
            Route::get('/', [ActorController::class, 'index'])->name('index');
            Route::get('/create', [ActorController::class, 'create'])->name('create');
            Route::post('/store', [ActorController::class, 'store'])->name('store');
            Route::get('/{actor}/edit', [ActorController::class, 'edit'])->name('edit');
            Route::put('/{actor}', [ActorController::class, 'update'])->name('update');
            Route::delete('/{actor}', [ActorController::class, 'destroy'])->name('destroy');
            Route::get('/{actor}', [ActorController::class, 'show'])->name('show');
        });

        // RUTAS DE TEST DE ADMIN
        Route::get('superadmin', function(){
            return "Super Admin Area";
        });
    });

    Route::get('no-superadmin', function(){
        return "No Super Admin Area";
    });

});

require __DIR__.'/auth.php';
