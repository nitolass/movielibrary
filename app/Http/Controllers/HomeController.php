<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Controller;

class HomeController extends Controller
{
    //  Portada
    public function index()
    {
        $movies = Movie::with('director')->latest()->take(6)->get();
        return view('welcome', compact('movies'));
    }

    // Catalogo
    public function catalogo()
    {
        $movies = Movie::with('director')->paginate(12);

        return view('public.movies.index', compact('movies'));
    }

    public function prompt()
    {
        // Esta vista la crearemos enseguida si no la tienes
        return view('public.prompt');
    }


}
