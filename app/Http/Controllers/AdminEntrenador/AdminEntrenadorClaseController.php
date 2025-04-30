<?php

namespace App\Http\Controllers\AdminEntrenador;

use App\Http\Controllers\Controller;
use App\Models\ClaseGrupal;
use App\Models\User;
use Illuminate\Http\Request;

class AdminEntrenadorClaseController extends Controller
{
    public function index()
    {
        $clases = ClaseGrupal::all();
        return view('admin-entrenador.clases.index', compact('clases'));
    }

    public function create()
    {
        $entrenadores = User::whereHas('roles', function ($query) {
            $query->where('name', 'entrenador');
        })->get();

        if ($entrenadores->isEmpty()) {
            return redirect()->route('admin-entrenador.clases.index')
                ->with('error', 'No hay entrenadores disponibles para asignar a la clase.');
        }

        return view('admin-entrenador.clases.create', compact('entrenadores'));
    }

    public function store(Request $request)
    
    {
        if (!auth()->user()->can('admin_entrenador')) {
            abort(403, 'No tienes permiso para crear clases.');
        }
        
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'entrenador_id' => 'required|exists:users,id',
        ]);

        $clase = new ClaseGrupal();
        $clase->nombre = $request->nombre;
        $clase->descripcion = $request->descripcion;
        $clase->fecha_inicio = $request->fecha_inicio;
        $clase->entrenador_id = $request->entrenador_id;

        $clase->save();

        return redirect()->route('admin-entrenador.clases.index')->with('success', 'Clase creada correctamente.');
    }

    public function edit(ClaseGrupal $clase)
    {
        $entrenadores = User::whereHas('roles', function ($query) {
            $query->where('name', 'entrenador');
        })->get();

        return view('admin-entrenador.clases.edit', compact('clase', 'entrenadores'));
    }

    public function update(Request $request, ClaseGrupal $clase)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'entrenador_id' => 'required|exists:users,id',
        ]);

        $clase->nombre = $request->nombre;
        $clase->descripcion = $request->descripcion;
        $clase->fecha_inicio = $request->fecha_inicio;
        $clase->entrenador_id = $request->entrenador_id;

        $clase->save();

        return redirect()->route('admin-entrenador.clases.index')->with('success', 'Clase actualizada correctamente.');
    }

    public function destroy(ClaseGrupal $clase)
    {
        if (!auth()->user()->can('admin_entrenador')) {
            return redirect()->back()->with('error', 'No tienes permisos para eliminar clases.');
        }

        if ($clase->usuarios()->count() > 0) {
            return redirect()->back()->with('error', 'No se puede eliminar la clase porque tiene alumnos inscritos.');
        }

        $clase->delete();

        return redirect()->route('admin-entrenador.clases.index')->with('success', 'Clase eliminada correctamente.');
    }
}
