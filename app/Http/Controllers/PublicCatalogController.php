<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\Movie; // Importamos el modelo

class PublicCatalogController extends Controller
{
    public function catalogo()
    {
        // Traemos películas con director y géneros
        $movies = Movie::with(['director', 'genres'])
            ->latest()
            ->paginate(12);

        return view('user.movies.index', compact('movies'));
    }

    public function show(Movie $movie)
    {
        Gate::authorize('view', $movie);

        $movie->load(['director', 'genres']);
        return view('user.movies.show', compact('movie'));
    }

    public function prompt()
    {
        return view('user.prompt');
    }
}
