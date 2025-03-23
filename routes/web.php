<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerifyEmailController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas de verificación de correo electrónico
Route::middleware(['auth'])->group(function () {
    // Mostrar vista de verificación
    Route::get('/email/verify', function () {
        return view('auth.verify');
    })->name('verification.notice');
    
    // Enviar la notificación de verificación
    Route::post('/email/verification-notification', [VerifyEmailController::class, 'sendVerificationEmail'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // Ruta para verificar el correo electrónico
    Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, 'verify'])
        ->middleware(['signed'])  // Esto valida la firma de la URL
        ->name('verification.verify');
});
