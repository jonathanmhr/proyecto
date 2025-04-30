<?php

namespace App\Http\Controllers\AdminEntrenador;

use App\Http\Controllers\Controller;
use App\Models\ClaseGrupal;
use App\Models\User; // Para los entrenadores y usuarios

class AdminEntrenadorController extends Controller
{
    public function index()
    {
        // Contar todas las clases
        $totalClases = ClaseGrupal::count();

        // Contar los usuarios con rol 'entrenador'
        $totalEntrenadores = User::whereHas('roles', function ($query) {
            $query->where('name', 'entrenador');
        })->count();

        // Contar los usuarios con rol 'alumno'
        $totalAlumnos = User::whereHas('roles', function ($query) {
            $query->where('name', 'alumno');
        })->count();

        return view('admin-entrenador.dashboard', compact('totalClases', 'totalEntrenadores', 'totalAlumnos'));
    }
}
