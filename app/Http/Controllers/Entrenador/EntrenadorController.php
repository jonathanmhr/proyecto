<?php

namespace App\Http\Controllers\Entrenador;

use App\Http\Controllers\Controller;
use App\Models\ClaseGrupal;
use App\Models\Suscripcion;
use App\Models\User;
use App\Models\Entrenamiento;
use Illuminate\Http\Request;
use App\Models\ReservaDeClase;

class EntrenadorController extends Controller
{
    public function index()
    {
        // Obtener las clases del entrenador con su estado de cambio pendiente
        $clases = ClaseGrupal::where('entrenador_id', auth()->id())
            ->select('id_clase', 'nombre', 'fecha_inicio', 'fecha_fin', 'cambio_pendiente')
            ->get();

        // Obtener las reservas de clases relacionadas con el entrenador
        $reservas = ReservaDeClase::whereIn('id_clase', $clases->pluck('id_clase'))->get();

        // Obtener los entrenamientos del entrenador
        $entrenamientos = Entrenamiento::where('id_usuario', auth()->id())->get();

        // Obtener las suscripciones activas
        $suscripciones = Suscripcion::where('id_usuario', auth()->id())->where('estado', 'activo')->get();

        // Obtener las suscripciones pendientes
        $suscripcionesPendientes = Suscripcion::where('estado', 'pendiente')
            ->whereHas('clase', function ($query) {
                $query->where('entrenador_id', auth()->user()->id); // Filtrar por clases del entrenador
            })
            ->get();

        // Pasar las clases, reservas, entrenamientos, suscripciones y solicitudes a la vista
        return view('entrenador.dashboard', compact('clases', 'reservas', 'entrenamientos', 'suscripciones', 'suscripcionesPendientes'));
    }

    public function misClases()
    {
        $clases = ClaseGrupal::where('entrenador_id', auth()->id())->get();
        return view('entrenador.clases.index', compact('clases'));
    }

    public function verSuscripciones()
    {
        $suscripcionesPendientes = \App\Models\Suscripcion::where('estado', 'pendiente')
            ->whereHas('clase', function ($query) {
                $query->where('entrenador_id', auth()->id());
            })
            ->paginate(10);

        return view('entrenador.suscripciones.index', compact('suscripcionesPendientes'));
    }

    public function aceptarSolicitud($claseId, $userId)
    {
        $user = User::findOrFail($userId);
        $clase = ClaseGrupal::findOrFail($claseId);

        // Verificar si el alumno ya está inscrito
        if (Suscripcion::where('id_clase', $clase->id)->where('id_usuario', $user->id)->exists()) {
            return redirect()->route('entrenador.dashboard')->with('error', 'El alumno ya está inscrito en esta clase.');
        }

        // Crear la suscripción activa
        Suscripcion::create([
            'id_usuario' => $user->id,
            'id_clase' => $clase->id,
            'estado' => Suscripcion::ESTADO_ACTIVO,  // Ahora activo
            'fecha_inicio' => now(),
            'fecha_fin' => now()->addMonth(),  // Suscripción de un mes, ejemplo
        ]);

        return redirect()->route('entrenador.dashboard')->with('success', 'Solicitud aceptada y suscripción creada.');
    }

    public function rechazarSolicitud($claseId, $userId)
    {
        $user = User::findOrFail($userId);
        $clase = ClaseGrupal::findOrFail($claseId);

        // Verificar si el alumno está inscrito
        $suscripcion = Suscripcion::where('id_clase', $clase->id)
            ->where('id_usuario', $user->id)
            ->first();
        if (!$suscripcion) {
            return redirect()->route('entrenador.dashboard')->with('error', 'El alumno no está inscrito en esta clase.');
        }

        // Eliminar la suscripción
        $suscripcion->delete();

        return redirect()->route('entrenador.dashboard')->with('success', 'Solicitud rechazada y el alumno eliminado de la clase.');
    }

    // Método para editar los detalles de una clase
    public function edit(ClaseGrupal $clase)
    {
        $clase->load('usuarios'); 
        dd($clase);
        return view('entrenador.clases.edit', compact('clase'));
    }

    public function quitarUsuario($claseId, $userId)
    {
        // Encuentra la clase y el usuario
        $clase = ClaseGrupal::findOrFail($claseId);
        $usuario = User::findOrFail($userId);
        
        // Quitar al usuario de la clase
        $clase->usuarios()->detach($usuario);
        
        // Redirigir a la vista con un mensaje de éxito
        return redirect()->route('entrenador.clases.edit', ['clase' => $claseId])
            ->with('success', 'Usuario quitado de la clase con éxito.');
    }    

    // Método para actualizar los detalles de la clase, pero debe marcarse como pendiente para aprobación
    public function updateClase(Request $request, $id)
    {
        $clase = ClaseGrupal::findOrFail($id);

        // Validar los datos de entrada
        $validated = $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'cupos_maximos' => 'required|integer',
            'ubicacion' => 'nullable|string|max:100',
            'duracion' => 'required|integer',
            'nivel' => 'required|in:principiante,intermedio,avanzado',
        ]);

        // Actualizar los datos de la clase
        $clase->update($validated);

        // Marcar como cambio pendiente para aprobación por el Admin
        $clase->cambio_pendiente = true;
        $clase->save();

        return redirect()->route('entrenador.clase.index')->with('success', 'Clase actualizada, pendiente de aprobación.');
    }
}
