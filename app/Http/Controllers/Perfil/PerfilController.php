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

        // Obtener el perfil del usuario
        $perfil = $usuario->perfilUsuario; // Asumiendo que ya tienes la relación configurada

        // Verificar si el perfil está completo
        $datosCompletos = $perfil && $perfil->fecha_nacimiento && $perfil->peso && $perfil->altura && $perfil->objetivo && $perfil->id_nivel;

        // Si no está completo, mostrar una notificación
        if (!$datosCompletos) {
            session()->flash('incomplete_profile', 'Por favor complete sus datos para poder acceder a las clases.');
        }

        // Obtener clases inscritas por el usuario a través de la relación muchos a muchos
        $clases = $usuario->clases; // Relación ya definida en el modelo User

        // Obtener entrenamientos del usuario (relación uno a muchos)
        $entrenamientos = Entrenamiento::where('id_usuario', $usuario->id)->get();

        // Obtener suscripciones del usuario (relación uno a muchos)
        $suscripciones = Suscripcion::where('id_usuario', $usuario->id)->get();

        // Pasar los datos a la vista
        return view('dashboard', compact('clases', 'entrenamientos', 'suscripciones', 'perfil'));
    }
}

