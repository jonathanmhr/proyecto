<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\ClaseGrupal;
use Illuminate\Http\Request;

class ClaseGrupalController extends Controller
{
    //public function index()
    //{
    //    $clases = ClaseGrupal::paginate(10);
    //    return view('clases.index', compact('clases'));
    //}
//
    //public function show(ClaseGrupal $clase)
    //{
    //    return view('clases.show', compact('clase'));
    //}
//
    //public function create()
    //{
    //    return view('clases.create');
    //}
//
    //public function store(Request $request)
    //{
    //    $data = $request->validate([
    //        'nombre' => 'required|string|max:255',
    //        'descripcion' => 'nullable|string',
    //        'fecha_inicio' => 'required|date',
    //        'cupos_maximos' => 'required|integer|min:1',
    //        // más reglas...
    //    ]);
//
    //    ClaseGrupal::create($data);
//
    //    return redirect()->route('clases.index')->with('success', 'Clase creada correctamente.');
    //}
//
    //public function edit(ClaseGrupal $clase)
    //{
    //    return view('clases.edit', compact('clase'));
    //}
//
    //public function update(Request $request, ClaseGrupal $clase)
    //{
    //    $data = $request->validate([
    //        'nombre' => 'required|string|max:255',
    //        'descripcion' => 'nullable|string',
    //        'fecha_inicio' => 'required|date',
    //        'cupos_maximos' => 'required|integer|min:1',
    //        // más reglas...
    //    ]);
//
    //    $clase->update($data);
//
    //    return redirect()->route('clases.index')->with('success', 'Clase actualizada correctamente.');
    //}
//
    //public function destroy(ClaseGrupal $clase)
    //{
    //    $clase->delete();
//
    //    return redirect()->route('clases.index')->with('success', 'Clase eliminada correctamente.');
    //}
}
