<?php

namespace App\Http\Controllers\AdminEntrenador;

use App\Http\Controllers\Controller;
use App\Models\ClaseGrupal;
use Silber\Bouncer\Database\Role;

class AdminEntrenadorController extends Controller
{
    public function index()
    {
        // Contar todas las clases
        $totalClases = ClaseGrupal::count();
    
        // Contar los entrenadores
        $totalEntrenadores = User::whereHas('roles', function ($query) {
            $query->where('name', 'entrenador');
        })->count();
    
        // Contar los alumnos
        $totalAlumnos = User::whereHas('roles', function ($query) {
            $query->where('name', 'alumno');
        })->count();
    
        return view('admin-entrenador.dashboard', compact('totalClases', 'totalEntrenadores', 'totalAlumnos'));
    }
}
