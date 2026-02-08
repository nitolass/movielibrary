<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;


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

        Gate::define('manage-users', function (User $user) {
            return $user->role->name === 'admin';
        });

        Gate::define('manage-content', function (User $user) {
            return in_array($user->role->name, ['admin', 'editor']);
        });

        Gate::define('moderate-reviews', function (User $user) {
            return in_array($user->role->name, ['admin', 'moderador']);
        });

        Gate::define('access-admin-panel', function (User $user) {
            return in_array($user->role->name, ['admin', 'editor', 'moderador']);
        });
    }
}
