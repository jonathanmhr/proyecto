<?php

namespace App\Http\Controllers\AdminEntrenador;

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
            'id_usuario' => auth()->id(),
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

    public function usuarios(Entrenamiento $entrenamiento)
    {
        // Obtenemos todos los usuarios que tienen el rol "cliente"
        $usuarios = User::whereHas('roles', function ($query) {
            $query->where('name', 'cliente');  // Reemplaza 'name' con el nombre real del campo de rol en la tabla de roles
        })->get();

        $usuariosAsignados = $entrenamiento->usuarios ?? [];
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

    public function agregarUsuariosMasivos(Request $request, Entrenamiento $entrenamiento)
    {
        // Validar que los IDs de usuario sean correctos
        $request->validate([
            'usuario_ids' => 'required|array',
            'usuario_ids.*' => 'exists:users,id', // Validar que cada ID de usuario exista en la base de datos
        ]);

        // Agregar los usuarios seleccionados al entrenamiento
        $entrenamiento->usuarios()->attach($request->usuario_ids);

        // Redirigir de nuevo con un mensaje de éxito
        return back()->with('success', 'Usuarios agregados correctamente al entrenamiento.');
    }
}
