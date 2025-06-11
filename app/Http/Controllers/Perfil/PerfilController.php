<?php

namespace App\Http\Controllers\Perfil;

use App\Models\ClaseGrupal;
use App\Models\ClaseIndividual;
use App\Models\Entrenamiento;
use App\Models\Suscripcion;
use App\Models\PerfilUsuario;
use App\Models\DietaYPlanNutricional;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\FaseEntrenamientoDia;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NotificacionPersonalizada;
use Illuminate\Support\Collection;

class PerfilController extends Controller
{

    public function index()
    {
        $usuario = auth()->user();

        // Perfil y demás datos...
        $perfil = $usuario->perfilUsuario;

        $datosCompletos = $perfil && $perfil->fecha_nacimiento && $perfil->peso && $perfil->altura && $perfil->objetivo && $perfil->id_nivel;
        $incompleteProfile = !$datosCompletos && !session('profile_modal_shown');
        session(['profile_modal_shown' => true]);

        $clasesGrupales = $usuario->clasesAceptadas ?? collect();
        $clasesIndividuales = ClaseIndividual::where('usuario_id', $usuario->id)->get();
        $entrenamientos = Entrenamiento::where('creado_por', $usuario->id)->get();
        $suscripciones = Suscripcion::where('id_usuario', $usuario->id)->get();
        $notificaciones = $usuario->notifications()->latest()->take(10)->get();
        $dietasRecomendadas = $usuario->dietas()->inRandomOrder()->limit(5)->get();

        $hoy = Carbon::today();

        // Filtrar clases grupales para hoy
        $clasesGrupalesHoy = $clasesGrupales->filter(function ($clase) use ($hoy) {
            $fechaClase = $clase->fecha_hora ?? $clase->fecha_inicio;
            return Carbon::parse($fechaClase)->isSameDay($hoy);
        });

        // Filtrar clases individuales para hoy
        $clasesIndividualesHoy = $clasesIndividuales->filter(function ($clase) use ($hoy) {
            $fechaClase = $clase->fecha_hora ?? $clase->fecha_inicio;
            return Carbon::parse($fechaClase)->isSameDay($hoy);
        });

        $clasesHoy = $clasesGrupalesHoy->merge($clasesIndividualesHoy)->values();

        // Entrenamientos planificados para hoy
        $entrenamientosHoy = FaseEntrenamientoDia::where('user_id', $usuario->id)
            ->where('fecha', $hoy)
            ->where('estado', 'pendiente') // solo los pendientes para evitar mostrar ya completados
            ->with(['entrenamiento', 'faseEntrenamiento'])
            ->get();

        $eventosFases = FaseEntrenamientoDia::where('user_id', $usuario->id)
            ->with(['entrenamiento', 'faseEntrenamiento'])
            ->get()
            ->map(function ($faseDia) {
                return [
                    'id' => $faseDia->id,
                    'title' => $faseDia->entrenamiento->nombre . ' - ' . $faseDia->faseEntrenamiento->nombre,  // Entrenamiento - Actividad
                    'start' => Carbon::parse($faseDia->fecha)->toDateString(),
                    'end' => Carbon::parse($faseDia->fecha)->toDateString(),
                    'tipo' => 'Fase Entrenamiento',
                    'estado' => $faseDia->estado,
                    'description' => 'Haz clic para marcar como completado',
                ];
            });

        $eventosClasesGrupales = $clasesGrupales->map(function ($clase) {
            return [
                'id'    => 'G' . $clase->id_clase,
                'title' => $clase->nombre . ' (Grupal)',  // Indico tipo en título
                'start' => Carbon::parse($clase->fecha_hora ?? $clase->fecha_inicio)->toDateTimeString(),
                'end'   => Carbon::parse($clase->fecha_hora ?? $clase->fecha_fin)->toDateTimeString(),
                'tipo'  => 'Clase Grupal',
                'estado' => 'aceptada',
                'description' => $clase->descripcion,
            ];
        });

        $eventosClasesIndividuales = $clasesIndividuales->map(function ($clase) {
            if ($clase->fecha_hora) {
                $start = $clase->fecha_hora->toDateTimeString();
                $end = $clase->fecha_hora->copy()->addMinutes($clase->duracion ?? 60)->toDateTimeString();
            } else {
                $fecha = Carbon::parse($clase->fecha_inicio)->format('Y-m-d');
                $hora = $clase->hora_inicio instanceof Carbon
                    ? $clase->hora_inicio->format('H:i:s')
                    : $clase->hora_inicio;

                $start = Carbon::parse("{$fecha} {$hora}")->toDateTimeString();
                $end = Carbon::parse("{$fecha} {$hora}")->addMinutes($clase->duracion ?? 60)->toDateTimeString();
            }

            return [
                'id'    => 'I' . $clase->id,
                'title' => $clase->titulo . ' (Individual)', // Indico tipo en título
                'start' => $start,
                'end'   => $end,
                'tipo'  => 'Clase Individual',
                'estado' => 'programada',
                'description' => $clase->descripcion,
            ];
        });

        $eventosClases = (new Collection($eventosClasesGrupales))
            ->merge(new Collection($eventosClasesIndividuales))
            ->values();

        // PASAMOS SOLO LAS CLASES DE HOY para mostrar en la lista
        $clases = $clasesHoy;

        return view('dashboard', compact(
            'clases',
            'eventosClases',
            'eventosFases',
            'entrenamientos',
            'suscripciones',
            'incompleteProfile',
            'datosCompletos',
            'perfil',
            'notificaciones',
            'dietasRecomendadas',
            'entrenamientosHoy'
        ));
    }


    public function completar()
    {
        $usuario = auth()->user(); // Obtener al usuario autenticado
        $perfil = $usuario->perfilUsuario; // Obtener el perfil del usuario (si existe)

        return view('perfil.completar', compact('perfil')); // Pasar los datos a la vista del formulario
    }

    public function editar()
    {
        $perfil = auth()->user()->perfilUsuario;
        return view('perfil.editar', compact('perfil'));
    }

    public function actualizar(Request $request)
    {
        $request->validate([
            'peso' => 'required|numeric|min:1',
            'objetivo' => 'required|string|max:255',
            'id_nivel' => 'required|in:1,2,3',
        ]);

        try {
            $perfil = auth()->user()->perfilUsuario;
            $perfil->update($request->only('peso', 'objetivo', 'id_nivel'));

            return redirect()->route('dashboard')->with([
                'status' => 'Perfil actualizado con éxito.',
                'status_type' => 'success'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with([
                'status' => 'Error al actualizar el perfil.',
                'status_type' => 'error'
            ]);
        }
    }

    public function guardarPerfil(Request $request)
    {
        $usuario = auth()->user();

        // Validar los datos del perfil
        $validated = $request->validate([
            'fecha_nacimiento' => 'required|date',
            'peso' => 'required|numeric|max:300',
            'altura' => 'required|numeric|max:220',
            'objetivo' => 'required|string|max:255',
            'id_nivel' => 'required|integer',
        ]);

        // Guardar o actualizar el perfil
        $perfil = $usuario->perfilUsuario ?: new PerfilUsuario();
        $perfil->fill($validated);
        $perfil->id_usuario = $usuario->id;
        $perfil->save();

        // Redirigir al dashboard con una notificación
        return redirect()->route('dashboard')->with('status', 'Perfil completado con éxito')->with('status_type', 'success');
    }

    public function marcarNotificacionLeida($id)
    {
        $usuario = auth()->user();
        $notificacion = $usuario->notifications()->where('id', $id)->firstOrFail();
        $notificacion->markAsRead();

        return redirect()->route('dashboard')->with('status', 'Notificación marcada como leída');
    }

    // Marcar todas las notificaciones como leídas
    public function marcarTodasNotificacionesLeidas()
    {
        $usuario = auth()->user();
        $usuario->unreadNotifications->markAsRead();

        return redirect()->route('dashboard')->with('status', 'Todas las notificaciones marcadas como leídas');
    }
}
