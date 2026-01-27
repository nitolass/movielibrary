<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Admin\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use App\Http\Resources\GenreResource;

class GenreController extends Controller
{
    public function index()
    {
        return GenreResource::collection(Genre::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:genres,name|max:255'
        ]);

        $genre = Genre::create($request->all());

        return response()->json([
            'message' => 'Género creado correctamente',
            'data' => new GenreResource($genre)
        ], 201);
    }

    public function show(Genre $genre)
    {
        return new GenreResource($genre);
    }

    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'name' => 'required|string|unique:genres,name,' . $genre->id . '|max:255'
        ]);

        $genre->update($request->all());

        return response()->json([
            'message' => 'Género actualizado',
            'data' => new GenreResource($genre)
        ]);
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();
        return response()->json(['message' => 'Género eliminado'], 204);
    }
}
