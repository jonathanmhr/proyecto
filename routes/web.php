<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Entrenador\EntrenadorController;
use App\Http\Controllers\Perfil\PerfilController;
use App\Http\Controllers\ClaseGrupal\ClaseGrupalController;
use App\Http\Controllers\AdminEntrenador\AdminEntrenadorController;
use App\Http\Controllers\AdminEntrenador\AdminEntrenadorClaseController;
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
    Route::get('/', [AdminEntrenadorController::class, 'index'])->name('admin-entrenador.index');
    // Gestión de usuarios
    Route::get('entrenadores', [AdminEntrenadorController::class, 'verEntrenadores'])->name('admin-entrenador.entrenadores');
    Route::post('entrenadores/{user}/eliminar', [AdminEntrenadorController::class, 'eliminarEntrenador'])->name('admin-entrenador.entrenadores.eliminar');

    Route::get('alumnos', [AdminEntrenadorController::class, 'verAlumnos'])->name('admin-entrenador.alumnos');
    Route::get('alumnos/{user}/editar', [AdminEntrenadorController::class, 'editarAlumno'])->name('admin-entrenador.alumnos.editar');
    Route::put('alumnos/{user}', [AdminEntrenadorController::class, 'actualizarAlumno'])->name('admin-entrenador.alumnos.actualizar');
    Route::post('alumnos/{user}/eliminar', [AdminEntrenadorController::class, 'eliminarAlumno'])->name('admin-entrenador.alumnos.eliminar');
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
    Route::resource('clases', ClaseGrupalController::class)->except(['show']);

    // Gestión de alumnos en clases
    Route::post('clases/{clase}/agregar-usuario', [ClaseGrupalController::class, 'agregarUsuario'])->name('clases.agregarUsuario');
    Route::post('clases/{clase}/{user}/eliminar-usuario', [ClaseGrupalController::class, 'eliminarUsuario'])->name('clases.eliminarUsuario');

    // Usuarios
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::put('/usuarios/{user}', [UserController::class, 'update'])->name('usuarios.update');

    // Notificaciones
    //Route::resource('notificaciones', NotificacionesController::class)->only(['index', 'store']);

    // Estadísticas
    //Route::get('/estadisticas', [EstadisticasController::class, 'index'])->name('estadisticas.index');

    // Suscripciones
    //Route::get('/suscripciones', [SuscripcionesController::class, 'index'])->name('suscripciones.index');

    // Reportes
    //Route::get('/reportes', [ReportesController::class, 'index'])->name('reportes.index');
});

// ----------------------
// RUTAS CLIENTE (ver clases y unirse)
// ----------------------
// Rutas para las clases grupales
Route::get('clases', [ClaseGrupalController::class, 'index'])->name('clases.index');
Route::post('clases', [ClaseGrupalController::class, 'store'])->name('clases.store');
Route::post('clases/{clase}/unirse', [ClaseGrupalController::class, 'unirse'])->name('clases.unirse');
