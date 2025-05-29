<?php

use Illuminate\Foundation\Scheduling\Schedule;
use App\Console\Commands\DesactivarSuscripcionesVencidas;

return function (Schedule $schedule) {
    $schedule->command(DesactivarSuscripcionesVencidas::class)->everyMinute();
};