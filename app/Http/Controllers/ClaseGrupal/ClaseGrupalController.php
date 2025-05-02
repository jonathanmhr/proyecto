<?php

namespace App\Http\Controllers\ClaseGrupal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClaseGrupal;
use App\Models\Suscripcion;
use App\Models\User;

class ClaseGrupalController extends Controller
{
    // Mostrar todas las clases disponibles
    public function index()
    {
        $user = auth()->user();

        if ($user->isAn('admin_entrenador')) {
            $clases = ClaseGrupal::all();
        } elseif ($user->isAn('entrenador')) {
            $clases = ClaseGrupal::where('entrenador_id', $user->id)->get();
        } else {
            $clases = ClaseGrupal::withCount('usuarios')
                ->whereDate('fecha_inicio', '>=', now())
                ->havingRaw('usuarios_count < cupos_maximos')
                ->get();
        }

        return view('clases.index', compact('clases'));
    }

    // Permitir que un usuario se una a una clase
    public function unirse(ClaseGrupal $clase)
    {
        $usuario = auth()->user();

        if ($clase->usuarios()->where('id_usuario', $usuario->id)->exists()) {
            return redirect()->route('dashboard')->with('info', 'Ya estás inscrito en esta clase.');
        }

        if ($clase->usuarios()->count() >= $clase->cupos_maximos) {
            return redirect()->route('clases.index')->with('error', 'Esta clase ya está completa.');
        }

        if ($clase->fecha_inicio < now()) {
            return redirect()->route('clases.index')->with('error', 'No puedes inscribirte en una clase ya iniciada.');
        }

        Suscripcion::create([
            'id_usuario' => $usuario->id,
            'id_clase' => $clase->id_clase,
            'estado' => 'activo',
            'fecha_inicio' => now(),
            'fecha_fin' => now()->addMonths(1),
        ]);

        return redirect()->route('dashboard')->with('success', 'Te has unido a la clase con éxito.');
    }

    // Mostrar suscripciones del usuario
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
