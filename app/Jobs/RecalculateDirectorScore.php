<?php

namespace App\Jobs;

use App\Models\Director;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RecalculateDirectorScore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $director;

    public function __construct(Director $director)
    {
        $this->director = $director;
    }

    public function handle(): void
    {
        // 1. Obtenemos la media cruda
        $rawAvg = $this->director->movies()->avg('score');

        // 2. Si es null (no tiene pelis) ponemos 0. Si tiene valor, formateamos a 2 decimales.
        // number_format devuelve un string, pero MySQL lo convierte a float sin problemas.
        $finalScore = $rawAvg ? number_format((float)$rawAvg, 2, '.', '') : 0;

        $this->director->update([
            'score' => $finalScore
        ]);
    }
}
