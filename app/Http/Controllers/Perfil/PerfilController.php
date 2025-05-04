<?php

namespace App\Http\Controllers\Perfil;

use App\Models\ClaseGrupal;
use App\Models\Entrenamiento;
use App\Models\Suscripcion;
use Illuminate\Http\Request;
use App\Models\PerfilUsuario;
use App\Http\Controllers\Controller;

class PerfilController extends Controller
{
    public function index()
    {
        $usuario = auth()->user(); // Obtener al usuario autenticado
        $perfil = $usuario->perfilUsuario; // Obtener el perfil del usuario

        // Verificar si el perfil está completo
        $datosCompletos = $perfil && $perfil->fecha_nacimiento && $perfil->peso && $perfil->altura && $perfil->objetivo && $perfil->id_nivel;

        // Si no está completo, mostrar una notificación
        if (!$datosCompletos) {
            session()->flash('incomplete_profile', 'Por favor complete sus datos para poder acceder a las clases.');
        }

        // Obtener clases, entrenamientos y suscripciones
        $clases = $usuario->clases;
        $entrenamientos = $usuario->entrenamientos;
        $suscripciones = $usuario->suscripciones;

        // Pasar los datos a la vista
        return view('dashboard', compact('clases', 'entrenamientos', 'suscripciones', 'perfil'));
    }
}

