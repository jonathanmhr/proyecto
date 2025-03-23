<?php

// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Obtener el usuario autenticado
        return view('dashboard', compact('user')); // Pasamos el usuario a la vista
    }
}
