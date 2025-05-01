<?php

namespace App\Http\Controllers\AdminEntrenador;

use App\Http\Controllers\Controller;
use App\Models\ClaseGrupal;
use App\Models\User;
use Illuminate\Http\Request;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use tidy;

class AdminEntrenadorController extends Controller
{
    // Método para ver las clases
    public function dashboard()
    {
        $totalClases = ClaseGrupal::count();
        $totalEntrenadores = Bouncer::role()->where('name', 'entrenador')->first()->users()->count();
        $totalAlumnos = Bouncer::role()->where('name', 'cliente')->first()->users()->count();

        return view('admin-entrenador.dashboard', compact('totalClases', 'totalEntrenadores', 'totalAlumnos'));
    }

    public function verClases()
    {
        $clases = ClaseGrupal::with('entrenador')->get(); // O ajusta según lo necesites
        return view('admin-entrenador.clases.index', compact('clases'));
    }


    public function create()
    {
        // Obtener los entrenadores disponibles
        $entrenadores = User::whereHas('roles', function ($query) {
            $query->where('name', 'entrenador');
        })->get();

        // Verificar si hay entrenadores disponibles
        if ($entrenadores->isEmpty()) {
            return redirect()->route('admin-entrenador.clases.index')
                ->with('error', 'No hay entrenadores disponibles para asignar a la clase.');
        }

        // Retornar la vista para crear una clase y pasar la lista de entrenadores
        return view('admin-entrenador.clases.create', compact('entrenadores'));
    }


    public function store(Request $request)
    {
        if (!auth()->user()->can('admin_entrenador')) {
            return redirect()->route('admin-entrenador.clases.index')->with('error', 'No tienes permiso para crear clases.');
        }

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
        $entrenador = User::find($request->entrenador_id);

        try {
            ClaseGrupal::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'fecha_inicio' => $fechaInicio,   // Usa la fecha formateada
                'fecha_fin' => $fechaFin,        // Usa la fecha formateada
                'fecha' => now(),
                'duracion' => $request->duracion,
                'ubicacion' => $request->ubicacion,
                'nivel' => $request->nivel,
                'cupos_maximos' => $request->cupos_maximos,
                'entrenador_id' => $request->entrenador_id, // Asegúrate de que esto esté bien
            ]);

            return redirect()->route('admin-entrenador.dashboard')
                ->with('success', 'Clase creada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear la clase grupal: ' . $e->getMessage());
            return redirect()->route('admin-entrenador.dashboard')
                ->with('error', 'Hubo un error al crear la clase. Intenta nuevamente.');
        }
    }

    // ---------- Gestión de Entrenadores ----------
    public function verEntrenadores()
    {
        $entrenadores = User::whereIs('entrenador')->get();
        return view('admin-entrenador.entrenadores.index', compact('entrenadores'));
    }

    public function darBajaEntrenador(User $user)
    {
        // Verificar si el usuario autenticado es un admin_entrenador
        if (auth()->user()->hasRole('admin_entrenador')) {
            // Verificar si el usuario que intenta dar de baja es un admin_entrenador
            if ($user->hasRole('admin_entrenador')) {
                return redirect()->route('admin-entrenador.entrenadores')
                                 ->with('error', 'No puedes dar de baja a otro admin_entrenador.');
            }
        }
    
        // Verificamos si el usuario tiene el rol de entrenador
        if ($user->isAn('entrenador')) {
            // Eliminamos el rol de 'entrenador' y le asignamos el rol de 'cliente'
            $user->removeRole('entrenador');
            $user->assignRole('cliente');  // Asignamos el rol 'cliente'
    
            // Aseguramos que el entrenador ya no esté asignado a ninguna clase
            $user->clasesGrupales()->detach();
    
            return redirect()->route('admin-entrenador.entrenadores')->with('success', 'Entrenador dado de baja correctamente, ahora es un cliente.');
        }
    
        return redirect()->route('admin-entrenador.entrenadores')->with('error', 'Este usuario no tiene el rol de entrenador.');
    }
    

    public function editarEntrenador(User $entrenador)
    {
        // Cargar todas las clases disponibles
        $clases = ClaseGrupal::all(); 
    
        // Pasar el entrenador y las clases a la vista
        return view('admin-entrenador.entrenadores.edit', compact('entrenador', 'clases'));
    }

    public function actualizarEntrenador(Request $request, User $entrenador)
    {
        // Log para verificar los datos que se reciben
        Log::info('Datos recibidos para actualizar las clases:', $request->all());
    
        // Validar que las clases seleccionadas existen
        $request->validate([
            'clases' => 'nullable|array|exists:clases_grupales,id',
        ]);
        
        // Obtener las clases seleccionadas
        $clasesSeleccionadas = $request->clases;
        
        // Log para verificar las clases seleccionadas
        Log::info('Clases seleccionadas:', $clasesSeleccionadas);
        
        // Verificar que al menos una clase tenga un entrenador
        foreach ($clasesSeleccionadas as $claseId) {
            $clase = ClaseGrupal::findOrFail($claseId);
        
            // Verificar si se está quitando el único entrenador de la clase
            if ($clase->entrenador && $clase->entrenador->id == $entrenador->id && $clase->entrenadores->count() == 1) {
                return redirect()->back()->with('error', 'Cada clase debe tener al menos un entrenador.');
            }
        }
        
        // Sincronizar clases del entrenador si hay clases seleccionadas
        if (!empty($clasesSeleccionadas)) {
            $entrenador->clasesGrupales()->sync($clasesSeleccionadas);
            return redirect()->route('admin-entrenador.entrenadores')->with('success', 'Clases asignadas correctamente.');
        }
        
        // Si no hay clases seleccionadas, eliminar las asignaciones
        if (empty($clasesSeleccionadas)) {
            $entrenador->clasesGrupales()->detach();
            return redirect()->route('admin-entrenador.entrenadores')->with('success', 'Clases desasignadas correctamente.');
        }
        
        // Si no se pudo realizar la acción
        return redirect()->route('admin-entrenador.entrenadores')->with('error', 'Hubo un problema al actualizar las clases.');
    }
    
   
    // ---------- Gestión de Alumnos ----------
    public function verAlumnos()
    {
        $alumnos = User::whereIs('cliente')->get();
        return view('admin-entrenador.alumnos.index', compact('alumnos'));
    }

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

        // Actualizamos las clases del alumno (como cliente)
        $user->clases()->sync($request->clases ?? []);

        return redirect()->route('admin-entrenador.alumnos')->with('success', 'Clases del alumno actualizadas.');
    }

    public function eliminarAlumno(User $user)
    {
        // No se pueden eliminar alumnos si son del rol 'cliente'
        if ($user->isAn('cliente') && !$user->isAn('admin_entrenador')) {
            $user->delete();
            return redirect()->back()->with('success', 'Alumno eliminado correctamente.');
        }
        return redirect()->back()->with('error', 'No se puede eliminar a este usuario.');
    }

    // ---------- Gestión de Clases ----------
    public function destroy(ClaseGrupal $clase)
    {
        // Verificamos que no haya usuarios inscritos antes de eliminar
        if ($clase->usuarios()->count() > 0) {
            return redirect()->back()->with('error', 'No se puede eliminar la clase porque tiene alumnos inscritos.');
        }

        // Borramos la clase
        $clase->delete();
        return redirect()->route('admin-entrenador.clases.index')->with('success', 'Clase eliminada correctamente.');
    }
}
