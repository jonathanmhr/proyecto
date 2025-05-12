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

        if ($user->can('admin_entrenador')) {
            // Admin Entrenador: Ver todos los entrenamientos
            $clases = ClaseGrupal::all();
        } elseif ($user->can('entrenador')) {
            // Entrenador: Ver solo las clases asignadas a sus clases
            $clases = ClaseGrupal::where('entrenador_id', $user->id)->get();
        } else {
            // Cliente: Ver solo las clases disponibles, no se usan entrenamientos
            $clases = ClaseGrupal::whereDate('fecha_inicio', '>=', now())
                                 ->where('cupos_maximos', '>', 0)
                                 ->get();
        }

        return view('clases.index', compact('clases'));
    }
}
