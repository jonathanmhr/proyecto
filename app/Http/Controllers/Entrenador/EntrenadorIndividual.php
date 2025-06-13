<?php

namespace App\Http\Controllers\Entrenador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ClaseIndividual;
use App\Models\ClaseGrupal; // modelo de clases grupales
use App\Models\SolicitudClaseIndividual; // modelo de solicitudes
use App\Models\SolicitudClase; // modelo de solicitudes de clases grupales
use App\Notifications\NotificacionPersonalizada;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

class EntrenadorIndividual extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Cargar ambas clases del entrenador autenticado
        $clasesGrupales = ClaseGrupal::where('entrenador_id', $user->id)->get();
        $clasesIndividuales = ClaseIndividual::where('entrenador_id', $user->id)->get();

        // Añadir el tipo a cada clase para diferenciarlas en la vista
        $clasesGrupales->map(function ($clase) {
            $clase->tipo = 'grupal';
            return $clase;
        });

        $clasesIndividuales->map(function ($clase) {
            $clase->tipo = 'individual';
            return $clase;
        });

        // Unir ambas colecciones
        $clases = $clasesGrupales->merge($clasesIndividuales);

        // Ordenar por fecha (puedes ajustar este criterio si deseas)
        $clases = $clases->sortBy(function ($clase) {
            if ($clase->tipo === 'individual') {
                return $clase->frecuencia === 'unica' ? $clase->fecha_hora : $clase->fecha_inicio;
            }
            return $clase->fecha_inicio;
        });

        return view('entrenador.clases.index', compact('clases'));
    }

    public function create()
    {
        $entrenadores = User::whereHas('roles', fn($q) => $q->where('name', 'entrenador'))->get();
        $clientes = User::whereHas('roles', fn($q) => $q->where('name', 'cliente'))->get();

        if ($entrenadores->isEmpty()) {
            return redirect()->route('entrenador.clases-individuales.index')
                ->with('error', 'No hay entrenadores disponibles para asignar a la clase individual.');
        }

        return view('entrenador.clases.individuales.create', compact('clientes', 'entrenadores'));
    }

    public function store(Request $request)
    {
        $rules = [
            'frecuencia' => 'required|in:unica,semanal,mensual',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'usuario_id' => 'required|exists:users,id',
            'nivel' => 'required|in:principiante,intermedio,avanzado,todos',
            'lugar' => 'required|string|max:255',
        ];

        if ($request->frecuencia === 'unica') {
            $rules['fecha_hora'] = [
                'required',
                'date',
                'after_or_equal:today',
                'before_or_equal:' . now()->addMonths(3)->format('Y-m-d H:i:s'),
                function ($attribute, $value, $fail) {
                    $hora = \Carbon\Carbon::parse($value)->format('H:i');
                    if ($hora < '08:00' || $hora > '24:00') {
                        $fail('La hora debe estar entre 08:00 y 24:00.');
                    }
                }
            ];
        } elseif ($request->frecuencia === 'semanal') {
            $rules['fecha_inicio'] = ['required', 'date', 'after_or_equal:today'];
            $rules['fecha_fin'] = ['required', 'date', 'after_or_equal:' . $request->fecha_inicio];
            $rules['hora_inicio'] = [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    if ($value < '08:00' || $value > '24:00') {
                        $fail('La hora debe estar entre 08:00 y 24:00.');
                    }
                }
            ];
            $rules['duracion'] = ['required', 'integer', 'min:1'];
            $rules['dias_semana'] = 'required|array|min:1';
            $rules['dias_semana.*'] = 'in:lunes,martes,miercoles,jueves,viernes,sabado,domingo';
        } elseif ($request->frecuencia === 'mensual') {
            $rules['fecha_inicio'] = ['required', 'date', 'after_or_equal:today'];
            $rules['fecha_fin'] = ['required', 'date', 'after_or_equal:' . $request->fecha_inicio];
            $rules['hora_inicio'] = [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    if ($value < '08:00' || $value > '24:00') {
                        $fail('La hora debe estar entre 08:00 y 24:00.');
                    }
                }
            ];
            $rules['duracion'] = ['required', 'integer', 'min:1'];
            $rules['dias_mes'] = 'required|integer|between:1,31';
        }

        $validated = $request->validate($rules);

        $dias_semana = $validated['frecuencia'] === 'semanal' ? json_encode($validated['dias_semana']) : null;
        $dias_mes = $validated['frecuencia'] === 'mensual' ? $validated['dias_mes'] : null;

        ClaseIndividual::create([
            'titulo' => $validated['titulo'],
            'descripcion' => $validated['descripcion'] ?? null,
            'fecha_hora' => $validated['frecuencia'] === 'unica' ? $validated['fecha_hora'] : null,
            'fecha_inicio' => $validated['frecuencia'] !== 'unica' ? $validated['fecha_inicio'] : null,
            'fecha_fin' => $validated['frecuencia'] !== 'unica' ? $validated['fecha_fin'] : null,
            'hora_inicio' => $validated['frecuencia'] !== 'unica' ? $validated['hora_inicio'] : null,
            'duracion' => $validated['duracion'] ?? null,
            'lugar' => $validated['lugar'],
            'nivel' => $validated['nivel'] ?? null,
            'frecuencia' => $validated['frecuencia'],
            'dias_semana' => $dias_semana,
            'dias_mes' => $dias_mes,
            'usuario_id' => $validated['usuario_id'],
            'entrenador_id' => auth()->id(), 
            'creado_por' => auth()->id(),
        ]);

        return redirect()->route('entrenador.clases.index')
            ->with('success', 'Clase individual creada correctamente.');
    }

    public function edit(ClaseIndividual $claseIndividual)
    {
        $entrenadores = User::whereHas('roles', fn($q) => $q->where('name', 'entrenador'))->get();
        $clientes = User::whereHas('roles', fn($q) => $q->where('name', 'cliente'))->get();

        if ($entrenadores->isEmpty()) {
            return redirect()->route('entrenador.clases-individuales.index')
                ->with('error', 'No hay entrenadores disponibles para asignar.');
        }

        return view('entrenador.clases.individuales.edit', compact('claseIndividual', 'clientes', 'entrenadores'));
    }

    public function update(Request $request, ClaseIndividual $claseIndividual)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'usuario_id' => 'required|exists:users,id',
            'frecuencia' => 'required|in:dia,semana,mes',
            'dias_semana' => 'nullable|array',
            'dias_semana.*' => 'string|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo',
            'hora_inicio' => 'nullable|date_format:H:i',
            'fecha_hora' => ['required_if:frecuencia,dia', 'date', 'after_or_equal:today'],
            'fecha_inicio' => ['required_if:frecuencia,semana,mes', 'date', 'after_or_equal:today'],
            'fecha_fin' => ['required_if:frecuencia,semana,mes', 'date', 'after_or_equal:fecha_inicio'],
            'duracion' => 'nullable|integer|min:1',
            'lugar' => 'nullable|string|max:255',
            'nivel' => 'nullable|string|max:255',
            'entrenador_id' => 'nullable|exists:users,id',
        ]);

        // Crear solicitud pendiente de modificación
        SolicitudClaseIndividual::create([
            'clase_individual_id' => $claseIndividual->id,
            'entrenador_id' => auth()->id(),
            'datos_nuevos' => $validated, // casteado automáticamente a JSON si está definido en el modelo
            'estado' => 'pendiente',
        ]);

        // Notificar al admin-entrenador
        $adminEntrenadores = User::whereHas(
            'roles',
            fn($q) =>
            $q->where('name', 'admin-entrenador')
        )->get();

        Notification::send($adminEntrenadores, new NotificacionPersonalizada(
            'Modificación pendiente en clase individual',
            'El entrenador ' . auth()->user()->name . ' ha solicitado modificar la clase "' . $claseIndividual->titulo . '".',
            'modificacion',
            ['database'],
            auth()->user()
        ));

        return redirect()->route('entrenador.clases-individuales.index')
            ->with('success', 'Solicitud de modificación enviada al admin-entrenador para su aprobación.');
    }

    public function showGrupal($id)
    {
        $clase = ClaseGrupal::with(['usuarios' => function ($query) {
            $query->wherePivot('estado', 'aprobada');
        }])->findOrFail($id);

        $alumnos = $clase->usuarios;

        return view('entrenador.clases.grupales.detalle', compact('clase', 'alumnos'));
    }
    public function showIndividual($id)
    {
        $clase = ClaseIndividual::with('usuario')->findOrFail($id);

        return view('entrenador.clases.individuales.detalle', compact('clase'));
    }

    public function verAlumnos(string $tipo, int $id)
    {
        if ($tipo === 'grupal') {
            $clase = ClaseGrupal::with(['usuarios' => function ($query) {
                $query->wherePivot('estado', 'aprobada');
            }])->findOrFail($id);

            $alumnos = $clase->usuarios;

            return view('entrenador.clases.alumnos', compact('clase', 'alumnos', 'tipo'));
        } elseif ($tipo === 'individual') {
            $clase = ClaseIndividual::with('usuario')->findOrFail($id);

            return view('entrenador.clases.individuales.detalle', compact('clase'));
        } else {
            abort(404);
        }
    }
}
