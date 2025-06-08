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

            // En mensual no es necesario validar días_mes
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

            // En semanal no es necesario validar dias_semana
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
        //$this->Autorizar();

        $clientes = User::where('rol', 'cliente')->get();
        return view('admin-entrenador.clases.individuales.edit', compact('claseIndividual', 'clientes'));
    }

    public function update(Request $request, ClaseIndividual $claseIndividual)
    {
        $this->Autorizar();

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_hora' => 'required|date',
            'usuario_id' => 'required|exists:users,id',
            'frecuencia' => 'nullable|in:dia,semana,mes',
            'dias_semana' => 'nullable|array',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'hora_inicio' => 'nullable|date_format:H:i',
            'duracion' => 'nullable|integer|min:1',
        ]);

        $claseIndividual->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha_hora' => $request->fecha_hora,
            'usuario_id' => $request->usuario_id,
            'frecuencia' => $request->frecuencia ?? 'dia',
            'dias_semana' => $request->dias_semana,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'hora_inicio' => $request->hora_inicio,
            'duracion' => $request->duracion,
        ]);

        return redirect()->route('admin-entrenador.clases.index')->with('success', 'Clase individual actualizada.');
    }

    public function destroy(ClaseIndividual $claseIndividual)
    {
        //$this->Autorizar();

        $claseIndividual->delete();
        return redirect()->route('admin-entrenador.clases.index')->with('success', 'Clase individual eliminada.');
    }

    private function Autorizar()
    {
        $user = Auth::user();
        if (! $user->is('admin') && ! $user->is('admin-entrenador')) {
            abort(403, 'No tienes permiso para gestionar clases individuales.');
        }
    }
}
