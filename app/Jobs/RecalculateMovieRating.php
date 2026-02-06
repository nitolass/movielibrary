<?php

namespace App\Jobs;

use App\Models\Movie;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue; // Usa colas
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class RecalculateMovieRating implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $movie;

    /**
     * Recibimos la película que necesita actualizar su nota.
     */
    public function __construct(Movie $movie)
    {
        $this->movie = $movie;
    }

    public function handle(): void
    {
        // 1. Calcular la media de las reseñas (ratings)
        $avg = $this->movie->reviews()->avg('rating');

        // 2. Formatear y guardar en la columna 'score'
        $finalScore = $avg ? number_format((float)$avg, 2, '.', '') : 0;

        $this->movie->update([
            'score' => $finalScore
        ]);

        Log::info("RATING: Película '{$this->movie->title}' actualizada con nota: {$finalScore}");

        // --- REACCIÓN EN CADENA ---
        // Al cambiar la nota de la peli, cambia la media del director y los actores.
        // Disparamos sus jobs automáticamente aquí.

        if ($this->movie->director) {
            RecalculateDirectorScore::dispatch($this->movie->director);
        }

        foreach ($this->movie->actors as $actor) {
            RecalculateActorScore::dispatch($actor);
        }
    }
}
