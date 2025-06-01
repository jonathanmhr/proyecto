<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\ClaseGrupal;
use Illuminate\Http\Request;
use App\Models\InscripcionClaseGrupal;
use App\Models\SolicitudClaseGrupal;
use App\Models\User;
use Carbon\Carbon;

class ClaseGrupalController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Obtener las clases según el rol
        if ($user->can('admin_entrenador')) {
            $clases = ClaseGrupal::latest()->take(6)->get();
        } elseif ($user->can('entrenador')) {
            $clases = ClaseGrupal::where('entrenador_id', $user->id)->latest()->take(6)->get();
        } else {
            // Cliente: Solo clases futuras disponibles para unirse
            $clases = ClaseGrupal::whereDate('fecha_inicio', '>=', now()->startOfDay()) // Asegura que incluye el día actual
                // Nueva condición para verificar cupos REALES disponibles
                ->whereRaw('cupos_maximos > (SELECT COUNT(*) FROM inscripcion_clase_grupal WHERE clase_grupal_id = clases_grupales.id_clase AND estado = \'aceptado\')')

                // Excluir clases donde el usuario ya está aceptado o revocado
                ->whereDoesntHave('usuarios', function ($query) use ($user) {
                    $query->where('id_usuario', $user->id)
                        ->whereIn('estado', ['aceptado', 'revocado']);
                })
                // Excluir clases donde el usuario ya tiene una solicitud pendiente
                ->whereDoesntHave('solicitudes', function ($query) use ($user) {
                    $query->where('user_id', $user->id)
                        ->where('estado', 'pendiente');
                })
                ->orderBy('fecha_inicio', 'asc') // CAMBIO CRÍTICO: Ordenar por fecha de inicio, ascendente
                ->take(6)
                ->get();
        }

        // Verificación e indicadores visuales
        foreach ($clases as $clase) {
            // Cantidad actual de inscritos
            $inscritos = $clase->usuarios()->wherePivot('estado', 'aceptado')->count();
            $cuposTotales = $clase->cupos_maximos;

            // Calcular porcentaje ocupado
            $porcentaje = $cuposTotales > 0 ? ($inscritos / $cuposTotales) * 100 : 100;

            // Color según disponibilidad
            if ($porcentaje >= 100) {
                $clase->estado_color = 'bg-red-600 text-white'; // Lleno
            } elseif ($porcentaje >= 50) {
                $clase->estado_color = 'bg-yellow-500 text-black'; // A la mitad
            } else {
                $clase->estado_color = 'bg-green-600 text-white'; // Hay cupo
            }
        }

        return view('cliente.clases.index', compact('clases'));
    }

    public function unirse(Request $request, ClaseGrupal $clase)
    {
        $user = auth()->user();

        $yaInscrito = $clase->usuarios()->where('user_id', $user->id)->exists();
        if ($yaInscrito) {
            return redirect()->back()->with('error', 'Ya estás inscrito en esta clase.');
        }

        $solicitudPendiente = $clase->solicitudes()->where('user_id', $user->id)->where('estado', 'pendiente')->exists();
        if ($solicitudPendiente) {
            return redirect()->back()->with('error', 'Ya tienes una solicitud pendiente.');
        }

        $solicitudRechazada = $clase->solicitudes()->where('user_id', $user->id)->where('estado', 'rechazado')->exists();
        if ($solicitudRechazada) {
            return redirect()->back()->with('error', 'Te han rechazado de esta clase.');
        }

        $clase->solicitudes()->create([
            'user_id' => $user->id,
            'estado' => 'pendiente',
        ]);

        return redirect()->back()->with('success', 'Tu solicitud ha sido enviada y está pendiente de aprobación.');
    }
}
