<?php

namespace App\Http\Controllers\AdminEntrenamiento;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Entrenamiento;
use App\Models\User;

class AdminEntrenamientoController extends Controller
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
            'nombre' => 'required',
            'tipo' => 'required',
            'duracion' => 'required|integer',
            'fecha' => 'required|date',
        ]);

        Entrenamiento::create([
            'nombre' => $request->nombre,
            'tipo' => $request->tipo,
            'duracion' => $request->duracion,
            'fecha' => $request->fecha,
            'id_usuario' => auth()->id(), // o el entrenador actual
        ]);

        return redirect()->route('admin-entrenador.entrenamientos.index')->with('success', 'Entrenamiento creado correctamente.');
    }

    public function edit(Entrenamiento $entrenamiento)
    {
        return view('admin-entrenador.entrenamientos.edit', compact('entrenamiento'));
    }

    public function update(Request $request, Entrenamiento $entrenamiento)
    {
        $request->validate([
            'nombre' => 'required',
            'tipo' => 'required',
            'duracion' => 'required|integer',
            'fecha' => 'required|date',
        ]);

        $entrenamiento->update($request->only(['nombre', 'tipo', 'duracion', 'fecha']));

        return redirect()->route('admin-entrenador.entrenamientos.index')->with('success', 'Entrenamiento actualizado correctamente.');
    }

    public function destroy(Entrenamiento $entrenamiento)
    {
        $entrenamiento->delete();
        return redirect()->route('admin-entrenador.entrenamientos.index')->with('success', 'Entrenamiento eliminado.');
    }

    // Usuarios vinculados
    public function usuarios(Entrenamiento $entrenamiento)
    {
        $usuarios = User::where('role', 'cliente')->get(); // según cómo manejes roles
        $usuariosAsignados = $entrenamiento->usuarios ?? []; // si tienes la relación definida
        return view('admin-entrenador.entrenamientos.usuarios', compact('entrenamiento', 'usuarios', 'usuariosAsignados'));
    }

    public function agregarUsuario(Request $request, Entrenamiento $entrenamiento)
    {
        $request->validate([
            'usuario_id' => 'required|exists:users,id',
        ]);

        $entrenamiento->usuarios()->attach($request->usuario_id);
        return back()->with('success', 'Usuario agregado al entrenamiento.');
    }

    public function quitarUsuario(Entrenamiento $entrenamiento, User $usuario)
    {
        $entrenamiento->usuarios()->detach($usuario->id);
        return back()->with('success', 'Usuario quitado del entrenamiento.');
    }
}
