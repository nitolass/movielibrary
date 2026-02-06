<?php

namespace App\Jobs;

use App\Models\Actor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RecalculateActorScore implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $actor;

    public function __construct(Actor $actor)
    {
        $this->actor = $actor;
    }

    public function handle(): void
    {
        // 1. Obtenemos la media cruda
        $rawAvg = $this->actor->movies()->avg('score');

        // 2. Formateamos seguro con number_format
        $finalScore = $rawAvg ? number_format((float)$rawAvg, 2, '.', '') : 0;

        $this->actor->update([
            'score' => $finalScore
        ]);
    }
}
