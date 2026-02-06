<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Movie;

class MoviesTopCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'movies:top {limit=5}';

    /**
     * The console command description.
     */
    protected $description = 'Recalcula el score de las películas y muestra el Top';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $limit = (int) $this->argument('limit');

        $this->info("Recalculando puntuaciones de todas las películas...");

        // Traemos todas las pelis con sus reviews
        $movies = Movie::with('reviews')->get();

        $bar = $this->output->createProgressBar($movies->count());
        $bar->start();

        foreach ($movies as $movie) {
            // 1. Obtenemos el valor crudo. Si es null, asignamos 0.
            $rawAvg = $movie->reviews()->avg('rating');
            $finalScore = 0;

            if ($rawAvg !== null) {
                // 2. Usamos number_format que es más seguro para convertir a decimal limpio
                // Formato: 2 decimales, punto como separador, sin separador de miles
                $finalScore = number_format((float)$rawAvg, 2, '.', '');
            }

            // 3. Guardamos
            $movie->update([
                'score' => $finalScore
            ]);

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        // Mostrar el Top
        $this->info("🏆 Top $limit Películas mejor valoradas:");

        $topMovies = Movie::orderByDesc('score')
            ->take($limit)
            ->get(['title', 'year', 'score']);

        $this->table(
            ['Título', 'Año', 'Puntuación'],
            $topMovies->toArray()
        );
    }
}
