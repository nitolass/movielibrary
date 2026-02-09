<?php

namespace App\Http\Controllers\Api;

use App\Events\MovieCreated;
use App\Http\Controllers\Admin\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Resources\MovieResource;

class MovieController extends Controller
{
    public function index()
    {
        return MovieResource::collection(Movie::with('director', 'genres')->paginate(10));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|integer',
            'description' => 'required|string',
            'duration' => 'required|integer',
            'score' => 'required|numeric',
            'director_id' => 'required|exists:directors,id',
            'poster' => 'nullable|image'
        ]);

        if ($request->hasFile('poster')) {
            $validated['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $movie = Movie::create($validated);

        MovieCreated::dispatch($movie);

        return response()->json([
            'message' => 'Película creada',
            'data' => new MovieResource($movie)
        ], 201);
    }

    public function show(Movie $movie)
    {
        return new MovieResource($movie->load('director', 'genres'));
    }

    public function update(Request $request, Movie $movie)
    {
        $movie->update($request->all());
        return response()->json(['message' => 'Película actualizada', 'data' => new MovieResource($movie)]);
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();
        return response()->json(['message' => 'Película eliminada'], 204);
    }
}
