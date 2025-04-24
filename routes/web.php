<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Entrenador\EntrenadorController;
use App\Http\Controllers\Perfil\PerfilController;
use App\Http\Controllers\ClaseGrupal\ClaseGrupalController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas del dashboard, donde todos los usuarios verificados pueden acceder
Route::middleware([
    'auth', 
    config('jetstream.auth_session'),
    'verified',  // Asegura que el usuario haya verificado su correo
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Rutas del panel de administración
Route::middleware([
    'auth',
    config('jetstream.auth_session'),
    'verified',
    'can:admin-access', // Admin tiene acceso a todos los paneles
])->prefix('admin')->group(function () {
    Route::get('users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::post('users/{id}/assign-role', [UserController::class, 'assignRole'])->name('admin.users.assignRole');
    
    // Ruta para eliminar un usuario
    Route::delete('users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});


// Rutas para los paneles del entrenador
Route::middleware([
    'auth', 
    'verified', 
    'can:entrenador-access',  // El entrenador tiene acceso a su propio panel
])->prefix('entrenador')->group(function () {
    Route::get('/dashboard', [EntrenadorController::class, 'index'])->name('entrenador.dashboard');
});

// Ruta para el dashboard del perfil
Route::middleware(['auth'])->get('/dashboard', [PerfilController::class, 'index'])->name('dashboard');

//  Ruta para clase grupales
Route::get('clases', [ClaseGrupalController::class, 'index'])->name('clases.index');
Route::get('clases/create', [ClaseGrupalController::class, 'create'])->name('clases.create');
Route::post('clases', [ClaseGrupalController::class, 'store'])->name('clases.store');
Route::post('clases/{clase}/unirse', [ClaseGrupalController::class, 'unirse'])->name('clases.unirse');