<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MoviesShowCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'movies:show {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = $this->argument('id');
        $movie = \App\Models\Movie::with('director', 'genres')->find($id);

        if (!$movie) {
            $this->error(" No se encontró ninguna película con ID: $id");
            return;
        }

        $this->info(" Ficha Técnica: {$movie->title}");
        $this->line("Año: {$movie->year}");
        $this->line(" Director: " . ($movie->director->name ?? 'N/A'));
        $this->line("Géneros: " . $movie->genres->pluck('name')->implode(', '));
        $this->line("Puntuación: {$movie->score}");
        $this->line("Sinopsis: " . \Illuminate\Support\Str::limit($movie->description, 100));
    }
}
