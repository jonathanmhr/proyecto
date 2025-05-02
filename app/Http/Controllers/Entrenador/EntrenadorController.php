<?php

namespace App\Http\Controllers\Entrenador;

use App\Http\Controllers\Controller;
use App\Models\ClaseGrupal;
use App\Models\Entrenamiento;
use App\Models\Suscripcion;

class EntrenadorController extends Controller
{
    public function index()
    {
        $user = auth()->user();
    
        // Obtener clases según el rol
        if ($user->can('admin_entrenador')) {
            $clases = ClaseGrupal::all();
            $clasesPendientes = ClaseGrupal::where('estado', 'pendiente')->get();
            $clasesAprobadas = ClaseGrupal::where('estado', 'aprobada')->get();
            $clasesRechazadas = ClaseGrupal::where('estado', 'rechazada')->get();
        } elseif ($user->can('entrenador')) {
            $clases = ClaseGrupal::where('entrenador_id', $user->id)->get();
            $clasesPendientes = ClaseGrupal::where('entrenador_id', $user->id)->where('estado', 'pendiente')->get();
            $clasesAprobadas = ClaseGrupal::where('entrenador_id', $user->id)->where('estado', 'aprobada')->get();
            $clasesRechazadas = ClaseGrupal::where('entrenador_id', $user->id)->where('estado', 'rechazada')->get();
        }
    
        // Obtener entrenamientos y suscripciones (modifica según cómo lo manejas)
        $entrenamientos = Entrenamiento::where('entrenador_id', $user->id)->get();
        $suscripciones = Suscripcion::where('usuario_id', $user->id)->get();
    
        return view('entrenador.dashboard', compact('clases', 'clasesPendientes', 'clasesAprobadas', 'clasesRechazadas', 'entrenamientos', 'suscripciones'));
    }

    public function editClase($id)
    {
        $clase = ClaseGrupal::findOrFail($id);
        return view('entrenador.clase.edit', compact('clase'));
    }

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

        // Marcar como cambio pendiente
        $clase->cambio_pendiente = true;
        $clase->save();

        return redirect()->route('entrenador.clase.index')->with('success', 'Clase actualizada, pendiente de aprobación.');
    }
}
