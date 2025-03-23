<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\URL;

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
        $user = $request->user();
        
        // Generar la URL de verificación firmada
        $url = URL::signedRoute('verification.verify', [
            'id' => $user->getKey(),
            'hash' => sha1($user->getEmailForVerification()),
        ]);
    
        // Enviar el enlace de verificación por correo electrónico
        $user->notify(new \App\Notifications\VerifyEmail($url));
    
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
    
        // Verificar que el hash coincida con el correo del usuario
        if (! hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            abort(403, 'Invalid verification link');
        }
    
        // Marcar el correo como verificado
        $user->markEmailAsVerified();
    
        // Disparar el evento de verificación
        event(new Verified($user));
    
        // Redirigir a donde necesites (por ejemplo, al dashboard)
        return redirect('/dashboard');
    }
    
}
