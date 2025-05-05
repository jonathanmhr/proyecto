<?php

namespace App\Http\Controllers\ClaseGrupal;

use App\Http\Controllers\Controller;
use App\Models\ClaseGrupal;
use Illuminate\Http\Request;
use App\Models\Suscripcion;
use App\Models\User;
use App\Models\ReservaDeClase;
use App\Models\Entrenamiento;
use App\Models\SolicitudClase;

class ClaseGrupalController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->can('admin_entrenador')) {
            // Admin-entrenador: Ve todas las clases
            $clases = ClaseGrupal::all();
        } elseif ($user->can('entrenador')) {
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

    public function unirse(ClaseGrupal $clase)
    {
        $usuario = auth()->user();

        // Verificar si el usuario ya está inscrito
        if ($clase->usuarios()->where('id_usuario', $usuario->id)->exists()) {
            return redirect()->route('cliente.clases.index')->with('info', 'Ya estás inscrito en esta clase.');
        }

        // Verificar si el usuario tiene una suscripción pendiente
        $suscripcionPendiente = Suscripcion::where('id_usuario', $usuario->id)
            ->where('id_clase', $clase->id)
            ->where('estado', 'pendiente')
            ->exists();

        if ($suscripcionPendiente) {
            return redirect()->route('cliente.clases.index')->with('info', 'Ya tienes una solicitud pendiente para unirte a esta clase.');
        }

        // Validar cupo disponible
        if ($clase->usuarios()->count() >= $clase->cupos_maximos) {
            return redirect()->route('cliente.clases.index')->with('error', 'Esta clase ya está llena.');
        }

        // Validar fecha de la clase (no se puede inscribir si ya ha pasado)
        if ($clase->fecha_inicio < now()) {
            return redirect()->route('cliente.clases.index')->with('error', 'No puedes inscribirte en una clase ya iniciada.');
        }

        // Crear la solicitud de inscripción (suscripción pendiente)
        Suscripcion::create([
            'id_usuario' => $usuario->id,
            'id_clase' => $clase->id,
            'estado' => 'pendiente', // Estado pendiente
        ]);

        return redirect()->route('cliente.clases.index')->with('success', 'Tu solicitud para unirte a la clase ha sido enviada.');
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

        // Asegúrate de que la suscripción esté pendiente antes de aceptarla
        $suscripcion = Suscripcion::where('id_usuario', $usuario->id)
            ->where('id_clase', $clase->id)
            ->where('estado', 'pendiente')
            ->first();

        if ($suscripcion) {
            $suscripcion->update(['estado' => 'aceptado']);
        }

        return redirect()->route('entrenador.clases.edit', ['id' => $clase->id_clase])
            ->with('success', 'La solicitud del alumno ha sido aceptada');
    }

    // Rechazar la solicitud de un usuario
    public function rechazarSolicitud($claseId, $usuarioId)
    {
        $clase = ClaseGrupal::findOrFail($claseId);
        $usuario = User::findOrFail($usuarioId);

        // Asegúrate de que la suscripción esté pendiente antes de rechazarla
        $suscripcion = Suscripcion::where('id_usuario', $usuario->id)
            ->where('id_clase', $clase->id)
            ->where('estado', 'pendiente')
            ->first();

        if ($suscripcion) {
            $suscripcion->update(['estado' => 'rechazado']);
        }

        return redirect()->route('entrenador.clases.edit', ['id' => $clase->id_clase])
            ->with('error', 'La solicitud del alumno ha sido rechazada');
    }
}
