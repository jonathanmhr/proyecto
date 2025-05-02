<?php

namespace App\Http\Controllers\ClaseGrupal;

use App\Http\Controllers\Controller;
use App\Models\ClaseGrupal;
use Illuminate\Http\Request;
use App\Models\Suscripcion;

class ClaseGrupalController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin_entrenador')) {
            // Admin-entrenador: Ve todas las clases
            $clases = ClaseGrupal::all();
        } elseif ($user->hasRole('entrenador')) {
            // Entrenador: Ve solo sus propias clases
            $clases = ClaseGrupal::where('entrenador_id', $user->id)->get();
        } else {
            // Cliente: Ve solo clases futuras con cupos disponibles
            $clases = ClaseGrupal::whereDate('fecha_inicio', '>=', now())
                ->where('cupos_maximos', '>', 0) // Solo clases con cupos disponibles
                ->get();
        }

        return view('clases.index', compact('clases'));
    }

    public function unirse($id)
    {
        $clase = ClaseGrupal::findOrFail($id);
        $user = auth()->user();

        if ($clase->usuarios()->where('id_usuario', $user->id)->exists()) {
            return redirect()->route('clases.index')->with('info', 'Ya estás inscrito en esta clase.');
        }

        if ($clase->usuarios()->count() >= $clase->cupos_maximos) {
            return redirect()->route('clases.index')->with('error', 'Esta clase ya está llena.');
        }

        // Crear la suscripción
        $user->suscripciones()->create([
            'clase_id' => $clase->id,
            'estado' => 'activo',
        ]);

        return redirect()->route('clases.index')->with('success', 'Te has unido a la clase.');
    }

    // Mostrar las suscripciones del usuario
    public function suscripciones()
    {
        $suscripciones = Suscripcion::where('id_usuario', auth()->user()->id)->get();
        return view('clases.suscripciones', compact('suscripciones'));
    }

    // Aceptar la solicitud de un usuario para unirse a una clase
    public function aceptarSolicitud($claseId, $usuarioId)
    {
        $clase = ClaseGrupal::findOrFail($claseId);
        $usuario = User::findOrFail($usuarioId);

        $clase->usuarios()->updateExistingPivot($usuario->id, ['estado' => 'aceptado']);

        return redirect()->route('entrenador.clases.edit', ['id' => $clase->id_clase])
            ->with('success', 'La solicitud del alumno ha sido aceptada');
    }

    // Rechazar la solicitud de un usuario
    public function rechazarSolicitud($claseId, $usuarioId)
    {
        $clase = ClaseGrupal::findOrFail($claseId);
        $usuario = User::findOrFail($usuarioId);

        $clase->usuarios()->updateExistingPivot($usuario->id, ['estado' => 'rechazado']);

        return redirect()->route('entrenador.clases.edit', ['id' => $clase->id_clase])
            ->with('error', 'La solicitud del alumno ha sido rechazada');
    }
}
