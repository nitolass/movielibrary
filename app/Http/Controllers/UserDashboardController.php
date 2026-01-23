<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\Controller;

class UserDashboardController extends Controller
{
    public function favorites()
    {
        // Simulamos datos vacíos o traemos algo de prueba
        // Cuando tengas la tabla pivote 'favorites', pondrás: Auth::user()->favorites
        $movies = [];
        return view('user.favorites', compact('movies'));
    }

    public function watchLater()
    {
        $movies = [];
        return view('user.watch_later', compact('movies'));
    }

    public function rated()
    {
        $movies = [];
        return view('user.rated', compact('movies'));
    }

    public function watched()
    {
        $movies = [];
        return view('user.watched', compact('movies'));
    }
}
