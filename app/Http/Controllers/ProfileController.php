<?php

namespace App\Http\Controllers;

use App\Models\PerfilUsuario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Método para mostrar el formulario de creación
    public function create()
    {
        return view('profile.create');
    }

    // Método para guardar el perfil
    public function store(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'fecha_nacimiento' => 'required|date',
            'peso' => 'required|numeric',
            'altura' => 'required|numeric',
            'objetivo' => 'required|string',
        ]);

        // Obtener el usuario autenticado
        $user = Auth::user();

        // Crear el perfil para el usuario
        PerfilUsuario::create([
            'id_usuario' => $user->id,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'peso' => $request->peso,
            'altura' => $request->altura,
            'objetivo' => $request->objetivo,
            // Agrega otros campos según lo necesario
        ]);

        // Redirigir al dashboard o donde quieras
        return redirect()->route('dashboard');
    }

    // Método para mostrar el perfil
    public function show()
    {
        // Obtener el perfil del usuario autenticado
        $user = Auth::user();
        $perfil = $user->perfil; // Relación definida en User.php

        // Si el perfil no existe, redirigir para crearlo
        if (!$perfil) {
            return redirect()->route('perfil.create');
        }

        return view('profile.perfil', compact('perfil')); // Pasa el perfil a la vista
    }
}
