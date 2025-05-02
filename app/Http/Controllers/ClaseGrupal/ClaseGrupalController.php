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
    public function aceptarSolicitud($claseId, $usuarioId)
    {
        // Encuentra la clase y el usuario por su ID
        $clase = ClaseGrupal::findOrFail($claseId);
        $usuario = User::findOrFail($usuarioId);

        // Actualiza el estado de la suscripción en la tabla pivote
        $clase->usuarios()->updateExistingPivot($usuario->id, ['estado' => 'aceptado']);

        // Redirige de nuevo a la vista de edición de la clase con un mensaje de éxito
        return redirect()->route('entrenador.clase.edit', ['clase' => $clase->id_clase])
            ->with('success', 'La solicitud del alumno ha sido aceptada');
    }

    // Método para rechazar la solicitud
    public function rechazarSolicitud($claseId, $usuarioId)
    {
        // Encuentra la clase y el usuario por su ID
        $clase = ClaseGrupal::findOrFail($claseId);
        $usuario = User::findOrFail($usuarioId);

        // Actualiza el estado de la suscripción en la tabla pivote
        $clase->usuarios()->updateExistingPivot($usuario->id, ['estado' => 'rechazado']);

        // Redirige de nuevo a la vista de edición de la clase con un mensaje de error
        return redirect()->route('entrenador.clase.edit', ['clase' => $clase->id_clase])
            ->with('error', 'La solicitud del alumno ha sido rechazada');
    }
}
