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
            $this->info(' Destruyendo base de datos...');
            $this->call('migrate:fresh');

            $this->info(' Sembrando nueva vida...');
            $this->call('db:seed');

            $this->info(' ¡Sistema reseteado y listo!');
        }
    }
}
