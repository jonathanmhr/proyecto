<?php

// DashboardController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Asegúrate de que el usuario esté autenticado
        $user = Auth::user();
    
        // Obtiene el perfil del usuario autenticado
        $perfil = $user->perfil;  // 'perfil' es la relación que definimos en User.php
    
        // Si el perfil no existe, redirigir al usuario a la creación del perfil
        if (!$perfil) {
            return redirect()->route('perfil.create'); // Cambia esto si quieres una ruta diferente
        }
    
        // Pasa el perfil a la vista, sin redirigir
        return view('dashboard', compact('perfil'));
    }
    
}
