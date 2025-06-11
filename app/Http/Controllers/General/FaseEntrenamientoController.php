<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Entrenamiento;
use App\Models\FaseEntrenamientoDia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Notifications\NotificacionPersonalizada;
use Illuminate\Support\Facades\Notification;

class FaseEntrenamientoController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Traemos solo los entrenamientos guardados sin cargar fases planificadas
        $entrenamientos = $user->entrenamientosGuardados()
            ->with('fases.actividades')
            ->get();

        return view('cliente.entrenamientos.index', compact('entrenamientos'));
    }

    public function planificar(Entrenamiento $entrenamiento)
    {
        $user = Auth::user();

        if (!$user->entrenamientosGuardados()->where('entrenamiento_id', $entrenamiento->id)->exists()) {
            abort(403, 'No autorizado para planificar este entrenamiento');
        }

        $entrenamiento->load(['fases', 'diasPlanificados' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }]);

        $hoy = Carbon::today();

        $diaActual = $hoy->day;

        $fechaMin = $hoy->copy();

        $fechaMax = $fechaMin->copy()->addMonth()->day($diaActual);

        if ($fechaMax->month !== $fechaMin->copy()->addMonth()->month) {
            $fechaMax = $fechaMin->copy()->addMonth()->endOfMonth();
        }

        return view('cliente.entrenamientos.planificar', compact('entrenamiento', 'fechaMin', 'fechaMax'));
    }


    public function store(Request $request, Entrenamiento $entrenamiento)
    {
        $request->validate([
            'fase_entrenamiento_id' => 'required|exists:fases_entrenamiento,id',
            'fecha' => 'required|date',
        ]);

        $fase = $entrenamiento->fases()->findOrFail($request->fase_entrenamiento_id);

        $user = Auth::user();

        $existe = FaseEntrenamientoDia::where('entrenamiento_id', $entrenamiento->id)
            ->where('fase_entrenamiento_id', $fase->id)
            ->where('fecha', $request->fecha)
            ->where('user_id', $user->id)
            ->first();

        if ($existe) {
            return redirect()
                ->back()
                ->with('error', 'Ya existe esta asignación para esa fecha');
        }

        $faseDia = FaseEntrenamientoDia::create([
            'entrenamiento_id' => $entrenamiento->id,
            'fase_entrenamiento_id' => $fase->id,
            'fecha' => $request->fecha,
            'estado' => 'pendiente',
            'user_id' => $user->id,
        ]);

        // Crear la notificación
        $titulo = '¡Tienes un entrenamiento programado para hoy!';
        $mensaje = "Recuerda realizar tu entrenamiento '{$entrenamiento->titulo}' hoy, fase: '{$fase->nombre}'.";

        $fechaEnvio = Carbon::parse($request->fecha)->startOfDay()->addHours(8); // se enviará a las 08:00

        $notificacion = new NotificacionPersonalizada(
            $titulo,
            $mensaje,
            'entrenamiento',
            ['database', 'mail'],
            Auth::user() // remitente: el mismo usuario que planifica
        );

        // Programar el envío
        $user->notify($notificacion->delay($fechaEnvio));

        return redirect()
            ->route('cliente.entrenamientos.index')
            ->with('success', 'Entrenamiento planificado correctamente. Recibirás una notificación el día correspondiente.');
    }


    public function updateEstado(Request $request, FaseEntrenamientoDia $dia)
    {
        $user = Auth::user();

        if ($dia->user_id !== $user->id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        $dia->estado = $request->input('estado', 'completado');
        $dia->save();

        return response()->json(['message' => 'Estado actualizado', 'dia' => $dia]);
    }

    public function destroy(FaseEntrenamientoDia $dia)
    {
        $user = Auth::user();

        if ($dia->user_id !== $user->id) {
            return redirect()->back()->with('error', 'No autorizado.');
        }

        $dia->delete();

        return redirect()->back()->with('success', 'Fase eliminada correctamente.');
    }
}
