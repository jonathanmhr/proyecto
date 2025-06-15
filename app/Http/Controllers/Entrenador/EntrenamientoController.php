<?php

namespace App\Http\Controllers\Entrenador;

use App\Models\Entrenamiento;
use App\Models\SolicitudCambioEntrenamiento;
use App\Models\User;
use App\Notifications\NotificacionPersonalizada;
use App\Models\FaseEntrenamiento;
use App\Models\ActividadEntrenamiento;
use App\Models\UsuarioEntrenamiento;
use Silber\Bouncer\Database\Role;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EntrenamientoController extends Controller
{

    public function index()
    {
        $entrenamientos = Entrenamiento::where('creado_por', auth()->id())
            ->withCount('usuarios') // Por ejemplo, para ver cuántos usuarios tiene asignados
            ->get();

        return view('entrenador.entrenamientos.index', compact('entrenamientos'));
    }

    public function create()
    {
        return view('entrenador.entrenamientos.create');
    }

public function edit($id)
{
    $entrenamiento = Entrenamiento::with('fases.actividades')->findOrFail($id); // Trae un solo modelo
    return view('entrenador.entrenamientos.edit', compact('entrenamiento'));
}

    public function store(Request $request)
    {
        // Validación similar a admin-entrenador
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'zona_muscular_imagen' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'equipamiento_imagen' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'nivel' => 'required|in:bajo,medio,alto',
            'fases' => 'required|array',
        ]);

        // Manejo imágenes (zona muscular y equipamiento)
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
        return redirect()->route('entrenador.entrenamientos.index')
            ->with('success', 'Entrenamiento creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $entrenamiento = Entrenamiento::with('fases.actividades')->findOrFail($id);


        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'zona_muscular_imagen' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'equipamiento_imagen' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'nivel' => 'required|in:bajo,medio,alto',
            'fases' => 'required|array',
        ]);

        // En vez de actualizar directamente, creamos una solicitud de cambio
        $datosPropuestos = $request->all();

        SolicitudCambioEntrenamiento::create([
            'entrenamiento_id' => $entrenamiento->id,
            'entrenador_id' => auth()->id(),
            'datos_modificados' => json_encode($datosPropuestos),
            'estado' => 'pendiente',
        ]);

        // Enviar notificación a todos los admin-entrenador
        $admins = Role::where('name', 'admin_entrenador')
            ->first()
            ->users;

        Notification::send($admins, new NotificacionPersonalizada(
            'Solicitud de cambio de entrenamiento',
            "El entrenador " . auth()->user()->name . " ha solicitado cambios en el entrenamiento '{$entrenamiento->titulo}'. Revisa y aprueba o rechaza.",
            'solicitud_cambio',
            ['database', 'mail'],
            auth()->user()
        ));

        return redirect()->route('entrenador.entrenamientos.index')
            ->with('success', 'Solicitud de cambio enviada y pendiente de aprobación.');
    }

    // Ejemplo función para asignar entrenamiento a usuario(s)
    public function asignarUsuarios(Request $request, $entrenamientoId)
    {
        $request->validate([
            'usuarios' => 'required|array',
            'usuarios.*' => 'exists:users,id',
        ]);

        $entrenamiento = Entrenamiento::findOrFail($entrenamientoId);

        $entrenamiento->usuarios()->sync($request->usuarios); // Sync para reemplazar asignaciones

        return redirect()->route('entrenador.entrenamientos.show', $entrenamientoId)
            ->with('success', 'Entrenamiento asignado a los usuarios seleccionados.');
    }

    // Mostrar usuarios que han guardado un entrenamiento
    public function usuariosGuardaron($id)
    {
        $entrenamiento = Entrenamiento::with('usuarios')->findOrFail($id);


        $usuarios = UsuarioEntrenamiento::where('entrenamiento_id', $id)
            ->with('usuario')
            ->get();

        return view('entrenador.entrenamientos.usuarios', compact('entrenamiento', 'usuarios'));
    }
}
