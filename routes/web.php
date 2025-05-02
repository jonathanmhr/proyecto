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
    
    // Rutas para la gestión de clases
    Route::get('clases', [AdminEntrenadorController::class, 'verClases'])->name('clases.index');
    Route::get('clases/create', [AdminEntrenadorController::class, 'create'])->name('clases.create');
    Route::post('clases', [AdminEntrenadorController::class, 'store'])->name('clases.store');
    Route::get('clases/{clase}/edit', [AdminEntrenadorController::class, 'edit'])->name('clases.edit');
    Route::put('clases/{clase}', [AdminEntrenadorController::class, 'update'])->name('clases.update');
    Route::delete('clases/{clase}', [AdminEntrenadorController::class, 'destroy'])->name('clases.destroy');

    // Aprobar cambios pendientes en clase
    Route::put('/admin/clase/{id}/aprobar', [AdminEntrenadorController::class, 'aprobarCambios'])->name('admin.clase.aprobar');
    
    // Gestión de entrenadores
    Route::get('entrenadores', [AdminEntrenadorController::class, 'verEntrenadores'])->name('entrenadores');
    Route::get('entrenadores/{entrenador}/edit', [AdminEntrenadorController::class, 'editarEntrenador'])->name('entrenadores.edit');
    Route::get('entrenadores/create', [AdminEntrenadorController::class, 'crearEntrenador'])->name('entrenadores.create');
    Route::put('entrenadores/{entrenador}', [AdminEntrenadorController::class, 'actualizarEntrenador'])->name('entrenadores.update');
    Route::post('entrenadores', [AdminEntrenadorController::class, 'storeEntrenador'])->name('entrenadores.store');
    Route::post('entrenadores/{entrenador}/dar-baja', [AdminEntrenadorController::class, 'darBajaEntrenador'])->name('entrenadores.darBaja');

    // Gestión de alumnos
    Route::get('alumnos', [AdminEntrenadorController::class, 'verAlumnos'])->name('alumnos');
    Route::get('alumnos/{user}/editar', [AdminEntrenadorController::class, 'editarAlumno'])->name('alumnos.editar');
    Route::put('alumnos/{user}', [AdminEntrenadorController::class, 'actualizarAlumno'])->name('alumnos.actualizar');
    Route::post('alumnos/{user}/eliminar', [AdminEntrenadorController::class, 'eliminarAlumno'])->name('alumnos.eliminar');
    Route::post('clases/{clase}/aceptar/{user}', [AdminEntrenadorController::class, 'aceptarSolicitud'])->name('clases.aceptar');
    Route::post('clases/{clase}/rechazar/{user}', [AdminEntrenadorController::class, 'rechazarSolicitud'])->name('clases.rechazar');
    
    // Gestión de suscripciones
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

    // Clases
    Route::get('clases', [EntrenadorController::class, 'index'])->name('clases.index');
    Route::get('clase/{id}/edit', [EntrenadorController::class, 'editClase'])->name('clase.edit');
    Route::put('clase/{id}', [EntrenadorController::class, 'updateClase'])->name('entrenador.clase.update');

    // Gestión de alumnos en clases
    Route::post('clases/{clase}/{usuario}/aceptar', [ClaseGrupalController::class, 'aceptarSolicitud'])->name('entrenador.suscripcion.aceptar');
    Route::post('clases/{clase}/{usuario}/rechazar', [ClaseGrupalController::class, 'rechazarSolicitud'])->name('entrenador.suscripcion.rechazar');

});

// ----------------------
// RUTAS CLIENTE (ver clases y unirse)
// ----------------------
Route::get('clases', [ClaseGrupalController::class, 'index'])->name('clases.index');
Route::post('clases/{clase}/unirse', [ClaseGrupalController::class, 'unirse'])->name('clases.unirse');
