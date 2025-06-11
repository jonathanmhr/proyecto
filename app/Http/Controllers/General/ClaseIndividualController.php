<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;

use App\Models\ClaseIndividual;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Illuminate\Support\Facades\Log;

class ClaseIndividualController extends Controller
{
    public function index()
    {
        $clasesIndividuales = ClaseIndividual::with('usuario')->latest()->get();
        return view('admin-entrenador.clases.index', compact('clasesIndividuales'));
    }

    public function create()
    {
        // Entrenadores
        $entrenadores = User::whereHas('roles', function ($query) {
            $query->where('name', 'entrenador');
        })->get();

        // Clientes
        $clientes = User::whereHas('roles', function ($query) {
            $query->where('name', 'cliente');
        })->get();

        if ($entrenadores->isEmpty()) {
            return redirect()->route('admin-entrenador.clases.index')
                ->with('error', 'No hay entrenadores disponibles para asignar a la clase individual.');
        }

        return view('admin-entrenador.clases.individuales.create', compact('clientes', 'entrenadores'));
    }


    public function store(Request $request)
    {
        // Validaciones base
        $rules = [
            'frecuencia' => 'required|in:unica,semanal,mensual',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'usuario_id' => 'required|exists:users,id',
            'entrenador_id' => 'required|exists:users,id',
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
                        $fail('La hora de la clase debe estar entre las 08:00 y las 24:00.');
                    }
                }
            ];
            $rules['dias_semana'] = 'nullable'; // no aplica
            $rules['fecha_inicio'] = 'nullable';
            $rules['fecha_fin'] = 'nullable';
            $rules['hora_inicio'] = 'nullable';
            $rules['duracion'] = 'nullable';
        } elseif ($request->frecuencia === 'semanal') {
            $rules['fecha_inicio'] = [
                'required',
                'date',
                'after_or_equal:today',
                'before_or_equal:' . now()->addMonths(3)->format('Y-m-d'),
            ];
            $rules['fecha_fin'] = [
                'required',
                'date',
                'after_or_equal:' . $request->fecha_inicio,
                'before_or_equal:' . now()->addMonths(3)->format('Y-m-d'),
            ];
            $rules['hora_inicio'] = [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    if ($value < '08:00' || $value > '24:00') {
                        $fail('La hora de inicio debe estar entre las 08:00 y las 24:00.');
                    }
                }
            ];
            $rules['duracion'] = ['required', 'integer', 'min:1'];
            $rules['dias_semana'] = 'required|array|min:1';
            $rules['dias_semana.*'] = 'in:lunes,martes,miercoles,jueves,viernes,sabado,domingo';

            $rules['dias_mes'] = 'nullable';
        } elseif ($request->frecuencia === 'mensual') {
            $rules['fecha_inicio'] = [
                'required',
                'date',
                'after_or_equal:today',
                'before_or_equal:' . now()->addMonths(3)->format('Y-m-d'),
            ];
            $rules['fecha_fin'] = [
                'required',
                'date',
                'after_or_equal:' . $request->fecha_inicio,
                'before_or_equal:' . now()->addMonths(3)->format('Y-m-d'),
            ];
            $rules['hora_inicio'] = [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    if ($value < '08:00' || $value > '24:00') {
                        $fail('La hora de inicio debe estar entre las 08:00 y las 24:00.');
                    }
                }
            ];
            $rules['duracion'] = ['required', 'integer', 'min:1'];

            $rules['dias_mes'] = 'required|integer|between:1,31';

            $rules['dias_semana'] = 'nullable';
            $rules['dias_semana.*'] = 'nullable';
        }

        $validated = $request->validate($rules);

        // Guardar días_semana o dias_mes segun frecuencia
        $dias_semana = null;
        $dias_mes = null;
        if ($validated['frecuencia'] === 'semanal') {
            $dias_semana = json_encode($validated['dias_semana']);
        } elseif ($validated['frecuencia'] === 'mensual') {
            $dias_mes = $validated['dias_mes'];
        }

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
            'entrenador_id' => $validated['entrenador_id'] ?? null,
            'creado_por' => auth()->id(),
        ]);

        return redirect()->route('admin-entrenador.clases.index')
            ->with('success', 'Clase individual creada correctamente.');
    }



    public function edit(ClaseIndividual $claseIndividual)
    {


        // Entrenadores
        $entrenadores = User::whereHas('roles', function ($query) {
            $query->where('name', 'entrenador');
        })->get();

        // Clientes
        $clientes = User::whereHas('roles', function ($query) {
            $query->where('name', 'cliente');
        })->get();

        if ($entrenadores->isEmpty()) {
            return redirect()->route('admin-entrenador.clases.index')
                ->with('error', 'No hay entrenadores disponibles para asignar a la clase individual.');
        }

        return view('admin-entrenador.clases.individuales.edit', compact('claseIndividual', 'clientes', 'entrenadores'));
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

        // Convertir dias_semana a JSON para almacenar en DB
        $diasSemanaJson = null;
        if (!empty($validated['dias_semana'])) {
            $diasSemanaJson = json_encode($validated['dias_semana']);
        }

        $claseIndividual->update([
            'titulo' => $validated['titulo'],
            'descripcion' => $validated['descripcion'] ?? null,
            'usuario_id' => $validated['usuario_id'],
            'frecuencia' => $validated['frecuencia'],
            'dias_semana' => $diasSemanaJson,
            'fecha_hora' => $validated['fecha_hora'] ?? null,
            'fecha_inicio' => $validated['fecha_inicio'] ?? null,
            'fecha_fin' => $validated['fecha_fin'] ?? null,
            'hora_inicio' => $validated['hora_inicio'] ?? null,
            'duracion' => $validated['duracion'] ?? null,
            'lugar' => $validated['lugar'] ?? null,
            'nivel' => $validated['nivel'] ?? null,
            'entrenador_id' => $validated['entrenador_id'] ?? null,
        ]);

        return redirect()->route('admin-entrenador.clases-individuales.index')
            ->with('success', 'Clase individual actualizada correctamente.');
    }


    public function destroy(ClaseIndividual $claseIndividual)
    {


        $claseIndividual->delete();
        return redirect()->route('admin-entrenador.clases.index')->with('success', 'Clase individual eliminada.');
    }
}
