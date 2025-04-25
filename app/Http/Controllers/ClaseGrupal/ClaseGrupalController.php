<?php

namespace App\Http\Controllers\ClaseGrupal;

use App\Models\User;
use App\Models\ClaseGrupal;
use App\Http\Controllers\Controller;
use App\Models\Suscripcion;
use Illuminate\Http\Request;

class ClaseGrupalController extends Controller
{
    // Mostrar todas las clases disponibles
    public function index()
    {
        $clases = ClaseGrupal::all(); // Obtener todas las clases disponibles
        return view('clases.index', compact('clases'));
    }

    // Mostrar el formulario para crear una nueva clase (solo para admin/entrenador)
    public function create()
    {
        return view('clases.create');
    }

    // Guardar una nueva clase en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:500',
        ]);

        ClaseGrupal::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('clases.index')->with('success', 'Clase creada exitosamente.');
    }

    // Permitir que un usuario se una a una clase
    public function unirse(ClaseGrupal $clase)
    {
        $usuario = auth()->user();

        // Verificar si el usuario ya está inscrito
        if ($clase->usuarios()->where('id_usuario', $usuario->id)->exists()) {
            return redirect()->route('dashboard')->with('info', 'Ya estás inscrito en esta clase.');
        }

        // Crear la suscripción
        Suscripcion::create([
            'id_usuario' => $usuario->id,
            'id_clase' => $clase->id_clase,
            'estado' => 'activo',
            'fecha_inicio' => now(),
            'fecha_fin' => now()->addMonths(1), // Suscripción de un mes
        ]);

        return redirect()->route('dashboard')->with('success', 'Te has unido a la clase con éxito.');
    }

    public function edit(ClaseGrupal $clase)
    {
        $usuarios = $clase->usuarios; // usuarios inscritos
        $todosLosUsuarios = User::where('email_verified_at', '!=', null)->get(); // para agregar nuevos

        return view('clases.edit', compact('clase', 'usuarios', 'todosLosUsuarios'));
    }

    public function update(Request $request, ClaseGrupal $clase)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:500',
        ]);

        $clase->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('entrenador.clases.index')->with('success', 'Clase actualizada.');
    }

    public function destroy(ClaseGrupal $clase)
    {
        $clase->delete();
        return redirect()->route('entrenador.clases.index')->with('success', 'Clase eliminada.');
    }

    public function agregarUsuario(Request $request, ClaseGrupal $clase)
    {
        $request->validate([
            'id_usuario' => 'required|exists:users,id',
        ]);

        if ($clase->usuarios()->where('id_usuario', $request->id_usuario)->exists()) {
            return back()->with('info', 'El usuario ya está inscrito.');
        }

        Suscripcion::create([
            'id_usuario' => $request->id_usuario,
            'id_clase' => $clase->id_clase,
            'estado' => 'activo',
            'fecha_inicio' => now(),
            'fecha_fin' => now()->addMonths(1),
        ]);

        return back()->with('success', 'Usuario agregado a la clase.');
    }

    public function eliminarUsuario(ClaseGrupal $clase, User $user)
    {
        $clase->usuarios()->detach($user->id);
        return back()->with('success', 'Usuario eliminado de la clase.');
    }
}
