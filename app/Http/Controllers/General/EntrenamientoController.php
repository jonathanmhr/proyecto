<?php

<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Entrenamiento;

class EntrenamientoController extends Controller
{
    // Mostrar entrenamientos según el rol
    public function index()
    {
        $user = auth()->user();

        if ($user->isAn('admin_entrenador')) {
            // Admin-entrenador: ver todos los entrenamientos
            $entrenamientos = Entrenamiento::all();
        } elseif ($user->isAn('entrenador')) {
            // Entrenador: ver los que él creó
            $entrenamientos = Entrenamiento::where('id_usuario', $user->id)->get();
        } else {
            // Cliente: ver entrenamientos disponibles (por fecha futura)
            $entrenamientos = Entrenamiento::whereDate('fecha', '>=', now())->get();
        }

        return view('clases.index', compact('entrenamientos'));
    }

    // Unirse a un entrenamiento (cliente)
    public function unirseEntrenamiento($entrenamientoId)
    {
        $usuario = auth()->user();
        $entrenamiento = Entrenamiento::findOrFail($entrenamientoId);

        // Verificar si ya está inscrito
        $yaInscrito = $entrenamiento->usuarios()->where('usuario_id', $usuario->id)->exists();
        if ($yaInscrito) {
            return redirect()->back()->with('error', 'Ya estás inscrito en este entrenamiento.');
        }

        // Inscribir al usuario
        $entrenamiento->usuarios()->attach($usuario->id, ['estado' => 'inscrito']);

        return redirect()->back()->with('success', 'Te has inscrito en el entrenamiento exitosamente.');
    }
}
