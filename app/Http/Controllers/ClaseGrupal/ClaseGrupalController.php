<?php

namespace App\Http\Controllers\ClaseGrupal;

use App\Models\ClaseGrupal;
use App\Models\Suscripcion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClaseGrupalController extends Controller
{
    // Mostrar todas las clases disponibles
    public function index()
    {
        $user = auth()->user();

        // Mostrar clases según el rol
        if ($user->can('admin_entrenador')) {
            $clases = ClaseGrupal::all();
        } elseif ($user->can('entrenador')) {
            $clases = ClaseGrupal::where('entrenador_id', $user->id)->get();
        } else {
            // Mostrar solo clases con cupo disponible, fecha de inicio futura o actual
            $clases = ClaseGrupal::withCount('usuarios')
                ->whereDate('fecha_inicio', '>=', now())
                ->get()
                ->filter(function ($clase) {
                    return $clase->usuarios_count < $clase->cupos_maximos;
                });
        }

        return view('clases.index', compact('clases'));
    }

    // Mostrar el formulario para crear una nueva clase
    public function create()
    {
        return redirect()->route('clases.index');
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
    public function aceptarSolicitud(Request $request, ClaseGrupal $clase)
    {
        $usuario = auth()->user();

        // Verifica que el entrenador actual sea el dueño de la clase
        if ($clase->entrenador_id !== $usuario->id || !$usuario->can('entrenador-access')) {
            abort(403, 'No tienes permisos para aceptar solicitudes en esta clase.');
        }

        $suscripcion = Suscripcion::where('id_clase', $clase->id_clase)
            ->where('id_usuario', $request->id_usuario)
            ->where('estado', 'pendiente')
            ->first();

        if (!$suscripcion) {
            return redirect()->back()->with('error', 'No se encontró la solicitud pendiente.');
        }

        $suscripcion->update([
            'estado' => 'activo',
            'fecha_inicio' => now(),
            'fecha_fin' => now()->addMonth(),
        ]);

        return redirect()->back()->with('success', 'Solicitud aceptada correctamente.');
    }

    // Rechazar la solicitud de un usuario para unirse a una clase
    public function rechazarSolicitud(Request $request, ClaseGrupal $clase)
    {
        $usuario = auth()->user();

        // Verifica que el entrenador actual sea el dueño de la clase
        if ($clase->entrenador_id !== $usuario->id || !$usuario->can('entrenador-access')) {
            abort(403, 'No tienes permisos para rechazar solicitudes en esta clase.');
        }

        $suscripcion = Suscripcion::where('id_clase', $clase->id_clase)
            ->where('id_usuario', $request->id_usuario)
            ->where('estado', 'pendiente')
            ->first();

        if (!$suscripcion) {
            return redirect()->back()->with('error', 'No se encontró la solicitud pendiente.');
        }

        $suscripcion->delete();

        return redirect()->back()->with('success', 'Solicitud rechazada correctamente.');
    }
}
