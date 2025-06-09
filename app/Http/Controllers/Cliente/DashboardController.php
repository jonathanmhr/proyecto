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

        // Cargar entrenamientos
        $entrenamientos = Entrenamiento::latest()->paginate(6);

        // Añadir estados extra a cada clase
        $clases = $clases->map(function ($clase) use ($user) {
            $solicitud = $clase->solicitudes->first();

            // Contar usuarios aceptados desde la colección precargada
            $inscritosAceptadosCount = $clase->usuarios->filter(function ($usuario) {
                return $usuario->pivot->estado === 'aceptada';
            })->count();

            $cuposRestantes = $clase->cupos_maximos - $inscritosAceptadosCount;

            $clase->inscrito = $solicitud && $solicitud->estado === 'aceptada';
            $clase->solicitud_pendiente = $solicitud && $solicitud->estado === 'pendiente';
            $clase->revocado = $solicitud && $solicitud->estado === 'rechazada';
            $clase->expirada = \Carbon\Carbon::parse($clase->fecha_inicio)->isPast();
            $clase->cupos_restantes = $cuposRestantes;

            return $clase;
        });

        return view('cliente.dashboard', compact('clases', 'entrenamientos'));
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

    // Guardar entrenamiento para el usuario autenticado
    public function guardarEntrenamiento($id)
    {
        $user = Auth::user();

        // Verificar que el entrenamiento exista
        $entrenamiento = Entrenamiento::findOrFail($id);

        // Añadir sin eliminar otros guardados
        $user->entrenamientos()->syncWithoutDetaching([$id]);

        return back()->with('success', 'Entrenamiento guardado correctamente.');
    }

    // Quitar entrenamiento guardado por el usuario
    public function quitarEntrenamiento($id)
    {
        $user = Auth::user();

        $entrenamiento = Entrenamiento::findOrFail($id);

        // Quitar de la relación
        $user->entrenamientos()->detach($id);

        return back()->with('success', 'Entrenamiento quitado correctamente.');
    }
}
