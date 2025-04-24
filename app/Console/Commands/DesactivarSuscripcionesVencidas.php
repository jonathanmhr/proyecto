<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Suscripcion;

class DesactivarSuscripcionesVencidas extends Command
{
    protected $signature = 'suscripciones:desactivar-vencidas';
    protected $description = 'Desactiva las suscripciones cuya fecha de fin ya ha pasado';

    public function handle()
    {
        $now = now();
    
        $suscripciones = Suscripcion::where('estado', 'activo')
            ->where('fecha_fin', '<', $now)
            ->get();
    
        foreach ($suscripciones as $suscripcion) {
            $suscripcion->estado = 'inactiva';
            $suscripcion->save();
        }
    
        $this->info("Suscripciones vencidas desactivadas.");
    }
    
}
