<?php
namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\Suscripcion;
use App\Models\SolicitudClase;
use App\Models\ClaseGrupal;
use App\Models\User;
use Illuminate\Http\Request;

class SuscripcionController extends Controller
{
    // Mostrar las suscripciones del usuario
    public function suscripciones()
    {
        $suscripciones = Suscripcion::where('id_usuario', auth()->user()->id)->get();
        return view('clases.suscripciones', compact('suscripciones'));
    }

    // Unirse a una clase
    public function unirse(ClaseGrupal $clase)
    {
        $usuario = auth()->user();

        // Verificar si ya existe una solicitud pendiente
        $solicitudPendiente = SolicitudClase::where('id_clase', $clase->id)
            ->where('user_id', $usuario->id)
            ->where('estado', 'pendiente')
            ->exists();

        if ($solicitudPendiente) {
            return redirect()->route('cliente.clases.index')->with('info', 'Ya tienes una solicitud pendiente para esta clase.');
        }

        // Validar si hay cupo disponible en la clase
        if ($clase->usuarios()->count() >= $clase->cupos_maximos) {
            return redirect()->route('cliente.clases.index')->with('error', 'Esta clase ya está llena.');
        }

        // Validar fecha de la clase (no se puede inscribir si ya ha pasado)
        if ($clase->fecha_inicio < now()) {
            return redirect()->route('cliente.clases.index')->with('error', 'No puedes inscribirte en una clase que ya ha comenzado.');
        }

        // Crear la solicitud con estado 'pendiente'
        SolicitudClase::create([
            'user_id' => $usuario->id, 
            'id_clase' => $clase->id_clase, 
            'estado' => 'pendiente',
        ]);

        return redirect()->route('cliente.clases.index')->with('success', 'Tu solicitud para unirte a la clase ha sido enviada.');
    }
}
