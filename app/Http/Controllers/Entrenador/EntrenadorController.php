<?php

namespace App\Http\Controllers\Entrenador;

use App\Http\Controllers\Controller;
use App\Models\ClaseGrupal;
use App\Models\Suscripcion;
use App\Models\SolicitudClase;
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
                $query->where('entrenador_id', auth()->user()->id);
            })
            ->get();

        // Solicitudes pendientes
        $solicitudesPendientes = SolicitudClase::where('estado', 'pendiente')
            ->whereIn('id_clase', $clases->pluck('id_clase'))
            ->get();

        // Pasar las clases, reservas, entrenamientos, suscripciones y solicitudes a la vista
        return view('entrenador.dashboard', compact('clases', 'reservas', 'entrenamientos', 'suscripciones', 'suscripcionesPendientes', 'solicitudesPendientes'));
    }

    public function misClases()
    {
        $clases = ClaseGrupal::where('entrenador_id', auth()->id())->get();
        return view('entrenador.clases.index', compact('clases'));
    }

    public function verSolicitudesPendientes()
    {
        // Obtener las solicitudes pendientes para las clases del entrenador
        $solicitudesPendientes = SolicitudClase::where('estado', 'pendiente')
            ->whereHas('clase', function ($query) {
                $query->where('entrenador_id', auth()->id());
            })
            ->with(['usuario', 'clase'])
            ->get();

        return view('entrenador.solicitudes.index', compact('solicitudesPendientes'));
    }

    public function verAlumnos(ClaseGrupal $clase)
    {
        // Obtener los usuarios que han solicitado unirse a la clase y han sido aceptados
        $alumnos = SolicitudClase::where('id_clase', $clase->id_clase)
            ->where('estado', 'aceptado')
            ->with('usuario')  // Asegúrate de cargar la relación de usuario
            ->get();

        return view('entrenador.clases.alumnos', compact('clase', 'alumnos'));
    }

    // Método para editar los detalles de una clase
    public function edit(ClaseGrupal $clase)
    {
        return view('entrenador.clases.edit', compact('clase'));
    }

    // Método para aceptar una solicitud de un alumno
    public function aceptarSolicitud($claseId, $userId)
    {
        // Buscar la clase
        $clase = ClaseGrupal::findOrFail($claseId);

        // Buscar la solicitud pendiente
        $solicitud = SolicitudClase::where('id_clase', $claseId)
            ->where('user_id', $userId)
            ->where('estado', 'pendiente')
            ->first();

        if (!$solicitud) {
            return redirect()->route('entrenador.clases.index')->with('error', 'No se ha encontrado una solicitud pendiente.');
        }

        // Cambiar el estado a 'aceptado'
        $solicitud->estado = 'aceptado';
        $solicitud->save();

        // Aquí puedes agregar lógica adicional, como agregar al usuario a la clase, si es necesario.

        return redirect()->route('entrenador.clases.index')->with('success', 'La solicitud ha sido aceptada.');
    }

    // Método para rechazar una solicitud de un alumno
    public function rechazarSolicitud($claseId, $userId)
    {
        // Buscar la clase
        $clase = ClaseGrupal::findOrFail($claseId);

        // Buscar la solicitud pendiente
        $solicitud = SolicitudClase::where('id_clase', $claseId)
            ->where('user_id', $userId)
            ->where('estado', 'pendiente')
            ->first();

        if (!$solicitud) {
            return redirect()->route('entrenador.clases.index')->with('error', 'No se ha encontrado una solicitud pendiente.');
        }

        // Cambiar el estado a 'rechazado'
        $solicitud->estado = 'rechazado';
        $solicitud->save();

        return redirect()->route('entrenador.clases.index')->with('success', 'La solicitud ha sido rechazada.');
    }

    public function eliminarAlumno($claseId, $alumnoId)
    {
        // Encontrar la clase y el alumno
        $clase = ClaseGrupal::findOrFail($claseId);
        $alumno = User::findOrFail($alumnoId);

        // Eliminar la suscripción
        $suscripcion = Suscripcion::where('id_clase', $clase->id_clase)
            ->where('id_usuario', $alumno->id)
            ->first();

        $suscripcion->delete();

        // Notificar al admin_entrenador
        // Notification::send($adminEntrenador, new AlumnoEliminadoNotificacion($alumno, $clase));

        return redirect()->route('entrenador.clases.alumnos', $clase->id_clase)
            ->with('success', 'El alumno ha sido eliminado de la clase.');
    }

    // Método para actualizar los detalles de la clase, pero debe marcarse como pendiente para aprobación
    public function updateClase(Request $request, $id)
    {
        // Validar los datos recibidos
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            'ubicacion' => 'required|string|max:255',
            'cupos_maximos' => 'required|integer|min:1',
            'nivel' => 'required|string|in:principiante,intermedio,avanzado',
        ]);

        // Encontrar la clase
        $clase = ClaseGrupal::findOrFail($id);

        // Actualizar los datos
        $clase->nombre = $request->input('nombre');
        $clase->descripcion = $request->input('descripcion');
        $clase->ubicacion = $request->input('ubicacion');
        $clase->cupos_maximos = $request->input('cupos_maximos');
        $clase->nivel = $request->input('nivel');

        // Marcar como pendiente
        $clase->cambio_pendiente = true;
        $clase->save();

        // Notificar al admin_entrenador sobre los cambios pendientes (puedes implementar una notificación)
        // Notification::send($adminEntrenador, new CambioPendienteNotificacion($clase));

        return redirect()->route('entrenador.clases.index')->with('success', 'Tu clase ha sido actualizada y está pendiente de aprobación.');
    }
}
