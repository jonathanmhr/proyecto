<?php

namespace App\Http\Controllers\Entrenador;

use App\Http\Controllers\Controller;
use App\Models\ClaseGrupal;
use App\Models\Suscripcion;
use App\Models\SolicitudClase;
use App\Models\ClaseIndividual;
use App\Models\User;
use App\Models\Entrenamiento;
use Illuminate\Http\Request;
use App\Models\ReservaDeClase;
use Illuminate\Support\Facades\Auth;
use App\Models\SolicitudClaseIndividual;
use Illuminate\Support\Facades\Notification;

class EntrenadorController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        // Clases Grupales del entrenador
        $clases = ClaseGrupal::where('entrenador_id', $user->id)
            ->select('id_clase', 'nombre', 'fecha_inicio', 'fecha_fin', 'cambio_pendiente')
            ->get();

        // Clases Individuales del entrenador
        $clasesIndividuales = ClaseIndividual::where('entrenador_id', $user->id)
            ->select('id', 'titulo', 'fecha_inicio', 'fecha_fin')
            ->get();

        // Reservas de clases grupales
        $reservas = ReservaDeClase::whereIn('id_clase', $clases->pluck('id_clase'))->get();

        // Entrenamientos creados por el entrenador
        $entrenamientos = Entrenamiento::where('creado_por', $user->id)->latest()->paginate(6);

        // Solicitudes pendientes (grupales)
        $solicitudesPendientes = SolicitudClase::where('estado', 'pendiente')
            ->whereIn('id_clase', $clases->pluck('id_clase'))
            ->get();

        return view('entrenador.dashboard', compact(
            'clases',
            'clasesIndividuales',
            'reservas',
            'entrenamientos',
            'solicitudesPendientes'
        ));
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
            ->where('estado', 'aceptada')
            ->with('usuario')  // Asegúrate de cargar la relación de usuario
            ->get();

        return view('entrenador.clases.alumnos', compact('clase', 'alumnos'));
    }
    // Método para aceptar una solicitud de un alumno

    public function aceptarSolicitud($id)
    {
        $solicitud = SolicitudClase::findOrFail($id);

        // Asegurarse de que la solicitud esté pendiente
        if ($solicitud->estado !== 'pendiente') {
            return redirect()->route('entrenador.solicitudes.index')
                ->with('error', 'La solicitud no está pendiente.');
        }

        $clase = $solicitud->clase;

        // Verificar que la clase pertenece al entrenador
        if ($clase->entrenador_id != auth()->id()) {
            return redirect()->route('entrenador.solicitudes.index')
                ->with('error', 'No puedes aceptar solicitudes para esta clase.');
        }

        // ❗️ Verificar que hay cupos disponibles
        $inscritosCount = $clase->usuarios()->wherePivot('estado', 'aceptada')->count();
        if ($inscritosCount >= $clase->cupos_maximos) {
            return redirect()->route('entrenador.solicitudes.index')
                ->with('error', 'La clase ya está llena.');
        }

        // Cambiar el estado de la solicitud a aceptada
        $solicitud->estado = 'aceptada';
        $solicitud->save();

        // ✅ Añadir al usuario como inscrito en la clase (evita duplicados)
        $clase->usuarios()->syncWithoutDetaching([
            $solicitud->user_id => ['estado' => 'aceptada']
        ]);

        return redirect()->route('entrenador.solicitudes.index')
            ->with('success', 'La solicitud ha sido aceptada.');
    }

    public function rechazarSolicitud($id)
    {
        // Buscar la solicitud pendiente por su id
        $solicitud = SolicitudClase::findOrFail($id);

        // Asegúrate de que la solicitud esté pendiente
        if ($solicitud->estado !== 'pendiente') {
            return redirect()->route('entrenador.solicitudes.index')->with('error', 'La solicitud no está pendiente.');
        }

        // Buscar la clase asociada a la solicitud
        $clase = $solicitud->clase;

        // Verificar que la clase pertenece al entrenador
        if ($clase->entrenador_id != auth()->id()) {
            return redirect()->route('entrenador.solicitudes.index')->with('error', 'No puedes rechazar solicitudes para esta clase.');
        }

        // Cambiar el estado de la solicitud a 'rechazado'
        $solicitud->estado = 'rechazado';
        $solicitud->save();

        return redirect()->route('entrenador.solicitudes.index')->with('success', 'La solicitud ha sido rechazada.');
    }

    public function obtenerEstadosClases()
    {
        try {
            $entrenadorId = Auth::id();

            // Contar solicitudes grupales por estado
            $solicitudesGrupales = SolicitudClase::whereHas('clase', function ($query) use ($entrenadorId) {
                $query->where('entrenador_id', $entrenadorId);
            })->selectRaw("
            SUM(CASE WHEN estado = 'aceptado' THEN 1 ELSE 0 END) as aceptadas,
            SUM(CASE WHEN estado = 'pendiente' THEN 1 ELSE 0 END) as pendientes,
            SUM(CASE WHEN estado = 'rechazado' THEN 1 ELSE 0 END) as rechazadas
        ")->first();

            // Contar solicitudes individuales por estado
            $solicitudesIndividuales = SolicitudClaseIndividual::where('entrenador_id', $entrenadorId)
                ->selectRaw("
                SUM(CASE WHEN estado = 'aceptado' THEN 1 ELSE 0 END) as aceptadas,
                SUM(CASE WHEN estado = 'pendiente' THEN 1 ELSE 0 END) as pendientes,
                SUM(CASE WHEN estado = 'rechazado' THEN 1 ELSE 0 END) as rechazadas
            ")->first();

            // Sumar totales
            $aceptadas = $solicitudesGrupales->aceptadas + $solicitudesIndividuales->aceptadas;
            $pendientes = $solicitudesGrupales->pendientes + $solicitudesIndividuales->pendientes;
            $rechazadas = $solicitudesGrupales->rechazadas + $solicitudesIndividuales->rechazadas;

            return response()->json([
                'aceptadas' => $aceptadas,
                'pendientes' => $pendientes,
                'rechazadas' => $rechazadas,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error en obtenerEstadosClases: ' . $e->getMessage());
            return response()->json(['error' => 'Error al obtener estados'], 500);
        }
    }
}
