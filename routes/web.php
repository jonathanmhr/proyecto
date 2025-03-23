<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\VerificationController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

// Ruta para verificar el correo electrónico
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['auth', 'signed'])
    ->name('verification.verify');

// Ruta para reenviar el correo de verificación
Route::post('/email/verification-notification', [VerificationController::class, 'sendVerificationEmail'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');
