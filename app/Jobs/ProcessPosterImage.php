<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessPosterImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $movieTitle;

    public function __construct($movieTitle)
    {
        $this->movieTitle = $movieTitle;
    }

    public function handle(): void
    {
       sleep(2);
        Log::info(" IMAGEN PROCESADA: El póster de '{$this->movieTitle}' se ha redimensionado a 4K.");
    }
}
