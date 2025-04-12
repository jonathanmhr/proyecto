<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PerfilUsuario;

class ProfileController extends Controller
{
    // Mostrar el perfil
    public function show()
    {
        // Obtener el perfil del usuario autenticado
        $perfil = Auth::user()->perfil;

        // Pasar el perfil a la vista
        return view('dashboard', compact('perfil'));
    }

    // Mostrar el formulario para crear o editar el perfil
    public function edit()
    {
        $perfil = Auth::user()->perfil; // Obtener el perfil del usuario para editarlo

        // Si el perfil no existe, redirigir a la creación
        if (!$perfil) {
            return redirect()->route('perfil.create');
        }

        return view('profile.edit', compact('perfil'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'fecha_nacimiento' => 'required|date',
            'peso' => 'required|numeric',
            'altura' => 'required|numeric',
            'objetivo' => 'required|string',
            'id_nivel' => 'required|integer',
        ]);

        // Obtener el perfil del usuario autenticado
        $perfil = Auth::user()->perfil;

        // Actualizar el perfil
        $perfil->update([
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'peso' => $request->peso,
            'altura' => $request->altura,
            'objetivo' => $request->objetivo,
            'id_nivel' => $request->id_nivel,
        ]);

        return redirect()->route('perfil.show')->with('success', 'Perfil actualizado con éxito');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha_nacimiento' => 'required|date',
            'peso' => 'required|numeric',
            'altura' => 'required|numeric',
            'objetivo' => 'required|string',
            'id_nivel' => 'required|integer',
        ]);

        // Si el perfil no existe, crearlo
        $perfil = new PerfilUsuario([
            'id_usuario' => Auth::id(),
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'peso' => $request->peso,
            'altura' => $request->altura,
            'objetivo' => $request->objetivo,
            'id_nivel' => $request->id_nivel,
        ]);
        $perfil->save();

        return redirect()->route('perfil.show')->with('success', 'Perfil creado con éxito');
    }
}
