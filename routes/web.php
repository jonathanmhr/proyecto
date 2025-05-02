<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Entrenador\EntrenadorController;
use App\Http\Controllers\Perfil\PerfilController;
use App\Http\Controllers\ClaseGrupal\ClaseGrupalController;
use App\Http\Controllers\AdminEntrenador\AdminEntrenadorController;
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


// ----------------------
// RUTAS ADMIN (acceso total)
// ----------------------
Route::middleware([
    'auth',
    config('jetstream.auth_session'),
    'verified',
    'can:admin-access',
])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class)->except(['create', 'show']);
    Route::post('users/{id}/assign-role', [UserController::class, 'assignRole'])->name('users.assignRole');
});

// ----------------------
// RUTAS ADMIN ENTRENADOR (gestión de entrenadores y clases)
// ----------------------
Route::middleware([
    'auth',
    'verified',
    'can:admin_entrenador',
])->prefix('admin-entrenador')->name('admin-entrenador.')->group(function () {
    Route::get('/', [AdminEntrenadorController::class, 'dashboard'])->name('dashboard');
    
    // Gestión de clases
    Route::get('clases', [AdminEntrenadorController::class, 'verClases'])->name('clases.index');
    Route::get('clases/create', [AdminEntrenadorController::class, 'create'])->name('clases.create');
    Route::post('clases', [AdminEntrenadorController::class, 'store'])->name('clases.store');
    Route::get('clases/{clase}/edit', [AdminEntrenadorController::class, 'edit'])->name('clases.edit');
    Route::put('clases/{clase}', [AdminEntrenadorController::class, 'update'])->name('clases.update');
    Route::delete('clases/{clase}', [AdminEntrenadorController::class, 'destroy'])->name('clases.destroy');
    Route::put('clase/{id}/aprobar', [AdminEntrenadorController::class, 'aprobarCambios'])->name('clases.aprobar');

    // Gestión de entrenadores
    Route::get('entrenadores', [AdminEntrenadorController::class, 'verEntrenadores'])->name('entrenadores.index');
    Route::get('entrenadores/create', [AdminEntrenadorController::class, 'crearEntrenador'])->name('entrenadores.create');
    Route::post('entrenadores', [AdminEntrenadorController::class, 'storeEntrenador'])->name('entrenadores.store');
    Route::get('entrenadores/{entrenador}/edit', [AdminEntrenadorController::class, 'editarEntrenador'])->name('entrenadores.edit');
    Route::put('entrenadores/{entrenador}', [AdminEntrenadorController::class, 'actualizarEntrenador'])->name('entrenadores.update');
    Route::post('entrenadores/{entrenador}/dar-baja', [AdminEntrenadorController::class, 'darBajaEntrenador'])->name('entrenadores.darBaja');

    // Gestión de alumnos
    Route::get('alumnos', [AdminEntrenadorController::class, 'verAlumnos'])->name('alumnos.index');
    Route::get('alumnos/{user}/editar', [AdminEntrenadorController::class, 'editarAlumno'])->name('alumnos.edit');
    Route::put('alumnos/{user}', [AdminEntrenadorController::class, 'actualizarAlumno'])->name('alumnos.update');
    Route::post('alumnos/{user}/quitar-de-clase/{claseId}', [AdminEntrenadorController::class, 'quitarDeClase'])->name('alumnos.quitarDeClase');

    // Aceptar o rechazar solicitudes de clases
    Route::post('clases/{clase}/aceptar/{user}', [AdminEntrenadorController::class, 'aceptarSolicitud'])->name('clases.aceptar');
    Route::post('clases/{clase}/rechazar/{user}', [AdminEntrenadorController::class, 'rechazarSolicitud'])->name('clases.rechazar');

    // Gestión de suscripciones de usuarios
    Route::get('users/{id}/suscripciones', [UserController::class, 'suscripciones'])->name('users.suscripciones');
});

// ----------------------
// RUTAS ENTRENADOR (gestionar sus propias clases y usuarios)
// ----------------------
Route::middleware([
    'auth',
    'verified',
    'can:entrenador-access',
])->prefix('entrenador')->name('entrenador.')->group(function () {
    // Dashboard del entrenador
    Route::get('/dashboard', [EntrenadorController::class, 'index'])->name('dashboard');

    // Clases del entrenador
    Route::get('clases', [EntrenadorController::class, 'index'])->name('clases.index');
    Route::get('clases/{id}/edit', [EntrenadorController::class, 'editClase'])->name('clases.edit');
    Route::put('clases/{id}', [EntrenadorController::class, 'updateClase'])->name('clases.update');

    // Gestión de alumnos en sus clases (aceptar o rechazar solicitudes)
    Route::post('clases/{claseId}/aceptar/{userId}', [EntrenadorController::class, 'aceptarSolicitud'])->name('clases.aceptar');
    Route::post('clases/{claseId}/rechazar/{userId}', [EntrenadorController::class, 'rechazarSolicitud'])->name('clases.rechazar');
});


// ----------------------
// RUTAS CLIENTE (ver clases y unirse)
// ----------------------
Route::prefix('cliente')->name('cliente.')->group(function () {
    Route::get('clases', [ClaseGrupalController::class, 'index'])->name('clases.index');
    Route::post('clases/{id}/unirse', [ClaseGrupalController::class, 'unirse'])->name('clases.unirse');
});
