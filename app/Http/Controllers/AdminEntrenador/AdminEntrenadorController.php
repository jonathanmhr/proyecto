<?php

namespace App\Http\Controllers\AdminEntrenador;

use App\Http\Controllers\Controller;

class AdminEntrenadorController extends Controller
{
    public function index()
    {
        return view('admin-entrenador.dashboard');
    }
}
