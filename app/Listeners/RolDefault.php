<?php

namespace App\Listeners;

use IlluminateAuthEventsVerified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Log;

class RolDefault
{
    public function handle(Verified $event): void
    {
        Log::info('Se ha verificado el usuario: ' . $event->user->email);

        if ($event->user->roles()->count() === 0) {
            $event->user->assign('cliente');
            Log::info('Rol cliente asignado a: ' . $event->user->email);
        }
    }
}