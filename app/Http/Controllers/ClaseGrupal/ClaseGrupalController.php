<?php

namespace App\Http\Controllers\ClaseGrupal;

use App\Models\User;
use App\Models\ClaseGrupal;
use App\Models\Suscripcion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClaseGrupalController extends Controller
{
    // Mostrar todas las clases disponibles
    public function index()
    {
        // Si el usuario es un administrador de entrenadores, mostrar todas las clases
        if (auth()->user()->can('admin_entrenador')) {
            $clases = ClaseGrupal::all(); // Todos los clases
        } else {
            // Si el usuario es un entrenador, mostrar solo las clases asignadas a él
            $clases = ClaseGrupal::where('id_entrenador', auth()->user()->id)->get();
        }

        return view('clases.index', compact('clases'));
    }

    // Mostrar el formulario para crear una nueva clase
    public function create()
    {
        // Solo los admins y entrenadores pueden crear clases
        return view('clases.create');
    }

    // Guardar una nueva clase en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:500',
        ]);

        // Solo el admin entrenador o el entrenador asignado puede crear la clase
        $clase = ClaseGrupal::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'id_entrenador' => auth()->user()->id, // El entrenador crea las clases que le corresponden
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
            'fecha_fin' => now()->addMonths(1),
        ]);

        return redirect()->route('dashboard')->with('success', 'Te has unido a la clase con éxito.');
    }

    // Editar clase (solo para el entrenador que creó la clase o el admin entrenador)
    public function edit(ClaseGrupal $clase)
    {
        // Verificar si el usuario es el entrenador asignado o el admin_entrenador
        if ($clase->id_entrenador !== auth()->user()->id && !auth()->user()->can('admin_entrenador')) {
            return redirect()->route('clases.index')->with('error', 'No tienes permiso para editar esta clase.');
        }

        $usuarios = $clase->usuarios;
        $todosLosUsuarios = User::where('email_verified_at', '!=', null)->get();

        return view('clases.edit', compact('clase', 'usuarios', 'todosLosUsuarios'));
    }

    // Actualizar clase
    public function update(Request $request, ClaseGrupal $clase)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:500',
        ]);

        // Solo el entrenador o el admin_entrenador puede actualizar la clase
        if ($clase->id_entrenador !== auth()->user()->id && !auth()->user()->can('admin_entrenador')) {
            return redirect()->route('clases.index')->with('error', 'No tienes permiso para editar esta clase.');
        }

        $clase->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('clases.index')->with('success', 'Clase actualizada.');
    }

    // Eliminar clase
    public function destroy(ClaseGrupal $clase)
    {
        // Solo el entrenador que creó la clase o un admin_entrenador puede eliminar la clase
        if ($clase->id_entrenador !== auth()->user()->id && !auth()->user()->can('admin_entrenador')) {
            return redirect()->route('clases.index')->with('error', 'No tienes permiso para eliminar esta clase.');
        }

        $clase->delete();

        return redirect()->route('clases.index')->with('success', 'Clase eliminada.');
    }

    // Agregar usuario a una clase
    public function agregarUsuario(Request $request, ClaseGrupal $clase)
    {
        $request->validate([
            'id_usuario' => 'required|exists:users,id',
        ]);

        // Solo el entrenador o admin_entrenador puede agregar usuarios
        if ($clase->id_entrenador !== auth()->user()->id && !auth()->user()->can('admin_entrenador')) {
            return back()->with('error', 'No tienes permiso para agregar usuarios a esta clase.');
        }

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

    // Eliminar usuario de la clase
    public function eliminarUsuario(ClaseGrupal $clase, User $user)
    {
        // Solo el entrenador o admin_entrenador puede eliminar usuarios
        if ($clase->id_entrenador !== auth()->user()->id && !auth()->user()->can('admin_entrenador')) {
            return back()->with('error', 'No tienes permiso para eliminar usuarios de esta clase.');
        }

        $clase->usuarios()->detach($user->id);
        return back()->with('success', 'Usuario eliminado de la clase.');
    }
}
