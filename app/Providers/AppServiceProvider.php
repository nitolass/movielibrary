<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Events\MovieCreated;
use App\Listeners\SendTelegramNotification;
use App\Listeners\SendEmailNotificationToSubscribers;

use App\Events\UserCreated;
use App\Listeners\SendWelcomeEmail;

use App\Events\ActorCreated;
use App\Listeners\LogActorCreated;

use App\Events\DirectorCreated;
use App\Listeners\LogDirectorCreated;

use App\Events\GenreCreated;
use App\Listeners\LogGenreCreated;

class AppServiceProvider extends ServiceProvider
{
    protected $listen = [
        MovieCreated::class => [
            SendTelegramNotification::class,
            SendEmailNotificationToSubscribers::class,
        ],

        UserCreated::class => [
            SendWelcomeEmail::class,
        ],

        ActorCreated::class => [
            LogActorCreated::class,
        ],

        DirectorCreated::class => [
            LogDirectorCreated::class,
        ],

        GenreCreated::class => [
            LogGenreCreated::class,
        ],
    ];
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
