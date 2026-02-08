<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreGenreRequest;
use App\Http\Requests\UpdateGenreRequest;
use App\Jobs\AuditLogJob;
use App\Models\Genre;
use App\Events\GenreCreated;
use Illuminate\Support\Facades\Artisan;
use App\Jobs\RecalculateMovieRating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class GenreController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Genre::class);
        $genres = Genre::all();
        return view('admin.genres.index', compact('genres'));
    }

    public function create()
    {
        Gate::authorize('create', Genre::class);
        return view('admin.genres.create');
    }

    public function store(StoreGenreRequest $request)
    {
        Gate::authorize('create', Genre::class);
        $genre = Genre::create($request->validated());


        //Comando
        Artisan::call('movies:stats');
        //Job y event
        GenreCreated::dispatch($genre);
        AuditLogJob::dispatch("GÉNERO: El usuario " . Auth::user()->email . " creó el género '{$genre->name}'");
        return redirect()->route('admin.genres.index');
    }

    public function edit(Genre $genre)
    {
        Gate::authorize('update', $genre);
        return view('admin.genres.edit', compact('genre'));
    }

    public function update(UpdateGenreRequest $request, Genre $genre)
    {
        Gate::authorize('update', $genre);
        $genre->update($request->validated());
        //Job
        AuditLogJob::dispatch("GÉNERO: El usuario " . Auth::user()->email . " actualizó el género '{$genre->name}'");
        return redirect()->route('admin.genres.index');
    }

    public function destroy(Genre $genre)
    {
        Gate::authorize('delete', $genre);
        $genre->delete();
        //Job
        AuditLogJob::dispatch("GÉNERO: El usuario " . Auth::user()->email . " eliminó el género '$genre->name'");
        return redirect()->route('admin.genres.index');
    }
}
