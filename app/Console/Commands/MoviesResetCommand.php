<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MoviesResetCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'movies:reset';

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
        if ($this->confirm('¿Seguro que quieres borrar TODA la base de datos y empezar de cero?')) {

            if (app()->environment('testing')) {
                // En tests, vaciamos tablas en lugar de refrescar migraciones
                \App\Models\Movie::query()->delete();
                \App\Models\User::query()->delete();
                $this->info(' Base de datos vaciada (Modo Test).');
            } else {
                $this->info(' Destruyendo base de datos...');
                $this->call('migrate:fresh');

                $this->info(' Sembrando nueva vida...');
                $this->call('db:seed');
            }

            $this->info(' ¡Sistema reseteado y listo!');
        }
    }
}
