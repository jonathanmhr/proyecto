<?php

namespace App\Http\Controllers\Perfil;

use App\Models\ClaseGrupal;
use App\Models\Entrenamiento;
use App\Models\Suscripcion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PerfilController extends Controller
{
    public function index()
    {
        $usuario = auth()->user(); // Obtener al usuario autenticado

        // Obtener clases inscritas por el usuario a través de la relación muchos a muchos
        $clases = $usuario->clases; // Utilizando la relación ya definida en el modelo User

        // Obtener entrenamientos del usuario (relación uno a muchos)
        $entrenamientos = Entrenamiento::where('id_usuario', $usuario->id)->get();

        // Obtener suscripciones del usuario (relación uno a muchos)
        $suscripciones = Suscripcion::where('id_usuario', $usuario->id)->get();

        // Pasar los datos a la vista
        return view('dashboard', compact('clases', 'entrenamientos', 'suscripciones'));
    }
}

