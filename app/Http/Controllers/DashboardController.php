<?php

// DashboardController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Asegúrate de incluir esta línea

class DashboardController extends Controller
{
    public function index()
    {
        // Asegurarse de que el usuario esté autenticado
        $user = Auth::user();

        // Si el usuario no está autenticado, redirigir a la página de login (opcional)
        if (!$user) {
            return redirect()->route('login');
        }

        // Obtener el perfil del usuario autenticado
        $perfil = $user->perfil;  // Usar 'perfil' que es la relación definida en User.php

        // Si el perfil no existe, redirigir a la página de creación de perfil (opcional)
        if (!$perfil) {
            return redirect()->route('perfil.create');
        }

        return view('dashboard', compact('perfil')); // Pasa el perfil a la vista
    }
}
