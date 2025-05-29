<?php
namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Suscripcion;
use App\Models\ClaseGrupal;
use App\Models\User;
use Illuminate\Http\Request;

class SolicitudClaseController extends Controller
{
    // Aceptar solicitud
    public function aceptarSolicitud($claseId, $usuarioId)
    {
        $clase = ClaseGrupal::findOrFail($claseId);
        $usuario = User::findOrFail($usuarioId);

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

    // Rechazar solicitud
    public function rechazarSolicitud($claseId, $usuarioId)
    {
        $clase = ClaseGrupal::findOrFail($claseId);
        $usuario = User::findOrFail($usuarioId);

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
