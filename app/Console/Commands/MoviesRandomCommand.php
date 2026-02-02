<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MoviesRandomCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'movies:random {limit=3}';

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
        $this->info(" Aquí tienes $limit sugerencias aleatorias:");

        $movies = \App\Models\Movie::inRandomOrder()->take($limit)->get();

        foreach ($movies as $movie) {
            $this->line("{$movie->title} ({$movie->year})");
        }
    }
}
