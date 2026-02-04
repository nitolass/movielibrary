<?php

namespace App\Http\Controllers\Admin;

use App\Events\MovieCreated;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Director;
use App\Models\Actor;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Http\Requests\MovieRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use App\Jobs\ProcessPosterImage;

class MovieController extends Controller
{


    public function index()
    {
        $movies = Movie::with(['genres', 'director', 'actors'])->get();
        return view('admin.movies.index', compact('movies'));
    }

    public function create()
    {
        $genres = Genre::all();
        $directors = Director::all();
        $actors = Actor::all();
        return view('admin.movies.create', compact('genres', 'directors', 'actors'));
    }

    public function store(MovieRequest $request)
    {
        $data = $request->validated();


        // 2. Procesamos el póster y lo metemos en el array de datos
        if ($request->hasFile('poster')) {
            $path = $request->file('poster')->store('posters', 'public');
            $data['poster'] = $path; // <-- Lo guardamos en $data, no en una variable suelta
        }

        // 3. Pasamos TODO el array $data a create.
        // Aquí es donde irán title, year, description, duration, etc.
        $movie = Movie::create($data);

        // 4. Relaciones
        $movie->genres()->sync($request->genres);
        if ($request->has('actors')) {
            $movie->actors()->sync($request->actors);
        }

        // 5. Tus procesos extra
        \App\Jobs\ProcessPosterImage::dispatch($movie->title);
        \App\Events\MovieCreated::dispatch($movie);
        \Illuminate\Support\Facades\Artisan::call('movies:clean');

        return redirect()->route('movies.index')
            ->with('success', '¡Película creada correctamente!');
    }

    public function show(Movie $movie)
    {
        $movie->load(['genres', 'director', 'actors']);
        return view('admin.movies.show', compact('movie'));
    }

    public function edit(Movie $movie)
    {
        $genres = Genre::all();
        $directors = Director::all();
        $actors = Actor::all();
        $movie->load(['genres', 'director', 'actors']);
        return view('admin.movies.edit',
            compact('movie', 'genres', 'directors', 'actors'));
    }

    public function update(MovieRequest $request, Movie $movie)
    {
        $data = $request->validated();

        if ($request->hasFile('poster')) {
            if ($movie->poster) {
                Storage::disk('public')->delete($movie->poster);
            }
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }

        // si cambio el director_id se actualiza
        $movie->update($data);

        // Sincronizamos generos y actores

        $movie->genres()->sync($request->input('genres', []));
        $movie->actors()->sync($request->input('actors', []));

        return redirect()->route('movies.index')
            ->with('success', 'Película actualizada correctamente.');
    }

    public function destroy(Movie $movie)
    {
        // Gate::authorize('delete', $movie);
        if ($movie->poster) {
            Storage::disk('public')->delete($movie->poster);
        }
        $movie->delete();
        return redirect()->route('movies.index')->with('success', 'Película eliminada correctamente.');
    }
}
