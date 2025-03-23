<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Routing\Controller;

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

    /**
     * Handle the email verification.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        $user = $request->user();  // Verificar que el usuario está autenticado

        // Verificar que el id de la ruta coincida con el id del usuario
        if (! hash_equals((string) $request->route('id'), (string) $user->getKey())) {
            abort(403, 'Invalid verification link');
        }
    
        // Verificar que el hash coincida con el hash del correo electrónico
        if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            abort(403, 'Invalid verification link');
        }
    
        // Marcar el correo como verificado
        $user->markEmailAsVerified();
    
        // Redirigir a donde necesites (por ejemplo, al dashboard)
        return redirect('/dashboard');
    }
}
