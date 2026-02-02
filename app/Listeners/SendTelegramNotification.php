<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\MovieCreated;
use Illuminate\Support\Facades\Log;

class SendTelegramNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(MovieCreated $event): void
    {
        Log::info("TELEGRAM ENVIADO: Se ha estrenado la película '{$event->movie->title}'");
    }
}
