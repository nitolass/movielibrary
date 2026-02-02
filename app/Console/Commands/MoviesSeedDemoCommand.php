<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MoviesSeedDemoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'movies:seed-demo';

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
        $this->info(' Sembrando datos de prueba...');

        $this->call('db:seed');

        $this->info('¡Datos generados correctamente!');
    }
}
