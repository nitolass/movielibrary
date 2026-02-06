<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class MoviesCreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'movies:create-admin {email} {password}';

    /**
     * The console command description.
     */
    protected $description = 'Crea un administrador o actualiza uno existente';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        // 1. Buscamos si el usuario ya existe
        $user = User::where('email', $email)->first();

        if ($user) {
            // Lógica nueva: Comprobamos si YA es administrador (role_id = 1)
            if ($user->role_id == 1) {
                $this->warn("⚠️  El usuario {$email} YA existe y YA tiene el rol de Administrador.");

                // Opción A: Simplemente avisar y salir
                // return;

                // Opción B (Recomendada): Preguntar si quiere actualizar la contraseña de todas formas
                if ($this->confirm('¿Deseas actualizar solo su contraseña?')) {
                    $user->update([
                        'password' => bcrypt($password)
                    ]);
                    $this->info("✅ Contraseña actualizada correctamente.");
                } else {
                    $this->info("Operación cancelada. El usuario no se ha modificado.");
                }

                return; // Salimos aquí para no ejecutar el resto
            }

            // Si existe pero NO es admin (role_id distinto de 1)
            $this->warn("El usuario con email {$email} existe, pero NO es administrador.");

            if ($this->confirm('¿Quieres actualizar su contraseña y convertirlo en Administrador?')) {
                $user->update([
                    'password' => bcrypt($password),
                    'role_id' => 1,
                ]);
                $this->info("✅ Usuario promocionado a Administrador correctamente.");
            } else {
                $this->info("Operación cancelada.");
            }

        } else {
            // Si no existe, lo creamos de cero
            User::create([
                'name' => 'Admin',
                'surname' => 'Console',
                'email' => $email,
                'password' => bcrypt($password),
                'role_id' => 1,
            ]);

            $this->info("✅ Administrador creado correctamente: {$email}");
        }
    }
}
