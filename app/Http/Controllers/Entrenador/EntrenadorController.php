<?php

namespace App\Http\Controllers\Entrenador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EntrenadorController extends Controller
{
    public function index()
    {
        // Aquí puedes pasar los datos necesarios para el panel del entrenador
        return view('entrenador.dashboard');
    }
}
