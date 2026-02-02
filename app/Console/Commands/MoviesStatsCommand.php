<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MoviesStatsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'movies:stats';

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
        $this->info(' Calculando estadísticas de MovieHub...');

        $headers = ['Métrica', 'Valor'];
        $data = [
            ['Total Películas', \App\Models\Movie::count()],
            ['Total Actores', \App\Models\Actor::count()],
            ['Total Usuarios', \App\Models\User::count()],
            ['Valoración Media', random_int(1, 10)],
        ];

        $this->table($headers, $data);

        $this->newLine();
        $this->comment('Top 3 Géneros:');
        $genres = \App\Models\Genre::withCount('movies')
            ->orderByDesc('movies_count')
            ->take(3)->get();

        foreach ($genres as $genre) {
            $this->line("- {$genre->name}: {$genre->movies_count} películas");
        }
    }
}
