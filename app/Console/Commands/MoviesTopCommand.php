<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MoviesTopCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'movies:top {limit=5}';

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
        $limit = $this->argument('limit');
        $this->info("Top $limit Películas mejor valoradas:");

        $movies = \App\Models\Movie::orderByDesc('score')
            ->take($limit)
            ->get(['title', 'year', 'score']);

        $this->table(['Título', 'Año', 'Puntuación'], $movies);
    }
}
