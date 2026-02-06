<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller; // <-- Corregido el namespace (sobraba Admin)
use App\Jobs\RecalculateMovieRating;
use App\Jobs\AuditLogJob;
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
        //Disparamos Job
        RecalculateMovieRating::dispatch($movie);

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

        $review->update($request->validated());

        // Disparamos Job
        RecalculateMovieRating::dispatch($review->movie);

        return redirect()->route('movies.show', $review->movie_id)
            ->with('success', 'Reseña actualizada.');
    }

    public function destroy(Review $review)
    {
        if (Auth::user()->role->name !== 'admin' && Auth::id() !== $review->user_id) {
            abort(403);
        }

        $movie = $review->movie;
        $reviewId = $review->id;

        $review->delete();

        if($movie) {
            //Job
            RecalculateMovieRating::dispatch($movie);
        }

        // Job
        AuditLogJob::dispatch("Reseña eliminada (ID: $reviewId) por el usuario " . Auth::user()->email);

        return back()->with('success', 'Reseña eliminada.');
    }

    public function edit(Review $review)
    {
        if (Auth::user()->role->name !== 'admin' && Auth::id() !== $review->user_id) { abort(403); }
        return view('user.reviews.edit', compact('review'));
    }
}
