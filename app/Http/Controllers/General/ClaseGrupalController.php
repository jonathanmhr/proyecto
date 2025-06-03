<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\ClaseGrupal;
use Illuminate\Http\Request;

class ClaseGrupalController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->can('admin_entrenador') || $user->can('admin')) {
            // Todos ven todas las clases ordenadas por fecha_inicio descendente, paginadas
            $clases = ClaseGrupal::orderBy('fecha_inicio', 'desc')->paginate(10);
            $clasesParaEventos = $user->clases;
        } elseif ($user->can('entrenador')) {
            // Entrenador solo sus clases
            $clases = ClaseGrupal::where('entrenador_id', $user->id)
                ->orderBy('fecha_inicio', 'desc')
                ->paginate(10);
        } else {
            // Clientes ven todas las clases ordenadas igual
            $clases = ClaseGrupal::orderBy('fecha_inicio', 'desc')->paginate(10);
        }

        foreach ($clases as $clase) {
            $inscritos = $clase->usuarios()->wherePivot('estado', 'aceptado')->count();
            $cupos_maximos = $clase->cupos_maximos;

            if ($cupos_maximos - $inscritos > ($cupos_maximos / 2)) {
                $clase->estado_color = 'bg-green-600 text-white';
            } elseif ($cupos_maximos - $inscritos > 0) {
                $clase->estado_color = 'bg-yellow-500 text-black';
            } else {
                $clase->estado_color = 'bg-red-600 text-white';
            }

            $clase->inscrito = $clase->usuarios()->where('users.id', $user->id)->wherePivot('estado', 'aceptado')->exists();
            $clase->solicitud_pendiente = $clase->solicitudes()->where('id_usuario', $user->id)->where('estado', 'pendiente')->exists();
            $clase->revocado = $clase->usuarios()->where('users.id', $user->id)->wherePivot('estado', 'revocado')->exists();


            $clase->expirada = $clase->fecha_inicio < now();
        }
        $eventos = $clasesParaEventos->map(function ($clase) {
            return [
                'title' => $clase->nombre,
                'start' => $clase->fecha_inicio->toDateTimeString(),
                'end' => $clase->fecha_fin ? $clase->fecha_fin->toDateTimeString() : null,
                'tipo' => 'Clase Grupal',
                'description' => $clase->descripcion ?? '',
            ];
        });

        return view('cliente.clases.index', compact('clases', 'eventos'));
    }


    public function unirse(Request $request, ClaseGrupal $clase)
    {
        $user = auth()->user();

        // Contar inscritos activos (puedes ajustar el estado si tienes otro nombre)
        $inscritosCount = $clase->suscripciones()->where('estado', 'activa')->count();

        // Calcular cupos restantes
        $cuposRestantes = $clase->cupos_maximos - $inscritosCount;

        if ($cuposRestantes <= 0) {
            return redirect()->back()->with('error', 'No quedan cupos disponibles en esta clase.');
        }

        // Validaciones previas
        $yaInscrito = $clase->usuarios()->where('users.id', $user->id)->exists();
        if ($yaInscrito) {
            return redirect()->back()->with('error', 'Ya estás inscrito en esta clase.');
        }

        $solicitudPendiente = $clase->solicitudes()->where('user_id', $user->id)->where('estado', 'pendiente')->exists();
        if ($solicitudPendiente) {
            return redirect()->back()->with('error', 'Ya tienes una solicitud pendiente.');
        }

        $solicitudRechazada = $clase->solicitudes()->where('user_id', $user->id)->where('estado', 'rechazado')->exists();
        if ($solicitudRechazada) {
            return redirect()->back()->with('error', 'Te han rechazado de esta clase.');
        }

        // Crear la solicitud
        $clase->solicitudes()->create([
            'user_id' => $user->id,
            'estado' => 'pendiente',
        ]);

        return redirect()->back()->with('success', 'Tu solicitud ha sido enviada y está pendiente de aprobación.');
    }
}
