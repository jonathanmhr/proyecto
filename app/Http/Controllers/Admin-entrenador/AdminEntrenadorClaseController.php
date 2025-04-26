<?php

namespace App\Http\Controllers\AdminEntrenador;

use App\Http\Controllers\Controller;
use App\Models\ClaseGrupal;
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
        return view('admin-entrenador.clases.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        ClaseGrupal::create($request->all());

        return redirect()->route('admin-entrenador.clases.index')->with('success', 'Clase creada correctamente');
    }

    public function edit(ClaseGrupal $clase)
    {
        return view('admin-entrenador.clases.edit', compact('clase'));
    }

    public function update(Request $request, ClaseGrupal $clase)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $clase->update($request->all());

        return redirect()->route('admin-entrenador.clases.index')->with('success', 'Clase actualizada correctamente');
    }

    public function destroy(ClaseGrupal $clase)
    {
        $clase->delete();
        return redirect()->route('admin-entrenador.clases.index')->with('success', 'Clase eliminada correctamente');
    }
}
