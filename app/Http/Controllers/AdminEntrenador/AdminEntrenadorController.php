<?php

namespace App\Http\Controllers\AdminEntrenador;

use App\Http\Controllers\Controller;
use App\Models\ClaseGrupal;
use App\Models\User;
use Illuminate\Http\Request;
use Silber\Bouncer\BouncerFacade as Bouncer;

class AdminEntrenadorController extends Controller
{
    public function dashboard()
    {
        $totalClases = ClaseGrupal::count();
        $totalEntrenadores = Bouncer::role()->where('name', 'entrenador')->first()->users()->count();
        $totalAlumnos = Bouncer::role()->where('name', 'cliente')->first()->users()->count();

        return view('admin-entrenador.dashboard', compact('totalClases', 'totalEntrenadores', 'totalAlumnos'));
    }


    // --------- MÉTODOS ---------

    public function verAlumnos()
    {
        $alumnos = User::whereIs('cliente')->get(); // 'cliente' es el rol de alumno
        return view('admin-entrenador.alumnos.index', compact('alumnos'));
    }

    public function verEntrenadores()
    {
        $entrenadores = User::whereIs('entrenador')->get();
        return view('admin-entrenador.entrenadores.index', compact('entrenadores'));
    }

    public function eliminarEntrenador(User $user)
    {
        if ($user->isAn('entrenador') && !$user->isAn('admin_entrenador')) {
            $user->delete();
            return redirect()->back()->with('success', 'Entrenador eliminado correctamente.');
        }
        return redirect()->back()->with('error', 'No se puede eliminar a este usuario.');
    }

    public function editarAlumno(User $user)
    {
        $clases = ClaseGrupal::all();
        return view('admin-entrenador.usuarios.editar-alumno', compact('user', 'clases'));
    }

    public function actualizarAlumno(Request $request, User $user)
    {
        $request->validate([
            'clase_id' => 'nullable|exists:clase_grupals,id',
        ]);

        $user->clase_id = $request->clase_id;
        $user->save();

        return redirect()->route('admin-entrenador.alumnos')->with('success', 'Clase del alumno actualizada.');
    }

    public function eliminarAlumno(User $user)
    {
        if ($user->isAn('cliente') && !$user->isAn('admin_entrenador')) {
            $user->delete();
            return redirect()->back()->with('success', 'Alumno eliminado correctamente.');
        }
        return redirect()->back()->with('error', 'No se puede eliminar a este usuario.');
    }

    public function verClases()
    {
        $clases = ClaseGrupal::all(); // O el código necesario para obtener las clases
        return view('admin-entrenador.clases.index', compact('clases'));
    }

    public function crearClase()
    {
        // Verificar si hay entrenadores disponibles
        $entrenadores = User::whereHas('roles', function ($query) {
            $query->where('name', 'entrenador');
        })->get();

        if ($entrenadores->isEmpty()) {
            return redirect()->route('admin-entrenador.clases.index')
                ->with('error', 'No hay entrenadores disponibles para asignar a la clase.');
        }

        return view('admin-entrenador.clases.create', compact('entrenadores'));
    }

    public function guardarClase(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'entrenador_id' => 'required|exists:users,id', // Asegurarse de que haya un entrenador válido
        ]);

        // Validar si hay un entrenador asignado
        if (!$request->entrenador_id) {
            return redirect()->back()->with('error', 'Debe asignar un entrenador para crear la clase.');
        }

        $clase = new ClaseGrupal();
        $clase->nombre = $request->nombre;
        $clase->descripcion = $request->descripcion;
        $clase->fecha_inicio = $request->fecha_inicio;
        $clase->entrenador_id = $request->entrenador_id; // Asignar entrenador

        $clase->save();

        return redirect()->route('admin-entrenador.clases.index')->with('success', 'Clase creada correctamente.');
    }

    public function editarClase(ClaseGrupal $clase)
    {
        // Aquí también puedes incluir una validación si quieres que solo los administradores puedan editar
        return view('admin-entrenador.clases.edit', compact('clase'));
    }

    public function actualizarClase(Request $request, ClaseGrupal $clase)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'entrenador_id' => 'required|exists:users,id', // Asegurarse de que haya un entrenador válido
        ]);

        // Actualizar los campos
        $clase->nombre = $request->nombre;
        $clase->descripcion = $request->descripcion;
        $clase->fecha_inicio = $request->fecha_inicio;
        $clase->entrenador_id = $request->entrenador_id; // Asignar nuevo entrenador si es necesario

        $clase->save();

        return redirect()->route('admin-entrenador.clases.index')->with('success', 'Clase actualizada correctamente.');
    }

    public function eliminarClase(ClaseGrupal $clase)
    {
        // Verificar si el usuario tiene el permiso de 'admin_entrenador' antes de eliminar
        if (!auth()->user()->can('admin_entrenador')) {
            return redirect()->back()->with('error', 'No tienes permisos para eliminar clases.');
        }
    
        // Comprobar si hay usuarios inscritos en la clase antes de permitir la eliminación
        if ($clase->usuarios()->count() > 0) {
            return redirect()->back()->with('error', 'No se puede eliminar la clase porque tiene alumnos inscritos.');
        }
    
        // Eliminar la clase si no tiene usuarios inscritos
        $clase->delete();
    
        return redirect()->route('admin-entrenador.clases.index')->with('success', 'Clase eliminada correctamente.');
    }
    
}
