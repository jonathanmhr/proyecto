<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\ClaseGrupal;
use App\Models\Entrenamiento;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->can('admin_entrenador')) {
            $clases = ClaseGrupal::latest()->take(6)->get();
            $entrenamientos = Entrenamiento::latest()->take(6)->get();
        } elseif ($user->can('entrenador')) {
            $clases = ClaseGrupal::where('entrenador_id', $user->id)->latest()->take(6)->get();
            $entrenamientos = Entrenamiento::where('entrenador_id', $user->id)->latest()->take(6)->get();
        } else {
            $clases = ClaseGrupal::latest()->take(6)->get();

            $entrenamientos = Entrenamiento::latest()->take(6)->get();
        }

        return view('cliente.dashboard', compact('clases', 'entrenamientos'));
    }
}
