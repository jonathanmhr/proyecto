<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Entrenador\EntrenadorController;
use App\Http\Controllers\Perfil\PerfilController;
use App\Http\Controllers\ClaseGrupal\ClaseGrupalController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// Ruta de bienvenida
Route::get('/', function () {
    return view('welcome');
});

// Rutas del dashboard, donde todos los usuarios verificados pueden acceder
Route::middleware([
    'auth',
    config('jetstream.auth_session'),
    'verified',  // Asegura que el usuario haya verificado su correo
])->group(function () {
    Route::get('/dashboard', [PerfilController::class, 'index'])->name('dashboard');
});

// Rutas del panel de administración
Route::middleware([
    'auth',
    config('jetstream.auth_session'),
    'verified',
    'can:admin-access',
])->prefix('admin')->group(function () {
    Route::get('users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::post('users/{id}/assign-role', [UserController::class, 'assignRole'])->name('admin.users.assignRole');
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});

// Rutas para los paneles del entrenador
Route::middleware([
    'auth',
    'verified',
    'can:entrenador-access',
])->prefix('entrenador')->group(function () {
    Route::get('/dashboard', [EntrenadorController::class, 'index'])->name('entrenador.dashboard');
});

// Rutas para las clases grupales
Route::get('clases', [ClaseGrupalController::class, 'index'])->name('clases.index');
Route::get('clases/create', [ClaseGrupalController::class, 'create'])->name('clases.create');
Route::post('clases', [ClaseGrupalController::class, 'store'])->name('clases.store');
Route::post('clases/{clase}/unirse', [ClaseGrupalController::class, 'unirse'])->name('clases.unirse');

// Rutas de verificación de correo electrónico
Route::get('/email/verify', function () {
    return view('auth.verify-email'); // Jetstream incluye esta vista
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Correo de verificación reenviado.');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
