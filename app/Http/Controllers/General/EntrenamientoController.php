<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EntrenamientoController extends Controller
{
public function __call($method, $parameters)
{
    $user = Auth::user();

    if ($user->isAn('admin_entrenador') || $user->isAn('admin')) {
        return app(\App\Http\Controllers\AdminEntrenador\AdminEntrenamientoController::class)->$method(request(), ...$parameters);
    }

    if ($user->isAn('entrenador')) {
        return app(\App\Http\Controllers\Entrenador\EntrenamientoController::class)->$method(request(), ...$parameters);
    }

    if ($user->isAn('cliente')) {
        return app(\App\Http\Controllers\Cliente\EntrenamientoController::class)->$method(request(), ...$parameters);
    }

    abort(403, 'Rol no autorizado');
}

}
