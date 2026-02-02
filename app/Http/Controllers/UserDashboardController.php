<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\Controller;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Mail\FavoriteAddedMail;
use App\Mail\WatchLaterAddedMail;
use Illuminate\Support\Facades\Mail;

class UserDashboardController extends Controller
{

    public function index()
    {
        Artisan::call('movies:random');


        return view('user.dashboard');
    }
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
        $result = Auth::user()->favorites()->toggle([
            $movie->id => ['type' => 'favorite']
        ]);

        if (count($result['attached']) > 0) {
            // EMAIL 4: Aviso de favorito
            Mail::to(Auth::user()->email)->send(new FavoriteAddedMail($movie));
        }

        return back();
    }

    public function toggleWatchLater(Movie $movie)
    {
        $result = Auth::user()->watchLater()->toggle([
            $movie->id => ['type' => 'watch_later']
        ]);

        if (count($result['attached']) > 0) {
            Mail::to(Auth::user()->email)->send(new WatchLaterAddedMail($movie));
        }

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
