<?php

namespace App\Jobs;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue; // <--- ESTO ACTIVA LA COLA
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CheckInactiveUsersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        // Buscamos usuarios cuyo 'last_login_at' sea anterior a hace 1 mes
        // Y que no sea null (usuarios nuevos que nunca entraron)
        $limitDate = Carbon::now()->subMonth();

        $inactiveUsers = User::where('last_login_at', '<', $limitDate)->get();

        foreach ($inactiveUsers as $user) {
            // Aquí simulamos una acción, como enviar un email o loguearlo
            Log::warning("USUARIO INACTIVO DETECTADO: {$user->email} (Último login: {$user->last_login_at})");
        }

        Log::info("Revisión de inactivos completada. Total: " . $inactiveUsers->count());
    }
}
