<?php

namespace App\Http\Controllers\Entrenador;

use App\Http\Controllers\Controller;
use App\Models\Clase;
use App\Models\Entrenamiento;
use App\Models\Suscripcion;

class EntrenadorController extends Controller
{
    public function index()
    {
        // Obtener todas las clases asociadas al entrenador logueado
        $clases = Clase::where('entrenador_id', auth()->user()->id)->get();
        
        // Obtener todos los entrenamientos del entrenador logueado
        $entrenamientos = Entrenamiento::where('entrenador_id', auth()->user()->id)->get();
        
        // Obtener todas las suscripciones activas del entrenador (a clases que tengan este entrenador)
        $suscripciones = Suscripcion::whereHas('clase', function ($query) {
            $query->where('entrenador_id', auth()->user()->id);
        })->get();

        // Pasar todas las variables a la vista
        return view('entrenador.dashboard', compact('clases', 'entrenamientos', 'suscripciones'));
    }
}
