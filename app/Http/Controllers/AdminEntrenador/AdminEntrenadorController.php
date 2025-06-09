<?php

namespace App\Http\Controllers\AdminEntrenador;

// Controladores  
use App\Http\Controllers\Controller;
use App\Http\Controllers\AdminEntrenador;

// Modelos  
use App\Models\User;
use App\Models\ClaseGrupal;
use App\Models\ClaseIndividual;
use App\Models\Suscripcion;
use App\Models\ReservaDeClase;
use App\Models\Entrenamiento;

// Otras dependencias  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Auth;
use Carbon\Carbon;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Silber\Bouncer\Database\Role;
use Illuminate\Support\Facades\Cache;

class AdminEntrenadorController extends Controller
{
    // ========================================
    // Dashboard y vistas principales
    // ========================================

    public function dashboard()
    {
        $totalClases = ClaseGrupal::count() + ClaseIndividual::count();

        $totalEntrenadores = Cache::remember('total_entrenadores', 60, function () {
            return Bouncer::role()->where('name', 'entrenador')->first()->users()->count();
        });

        $totalAlumnos = Cache::remember('total_alumnos', 60, function () {
            return Bouncer::role()->where('name', 'cliente')->first()->users()->count();
        });

        $totalSolicitudesClasesPendientes = Cache::remember('total_solicitudes_clases_pendientes', 60, function () {
            return ClaseGrupal::where('cambio_pendiente', 1)->count();
        });

        $totalEntrenamientos = Cache::remember('total_entrenamientos', 60, function () {
            return Entrenamiento::count();
        });

        return view('admin-entrenador.dashboard', compact(
            'totalClases',
            'totalEntrenadores',
            'totalAlumnos',
            'totalSolicitudesClasesPendientes',
            'totalEntrenamientos'
        ));
    }

    public function verClases()

    {

        $clasesGrupales = ClaseGrupal::with('entrenador')->get();
        $clasesIndividuales = ClaseIndividual::with('entrenador', 'usuario')->get();
        return view('admin-entrenador.clases.index', compact('clasesGrupales', 'clasesIndividuales'));
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

        return view('admin-entrenador.clases.grupales.create', compact('entrenadores'));
    }

    public function store(Request $request)
    {
        // Guardamos la fecha de inicio desde el formulario para poder usarla en las reglas
        $fechaInicio = $request->input('fecha_inicio');

        // Definimos las reglas de validación
        $rules = [
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'fecha_inicio' => ['required', 'date', 'after_or_equal:today', 'before_or_equal:' . now()->addMonths(3)->format('Y-m-d')],
            'fecha_fin' => ['required', 'date', 'after_or_equal:' . $fechaInicio, 'before_or_equal:' . now()->addMonths(3)->format('Y-m-d')],
            'hora_inicio' => ['required', 'date_format:H:i'],
            'duracion' => 'nullable|integer|min:1',
            'ubicacion' => 'nullable|string|max:100',
            'nivel' => 'nullable|in:principiante,intermedio,avanzado',
            'cupos_maximos' => 'required|integer|min:5|max:20',
            'entrenador_id' => 'required|exists:users,id',
            'frecuencia' => 'required|in:dia,semana,mes',
        ];

        // Reglas adicionales según la frecuencia seleccionada
        if (in_array($request->frecuencia, ['semana', 'mes'])) {
            $rules['dias_semana'] = 'required|array|min:1';
            $rules['dias_semana.*'] = 'in:lunes,martes,miércoles,jueves,viernes,sábado,domingo';
        } elseif ($request->frecuencia === 'dia') {
            $rules['fecha_fin'] = 'same:fecha_inicio'; // misma fecha para clases de un solo día
        }

        // Validamos los datos con las reglas definidas
        $validatedData = $request->validate($rules);

        // Aseguramos que fecha_fin sea igual a fecha_inicio si es una clase de un día
        if ($validatedData['frecuencia'] === 'dia') {
            $validatedData['fecha_fin'] = $validatedData['fecha_inicio'];
        }

        try {
            // Creamos la clase grupal
            ClaseGrupal::create([
                'nombre' => $validatedData['nombre'],
                'descripcion' => $validatedData['descripcion'] ?? null,
                'fecha_inicio' => $validatedData['fecha_inicio'],
                'fecha_fin' => $validatedData['fecha_fin'],
                'fecha' => now(), // Fecha de creación (puede omitirse si no se usa)
                'hora_inicio' => $validatedData['hora_inicio'],
                'duracion' => $validatedData['duracion'] ?? null,
                'ubicacion' => $validatedData['ubicacion'] ?? null,
                'nivel' => $validatedData['nivel'] ?? null,
                'cupos_maximos' => $validatedData['cupos_maximos'],
                'entrenador_id' => $validatedData['entrenador_id'],
                'frecuencia' => $validatedData['frecuencia'],
                'dias_semana' => $validatedData['dias_semana'] ?? null,
            ]);

            // Redirigimos con mensaje de éxito
            return redirect()->route('admin-entrenador.clases.index')
                ->with('success', 'Clase creada exitosamente.');
        } catch (\Exception $e) {
            // Si ocurre un error, lo registramos y redirigimos con mensaje de error
            Log::error('Error al crear la clase grupal: ' . $e->getMessage());

            return redirect()->route('admin-entrenador.clases.index')
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

        return view('admin-entrenador.clases.grupales.edit', compact('clase', 'entrenadores'));
    }

    public function update(Request $request, ClaseGrupal $clase)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'fecha_inicio' => ['required', 'date', 'after_or_equal:today', 'before_or_equal:' . Carbon::now()->addMonths(3)->format('Y-m-d')],
            'fecha_fin' => ['required', 'date', 'after_or_equal:' . $request->fecha_inicio, 'before_or_equal:' . Carbon::now()->addMonths(3)->format('Y-m-d')],
            'hora_inicio' => ['required', 'date_format:H:i'],
            'duracion' => 'nullable|integer|min:1',
            'ubicacion' => 'nullable|string|max:100',
            'nivel' => 'nullable|in:principiante,intermedio,avanzado',
            'cupos_maximos' => 'required|integer|min:5|max:30',
            'entrenador_id' => 'required|exists:users,id',
            'frecuencia' => 'required|in:dia,semana,mes',
        ]);

        // Validaciones condicionales para dias_semana según frecuencia
        if (in_array($request->frecuencia, ['semana', 'mes'])) {
            $request->validate([
                'dias_semana' => 'required|array|min:1',
                'dias_semana.*' => 'in:lunes,martes,miercoles,jueves,viernes,sabado,domingo',
            ]);
        } elseif ($request->frecuencia === 'dia') {
            $request->validate([
                'fecha_fin' => 'same:fecha_inicio',
            ]);
        }

        $clase->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'hora_inicio' => $request->hora_inicio,
            'duracion' => $request->duracion,
            'ubicacion' => $request->ubicacion,
            'nivel' => $request->nivel,
            'cupos_maximos' => $request->cupos_maximos,
            'entrenador_id' => $request->entrenador_id,
            'frecuencia' => $request->frecuencia,
            'dias_semana' => $request->dias_semana ?? null,
        ]);

        return redirect()->route('admin-entrenador.clases.index')->with('success', 'Clase actualizada correctamente.');
    }


    // ========================================
    // Gestión de Solicitudes
    // ========================================

    public function verSolicitudesClases()
    {
        // Traemos las clases con cambios pendientes
        $solicitudesPendientes = ClaseGrupal::where('cambio_pendiente', 1)
            ->whereNotNull('id_clase')
            ->get();

        return view('admin-entrenador.solicitudes.index', compact('solicitudesPendientes'));
    }

    public function aceptarSolicitud($id)
    {
        $this->autorizarAdmin();

        $clase = ClaseGrupal::find($id);

        if (!$clase || !$clase->cambio_pendiente) {
            return redirect()->back()->with('error', 'No se encontró ninguna solicitud pendiente para esta clase.');
        }

        // Si tienes un campo con los datos del cambio pendiente en JSON, aplicarlo
        if ($clase->cambios_pendientes) {
            $cambios = json_decode($clase->cambios_pendientes, true);
            $clase->fill($cambios);
        }

        // Marcar que ya no hay cambio pendiente y limpiar cambios temporales
        $clase->cambio_pendiente = 0;
        $clase->cambios_pendientes = null;
        $clase->save();

        return redirect()->back()->with('success', 'Solicitud aceptada y cambios aplicados correctamente.');
    }

    public function rechazarSolicitud($id)
    {
        $this->autorizarAdmin();

        $clase = ClaseGrupal::find($id);

        if (!$clase || !$clase->cambio_pendiente) {
            return redirect()->back()->with('error', 'No se encontró ninguna solicitud pendiente para esta clase.');
        }

        // Simplemente descartamos el cambio pendiente
        $clase->cambio_pendiente = 0;
        $clase->cambios_pendientes = null;
        $clase->save();

        return redirect()->back()->with('success', 'Solicitud rechazada y cambios descartados correctamente.');
    }

    // Método centralizado para verificar permisos
    protected function autorizarAdmin()
    {
        if (!auth()->user()->can('admin_entrenador')) {
            abort(403, 'No tienes permisos para realizar esta acción.');
        }
    }

    // ========================================
    // Gestión de Entrenamientos
    // ========================================



}
