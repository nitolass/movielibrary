<?php

namespace App\Listeners;

use App\Events\MovieCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewMovieMail;

class SendMovieNotifications implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(MovieCreated $event): void
    {
        // 1. Enviar Email
        Mail::to('suscriptores@ejemplo.com')->send(new NewMovieMail($event->movie));
        Log::info("EMAIL: Notificación enviada para la película '{$event->movie->title}'");

        // 2. Notificar Telegram (Simulado)
        Log::info("TELEGRAM: Se ha estrenado '{$event->movie->title}' en el canal oficial.");
    }
}
