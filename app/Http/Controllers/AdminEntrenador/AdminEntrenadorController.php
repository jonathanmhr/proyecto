<?php

namespace App\Http\Controllers\AdminEntrenador;

use App\Http\Controllers\Controller;
use App\Models\ClaseGrupal;
use Silber\Bouncer\BouncerFacade as Bouncer;
use App\Models\User;

class AdminEntrenadorController extends Controller
{
    public function index()
    {
        // Contar todas las clases
        $totalClases = ClaseGrupal::count();

        // Contar los entrenadores usando Bouncer
        $totalEntrenadores = Bouncer::role()->where('name', 'entrenador')->first()->users()->count();

        // Contar los alumnos usando Bouncer
        $totalAlumnos = Bouncer::role()->where('name', 'alumno')->first()->users()->count();

        return view('admin-entrenador.dashboard', compact('totalClases', 'totalEntrenadores', 'totalAlumnos'));
    }
}