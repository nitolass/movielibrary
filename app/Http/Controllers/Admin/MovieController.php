<?php

namespace App\Http\Controllers\Admin;

use App\Models\Movie;
use App\Models\Genre;
use App\Models\Director;
use App\Models\Actor;
use Illuminate\Http\Request;
use App\Http\Requests\MovieRequest;
use Illuminate\Support\Facades\Storage;

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
        // validamos
        $data = $request->validated();

        if ($request->hasFile('poster')) {
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }

        // creamos la pelicula.
        $movie = Movie::create($data);

        // sincronizamos generos
        $movie->genres()->sync($request->input('genres', []));
        $movie->actors()->sync($request->input('actors', []));

        return redirect()->route('movies.index')->with('success', 'Película creada correctamente.');
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
        if ($movie->poster) {
            Storage::disk('public')->delete($movie->poster);
        }
        $movie->delete();
        return redirect()->route('movies.index')->with('success', 'Película eliminada correctamente.');
    }
}
