<?php

use Illuminate\Support\Facades\Route;

// --- CONTROLADORES MVC (Para Cobertura de Tests y lógica clásica) ---
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

// --- COMPONENTES LIVEWIRE (Para la SPA real) ---
use App\Livewire\UserReviews;
use App\Livewire\GenreManager;
use App\Livewire\DirectorManager;
use App\Livewire\ActorManager;
use App\Livewire\UserManager;
use App\Livewire\UserDetail;

// --- MAILS & MODELS (TESTING) ---
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

    // --- LIVEWIRE DE USUARIO ---
    Route::get('/mis-resenas', UserReviews::class)->name('user.reviews.index');

    // --- CONTROLADOR DE USUARIO ---
    Route::controller(UserDashboardController::class)->group(function () {
        Route::get('/mis-favoritos', 'favorites')->name('user.favorites');
        Route::get('/ver-mas-tarde', 'watchLater')->name('user.watch_later');
        Route::get('/historial', 'watched')->name('user.watched');

        // Ruta para valoraciones (Corrección solicitada)
        Route::get('/mis-valoraciones', 'rated')->name('user.rated');

        Route::post('/pelicula/{movie}/favorito', 'toggleFavorite')->name('user.toggle.favorite');
        Route::post('/pelicula/{movie}/ver-mas-tarde', 'toggleWatchLater')->name('user.toggle.watchLater');
        Route::post('/pelicula/{movie}/vista', 'toggleWatched')->name('user.toggle.watched');
    });

    // --- RESEÑAS (CRUD) ---
    Route::post('/movies/{movie}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // --- PERFIL ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // PDF Dashboard Usuario
    Route::get('/pdf/dashboard-report', [PdfController::class, 'dashboardReport'])->name('admin.pdf.dashboard_report');
});


// =========================================================================
// 3. ZONA STAFF (ADMIN, EDITOR, MODERADOR)
// =========================================================================
Route::middleware(['auth', 'verified', 'can:access-admin-panel'])->prefix('admin')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // =====================================================================
    // A. RUTAS DE PDF (PRIORIDAD ALTA)
    // =====================================================================
    // Deben ir antes de las rutas resource/livewire que usan {id} para evitar conflictos.

    Route::get('/users/pdf', [PdfController::class, 'usersList'])->name('admin.pdf.users');
    Route::get('/users/{user}/informe', [PdfController::class, 'userReport'])->name('admin.pdf.userReport');
    Route::get('/pdf/movies', [PdfController::class, 'exportMovies'])->name('admin.pdf.movies');
    Route::get('/pdf/movie/{movie}', [PdfController::class, 'exportMovie'])->name('admin.pdf.movie');


    // =====================================================================
    // B. RUTAS "SHADOW" (MVC CLÁSICO) - PARA TUS TESTS ANTIGUOS
    // =====================================================================
    // Estas rutas permiten que tus tests hagan POST/PUT/DELETE y suban la cobertura.
    // Usamos 'parameters' para forzar el nombre de la variable (ej: {genre} en vez de {genres_crud}).

    // 1. Géneros
    Route::resource('genres-crud', GenreController::class)
        ->names('admin.genres')
        ->parameters(['genres-crud' => 'genre']);

    // 2. Actores
    Route::resource('actors-crud', ActorController::class)
        ->names('actors')
        ->parameters(['actors-crud' => 'actor']);

    // 3. Directores
    Route::resource('directors-crud', DirectorController::class)
        ->names('directors')
        ->parameters(['directors-crud' => 'director']);

    // 4. Usuarios (MVC)
    // Usamos 'admin.users' para que el test que busca 'admin.users.store' funcione.
    Route::resource('users-crud', UserController::class)
        ->names('admin.users')
        ->parameters(['users-crud' => 'user']);


    // =====================================================================
    // C. RUTAS REALES (LIVEWIRE SPA) - PARA LA NAVEGACIÓN WEB
    // =====================================================================
    // Estas rutas "sobrescriben" visualmente las rutas GET de arriba.

    // 1. Géneros
    Route::get('/genres', GenreManager::class)->name('admin.genres.manager');

    // 2. Directores
    Route::get('/directors', DirectorManager::class)->name('directors.index');

    // 3. Actores
    Route::get('/actors', ActorManager::class)->name('actors.index');

    // 4. Usuarios
    Route::get('/users', UserManager::class)->name('admin.users.index');
    Route::get('/users/{user}', UserDetail::class)->name('admin.users.show');


    // =====================================================================
    // D. RESTO DE FUNCIONALIDADES
    // =====================================================================

    // Películas (MVC Clásico)
    Route::resource('movies', MovieController::class)->names('movies');

});


// =========================================================================
// 4. ZONA LOCAL (TESTING MAILS)
// =========================================================================
if (app()->environment('local')) {
    Route::prefix('test-mail')->group(function () {

        $emailDestino = 'prueba@midominio.com';

        // Welcome Email
        Route::get('/welcome', function () {
            $user = new User(['name' => 'Usuario Preview', 'email' => 'test@test.com']);
            return new WelcomeUserMail($user);
        });
        Route::get('/welcome/send', function () use ($emailDestino) {
            $user = new User(['name' => 'Usuario Preview', 'email' => $emailDestino]);
            Mail::to($emailDestino)->send(new WelcomeUserMail($user));
            return "✅ Email de BIENVENIDA enviado a $emailDestino";
        });

        // Verify Email
        Route::get('/verify', function () {
            $user = new User(['name' => 'Ana Preview', 'email' => 'ana@test.com']);
            return new VerifyAccountMail($user);
        });
        Route::get('/verify/send', function () use ($emailDestino) {
            $user = new User(['name' => 'Ana Preview', 'email' => $emailDestino]);
            Mail::to($emailDestino)->send(new VerifyAccountMail($user));
            return "✅ Email de VERIFICACIÓN enviado a $emailDestino";
        });

        // New Movie Email
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

        // Favorite Email
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

        // Watch Later Email
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
