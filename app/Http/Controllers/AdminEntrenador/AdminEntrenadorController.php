<?php

namespace App\Http\Controllers\AdminEntrenador;

use App\Http\Controllers\Controller;
use App\Models\ClaseGrupal;
use Silber\Bouncer\Database\Role;

class AdminEntrenadorController extends Controller
{
    public function index()
    {
        $totalClases = ClaseGrupal::count();
    
        $totalEntrenadores = Role::where('name', 'entrenador')->first()?->users()->count() ?? 0;
        $totalAlumnos = Role::where('name', 'cliente')->first()?->users()->count() ?? 0;
    
        return view('admin-entrenador.dashboard', compact('totalClases', 'totalEntrenadores', 'totalAlumnos'));
    }
}
