<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Entrenamiento;
use App\Models\FaseEntrenamiento;
use App\Models\ActividadEntrenamiento;
use App\Models\UsuarioEntrenamiento;
use Illuminate\Support\Facades\Auth;

class EntrenamientoController extends Controller
{
    // Mostrar entrenamientos ordenados por fecha más reciente
    public function index()
    {
        $user = Auth::user();

        // Traemos entrenamientos creados por este admin-entrenador, con sus fases y usuarios que los guardaron
        $entrenamientos = Entrenamiento::with(['fases', 'usuariosGuardaron'])
            ->where('creado_por', $user->id)
            ->get();

        return view('admin-entrenador.entrenamientos.index', compact('entrenamientos'));
    }


    public function create()
    {
        return view('admin-entrenador.entrenamientos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'zona_muscular_imagen' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'equipamiento_imagen' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'nivel' => 'required|in:bajo,medio,alto',
            'fases' => 'required|array',
        ]);

        // Guardar imágenes generales
        $zonaMuscularImg = $request->hasFile('zona_muscular_imagen')
            ? $request->file('zona_muscular_imagen')->store('zona_muscular', 'public')
            : null;

        $equipamientoImg = $request->hasFile('equipamiento_imagen')
            ? $request->file('equipamiento_imagen')->store('equipamiento', 'public')
            : null;

        // Calcular kcal total
        $totalKcal = 0;
        foreach ($request->fases as $fase) {
            $totalKcal += (int) ($fase['kcal_estimadas'] ?? 0);
        }

        $entrenamiento = Entrenamiento::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'zona_muscular' => $zonaMuscularImg,
            'nivel' => $request->nivel,
            'equipamiento' => $equipamientoImg,
            'kcal_estimadas' => $totalKcal,
            'creado_por' => Auth::id(),
        ]);

        // Manejar cada fase
        foreach ($request->fases as $orden => $faseData) {
            // Procesar imagen si existe
            $faseImagenPath = null;
            if ($request->hasFile("fases.$orden.imagen")) {
                $faseImagenPath = $request->file("fases.$orden.imagen")->store("fases", 'public');
            }

            $fase = FaseEntrenamiento::create([
                'entrenamiento_id' => $entrenamiento->id,
                'nombre' => $faseData['nombre'],
                'duracion_min' => $faseData['duracion_min'],
                'kcal_estimadas' => $faseData['kcal_estimadas'],
                'orden' => $orden + 1,
                'imagen' => $faseImagenPath, // <= aquí se guarda si existe
            ]);

            foreach ($faseData['actividades'] ?? [] as $actividadData) {
                ActividadEntrenamiento::create([
                    'fase_entrenamiento_id' => $fase->id,
                    'nombre' => $actividadData['nombre'],
                    'tipo' => $actividadData['tipo'],
                    'series' => $actividadData['series'],
                    'repeticiones' => $actividadData['repeticiones'] ?? null,
                    'imagen' => $actividadData['imagen'] ?? null,
                ]);
            }
        }

        return redirect()->route('admin-entrenador.entrenamientos.index')
            ->with('success', 'Entrenamiento creado correctamente.');
    }


    public function edit($id)
    {
        $entrenamiento = Entrenamiento::with('fases.actividades')->findOrFail($id);

        //$this->authorize('update', $entrenamiento);

        return view('admin-entrenador.entrenamientos.edit', compact('entrenamiento'));
    }

    public function update(Request $request, $id)
    {
        // Similar a store, con lógica para actualizar fases/actividades
        // Lo podemos construir si te interesa ahora.
    }

    public function destroy($id)
    {
        $entrenamiento = Entrenamiento::findOrFail($id);

        if (Auth::user()->rol !== 'admin-entrenador') {
            abort(403, 'No autorizado para eliminar este entrenamiento.');
        }

        $entrenamiento->delete();

        return redirect()->route('admin-entrenador.entrenamientos.index')->with('success', 'Entrenamiento eliminado correctamente.');
    }

    public function usuariosGuardaron($id)
    {
        $entrenamiento = Entrenamiento::with('usuarios')->findOrFail($id);

        $usuarios = UsuarioEntrenamiento::where('entrenamiento_id', $id)
            ->with('user')
            ->get();

        return view('admin-entrenador.entrenamientos.usuarios', compact('entrenamiento', 'usuarios'));
    }
}
