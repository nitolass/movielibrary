<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller; // <-- Corregido el namespace (sobraba Admin)
use App\Models\Movie;
use App\Models\Review;
use App\Http\Requests\ReviewRequest;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(ReviewRequest $request, Movie $movie)
    {
        // 1. Obtenemos solo los datos validados y limpios (rating y content)
        $data = $request->validated();

        Review::updateOrCreate(
            ['user_id' => Auth::id(), 'movie_id' => $movie->id],
            [
                'rating' => $data['rating'],   // Us
                'content' => $data['content'], // Usamos el array validado
            ]
        );

        return back()->with('success', '¡Reseña publicada!');
    }

    public function update(ReviewRequest $request, Review $review)
    {
        if (Auth::id() !== $review->user_id) { abort(403); }

        // Aquí ya lo tenías bien
        $review->update($request->validated());

        return redirect()->route('movies.show', $review->movie_id)
            ->with('success', 'Reseña actualizada.');
    }

    public function destroy(Review $review)
    {
        if (Auth::user()->role->name !== 'admin' && Auth::id() !== $review->user_id) {
            abort(403);
        }

        $review->delete();
        return back()->with('success', 'Reseña eliminada.');
    }

    public function edit(Review $review)
    {
        if (Auth::user()->role->name !== 'admin' && Auth::id() !== $review->user_id) { abort(403); }
        // Aquí faltaba retornar la vista, supongo que la tienes
        return view('user.reviews.edit', compact('review'));
    }
}
