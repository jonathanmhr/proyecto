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
}
