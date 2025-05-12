<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Entrenamiento;
use Illuminate\Http\Request;

class EntrenamientoController extends Controller
{
    // Mostrar todos los entrenamientos
    public function index()
    {
        $user = auth()->user();

        if ($user->can('admin_entrenador')) {
            // Admin Entrenador: Ver todos los entrenamientos
            $entrenamientos = Entrenamiento::all();
        } elseif ($user->can('entrenador')) {
            // Entrenador: Ver solo los entrenamientos asignados a sus clases
            $entrenamientos = Entrenamiento::where('id_usuario', $user->id)->get();
        } else {
            // Cliente: Ver entrenamientos disponibles
            $entrenamientos = Entrenamiento::where('estado', 'activo')->get();
        }

        return view('clases.entrenamientos', compact('entrenamientos'));
    }

    // Unirse a un entrenamiento
    public function unirseEntrenamiento($entrenamientoId)
    {
        $usuario = auth()->user();
        $entrenamiento = Entrenamiento::findOrFail($entrenamientoId);

        // Verificar si el usuario ya está inscrito
        $inscrito = $entrenamiento->usuarios()->where('usuario_id', $usuario->id)->exists();
        if ($inscrito) {
            return redirect()->back()->with('error', 'Ya estás inscrito en este entrenamiento.');
        }

        // Agregar al usuario al entrenamiento automáticamente
        $entrenamiento->usuarios()->attach($usuario->id, ['estado' => 'inscrito']); // Se asume que la relación de muchos a muchos está definida correctamente

        return redirect()->back()->with('success', 'Te has inscrito en el entrenamiento exitosamente.');
    }
}
