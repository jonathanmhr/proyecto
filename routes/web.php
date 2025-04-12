<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Ruta para el Dashboard
Route::middleware(['auth', 'verified'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Ruta para la creación del perfil (solo si el perfil no existe)
Route::middleware(['auth', 'verified'])->get('/perfil/create', [ProfileController::class, 'create'])->name('perfil.create');
Route::middleware(['auth', 'verified'])->post('/perfil/store', [ProfileController::class, 'store'])->name('perfil.store');

// Ruta para la edición del perfil (mostrar el formulario de edición)
Route::middleware(['auth', 'verified'])->get('/perfil/edit', [ProfileController::class, 'edit'])->name('perfil.edit');

// Ruta para actualizar el perfil (guardar los cambios)
Route::middleware(['auth', 'verified'])->put('/perfil/update', [ProfileController::class, 'update'])->name('perfil.update');