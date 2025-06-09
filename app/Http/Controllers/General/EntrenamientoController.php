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
        $fases = $entrenamiento->fases;

        return view('admin-entrenador.entrenamientos.edit', compact('entrenamiento', 'fases'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'zona_muscular_imagen' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'equipamiento_imagen' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'nivel' => 'required|in:bajo,medio,alto',
            'fases' => 'required|array',
        ]);

        $entrenamiento = Entrenamiento::findOrFail($id);

        // Manejar imágenes generales: zona muscular y equipamiento
        if ($request->hasFile('zona_muscular_imagen')) {
            // Opcional: borrar imagen vieja si quieres
            $zonaMuscularImg = $request->file('zona_muscular_imagen')->store('zona_muscular', 'public');
            $entrenamiento->zona_muscular = $zonaMuscularImg;
        }

        if ($request->hasFile('equipamiento_imagen')) {
            $equipamientoImg = $request->file('equipamiento_imagen')->store('equipamiento', 'public');
            $entrenamiento->equipamiento = $equipamientoImg;
        }

        // Calcular kcal total
        $totalKcal = 0;
        foreach ($request->fases as $fase) {
            $totalKcal += (int) ($fase['kcal_estimadas'] ?? 0);
        }

        // Actualizar campos básicos del entrenamiento
        $entrenamiento->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'nivel' => $request->nivel,
            'kcal_estimadas' => $totalKcal,
        ]);

        // Obtener IDs actuales de fases para comparación y eliminación
        $idsFasesEnRequest = collect($request->fases)->pluck('id')->filter()->all(); // solo las que tienen id
        $idsFasesExistentes = $entrenamiento->fases()->pluck('id')->all();

        // Fases a eliminar (que no están en el request)
        $fasesAEliminar = array_diff($idsFasesExistentes, $idsFasesEnRequest);
        FaseEntrenamiento::destroy($fasesAEliminar);

        // Procesar fases
        foreach ($request->fases as $orden => $faseData) {
            $faseImagenPath = null;
            if ($request->hasFile("fases.$orden.imagen")) {
                $faseImagenPath = $request->file("fases.$orden.imagen")->store("fases", 'public');
            }

            if (!empty($faseData['id'])) {
                // Actualizar fase existente
                $fase = FaseEntrenamiento::find($faseData['id']);
                if ($fase) {
                    $fase->nombre = $faseData['nombre'];
                    $fase->duracion_min = $faseData['duracion_min'];
                    $fase->kcal_estimadas = $faseData['kcal_estimadas'];
                    $fase->orden = $orden + 1;
                    if ($faseImagenPath) {
                        $fase->imagen = $faseImagenPath;
                    }
                    $fase->save();
                }
            } else {
                // Crear nueva fase
                $fase = FaseEntrenamiento::create([
                    'entrenamiento_id' => $entrenamiento->id,
                    'nombre' => $faseData['nombre'],
                    'duracion_min' => $faseData['duracion_min'],
                    'kcal_estimadas' => $faseData['kcal_estimadas'],
                    'orden' => $orden + 1,
                    'imagen' => $faseImagenPath,
                ]);
            }

            // Actualizar actividades de la fase
            if (isset($faseData['actividades'])) {
                // Obtener IDs actuales actividades
                $idsActividadesEnRequest = collect($faseData['actividades'])->pluck('id')->filter()->all();
                $idsActividadesExistentes = $fase->actividades()->pluck('id')->all();

                // Actividades a eliminar
                $actividadesAEliminar = array_diff($idsActividadesExistentes, $idsActividadesEnRequest);
                ActividadEntrenamiento::destroy($actividadesAEliminar);

                foreach ($faseData['actividades'] as $actividadData) {
                    if (!empty($actividadData['id'])) {
                        // Actualizar actividad existente
                        $actividad = ActividadEntrenamiento::find($actividadData['id']);
                        if ($actividad) {
                            $actividad->nombre = $actividadData['nombre'];
                            $actividad->tipo = $actividadData['tipo'];
                            $actividad->series = $actividadData['series'];
                            $actividad->repeticiones = $actividadData['repeticiones'] ?? null;
                            // Nota: no manejo imagen para actividades aquí, si tienes lógica, la agregamos
                            $actividad->save();
                        }
                    } else {
                        // Crear actividad nueva
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
            }
        }

        return redirect()->route('admin-entrenador.entrenamientos.index')
            ->with('success', 'Entrenamiento actualizado correctamente.');
    }


    public function destroy($id)
    {
        $entrenamiento = Entrenamiento::findOrFail($id);

        if (Auth::user()->rol !== 'admin-entrenador') {
            abort(403, 'No autorizado para eliminar este entrenamiento.');
        }

        // Desvincula todos los usuarios que lo tenían guardado
        $entrenamiento->usuariosGuardaron()->detach();

        // Elimina el entrenamiento
        $entrenamiento->delete();

        return redirect()->route('admin-entrenador.entrenamientos.index')
            ->with('success', 'Entrenamiento eliminado correctamente.');
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
