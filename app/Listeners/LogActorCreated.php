<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;


class LogActorCreated
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     */
    public function handle(\App\Events\ActorCreated $event): void {
        Log::info("ACTOR REGISTRADO: {$event->actor->name}");
    }
}
