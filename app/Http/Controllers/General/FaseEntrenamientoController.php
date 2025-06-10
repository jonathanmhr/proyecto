<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Entrenamiento;
use App\Models\FaseEntrenamientoDia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

        // Verificar que no exista ya la asignación para esa fase y fecha y usuario
        $existe = FaseEntrenamientoDia::where('entrenamiento_id', $entrenamiento->id)
            ->where('fase_entrenamiento_id', $fase->id)
            ->where('fecha', $request->fecha)
            ->where('user_id', $user->id)
            ->first();

        if ($existe) {
            return response()->json(['message' => 'Ya existe esta asignación para esa fecha'], 409);
        }

        $faseDia = FaseEntrenamientoDia::create([
            'entrenamiento_id' => $entrenamiento->id,
            'fase_entrenamiento_id' => $fase->id,
            'fecha' => $request->fecha,
            'estado' => 'pendiente',
            'user_id' => $user->id,
        ]);

        return response()->json($faseDia, 201);
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
}
