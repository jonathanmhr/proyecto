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
        
        // Obtener las clases solo para el entrenador actual
        $clases = ClaseGrupal::where('entrenador_id', $user->id)->get();
    
        // Obtener entrenamientos del entrenador (utilizando id_usuario en lugar de id_entrenamiento)
        $entrenamientos = Entrenamiento::where('id_usuario', $user->id)->get();
        
        // Obtener clases con cambios pendientes, aprobadas y rechazadas
        $clasesPendientes = ClaseGrupal::where('entrenador_id', $user->id)
            ->where('cambio_pendiente', true)
            ->get();
        
        $clasesAprobadas = ClaseGrupal::where('entrenador_id', $user->id)
            ->where('cambio_pendiente', false)
            ->get();
        
        $clasesRechazadas = ClaseGrupal::where('entrenador_id', $user->id)
            ->where('cambio_pendiente', '!=', true)
            ->get();
        
        // Obtener las suscripciones activas para el entrenador
        $suscripciones = ClaseGrupal::whereHas('usuarios', function ($query) use ($user) {
            $query->where('id_usuario', $user->id)->where('estado', Suscripcion::ESTADO_ACTIVO);
        })->get();        
        
        // Pasar las variables a la vista
        return view('entrenador.dashboard', compact('clases', 'entrenamientos', 'clasesPendientes', 'clasesAprobadas', 'clasesRechazadas', 'suscripciones'));
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
