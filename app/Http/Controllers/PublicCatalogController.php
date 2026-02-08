<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Genre;

class PublicCatalogController extends Controller
{
    public function catalogo(Request $request)
    {
        // 1. Iniciamos la consulta cargando relaciones para evitar N+1
        $query = Movie::with(['director', 'genres']);

        // ---------------------------------------------------
        // APLICACIÓN DE SCOPES (FILTROS)
        // ---------------------------------------------------

        // SCOPE 1 (Complejo): BÚSQUEDA GLOBAL
        // Busca en título, año, director, género y actores
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // SCOPE 2 (Complejo): FILTRO POR GÉNEROS
        if ($request->has('genres') && is_array($request->genres)) {
            $query->byGenres($request->genres);
        }

        // SCOPE 3, 4 y 5: FILTROS ESPECIALES (Botones rápidos)
        if ($request->filled('filter')) {
            switch ($request->filter) {
                case 'popular':
                    // Scope Complejo: Ordena por cantidad de reseñas
                    $query->mostReviewed();
                    break;
                case 'top_rated':
                    // Scope Complejo: Nota alta o media con muchas reviews
                    $query->acclaimed();
                    break;
                case 'classics':
                    // Scope Simple: Anteriores al 2000
                    $query->classics();
                    break;
            }
        }

        // SCOPE 6 (Simple): RANGO DE DURACIÓN
        if ($request->filled('min_time') && $request->filled('max_time')) {
            $query->durationBetween($request->min_time, $request->max_time);
        }

        // SCOPE 7 (Complejo): POR PAÍS DEL DIRECTOR
        if ($request->filled('country')) {
            $query->byDirectorCountry($request->country);
        }

        // ---------------------------------------------------
        // ORDENACIÓN FINAL
        // ---------------------------------------------------

        // SCOPE 8 (Simple): ORDENACIÓN
        // Si piden explícitamente "recientes", usamos ese scope.
        // Si no hay filtro de popularidad (que ya ordena), usamos el orden por defecto.
        if ($request->get('sort') === 'recent') {
            $query->recent();
        } elseif (!$request->filled('filter')) {
            // Solo aplicamos latest() si no hay otro filtro que altere el orden (como popular o top_rated)
            $query->latest();
        }

        // 5. OBTENER RESULTADOS
        $movies = $query->paginate(12)->withQueryString();

        $allGenres = Genre::orderBy('name')->get();

        return view('user.movies.index', compact('movies', 'allGenres'));
    }

    public function show(Movie $movie)
    {
        // Autorización (opcional si es público, pero buena práctica)
        // Gate::authorize('view', $movie);

        $movie->load(['director', 'genres', 'actors', 'reviews.user']); // Cargamos actores y reviews
        return view('user.movies.show', compact('movie'));
    }

    public function prompt()
    {
        return view('user.prompt'); // Asumo que la vista prompt está en la raíz o user.prompt
    }
}
