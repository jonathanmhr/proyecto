<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\ClaseGrupal;
use App\Models\Entrenamiento;
use Illuminate\Http\Request;

class ClaseGrupalController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Obtenemos las clases disponibles dependiendo del rol del usuario
        if ($user->can('admin_entrenador')) {
            $clases = ClaseGrupal::latest()->take(6)->get();
        } elseif ($user->can('entrenador')) {
            $clases = ClaseGrupal::where('entrenador_id', $user->id)->latest()->take(6)->get();
        } else {
            // Clases con fecha de inicio futura y cupos disponibles
            $clases = ClaseGrupal::whereDate('fecha_inicio', '>=', now())
                ->where('cupos_maximos', '>', 0)
                ->latest()->take(6)->get();
        }

        // Verificamos la inscripción del usuario en las clases
        foreach ($clases as $clase) {
            // Verifica si el usuario ya está inscrito
            $clase->inscrito = $clase->usuarios()->wherePivot('estado', 'aceptado')
                ->where('id_usuario', $user->id)->exists();

            // Verifica si hay una solicitud pendiente
            $clase->solicitud_pendiente = $clase->solicitudes()->where('user_id', $user->id)
                ->where('estado', 'pendiente')->exists();

            // Verifica si el usuario ha sido revocado
            $clase->revocado = $clase->usuarios()->wherePivot('estado', 'revocado')
                ->where('id_usuario', $user->id)->exists();
        }

        return view('cliente.clases.index', compact('clases'));
    }


    public function unirse(Request $request, $claseId)
    {
        $user = auth()->user();
        $clase = ClaseGrupal::findOrFail($claseId);

        // Verificar si el usuario ya está inscrito en la clase
        $yaInscrito = $clase->usuarios()->where('user_id', $user->id)->exists();

        if ($yaInscrito) {
            return redirect()->back()->with('error', 'Ya estás inscrito en esta clase.');
        }

        // Verificar si ya tiene una solicitud pendiente
        $solicitudPendiente = $clase->solicitudes()->where('user_id', $user->id)->where('estado', 'pendiente')->exists();

        if ($solicitudPendiente) {
            return redirect()->back()->with('error', 'Ya tienes una solicitud pendiente.');
        }

        // Verificar si la solicitud fue rechazada
        $solicitudRechazada = $clase->solicitudes()->where('user_id', $user->id)->where('estado', 'rechazado')->exists();

        if ($solicitudRechazada) {
            return redirect()->back()->with('error', 'Te han rechazado de esta clase.');
        }

        // Si no tiene una solicitud pendiente ni está inscrito, creamos la solicitud
        $clase->solicitudes()->create([
            'user_id' => $user->id,
            'estado' => 'pendiente', // Estado inicial: pendiente
        ]);

        return redirect()->back()->with('success', 'Tu solicitud ha sido enviada y está pendiente de aprobación.');
    }
}
