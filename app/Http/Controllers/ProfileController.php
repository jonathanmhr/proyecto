<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PerfilUsuario;

class ProfileController extends Controller
{
    // Mostrar el perfil del usuario
    public function show()
    {
        // Obtener el perfil del usuario autenticado
        $perfil = Auth::user()->perfil;
        
        // Verifica si el usuario tiene un perfil
        if (!$perfil) {
            return redirect()->route('perfil.create');  // Redirige al formulario de creación
        }
        
        // Pasar el perfil a la vista
        return view('dashboard', compact('perfil'));
    }

    // Mostrar el formulario para crear el perfil (nuevo usuario)
    public function create()
    {
        return view('profile.create');
    }

    // Guardar el perfil en la base de datos (nuevo usuario)
    public function store(Request $request)
    {
        $request->validate([
            'fecha_nacimiento' => 'required|date',
            'peso' => 'required|numeric',
            'altura' => 'required|numeric',
            'objetivo' => 'required|string',
            'id_nivel' => 'required|integer',
        ]);

        // Crear el perfil del nuevo usuario
        $perfil = new PerfilUsuario([
            'id_usuario' => Auth::id(),
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'peso' => $request->peso,
            'altura' => $request->altura,
            'objetivo' => $request->objetivo,
            'id_nivel' => $request->id_nivel,
        ]);

        $perfil->save();

        return redirect()->route('dashboard')->with('success', 'Perfil creado con éxito');
    }

    // Mostrar el formulario para editar el perfil (usuario antiguo)
    public function edit()
    {
        $perfil = Auth::user()->perfil; // Obtener el perfil del usuario
        return view('profile.edit', compact('perfil'));
    }

    // Actualizar los datos del perfil
    public function update(Request $request)
    {
        $request->validate([
            'fecha_nacimiento' => 'required|date',
            'peso' => 'required|numeric',
            'altura' => 'required|numeric',
            'objetivo' => 'required|string',
            'id_nivel' => 'required|integer',
        ]);

        $perfil = Auth::user()->perfil; // Obtener el perfil del usuario

        // Actualizar el perfil del usuario
        $perfil->update([
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'peso' => $request->peso,
            'altura' => $request->altura,
            'objetivo' => $request->objetivo,
            'id_nivel' => $request->id_nivel,
        ]);

        return redirect()->route('dashboard')->with('success', 'Perfil actualizado con éxito');
    }
}