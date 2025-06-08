<?php

namespace App\Http\Controllers\Perfil;

use App\Models\ClaseGrupal;
use App\Models\Entrenamiento;
use App\Models\Suscripcion;
use App\Models\PerfilUsuario;
use App\Models\DietaYPlanNutricional;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class PerfilController extends Controller
{
    public function index()
    {
        $usuario = auth()->user(); // Obtener al usuario autenticado

        // Obtener el perfil del usuario
        $perfil = $usuario->perfilUsuario; // Asumiendo que ya tienes la relación configurada

        // Verificar si el perfil está completo
        $datosCompletos = $perfil && $perfil->fecha_nacimiento && $perfil->peso && $perfil->altura && $perfil->objetivo && $perfil->id_nivel;

        // Pasar a la vista el flag que indica si el perfil está incompleto
        $incompleteProfile = !$datosCompletos && !session('profile_modal_shown');
        session(['profile_modal_shown' => true]); // Se marca que ya se mostró

        // Obtener clases inscritas por el usuario a través de la relación muchos a muchos
        $clases = $usuario->clasesAceptadas; // Relación ya definida en el modelo User

        // Obtener entrenamientos del usuario (relación uno a muchos)
        $entrenamientos = Entrenamiento::where('creado_por', $usuario->id)->get();

        // Obtener suscripciones del usuario (relación uno a muchos)
        $suscripciones = Suscripcion::where('id_usuario', $usuario->id)->get();

        // Obtener notificaciones recientes del usuario (por ejemplo las últimas 10)
        $notificaciones = $usuario->notifications()->latest()->take(10)->get();

        $dietasRecomendadas = Cache::remember('dietas_recomendadas_' . auth()->id(), now()->addMinutes(30), function () use ($usuario) {
            return DietaYPlanNutricional::where(function ($query) use ($usuario) {
                $query->whereNull('id_usuario')
                    ->orWhere('id_usuario', $usuario->id);
            })
                ->inRandomOrder()
                ->limit(5)
                ->get();
        });


        // Pasar los datos a la vista
        return view('dashboard', compact('clases', 'entrenamientos', 'suscripciones', 'incompleteProfile', 'datosCompletos', 'perfil', 'notificaciones', 'dietasRecomendadas'));
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
