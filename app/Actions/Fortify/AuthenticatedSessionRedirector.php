<?php

namespace App\Actions\Fortify;

use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LoginResponse;

class AuthenticatedSessionRedirector implements LoginResponse
{
    public function toResponse($request)
    {
        // Si el usuario ha verificado su correo, redirige al dashboard
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended('/dashboard');
        }

        // Si no ha verificado el correo, redirige a la página de verificación
        return redirect()->route('verification.notice');
    }
}
