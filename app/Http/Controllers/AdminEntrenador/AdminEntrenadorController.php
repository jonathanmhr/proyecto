<?php

namespace App\Http\Controllers\AdminEntrenador;

use App\Http\Controllers\Controller;
use App\Models\ClaseGrupal;
use App\Models\User;
use App\Models\Suscripcion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Silber\Bouncer\Database\Role;
use Auth;

class AdminEntrenadorController extends Controller
{
    // ========================================
    // Dashboard y vistas principales
    // ========================================

    public function index()
    {
        return view('entrenador.dashboard');
    }

    public function dashboard()
    {
        // Obtener las clases activas (inicio pasado o presente, fin futuro o presente)
        $clases = ClaseGrupal::where('fecha_inicio', '<=', now())
                             ->where('fecha_fin', '>=', now())
                             ->get(); // Obtener todas las clases activas
    
        // Contamos el total de clases activas
        $totalClases = $clases->count();
    
        // Contamos el total de entrenadores y alumnos
        $totalEntrenadores = Bouncer::role()->where('name', 'entrenador')->first()->users()->count();
        $totalAlumnos = Bouncer::role()->where('name', 'cliente')->first()->users()->count();
    
        // Pasamos las variables a la vista
        return view('admin-entrenador.dashboard', compact('clases', 'totalClases', 'totalEntrenadores', 'totalAlumnos'));
    }

    public function verClases()
    {
        // Obtener las clases con su respectivo entrenador
        $clases = ClaseGrupal::with('entrenador')->get();
        return view('admin-entrenador.clases.index', compact('clases'));
    }
    

    public function verEntrenadores()
    {
        $entrenadores = User::whereIs('entrenador')->get();
        return view('admin-entrenador.entrenadores.index', compact('entrenadores'));
    }

    public function verAlumnos()
    {
        $alumnos = User::whereIs('cliente')->get();
        return view('admin-entrenador.alumnos.index', compact('alumnos'));
    }

    // ========================================
    // Gestión de Entrenadores
    // ========================================

    public function darBajaEntrenador(User $user)
    {
        if (auth()->user()->hasRole('admin_entrenador')) {
            if ($user->can('admin_entrenador')) {
                return redirect()->route('admin-entrenador.entrenadores')
                    ->with('error', 'No puedes dar de baja a otro admin_entrenador.');
            }
        }

        if ($user->isAn('entrenador')) {
            $user->removeRole('entrenador');
            $user->assignRole('cliente');
            $user->clasesGrupales()->detach(); // Desasignar clases
            $user->suscripciones()->delete(); // Eliminar suscripciones

            return redirect()->route('admin-entrenador.entrenadores')->with('success', 'Entrenador dado de baja correctamente, ahora es un cliente.');
        }

        return redirect()->route('admin-entrenador.entrenadores')->with('error', 'Este usuario no tiene el rol de entrenador.');
    }

    public function editarEntrenador(User $entrenador)
    {
        $clases = ClaseGrupal::all();
        return view('admin-entrenador.entrenadores.edit', compact('entrenador', 'clases'));
    }

    public function actualizarEntrenador(Request $request, User $entrenador)
    {
        $request->validate([
            'clases' => 'nullable|array|exists:clases_grupales,id_clase',
        ]);

        $clasesSeleccionadas = $request->input('clases', []);
        if (!empty($clasesSeleccionadas)) {
            $entrenador->clases()->sync($clasesSeleccionadas);
            return redirect()->route('admin-entrenador.entrenadores')->with('success', 'Clases asignadas correctamente.');
        }

        $entrenador->clases()->detach();
        return redirect()->route('admin-entrenador.entrenadores')->with('success', 'Clases desasignadas correctamente.');
    }

    // ========================================
    // Gestión de Alumnos
    // ========================================

    public function editarAlumno(User $user)
    {
        $clases = ClaseGrupal::all();
        return view('admin-entrenador.alumnos.edit', compact('user', 'clases'));
    }

    public function actualizarAlumno(Request $request, User $user)
    {
        $request->validate([
            'clases' => 'nullable|array',
            'clases.*' => 'exists:clases_grupales,id_clase',
        ]);

        $user->clases()->sync($request->clases ?? []);

        return redirect()->route('admin-entrenador.alumnos')->with('success', 'Clases del alumno actualizadas.');
    }

    public function quitarDeClase(User $user, $claseId)
    {
        $clase = ClaseGrupal::findOrFail($claseId);

        // Verificamos si el alumno está inscrito en la clase
        if (!$user->clases->contains($clase)) {
            return redirect()->route('admin-entrenador.alumnos.index')->with('error', 'El alumno no está inscrito en esta clase.');
        }

        // Desvinculamos al alumno de la clase
        $user->clases()->detach($claseId);

        // Cancelar la suscripción (si existe)
        $suscripcion = Suscripcion::where('id_usuario', $user->id)
            ->where('id_clase', $claseId)
            ->where('estado', Suscripcion::ESTADO_ACTIVO) // Solo si está activa
            ->first();

        if ($suscripcion) {
            // Opcionalmente, puedes cambiar el estado de la suscripción a 'inactivo' si no quieres eliminarla completamente
            $suscripcion->estado = Suscripcion::ESTADO_INACTIVO;
            $suscripcion->save();
            // Si prefieres eliminarla, usa $suscripcion->delete(); en lugar de $suscripcion->save();
        }

        return redirect()->route('admin-entrenador.alumnos.index')->with('success', 'Alumno quitado de la clase y su suscripción cancelada.');
    }


    // ========================================
    // Gestión de Clases
    // ========================================

    public function create()
    {
        $entrenadores = User::whereHas('roles', function ($query) {
            $query->where('name', 'entrenador');
        })->get();

        if ($entrenadores->isEmpty()) {
            return redirect()->route('admin-entrenador.clases.index')
                ->with('error', 'No hay entrenadores disponibles para asignar a la clase.');
        }

        return view('admin-entrenador.clases.create', compact('entrenadores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'fecha_inicio' => ['required', 'date', 'after_or_equal:today', 'before_or_equal:' . now()->addMonths(3)->format('Y-m-d')],
            'fecha_fin' => ['required', 'date', 'after:' . $request->fecha_inicio, 'before_or_equal:' . now()->addMonths(3)->format('Y-m-d')],
            'duracion' => 'nullable|integer|min:1',
            'ubicacion' => 'nullable|string|max:100',
            'nivel' => 'nullable|in:principiante,intermedio,avanzado',
            'cupos_maximos' => 'required|integer|min:5|max:20',
            'entrenador_id' => 'required|exists:users,id',
        ]);

        $fechaInicio = Carbon::parse($request->fecha_inicio)->format('Y-m-d');
        $fechaFin = Carbon::parse($request->fecha_fin)->format('Y-m-d');

        try {
            ClaseGrupal::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'fecha' => now(),
                'duracion' => $request->duracion,
                'ubicacion' => $request->ubicacion,
                'nivel' => $request->nivel,
                'cupos_maximos' => $request->cupos_maximos,
                'entrenador_id' => $request->entrenador_id,
            ]);

            return redirect()->route('admin-entrenador.dashboard')
                ->with('success', 'Clase creada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear la clase grupal: ' . $e->getMessage());
            return redirect()->route('admin-entrenador.dashboard')
                ->with('error', 'Hubo un error al crear la clase. Intenta nuevamente.');
        }
    }

    public function destroy(ClaseGrupal $clase)
    {
        if ($clase->usuarios()->count() > 0) {
            return redirect()->back()->with('error', 'No se puede eliminar la clase porque tiene alumnos inscritos.');
        }

        $clase->delete();
        return redirect()->route('admin-entrenador.clases.index')->with('success', 'Clase eliminada correctamente.');
    }

    public function edit($id)
    {
        $clase = ClaseGrupal::findOrFail($id);
        $entrenadores = User::whereHas('roles', function ($query) {
            $query->where('name', 'entrenador');
        })->get();

        return view('admin-entrenador.clases.edit', compact('clase', 'entrenadores'));
    }

    public function update(Request $request, ClaseGrupal $clase)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'fecha_inicio' => ['required', 'date', 'after_or_equal:today', 'before_or_equal:' . Carbon::now()->addMonths(3)->format('Y-m-d')],
            'fecha_fin' => ['required', 'date', 'after:' . $request->fecha_inicio, 'before_or_equal:' . Carbon::now()->addMonths(3)->format('Y-m-d')],
            'duracion' => 'nullable|integer|min:1',
            'ubicacion' => 'nullable|string|max:100',
            'nivel' => 'nullable|in:principiante,intermedio,avanzado',
            'cupos_maximos' => 'required|integer|min:5|max:30',
            'entrenador_id' => 'required|exists:users,id',
        ]);

        $clase->update($request->all());

        return redirect()->route('admin-entrenador.clases.index')->with('success', 'Clase actualizada correctamente.');
    }

    // ========================================
    // Gestión de Solicitudes
    // ========================================

    public function aceptarSolicitud($claseId, $usuarioId)
    {
        $this->autorizarAdmin(); // Verificación centralizada

        $suscripcion = Suscripcion::where('id_clase', $claseId)
            ->where('id_usuario', $usuarioId)
            ->where('estado', 'pendiente')
            ->first();

        if (!$suscripcion) {
            return redirect()->back()->with('error', 'No se encontró la solicitud pendiente.');
        }

        $suscripcion->update([
            'estado' => 'activo',
            'fecha_inicio' => now(),
            'fecha_fin' => now()->addMonth(),
        ]);

        return redirect()->back()->with('success', 'Solicitud aceptada correctamente.');
    }

    public function rechazarSolicitud($claseId, $usuarioId)
    {
        $this->autorizarAdmin(); // Verificación centralizada

        $suscripcion = Suscripcion::where('id_clase', $claseId)
            ->where('id_usuario', $usuarioId)
            ->where('estado', 'pendiente')
            ->first();

        if (!$suscripcion) {
            return redirect()->back()->with('error', 'No se encontró la solicitud pendiente.');
        }

        $suscripcion->delete();

        return redirect()->back()->with('success', 'Solicitud rechazada correctamente.');
    }

    public function aprobarCambios($id)
    {
        $clase = ClaseGrupal::findOrFail($id);

        // Marcar que los cambios fueron aprobados
        $clase->cambio_pendiente = false; // Asegúrate de que este campo exista en la base de datos
        $clase->save();

        return redirect()->route('admin-entrenador.clases.index')->with('success', 'Cambios aprobados exitosamente.');
    }

    // Método centralizado para verificar permisos
    protected function autorizarAdmin()
    {
        if (!auth()->user()->can('admin_entrenador')) {
            abort(403, 'No tienes permisos para realizar esta acción.');
        }
    }
}
