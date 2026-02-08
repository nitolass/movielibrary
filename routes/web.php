<?php

use App\Admin\Users\Controllers\ProfileController;
use App\Admin\Users\Controllers\UserController; // Ya no se usa (borrable)
use App\Http\Controllers\Admin\ActorController; // Ya no se usa (borrable)
use App\Http\Controllers\Admin\DirectorController; // Ya no se usa (borrable)
use App\Http\Controllers\Admin\GenreController; // Ya no se usa (borrable)
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\Admin\PdfController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\PublicCatalogController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Middleware\IsAdminUserMiddleware;
use App\Livewire\UserReviews;
use Illuminate\Support\Facades\Route;

// --- IMPORTS DE LIVEWIRE ---
use App\Livewire\GenreManager;
use App\Livewire\DirectorManager;
use App\Livewire\ActorManager;
use App\Livewire\UserManager; // <--- Nuevo para Usuarios
use App\Livewire\UserDetail;  // <--- Nuevo para Detalle Usuario

// Imports para Testing de Emails y Modelos
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Movie;
use App\Mail\WelcomeUserMail;
use App\Mail\VerifyAccountMail;
use App\Mail\NewMovieMail;
use App\Mail\FavoriteAddedMail;
use App\Mail\WatchLaterAddedMail;

// =========================================================================
// 1. ZONA PÚBLICA (ACCESIBLE PARA TODOS)
// =========================================================================

Route::get('/', function () {
    $movies = Movie::inRandomOrder()->take(6)->get();
    return view('welcome', compact('movies'));
})->name('welcome');

Route::get('/catalogo', [PublicCatalogController::class, 'catalogo'])->name('user.movies.index');
Route::get('/pelicula/{movie}', [PublicCatalogController::class, 'show'])->name('user.movies.show');
Route::get('/unete', [PublicCatalogController::class, 'prompt'])->name('public.prompt');


// =========================================================================
// 2. ZONA PRIVADA (SOLO USUARIOS REGISTRADOS)
// =========================================================================
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('dashboard');

    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    // Rutas de Usuario
    Route::controller(UserDashboardController::class)->group(function () {
        Route::get('/puntuadas', UserReviews::class)->name('user.rated');
        Route::get('/mis-favoritos', 'favorites')->name('user.favorites');
        Route::get('/ver-mas-tarde', 'watchLater')->name('user.watch_later');
        Route::get('/historial', 'watched')->name('user.watched');

        Route::post('/pelicula/{movie}/favorito', 'toggleFavorite')->name('user.toggle.favorite');
        Route::post('/pelicula/{movie}/ver-mas-tarde', 'toggleWatchLater')->name('user.toggle.watchLater');
        Route::post('/pelicula/{movie}/vista', 'toggleWatched')->name('user.toggle.watched');
    });

    // Rutas de Reseñas
    Route::post('/movies/{movie}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // PDF Usuarios
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

        // === GESTIÓN CON LIVEWIRE (SPA) ===

        // 1. Géneros
        Route::get('/admin/genres', GenreManager::class)->name('admin.genres.index');

        // 2. Directores
        Route::get('/admin/directors', DirectorManager::class)->name('directors.index');

        // 3. Actores
        Route::get('/admin/actors', ActorManager::class)->name('actors.index');

        // 4. Usuarios (NUEVO - Reemplaza al UserController MVC)
        Route::get('/admin/users', UserManager::class)->name('admin.users.index');
        Route::get('/admin/users/{user}', UserDetail::class)->name('admin.users.show');


        // === GESTIÓN CLÁSICA (MVC) - Pendiente de migrar ===

        // Películas (Único superviviente del modo clásico por ahora)
        Route::prefix('movies')->name('movies.')->group(function(){
            Route::get('/', [MovieController::class, 'index'])->name('index');
            Route::get('/create', [MovieController::class, 'create'])->name('create');
            Route::post('/store', [MovieController::class, 'store'])->name('store');
            Route::get('/{movie}/edit', [MovieController::class, 'edit'])->name('edit');
            Route::put('/{movie}', [MovieController::class, 'update'])->name('update');
            Route::delete('/{movie}', [MovieController::class, 'destroy'])->name('destroy');
            Route::get('/{movie}', [MovieController::class, 'show'])->name('show');
        });
    });
});

// =========================================================================
// 4. ZONA DE PRUEBAS DE MAIL (SOLO LOCAL)
// =========================================================================
if (app()->environment('local')) {
    Route::prefix('test-mail')->group(function () {

        $emailDestino = 'prueba@midominio.com';

        Route::get('/welcome', function () {
            $user = new User(['name' => 'Usuario Preview', 'email' => 'test@test.com']);
            return new WelcomeUserMail($user);
        });
        Route::get('/welcome/send', function () use ($emailDestino) {
            $user = new User(['name' => 'Usuario Preview', 'email' => $emailDestino]);
            Mail::to($emailDestino)->send(new WelcomeUserMail($user));
            return "✅ Email de BIENVENIDA enviado a $emailDestino";
        });

        Route::get('/verify', function () {
            $user = new User(['name' => 'Ana Preview', 'email' => 'ana@test.com']);
            return new VerifyAccountMail($user);
        });
        Route::get('/verify/send', function () use ($emailDestino) {
            $user = new User(['name' => 'Ana Preview', 'email' => $emailDestino]);
            Mail::to($emailDestino)->send(new VerifyAccountMail($user));
            return "✅ Email de VERIFICACIÓN enviado a $emailDestino";
        });

        Route::get('/new-movie', function () {
            $movie = new Movie([
                'title' => 'Gladiator II',
                'year' => 2024,
                'description' => 'Años después de presenciar la muerte del venerado héroe Máximo...',
                'poster' => null,
            ]);
            $movie->id = 1;
            return new NewMovieMail($movie);
        });
        Route::get('/new-movie/send', function () use ($emailDestino) {
            $movie = new Movie([
                'title' => 'Gladiator II',
                'year' => 2024,
                'description' => 'Años después de presenciar la muerte del venerado héroe Máximo...',
                'poster' => null,
            ]);
            $movie->id = 1;
            Mail::to($emailDestino)->send(new NewMovieMail($movie));
            return "✅ Email de NUEVA PELÍCULA enviado a $emailDestino";
        });

        Route::get('/favorite', function () {
            $movie = new Movie(['title' => 'Inception', 'year' => 2010]);
            $movie->id = 1;
            return new FavoriteAddedMail($movie);
        });
        Route::get('/favorite/send', function () use ($emailDestino) {
            $movie = new Movie(['title' => 'Inception', 'year' => 2010]);
            $movie->id = 1;
            Mail::to($emailDestino)->send(new FavoriteAddedMail($movie));
            return "✅ Email de FAVORITO enviado a $emailDestino";
        });

        Route::get('/watch-later', function () {
            $movie = new Movie(['title' => 'Interstellar', 'year' => 2014, 'description' => '...']);
            $movie->id = 1;
            return new WatchLaterAddedMail($movie);
        });
        Route::get('/watch-later/send', function () use ($emailDestino) {
            $movie = new Movie(['title' => 'Interstellar', 'year' => 2014, 'description' => '...']);
            $movie->id = 1;
            Mail::to($emailDestino)->send(new WatchLaterAddedMail($movie));
            return "✅ Email de VER MÁS TARDE enviado a $emailDestino";
        });
    });
}

require __DIR__.'/auth.php';
