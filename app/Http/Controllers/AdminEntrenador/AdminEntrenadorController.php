<?php

namespace App\Http\Controllers\AdminEntrenador;

use App\Http\Controllers\Controller;
use App\Models\ClaseGrupal;
use App\Models\User; // Para los entrenadores y usuarios

class AdminEntrenadorController extends Controller
{
    public function index()
    {
        // Datos para el dashboard
        $totalClases = ClaseGrupal::count(); // Contar todas las clases
        $totalEntrenadores = User::where('role', 'entrenador')->count(); // Contar los entrenadores
        $totalAlumnos = User::where('role', 'alumno')->count(); // Contar los alumnos

        // Pasar estos datos a la vista
        return view('admin-entrenador.dashboard', compact('totalClases', 'totalEntrenadores', 'totalAlumnos'));
    }
}
