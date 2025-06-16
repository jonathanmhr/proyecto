<?php

namespace App\Http\Controllers\Perfil;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Instructor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InstructorController extends Controller
{
    // Mostrar perfil del instructor logueado
    public function show()
    {
        $user = Auth::user();

        $instructor = Instructor::where('email', $user->email)->first();

        if (!$instructor) {
            return redirect()->route('entrenador.profile.create')->with('warning', 'Por favor, crea tu perfil de instructor.');
        }

        return view('entrenador.profile.show', compact('instructor'));
    }
    public function create()
    {
        $user = Auth::user();

        // Pasar el email y nombre al formulario para que se muestren o usen
        return view('entrenador.profile.create', compact('user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellidos' => 'nullable|string|max:100',
            'especialidad' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:2048',
            'descripcion' => 'nullable|string',
            'certificaciones' => 'nullable|string',
            'dias' => 'required|array|min:1',
            'dias.*' => 'in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);

        $data = $request->only([
            'nombre',
            'apellidos',
            'especialidad',
            'telefono',
            'descripcion',
            'certificaciones',
        ]);

        // Asignar el horario como array (Laravel lo castea a JSON)
        $data['horario'] = [
            'dias' => $request->dias,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
        ];

        $data['email'] = $user->email;
        $data['activo'] = 1;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('instructores', 'public');
        }

        Instructor::create($data);

        return redirect()->route('entrenador.profile.show')->with('success', 'Perfil creado con éxito.');
    }
    public function edit()
{
    $user = Auth::user();

    $instructor = Instructor::where('email', $user->email)->first();

    if (!$instructor) {
        return redirect()->route('entrenador.profile.create')->with('warning', 'Por favor, crea tu perfil primero.');
    }

    return view('entrenador.profile.edit', compact('instructor'));
}




    // Mostrar formulario para editar perfil
    public function update(Request $request)
    {
        $user = Auth::user();

        $instructor = Instructor::where('email', $user->email)->firstOrFail();

        $validatedData = $request->validate([
            'nombre' => 'nullable|string|max:100',
            'apellidos' => 'nullable|string|max:100',
            'especialidad' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:2048',
            'descripcion' => 'nullable|string',
            'certificaciones' => 'nullable|string',
            'dias' => 'required|array|min:1',
            'dias.*' => 'in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'activo' => 'required|boolean',
        ]);

        // Asignar el horario como array
        $validatedData['horario'] = [
            'dias' => $request->dias,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
        ];

        if ($request->hasFile('foto')) {
            if ($instructor->foto && Storage::disk('public')->exists($instructor->foto)) {
                Storage::disk('public')->delete($instructor->foto);
            }
            $validatedData['foto'] = $request->file('foto')->store('instructores_fotos', 'public');
        }

        $instructor->update($validatedData);

        return redirect()->route('entrenador.profile.show')->with('success', 'Perfil actualizado correctamente.');
    }
}
