<?php

namespace App\Http\Controllers\Entrenador;

use App\Http\Controllers\Controller;
use App\Models\ClaseGrupal;
use App\Models\Suscripcion;
use App\Models\User;
use Illuminate\Http\Request;

class EntrenadorController extends Controller
{

    public function index()
    {
        // Aquí puedes traer la información que necesitas para el dashboard, por ejemplo, clases del entrenador
        $clases = ClaseGrupal::where('id_entrenador', auth()->id())->get();

        return view('entrenador.dashboard', compact('clases'));
    }

    // Método para aceptar una solicitud de alumno
    public function aceptarSolicitud($claseId, $userId)
    {
        $user = User::findOrFail($userId);
        $clase = ClaseGrupal::findOrFail($claseId);

        // Verificar si el alumno ya está inscrito
        if ($clase->usuarios->contains($user)) {
            return redirect()->route('entrenador.dashboard')->with('error', 'El alumno ya está inscrito en esta clase.');
        }

        // Marcar la solicitud como aceptada pero pendiente de aprobación
        $clase->usuarios()->attach($user);

        // Crear una suscripción pendiente de aprobación por el Admin
        Suscripcion::create([
            'id_usuario' => $user->id,
            'id_clase' => $clase->id,
            'estado' => Suscripcion::ESTADO_INACTIVO,  // Pendiente de revisión
            'fecha_inicio' => now(),
            'fecha_fin' => now()->addMonth(),  // Por ejemplo, suscripción de un mes
        ]);

        return redirect()->route('entrenador.dashboard')->with('success', 'Solicitud aceptada, pendiente de aprobación por el Admin.');
    }

    // Método para rechazar una solicitud de alumno
    public function rechazarSolicitud($claseId, $userId)
    {
        $user = User::findOrFail($userId);
        $clase = ClaseGrupal::findOrFail($claseId);

        // Verificar si el alumno está inscrito en la clase
        if (!$clase->usuarios->contains($user)) {
            return redirect()->route('entrenador.dashboard')->with('error', 'El alumno no está inscrito en esta clase.');
        }

        // Eliminar la relación del alumno con la clase
        $clase->usuarios()->detach($user);

        // Cancelar la suscripción (estado inactivo)
        $suscripcion = Suscripcion::where('id_usuario', $user->id)
            ->where('id_clase', $clase->id)
            ->where('estado', Suscripcion::ESTADO_INACTIVO) // Asegurarse de que esté pendiente
            ->first();

        if ($suscripcion) {
            $suscripcion->estado = Suscripcion::ESTADO_INACTIVO;
            $suscripcion->save();
        }

        return redirect()->route('entrenador.dashboard')->with('success', 'Solicitud rechazada, el alumno ha sido eliminado de la clase.');
    }

    // Método para editar los detalles de una clase
    public function editClase($id)
    {
        $clase = ClaseGrupal::findOrFail($id);
        return view('entrenador.clase.edit', compact('clase'));
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
