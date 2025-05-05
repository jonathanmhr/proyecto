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

    // Mostrar las suscripciones del usuario
    public function suscripciones()
    {
        $suscripciones = Suscripcion::where('id_usuario', auth()->user()->id)->get();
        return view('clases.suscripciones', compact('suscripciones'));
    }

    public function unirse(ClaseGrupal $clase)
    {
        $usuario = auth()->user();

        // Verificar si el usuario ya está inscrito
        if ($clase->usuarios()->where('user_id', $usuario->id)->exists()) {
            return redirect()->route('cliente.clases.index')->with('info', 'Ya estás inscrito en esta clase.');
        }

        // Verificar si el usuario tiene una solicitud pendiente
        $solicitudPendiente = $clase->solicitudes()->where('user_id', $usuario->id)
            ->where('estado', 'pendiente')
            ->exists();

        if ($solicitudPendiente) {
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

        // Crear la solicitud de inscripción (estado pendiente)
        SolicitudClase::create([
            'user_id' => $usuario->id,
            'id_clase' => $clase->id,
            'estado' => 'pendiente',
        ]);

        return redirect()->route('cliente.clases.index')->with('success', 'Tu solicitud para unirte a la clase ha sido enviada.');
    }



    // Aceptar la solicitud de un usuario para unirse a una clase
    public function aceptarSolicitud($claseId, $usuarioId)
    {
        $clase = ClaseGrupal::findOrFail($claseId);
        $usuario = User::findOrFail($usuarioId);

        // Asegúrate de que la solicitud esté pendiente antes de aceptarla
        $solicitud = SolicitudClase::where('user_id', $usuario->id)
            ->where('id_clase', $clase->id)
            ->where('estado', 'pendiente')
            ->first();

        if ($solicitud) {
            $solicitud->update(['estado' => 'aceptado']);
        }

        // En este punto el usuario debería estar inscrito (si es necesario se puede agregar en otro lugar)
        return redirect()->route('entrenador.clases.edit', ['id' => $clase->id])
            ->with('success', 'La solicitud del alumno ha sido aceptada');
    }


    // Rechazar la solicitud de un usuario
    public function rechazarSolicitud($claseId, $usuarioId)
    {
        $clase = ClaseGrupal::findOrFail($claseId);
        $usuario = User::findOrFail($usuarioId);

        // Asegúrate de que la solicitud esté pendiente antes de rechazarla
        $solicitud = SolicitudClase::where('user_id', $usuario->id)
            ->where('id_clase', $clase->id)
            ->where('estado', 'pendiente')
            ->first();

        if ($solicitud) {
            $solicitud->update(['estado' => 'rechazado']);
        }

        return redirect()->route('entrenador.clases.edit', ['id' => $clase->id])
            ->with('error', 'La solicitud del alumno ha sido rechazada');
    }
}
