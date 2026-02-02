<?php

namespace App\Jobs;

// ... imports ...
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AuditLogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $action;

    public function __construct($action)
    {
        $this->action = $action;
    }

    public function handle(): void
    {
        Log::info(" AUDITORÍA: Se ha registrado la acción: '{$this->action}' en el sistema seguro.");
    }
}
