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
        // 1. Iniciamos la consulta cargando relaciones
        $query = Movie::with(['director', 'genres']);

        // 2. SCOPE 1: BÚSQUEDA (Barra superior)
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // 3. SCOPE 2: FILTRO POR GÉNEROS (Dropdown)
        if ($request->has('genres') && is_array($request->genres)) {
            $query->byGenres($request->genres);
        }

        // 4. SCOPE 3: ORDENACIÓN (Botón "Recientes")
        // CAMBIO: Ahora es condicional. Solo si la URL trae ?sort=recent
        if ($request->get('sort') === 'recent') {
            $query->recent(); // Ordena por año de lanzamiento (scopeRecent)
        } else {
            $query->latest(); // Por defecto: Ordena por fecha de subida a la web (ID descendente)
        }

        // 5. OBTENER RESULTADOS
        // withQueryString() es vital para no perder el ?sort=recent al cambiar de página
        $movies = $query->paginate(12)->withQueryString();

        // 6. CARGAR TODOS LOS GÉNEROS
        $allGenres = Genre::orderBy('name')->get();

        return view('user.movies.index', compact('movies', 'allGenres'));
    }

    public function show(Movie $movie)
    {
        // Gate::authorize('view', $movie); // Descomenta si usas policies
        $movie->load(['director', 'genres']);
        return view('user.movies.show', compact('movie'));
    }

    public function prompt()
    {
        return view('user.prompt');
    }
}
