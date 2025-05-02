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

        // Mostrar clases según el rol
        if ($user->can('admin_entrenador')) {
            $clases = ClaseGrupal::all();
        } elseif ($user->can('entrenador')) {
            $clases = ClaseGrupal::where('entrenador_id', $user->id)->get();
        } else {
            // Mostrar solo clases con cupo disponible, fecha de inicio futura o actual
            $clases = ClaseGrupal::withCount('usuarios')
                ->whereDate('fecha_inicio', '>=', now())
                ->get()
                ->filter(function ($clase) {
                    return $clase->usuarios_count < $clase->cupos_maximos;
                });
        }

        return view('entrenador.clases.index', compact('clases'));
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
