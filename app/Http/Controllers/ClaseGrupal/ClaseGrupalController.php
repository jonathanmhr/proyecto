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
        if (Suscripcion::where('id_clase', $clase->id)->where('id_usuario', $usuario->id)->exists()) {
            return redirect()->route('cliente.clases.index')->with('info', 'Ya estás inscrito en esta clase.');
        }
    
        // Verificar si ya existe una suscripción pendiente
        $suscripcionPendiente = Suscripcion::where('id_clase', $clase->id)
            ->where('id_usuario', $usuario->id)
            ->where('estado', 'pendiente')
            ->exists();
    
        if ($suscripcionPendiente) {
            return redirect()->route('cliente.clases.index')->with('info', 'Ya tienes una suscripción pendiente para esta clase.');
        }
    
        // Validar si hay cupo disponible en la clase
        if ($clase->usuarios()->count() >= $clase->cupos_maximos) {
            return redirect()->route('cliente.clases.index')->with('error', 'Esta clase ya está llena.');
        }
    
        // Validar fecha de la clase (no se puede inscribir si ya ha pasado)
        if ($clase->fecha_inicio < now()) {
            return redirect()->route('cliente.clases.index')->with('error', 'No puedes inscribirte en una clase que ya ha comenzado.');
        }
    
        // Crear la suscripción con estado 'pendiente'
        Suscripcion::create([
            'id_usuario' => $usuario->id,    // ID del usuario
            'id_clase' => $clase->id,        // ID de la clase
            'estado' => 'pendiente',         // Estado de la suscripción
            'fecha_inicio' => now(),         // Fecha de inicio
            'fecha_fin' => now()->addMonth(), // Fecha de finalización (por ejemplo, 1 mes)
        ]);
    
        return redirect()->route('cliente.clases.index')->with('success', 'Tu solicitud para unirte a la clase ha sido enviada.');
    }
    

    public function aceptarSolicitud($claseId, $usuarioId)
    {
        $clase = ClaseGrupal::findOrFail($claseId);
        $usuario = User::findOrFail($usuarioId);

        // Verificar si el usuario tiene una suscripción pendiente en la clase
        $suscripcion = Suscripcion::where('id_clase', $clase->id)
            ->where('id_usuario', $usuario->id)
            ->where('estado', 'pendiente')
            ->first();

        if (!$suscripcion) {
            return redirect()->route('entrenador.clases.index')->with('error', 'No hay una solicitud pendiente para este usuario en esta clase.');
        }

        // Marcar la suscripción como aceptada
        $suscripcion->update(['estado' => 'activo']);

        return redirect()->route('entrenador.clases.index')->with('success', 'La solicitud de inscripción del alumno ha sido aceptada.');
    }
    public function rechazarSolicitud($claseId, $usuarioId)
    {
        $clase = ClaseGrupal::findOrFail($claseId);
        $usuario = User::findOrFail($usuarioId);

        // Verificar si el usuario tiene una suscripción pendiente en la clase
        $suscripcion = Suscripcion::where('id_clase', $clase->id)
            ->where('id_usuario', $usuario->id)
            ->where('estado', 'pendiente')
            ->first();

        if (!$suscripcion) {
            return redirect()->route('entrenador.clases.index')->with('error', 'No hay una solicitud pendiente para este usuario en esta clase.');
        }

        // Marcar la suscripción como rechazada
        $suscripcion->update(['estado' => 'rechazado']);

        return redirect()->route('entrenador.clases.index')->with('success', 'La solicitud de inscripción del alumno ha sido rechazada.');
    }
}
