<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// Controladores
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Entrenador\EntrenadorController;
use App\Http\Controllers\Perfil\PerfilController;
use App\Http\Controllers\ClaseGrupal\ClaseGrupalController;
use App\Http\Controllers\AdminEntrenador\AdminEntrenadorController;

// ----------------------
// RUTA DE BIENVENIDA
// ----------------------
Route::get('/', fn() => view('welcome'));

// ----------------------
// RUTAS DEL DASHBOARD
// ----------------------
Route::middleware([
    'auth',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', [PerfilController::class, 'index'])->name('dashboard');
});

// ----------------------
// RUTAS DE VERIFICACIÓN DE CORREO ELECTRÓNICO
// ----------------------
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', fn() => view('auth.verify-email'))->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/dashboard');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Correo de verificación reenviado.');
    })->middleware('throttle:6,1')->name('verification.send');
});

// ----------------------
// RUTAS ADMINISTRATIVAS
// ----------------------
Route::middleware(['auth', 'verified', 'can:admin-access'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::resource('users', UserController::class)->except(['create', 'show']);
        Route::post('users/{id}/assign-role', [UserController::class, 'assignRole'])->name('users.assignRole');
    });

// ----------------------
// RUTAS ADMIN ENTRENADOR
// ----------------------
Route::middleware(['auth', 'verified', 'can:admin_entrenador'])
    ->prefix('admin-entrenador')
    ->name('admin-entrenador.')
    ->group(function () {
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
        Route::get('entrenadores/create', [AdminEntrenadorController::class, 'create'])->name('entrenadores.create');
        Route::post('entrenadores', [AdminEntrenadorController::class, 'store'])->name('entrenadores.store');
        Route::get('entrenadores/{entrenador}/edit', [AdminEntrenadorController::class, 'editarEntrenador'])->name('entrenadores.edit');
        Route::put('entrenadores/{entrenador}', [AdminEntrenadorController::class, 'actualizarEntrenador'])->name('entrenadores.update');
        Route::delete('entrenadores/{entrenador}', [AdminEntrenadorController::class, 'destroy'])->name('entrenadores.destroy');
        Route::post('entrenadores/{user}/dar-baja', [AdminEntrenadorController::class, 'darBajaEntrenador'])->name('entrenadores.darBaja');

        // Gestión de alumnos
        Route::get('alumnos', [AdminEntrenadorController::class, 'verAlumnos'])->name('alumnos.index');
        Route::get('alumnos/{user}/edit', [AdminEntrenadorController::class, 'editarAlumno'])->name('alumnos.edit');
        Route::put('alumnos/{user}', [AdminEntrenadorController::class, 'actualizarAlumno'])->name('alumnos.update');
        Route::post('alumnos/{user}/quitar-de-clase/{claseId}', [AdminEntrenadorController::class, 'quitarDeClase'])->name('alumnos.quitarDeClase');

        // Solicitudes de clases
        Route::get('solicitudes', [AdminEntrenadorController::class, 'verSolicitudesClases'])->name('solicitudes.index');
        Route::post('solicitudes/{claseId}/aceptar/{usuarioId}', [AdminEntrenadorController::class, 'aceptarSolicitud'])->name('solicitudes.aceptar');
        Route::post('solicitudes/{claseId}/rechazar/{usuarioId}', [AdminEntrenadorController::class, 'rechazarSolicitud'])->name('solicitudes.rechazar');

        // Suscripciones de usuarios
        Route::get('users/{id}/suscripciones', [UserController::class, 'suscripciones'])->name('users.suscripciones');
    });

// ----------------------
// RUTAS DEL ENTRENADOR
// ----------------------
Route::middleware(['auth', 'verified', 'can:entrenador-access'])
    ->prefix('entrenador')
    ->name('entrenador.')
    ->group(function () {
        Route::get('/dashboard', [EntrenadorController::class, 'index'])->name('dashboard');

        // Gestión de clases
        Route::get('clases', [EntrenadorController::class, 'misClases'])->name('clases.index');
        Route::get('clases/{clase}/alumnos', [EntrenadorController::class, 'verAlumnos'])->name('clases.alumnos');
        Route::get('clases/{clase}/edit', [EntrenadorController::class, 'edit'])->name('clases.edit');
        Route::put('clases/{clase}', [EntrenadorController::class, 'updateClase'])->name('clases.update');
        Route::delete('clases/{clase}/quitar/{userId}', [EntrenadorController::class, 'quitarUsuario'])->name('clases.quitarUsuario');

        Route::get('solicitudes', [EntrenadorController::class, 'verSolicitudes'])->name('solicitudes.index');
        Route::post('solicitudes/aceptar/{id}', [EntrenadorController::class, 'aceptarSolicitud'])->name('solicitudes.aceptar');
        Route::post('solicitudes/rechazar/{id}', [EntrenadorController::class, 'rechazarSolicitud'])->name('solicitudes.rechazar');
    });

// ----------------------
// RUTAS DEL CLIENTE
// ----------------------
Route::middleware('auth')
    ->prefix('cliente')
    ->name('cliente.')
    ->group(function () {
        Route::get('clases', [ClaseGrupalController::class, 'index'])->name('clases.index');
        Route::post('clases/{clase}/unirse', [ClaseGrupalController::class, 'unirse'])->name('clases.unirse');
    });

Route::middleware('auth')
    ->prefix('perfil')
    ->name('perfil.')
    ->group(function () {
        // Ruta para completar el perfil
        Route::get('completar', [PerfilController::class, 'completar'])->name('completar');
        Route::post('completar', [PerfilController::class, 'guardarPerfil'])->name('guardar');
        Route::get('editar', [PerfilController::class, 'editar'])->name('editar');
        Route::put('actualizar', [PerfilController::class, 'actualizar'])->name('actualizar');
    });
