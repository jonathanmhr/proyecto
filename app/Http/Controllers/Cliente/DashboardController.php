<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\ClaseGrupal;
use App\Models\Entrenamiento;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Cargar clases según rol, incluyendo usuarios (para contar aceptados) y solicitudes del usuario actual
        if ($user->can('admin_entrenador')) {
            $clases = ClaseGrupal::with([
                'usuarios',
                'solicitudes' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                }
            ])->latest()->take(6)->get();
        } elseif ($user->can('entrenador')) {
            $clases = ClaseGrupal::with([
                'usuarios',
                'solicitudes' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                }
            ])->where('entrenador_id', $user->id)->latest()->take(6)->get();
        } else {
            $clases = ClaseGrupal::with([
                'usuarios',
                'solicitudes' => function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                }
            ])->latest()->take(6)->get();
        }

        // Añadir estados extra a cada clase
        $clases = $clases->map(function ($clase) use ($user) {
            $solicitud = $clase->solicitudes->first();

            $inscritosAceptadosCount = $clase->usuarios->filter(function ($usuario) {
                return $usuario->pivot->estado === 'aceptada';
            })->count();

            $cuposRestantes = $clase->cupos_maximos - $inscritosAceptadosCount;

            $clase->inscrito = $solicitud && $solicitud->estado === 'aceptada';
            $clase->solicitud_pendiente = $solicitud && $solicitud->estado === 'pendiente';
            $clase->revocado = $solicitud && $solicitud->estado === 'rechazada';
            $clase->expirada = Carbon::parse($clase->fecha_inicio)->isPast();
            $clase->cupos_restantes = $cuposRestantes;

            return $clase;
        });

        // Cargar entrenamientos paginados
        $entrenamientos = Entrenamiento::latest()->paginate(6);

        // Obtener IDs de entrenamientos guardados por el usuario actual
        $entrenamientosGuardadosIds = $user->entrenamientos()->pluck('entrenamiento_id')->toArray();

        return view('cliente.dashboard', compact('clases', 'entrenamientos', 'entrenamientosGuardadosIds'));
    }


    public function unirse(Request $request, ClaseGrupal $clase)
    {
        $user = auth()->user();

        $inscritosAceptadosCount = $clase->usuarios()->wherePivot('estado', 'aceptada')->count();
        $cuposRestantes = $clase->cupos_maximos - $inscritosAceptadosCount;

        if ($cuposRestantes <= 0) {
            return redirect()->back()->with('error', 'No quedan cupos disponibles en esta clase.');
        }

        $yaInscritoAceptado = $clase->usuarios()->where('users.id', $user->id)->wherePivot('estado', 'aceptada')->exists();
        if ($yaInscritoAceptado) {
            return redirect()->back()->with('error', 'Ya estás inscrito y aceptado en esta clase.');
        }

        $solicitudPendiente = $clase->solicitudes()->where('user_id', $user->id)->where('estado', 'pendiente')->exists();
        if ($solicitudPendiente) {
            return redirect()->back()->with('error', 'Ya tienes una solicitud pendiente para esta clase.');
        }

        $yaRevocado = $clase->usuarios()->where('users.id', $user->id)->wherePivot('estado', 'rechazada')->exists();
        if ($yaRevocado) {
            return redirect()->back()->with('error', 'Tu inscripción a esta clase fue revocada anteriormente.');
        }

        $solicitudRechazada = $clase->solicitudes()->where('user_id', $user->id)->where('estado', 'rechazada')->exists();
        if ($solicitudRechazada) {
            return redirect()->back()->with('error', 'Tu solicitud anterior para esta clase fue rechazada.');
        }

        $clase->solicitudes()->create([
            'user_id' => $user->id,
            'estado' => 'pendiente',
        ]);

        return redirect()->back()->with('success', 'Tu solicitud ha sido enviada y está pendiente de aprobación.');
    }

    public function guardarEntrenamiento($id)
    {
        $user = auth()->user();
        $user->guardarEntrenamiento($id);

        return redirect()->route('cliente.entrenamientos.fases-dias', ['entrenamiento' => $id])
            ->with('success', 'Entrenamiento guardado. Ahora puedes planificarlo.');
    }


    public function quitarEntrenamiento($id)
    {
        $user = auth()->user();
        $user->quitarEntrenamiento($id);
        return back()->with('success', 'Entrenamiento quitado.');
    }
}
