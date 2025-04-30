<?php

namespace App\Http\Controllers\AdminEntrenador;

use App\Http\Controllers\Controller;
use App\Models\ClaseGrupal;
use App\Models\User; // Si lo necesitas para entrenadores
use Illuminate\Http\Request;

class AdminEntrenadorClaseController extends Controller
{
    // Mostrar listado de clases
    public function index()
    {
        $clases = ClaseGrupal::all(); // O puedes usar paginación
        return view('admin-entrenador.clases.index', compact('clases'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        $entrenadores = User::whereIs('entrenador')->get(); // Trae solo los entrenadores
        return view('admin-entrenador.clases.create', compact('entrenadores'));
    }

    // Almacenar nueva clase
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'entrenador_id' => 'required|exists:users,id',
            'fecha' => 'required|date',
        ]);

        ClaseGrupal::create([
            'nombre' => $request->nombre,
            'entrenador_id' => $request->entrenador_id,
            'fecha' => $request->fecha,
        ]);

        return redirect()->route('admin-entrenador.clases.index')->with('success', 'Clase creada con éxito.');
    }

    // Mostrar formulario de edición
    public function edit(ClaseGrupal $clase)
    {
        $entrenadores = User::role('entrenador')->get(); // Trae solo los entrenadores
        return view('admin-entrenador.clases.edit', compact('clase', 'entrenadores'));
    }

    // Actualizar clase
    public function update(Request $request, ClaseGrupal $clase)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'entrenador_id' => 'required|exists:users,id',
            'fecha' => 'required|date',
        ]);

        $clase->update([
            'nombre' => $request->nombre,
            'entrenador_id' => $request->entrenador_id,
            'fecha' => $request->fecha,
        ]);

        return redirect()->route('admin-entrenador.clases.index')->with('success', 'Clase actualizada con éxito.');
    }

    // Eliminar clase
    public function destroy(ClaseGrupal $clase)
    {
        // Verificar si el usuario tiene el rol de admin-entrenador
        if (!auth()->user()->can('admin_entrenador')) {
            return redirect()->route('admin-entrenador.clases.index')->with('error', 'No tienes permiso para eliminar esta clase.');
        }
    
        // Verificar si la clase tiene usuarios inscritos
        if ($clase->usuarios()->count() > 0) {
            return redirect()->route('admin-entrenador.clases.index')->with('error', 'No puedes eliminar la clase porque tiene usuarios inscritos.');
        }
    
        // Eliminar la clase
        $clase->delete();
    
        return redirect()->route('admin-entrenador.clases.index')->with('success', 'Clase eliminada con éxito.');
    }
}
