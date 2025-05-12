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

    if ($user->can('admin_entrenador')) {
        $clases = ClaseGrupal::all();
        $entrenamientos = Entrenamiento::all();
    } elseif ($user->can('entrenador')) {
        $clases = ClaseGrupal::where('entrenador_id', $user->id)->get();
        $entrenamientos = Entrenamiento::where('entrenador_id', $user->id)->get();
    } else {
        $clases = ClaseGrupal::whereDate('fecha_inicio', '>=', now())
                             ->where('cupos_maximos', '>', 0)
                             ->get();

        $entrenamientos = Entrenamiento::whereDate('fecha', '>=', now())
                                       ->get(); // o ajusta según tu lógica de disponibilidad
    }

    return view('clases.index', compact('clases', 'entrenamientos'));
}
}
