<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Admin\Controller;
use App\Models\Review;
use App\Models\Movie; // Necesario para validar si existe
use Illuminate\Http\Request;
use App\Http\Resources\ReviewResource;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Jobs\RecalculateMovieRating;
use App\Jobs\AuditLogJob;

class ReviewController extends Controller
{
    // Listar reseñas (opcional, o podrías filtrar por usuario)
    public function index()
    {
        // Devuelve las reseñas del usuario logueado o todas (según tu lógica)
        return ReviewResource::collection(Review::paginate(10));
    }

    public function store(Request $request)
    {
        // Validamos datos
        $validated = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'rating' => 'required|integer|min:0|max:10', // Ajusta según tu escala (0-10 o 1-5)
            'content' => 'required|string|max:1000',
        ]);

        // Evitar duplicados: Un usuario solo puede reseñar una vez la misma peli
        $existingReview = Review::where('user_id', Auth::id())
            ->where('movie_id', $validated['movie_id'])
            ->first();

        if ($existingReview) {
            return response()->json(['message' => 'Ya has valorado esta película.'], 409);
        }

        // Crear la reseña vinculada al usuario logueado
        $review = $request->user()->reviews()->create($validated);

        // --- JOBS ---
        // 1. Recalcular nota de la película (y actores/directores)
        RecalculateMovieRating::dispatch($review->movie);

        // 2. Auditoría
        AuditLogJob::dispatch("API: Nueva reseña (ID: {$review->id}) creada por " . Auth::user()->email);

        return new ReviewResource($review);
    }

    public function show(Review $review)
    {
        return new ReviewResource($review);
    }

    public function update(Request $request, Review $review)
    {
        // Autorización: Solo el dueño puede editar (Policy)
        Gate::authorize('update', $review);

        $validated = $request->validate([
            'rating' => 'sometimes|integer|min:0|max:10',
            'content' => 'sometimes|string|max:1000',
        ]);

        $review->update($validated);

        // --- JOBS ---
        // 1. Recalcular nota
        RecalculateMovieRating::dispatch($review->movie);

        // 2. Auditoría
        AuditLogJob::dispatch("API: Reseña (ID: {$review->id}) editada por " . Auth::user()->email);

        return new ReviewResource($review);
    }

    public function destroy(Review $review)
    {
        // Autorización: Dueño o Admin (Policy)
        Gate::authorize('delete', $review);

        // Guardamos datos antes de borrar para el Job
        $movie = $review->movie;
        $reviewId = $review->id;
        $userEmail = Auth::user()->email;

        $review->delete();

        // --- JOBS ---
        // 1. Recalcular nota (si la peli aún existe)
        if ($movie) {
            RecalculateMovieRating::dispatch($movie);
        }

        // 2. Auditoría
        AuditLogJob::dispatch("API: Reseña (ID: $reviewId) eliminada por $userEmail");

        return response()->json(['message' => 'Reseña eliminada'], 204);
    }
}
