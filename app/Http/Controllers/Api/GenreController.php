<?php

namespace App\Http\Controllers\Api;

use App\Events\GenreCreated;
use App\Http\Controllers\Admin\Controller;
use App\Jobs\AuditLogJob;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\GenreResource;

class GenreController extends Controller
{
    public function index()
    {
        // RESTAURADO
        Gate::authorize('viewAny', Genre::class);
        return GenreResource::collection(Genre::all());
    }

    public function show(Genre $genre)
    {
        // RESTAURADO
        Gate::authorize('view', $genre);
        return new GenreResource($genre);
    }

    // ... (Mantén store/update/destroy igual) ...
    public function store(Request $request)
    {
        Gate::authorize('create', Genre::class);
        $request->validate(['name' => 'required|string|unique:genres,name|max:255']);
        $genre = Genre::create($request->all());
        GenreCreated::dispatch($genre);
        return response()->json(['message' => 'Género creado correctamente', 'data' => new GenreResource($genre)], 201);
    }

    public function update(Request $request, Genre $genre)
    {
        Gate::authorize('update', $genre);
        $request->validate(['name' => 'required|string|unique:genres,name,' . $genre->id . '|max:255']);
        $genre->update($request->all());
        return response()->json(['message' => 'Género actualizado', 'data' => new GenreResource($genre)]);
    }

    public function destroy(Genre $genre)
    {
        Gate::authorize('delete', $genre);
        $genre->delete();
        return response()->json(['message' => 'Género eliminado'], 204);
    }
}
