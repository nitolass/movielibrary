<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Models\Actor;
use App\Models\Director;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PdfController extends Controller
{
    public function usersList()
    {
        $users = User::all();

        $pdf = Pdf::loadView('pdf.admin-users-list', compact('users'));

        return $pdf->stream('listado-usuarios.pdf');
    }

    public function userReport(User $user)
    {

        $user->load(['watchLater', 'role']);

        $pdf = Pdf::loadView('pdf.admin-user-report', compact('user'));

        return $pdf->stream('informe-usuario-' . $user->id . '.pdf');
    }

    public function exportMovies()
    {
        $movies = Movie::with('director', 'genres')->get();
        $pdf = Pdf::loadView('pdf.movies-list', compact('movies'));
        return $pdf->stream('catalogo-peliculas.pdf');
    }

    public function exportMovie(Movie $movie)
    {
        $movie->load(['director', 'genres', 'actors', 'reviews.user']);
        $pdf = Pdf::loadView('pdf.movie-detail', compact('movie'));
        return $pdf->stream('ficha-' . \Str::slug($movie->title) . '.pdf');
    }
    public function dashboardReport()
    {
        // 1. Estadísticas Generales
        $stats = [
            'movies_count' => Movie::count(),
            'users_count' => User::count(),
            'actors_count' => Actor::count(),
            'directors_count' => Director::count(),
            'total_reviews' => DB::table('reviews')->count(),
            'avg_score' => Movie::avg('score'),
        ];

        // 2. Top 5 Mejor Valoradas (Scope o Query directa)
        $topRated = Movie::orderBy('score', 'desc')->take(5)->get();

        // 3. Top 5 Más Populares (con más reviews)
        $mostReviewed = Movie::withCount('reviews')->orderBy('reviews_count', 'desc')->take(5)->get();

        // 4. Distribución por Géneros (Complejo: Agregación)
        $genresDistribution = Genre::withCount('movies')
            ->orderBy('movies_count', 'desc')
            ->take(8) // Solo los 8 principales para que quepan en el gráfico
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.dashboard-report', compact('stats', 'topRated', 'mostReviewed', 'genresDistribution'));

        return $pdf->stream('informe-mensual-moviehub.pdf');
    }
}
