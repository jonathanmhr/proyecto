<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Usuario autenticado
        $users = User::paginate(10); // Obtener solo 10 usuarios por página
        
        return view('dashboard', compact('user', 'users')); // Pasar ambas variables a la vista
    }
}
