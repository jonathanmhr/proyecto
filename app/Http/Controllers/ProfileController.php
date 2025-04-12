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
        $perfil = Auth::user()->perfil; // Obtener el perfil del usuario autenticado
        return view('profile.show', compact('perfil'));
    }

    // Mostrar el formulario para crear o editar el perfil
    public function edit()
    {
        $perfil = Auth::user()->perfil; // Obtener el perfil del usuario para editarlo
        return view('profile.edit', compact('perfil'));
    }

    // Guardar o actualizar el perfil
    public function save(Request $request)
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

        if ($perfil) {
            // Si el perfil ya existe, actualizamos los datos
            $perfil->update([
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'peso' => $request->peso,
                'altura' => $request->altura,
                'objetivo' => $request->objetivo,
                'id_nivel' => $request->id_nivel,
            ]);
        } else {
            // Si el perfil no existe, lo creamos
            $perfil = new PerfilUsuario([
                'id_usuario' => Auth::id(),
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'peso' => $request->peso,
                'altura' => $request->altura,
                'objetivo' => $request->objetivo,
                'id_nivel' => $request->id_nivel,
            ]);
            $perfil->save();
        }

        return redirect()->route('perfil.show')->with('success', 'Perfil actualizado con éxito');
    }
}
