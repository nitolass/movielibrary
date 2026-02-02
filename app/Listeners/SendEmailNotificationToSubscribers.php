<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\MovieCreated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewMovieMail;

class SendEmailNotificationToSubscribers
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
        Mail::to('suscriptores@ejemplo.com')->send(new NewMovieMail($event->movie));
        Log::info(" EMAIL MASIVO: Notificando a suscriptores sobre '{$event->movie->title}'");
    }
}
