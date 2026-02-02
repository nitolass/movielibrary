<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreGenreRequest;
use App\Http\Requests\UpdateGenreRequest;
use App\Models\Genre;
use App\Events\GenreCreated;
use Illuminate\Support\Facades\Artisan;
use App\Jobs\RecalculateMovieRating;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::all();
        return view('admin.genres.index', compact('genres'));
    }

    public function create()
    {
        return view('admin.genres.create');
    }

    public function store(StoreGenreRequest $request)
    {
        $genre = Genre::create($request->validated());

        RecalculateMovieRating::dispatch();
        GenreCreated::dispatch($genre);
        Artisan::call('movies:stats');

        return redirect()->route('admin.genres.index');
    }

    public function edit(Genre $genre)
    {
        return view('admin.genres.edit', compact('genre'));
    }

    public function update(UpdateGenreRequest $request, Genre $genre)
    {
        $genre->update($request->validated());
        return redirect()->route('admin.genres.index');
    }

    public function destroy(Genre $genre)
    {
        $genre->delete();
        return redirect()->route('admin.genres.index');
    }
}
