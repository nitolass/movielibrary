<?php

namespace App\Http\Controllers\Admin;

use App\Events\MovieCreated;
use App\Jobs\AuditLogJob;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Director;
use App\Models\Actor;
use Illuminate\Support\Facades\Auth;
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
        Gate::authorize('viewAny', Movie::class);
        $movies = Movie::with(['genres', 'director', 'actors'])->get();
        return view('admin.movies.index', compact('movies'));
    }

    public function create()
    {
        Gate::authorize('create', Movie::class);
        $genres = Genre::all();
        $directors = Director::all();
        $actors = Actor::all();
        return view('admin.movies.create', compact('genres', 'directors', 'actors'));
    }

    public function store(MovieRequest $request)
    {
        Gate::authorize('create', Movie::class);
        $data = $request->validated();


        // 2. Procesamos el póster
        if ($request->hasFile('poster')) {
            $path = $request->file('poster')->store('posters', 'public');
            $data['poster'] = $path;
        }

        // 3. Crear
        $movie = Movie::create($data);

        // 4. Relaciones
        $movie->genres()->sync($request->genres);
        if ($request->has('actors')) {
            $movie->actors()->sync($request->actors);
        }

        // Job
        AuditLogJob::dispatch("PELÍCULA: Se ha creado la película '{$movie->title}' por " . Auth::user()->email);;
        \Illuminate\Support\Facades\Artisan::call('movies:clean');

        return redirect()->route('movies.index')
            ->with('success', '¡Película creada correctamente!');
    }

    public function show(Movie $movie)
    {
        Gate::authorize('view', $movie);
        $movie->load(['genres', 'director', 'actors']);
        return view('admin.movies.show', compact('movie'));
    }

    public function edit(Movie $movie)
    {
        Gate::authorize('update', $movie);
        $genres = Genre::all();
        $directors = Director::all();
        $actors = Actor::all();
        $movie->load(['genres', 'director', 'actors']);
        return view('admin.movies.edit',
            compact('movie', 'genres', 'directors', 'actors'));
    }

    public function update(MovieRequest $request, Movie $movie)
    {
        Gate::authorize('update', $movie);
        $data = $request->validated();

        if ($request->hasFile('poster')) {
            if ($movie->poster) {
                Storage::disk('public')->delete($movie->poster);
            }
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $movie->update($data);

        // Sincronizamos
        $movie->genres()->sync($request->input('genres', []));
        $movie->actors()->sync($request->input('actors', []));

        //Job
        AuditLogJob::dispatch("PELÍCULA: Se ha editado la película '{$movie->title}' por " . Auth::user()->email);

        return redirect()->route('movies.index')
            ->with('success', 'Película actualizada correctamente.');
    }

    public function destroy(Movie $movie)
    {
        Gate::authorize('delete', $movie); // Solo Admin

        $title = $movie->title;

        if ($movie->poster) {
            Storage::disk('public')->delete($movie->poster);
        }

        $movie->delete();

        AuditLogJob::dispatch("PELÍCULA: Se ha eliminado la película '$title' por " . Auth::user()->email);

        return redirect()->route('movies.index')->with('success', 'Película eliminada correctamente.');
    }
}
