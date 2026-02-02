<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MoviesCreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'movie:create-admin {email} {password}';

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
        $email = $this->argument('email');
        $password = $this->argument('password');

        $user = \App\Models\User::create([
            'name' => 'Admin Console',
            'surname' => 'Superuser',
            'email' => $email,
            'password' => bcrypt($password),
            'role_id' => 1, //
        ]);

        $this->info("Administrador creado: {$user->email}");
    }
}
