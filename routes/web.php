<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Ruta para el Dashboard (ya autenticadas y con verificación de email)
Route::middleware(['auth', 'verified'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Ruta para crear el perfil (Formulario de creación)
Route::middleware('auth')->get('/perfil/create', [ProfileController::class, 'create'])->name('perfil.create');

// Ruta para guardar el perfil (Acción de almacenar en base de datos)
Route::middleware('auth')->post('/perfil', [ProfileController::class, 'store'])->name('perfil.store');

// Ruta para mostrar el perfil (Para ver el perfil ya creado)
Route::middleware('auth')->get('/perfil', [ProfileController::class, 'show'])->name('perfil.show');
