<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{

    public function favorites()
    {

        $movies = Auth::user()->favorites()->orderByPivot('created_at', 'desc')->get();

        return view('user.toggle.favorites', compact('movies'));
    }

    public function watchLater()
    {
        $movies = Auth::user()->watchLater()->orderByPivot('created_at', 'desc')->get();

        return view('user.toggle.watch_later', compact('movies'));
    }

    public function watched()
    {
        $movies = Auth::user()->watched()->orderByPivot('created_at', 'desc')->get();

        return view('user.toggle.watched', compact('movies'));
    }

    public function rated()
    {

        $reviews = Auth::user()->reviews()->with('movie')->orderBy('created_at', 'desc')->get();

        return view('user.toggle.rated', compact('reviews'));
    }




    public function toggleFavorite(Movie $movie)
    {
        Auth::user()->favorites()->toggle([
            $movie->id => ['type' => 'favorite']
        ]);
        return back();
    }

    public function toggleWatchLater(Movie $movie)
    {
        Auth::user()->watchLater()->toggle([
            $movie->id => ['type' => 'watch_later']
        ]);
        return back();
    }

    public function toggleWatched(Movie $movie)
    {
        Auth::user()->watched()->toggle([
            $movie->id => ['type' => 'watched']
        ]);


        if (Auth::user()->watched()->where('movie_id', $movie->id)->exists()) {
            Auth::user()->watchLater()->detach($movie->id);
        }

        return back();
    }
}
