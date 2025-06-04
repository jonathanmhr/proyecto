<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\ClaseGrupal;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ClaseGrupalController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $clasesParaEventos = collect();

        $eventosQuery = ClaseGrupal::orderBy('fecha_inicio', 'desc');

        if ($user->can('admin_entrenador') || $user->can('admin')) {
            $clases = ClaseGrupal::orderBy('fecha_inicio', 'desc')->paginate(10);
            $clasesParaEventos = $eventosQuery->get();
        } elseif ($user->can('entrenador')) {
            $clasesQuery = ClaseGrupal::where('entrenador_id', $user->id)
                ->orderBy('fecha_inicio', 'desc');
            $clases = $clasesQuery->paginate(10);
            $clasesParaEventos = $clasesQuery->get();
        } else {
            $clases = ClaseGrupal::orderBy('fecha_inicio', 'desc')->paginate(10);
            $clasesParaEventos = $eventosQuery->get();
        }

        foreach ($clases as $clase) {
            $inscritos = $clase->usuarios()->wherePivot('estado', 'aceptado')->count();
            $cupos_maximos = $clase->cupos_maximos;
            $cupos_disponibles = $cupos_maximos - $inscritos;

            if ($cupos_disponibles > ($cupos_maximos / 2)) {
                $clase->estado_color = 'bg-green-600 text-white';
            } elseif ($cupos_disponibles > 0) {
                $clase->estado_color = 'bg-yellow-500 text-black';
            } else {
                $clase->estado_color = 'bg-red-600 text-white';
            }

            $clase->cupos_disponibles = $cupos_disponibles;
            $clase->inscritos_count = $inscritos;

            $clase->inscrito = $clase->usuarios()->where('users.id', $user->id)->wherePivot('estado', 'aceptado')->exists();
            $clase->solicitud_pendiente = $clase->solicitudes()->where('user_id', $user->id)->where('estado', 'pendiente')->exists();
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

        $inscritosAceptadosCount = $clase->usuarios()->wherePivot('estado', 'aceptado')->count();
        $cuposRestantes = $clase->cupos_maximos - $inscritosAceptadosCount;

        if ($cuposRestantes <= 0) {
            return redirect()->back()->with('error', 'No quedan cupos disponibles en esta clase.');
        }

        $yaInscritoAceptado = $clase->usuarios()->where('users.id', $user->id)->wherePivot('estado', 'aceptado')->exists();
        if ($yaInscritoAceptado) {
            return redirect()->back()->with('error', 'Ya estás inscrito y aceptado en esta clase.');
        }
        
        $solicitudPendiente = $clase->solicitudes()->where('user_id', $user->id)->where('estado', 'pendiente')->exists();
        if ($solicitudPendiente) {
            return redirect()->back()->with('error', 'Ya tienes una solicitud pendiente para esta clase.');
        }

        $yaRevocado = $clase->usuarios()->where('users.id', $user->id)->wherePivot('estado', 'revocado')->exists();
        if ($yaRevocado) {
            return redirect()->back()->with('error', 'Tu inscripción a esta clase fue revocada anteriormente.');
        }
        
        $solicitudRechazada = $clase->solicitudes()->where('user_id', $user->id)->where('estado', 'rechazado')->exists();
        if ($solicitudRechazada) {
            return redirect()->back()->with('error', 'Tu solicitud anterior para esta clase fue rechazada.');
        }

        $clase->solicitudes()->create([
            'user_id' => $user->id,
            'estado' => 'pendiente',
        ]);

        return redirect()->back()->with('success', 'Tu solicitud ha sido enviada y está pendiente de aprobación.');
    }
}