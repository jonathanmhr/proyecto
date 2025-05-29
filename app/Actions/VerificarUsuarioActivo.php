<?php

namespace App\Actions;

use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class VerificarUsuarioActivo
{
    public function __invoke(Request $request, $next)
    {
        $usuario = Auth::user();

        if ($usuario && !$usuario->is_active) {
            Auth::logout();

            throw ValidationException::withMessages([
                Fortify::username() => 'Tu cuenta está desactivada. Si crees que esto es un error, por favor comunícate con el departamento de soporte: soporte@tudominio.com.',
            ]);
        }

        return $next($request);
    }
}
