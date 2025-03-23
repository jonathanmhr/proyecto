<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\VerifyEmail;

class VerifyEmailController extends Controller
{
    /**
     * Send the email verification notification to the user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function sendVerificationEmail(Request $request)
    {
        // Obtén al usuario autenticado
        $user = $request->user();

        // Enviar la notificación de verificación de correo electrónico
        $user->sendEmailVerificationNotification();

        // Responder con un mensaje
        return back()->with('status', 'Verification link sent!');
    }
}
