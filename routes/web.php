<?php

use App\Admin\Users\Controllers\ProfileController;
use App\Admin\Users\Controllers\UserController;
use App\Http\Controllers\Admin\ActorController;
use App\Http\Controllers\Admin\DirectorController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\PdfController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\PublicCatalogController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Middleware\IsAdminUserMiddleware;
use App\Livewire\UserReviews;
use Illuminate\Support\Facades\Route;

// =========================================================================
// 1. ZONA PÚBLICA (ACCESIBLE PARA TODOS: INVITADOS Y LOGUEADOS)
// =========================================================================

// 🏠 PORTADA: Al entrar a la web, sale tu diseño "welcome"
Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::get('/catalogo', [PublicCatalogController::class, 'catalogo'])->name('user.movies.index');

// Ver una película individual (también público)
Route::get('/pelicula/{movie}', [PublicCatalogController::class, 'show'])->name('user.movies.show');

// Pantalla de "Únete" (opcional)
Route::get('/unete', [PublicCatalogController::class, 'prompt'])->name('public.prompt');


// =========================================================================
// 2. ZONA PRIVADA (SOLO USUARIOS REGISTRADOS)
// =========================================================================
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard'); // Redirección por defecto de Breeze/Jetstream

    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    // Rutas de Usuario (Favoritos, Historial, etc.)
    Route::controller(UserDashboardController::class)->group(function () {
        Route::get('/puntuadas', UserReviews::class)->name('user.rated');
        Route::get('/mis-favoritos', 'favorites')->name('user.favorites');
        Route::get('/ver-mas-tarde', 'watchLater')->name('user.watch_later');
        Route::get('/historial', 'watched')->name('user.watched');

        // Acciones (Botones de favoritos, vista, etc.)
        Route::post('/pelicula/{movie}/favorito', 'toggleFavorite')->name('user.toggle.favorite');
        Route::post('/pelicula/{movie}/ver-mas-tarde', 'toggleWatchLater')->name('user.toggle.watchLater');
        Route::post('/pelicula/{movie}/vista', 'toggleWatched')->name('user.toggle.watched');
    });

    // Rutas de Reseñas (Crear, Editar, Borrar)
    Route::post('/movies/{movie}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Perfil de Usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // PDF (Usuarios normales)
    Route::get('/pdf/users', [PdfController::class, 'usersList'])->name('pdf.admin-user-list');
    Route::get('/pdf/user/{user}', [PdfController::class, 'userReport'])->name('pdf.admin-user-report');


    // -----------------------------------------------------------
    // 3. ZONA ADMIN (SOLO ADMINISTRADORES)
    // -----------------------------------------------------------
    Route::middleware([IsAdminUserMiddleware::class])->group(function () {

        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        // PDF Admin
        Route::get('/admin/users/pdf', [PdfController::class, 'usersList'])->name('admin.pdf.users');
        Route::get('/admin/users/{user}/informe', [PdfController::class, 'userReport'])->name('admin.pdf.userReport');

        // Directores
        Route::prefix('directors')->name('directors.')->group(function(){
            Route::get('/', [DirectorController::class, 'index'])->name('index');
            Route::get('/create', [DirectorController::class, 'create'])->name('create');
            Route::post('/store', [DirectorController::class, 'store'])->name('store');
            Route::get('/{director}', [DirectorController::class, 'show'])->name('show');
            Route::get('/{director}/edit', [DirectorController::class, 'edit'])->name('edit');
            Route::put('/{director}', [DirectorController::class, 'update'])->name('update');
            Route::delete('/{director}', [DirectorController::class, 'destroy'])->name('destroy');
        });

        // Películas (Admin)
        Route::prefix('movies')->name('movies.')->group(function(){
            Route::get('/', [MovieController::class, 'index'])->name('index');
            Route::get('/create', [MovieController::class, 'create'])->name('create');
            Route::post('/store', [MovieController::class, 'store'])->name('store');
            Route::get('/{movie}/edit', [MovieController::class, 'edit'])->name('edit');
            Route::put('/{movie}', [MovieController::class, 'update'])->name('update');
            Route::delete('/{movie}', [MovieController::class, 'destroy'])->name('destroy');
            Route::get('/{movie}', [MovieController::class, 'show'])->name('show');
        });

        // Usuarios (Admin)
        Route::prefix('users')->name('admin.users.')->group(function(){
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::get('/{user}', [UserController::class, 'show'])->name('show');
        });

        // Géneros
        Route::prefix('admin/genres')->name('admin.genres.')->group(function () {
            Route::get('/', [GenreController::class, 'index'])->name('index');
            Route::get('/create', [GenreController::class, 'create'])->name('create');
            Route::post('/', [GenreController::class, 'store'])->name('store');
            Route::get('/{genre}/edit', [GenreController::class, 'edit'])->name('edit');
            Route::put('/{genre}', [GenreController::class, 'update'])->name('update');
            Route::delete('/{genre}', [GenreController::class, 'destroy'])->name('destroy');
        });

        // Actores
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
