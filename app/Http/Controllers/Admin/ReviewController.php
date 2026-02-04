<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin;
use App\Models\Movie;
use App\Models\Review;
use App\Http\Requests\ReviewRequest;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{


    public function store(ReviewRequest $request, Movie $movie)
    {
        Review::updateOrCreate(
            ['user_id' => Auth::id(), 'movie_id' => $movie->id],
            [
                'rating' => $request->rating,
                'content' => $request->content,
            ]
        );

        return back()->with('success', '¡Reseña publicada!');
    }

    public function update(ReviewRequest $request, Review $review)
    {
        // Usamos Gate o política de seguridad
        if (Auth::id() !== $review->user_id) { abort(403); }

        $review->update($request->validated());

        return redirect()->route('movies.show', $review->movie_id)
            ->with('success', 'Reseña actualizada.');
    }

    public function destroy(Review $review)
    {
        // Para el coverage de Admin, permitimos que el admin también borre
        if (Auth::user()->role->name !== 'admin' && Auth::id() !== $review->user_id) {
            abort(403);
        }

        $review->delete();
        return back()->with('success', 'Reseña eliminada.');
    }

    public function edit(Review $review)
    {
    if (Auth::user()->role->name !== 'admin' && Auth::id() !== $review->user_id) { abort(403); }
    }
}
