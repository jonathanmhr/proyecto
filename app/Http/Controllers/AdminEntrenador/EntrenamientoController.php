<?php

namespace App\Http\Controllers\AdminEntrenador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Entrenamiento;
use App\Models\User;

class EntrenamientoController extends Controller
{
    public function index()
    {
        $entrenamientos = Entrenamiento::all();
        return view('admin-entrenador.entrenamientos.index', compact('entrenamientos'));
    }

    public function create()
    {
        return view('admin-entrenador.entrenamientos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'tipo' => 'required|string|max:50',
            'duracion' => 'required|integer',
            'fecha' => 'required|date',
        ]);

        Entrenamiento::create([
            'id_usuario' => auth()->id(),
            'nombre' => $request->nombre,
            'tipo' => $request->tipo,
            'duracion' => $request->duracion,
            'fecha' => $request->fecha,
        ]);

        return redirect()->route('entrenamientos.index')->with('success', 'Entrenamiento creado correctamente.');
    }

    public function edit($id_entrenamiento)
    {
        $entrenamiento = Entrenamiento::where('id_entrenamiento', $id_entrenamiento)->firstOrFail();
        return view('admin-entrenador.entrenamientos.edit', compact('entrenamiento'));
    }

    public function update(Request $request, $id_entrenamiento)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'tipo' => 'required|string|max:50',
            'duracion' => 'required|integer',
            'fecha' => 'required|date',
        ]);

        $entrenamiento = Entrenamiento::where('id_entrenamiento', $id_entrenamiento)->firstOrFail();
        $entrenamiento->update($request->only(['nombre', 'tipo', 'duracion', 'fecha']));

        return redirect()->route('entrenamientos.index')->with('success', 'Entrenamiento actualizado correctamente.');
    }

    public function destroy($id_entrenamiento)
    {
        $entrenamiento = Entrenamiento::where('id_entrenamiento', $id_entrenamiento)->firstOrFail();
        $entrenamiento->delete();

        return redirect()->route('entrenamientos.index')->with('success', 'Entrenamiento eliminado.');
    }

    public function show($id_entrenamiento)
    {
        $entrenamiento = Entrenamiento::where('id_entrenamiento', $id_entrenamiento)->firstOrFail();
        $usuarios = $entrenamiento->usuarios; // Relación many-to-many
        return view('admin-entrenador.entrenamientos.show', compact('entrenamiento', 'usuarios'));
    }

    public function asignarUsuario($id_entrenamiento)
    {
        $entrenamiento = Entrenamiento::where('id_entrenamiento', $id_entrenamiento)->firstOrFail();
        $usuarios = User::whereDoesntHave('entrenamientos', function ($q) use ($id_entrenamiento) {
            $q->where('entrenamiento_id', $id_entrenamiento);
        })->get();

        return view('admin-entrenador.entrenamientos.asignar', compact('entrenamiento', 'usuarios'));
    }

    public function guardarAsignacion(Request $request, $id_entrenamiento)
    {
        $entrenamiento = Entrenamiento::where('id_entrenamiento', $id_entrenamiento)->firstOrFail();
        $entrenamiento->usuarios()->attach($request->usuario_id);

        return redirect()->route('entrenamientos.usuarios', $id_entrenamiento)->with('success', 'Usuario asignado correctamente.');
    }

    public function quitarUsuario($id_entrenamiento, $usuario_id)
    {
        $entrenamiento = Entrenamiento::where('id_entrenamiento', $id_entrenamiento)->firstOrFail();
        $entrenamiento->usuarios()->detach($usuario_id);

        return redirect()->route('entrenamientos.usuarios', $id_entrenamiento)->with('success', 'Usuario eliminado del entrenamiento.');
    }
}
