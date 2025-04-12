<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Ruta para el Dashboard
Route::middleware(['auth', 'verified'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Mostrar el perfil (ver detalles)
Route::middleware(['auth', 'verified'])->get('/perfil', [ProfileController::class, 'show'])->name('perfil.show');

// Mostrar el formulario para crear o editar el perfil
Route::middleware(['auth', 'verified'])->get('/perfil/edit', [ProfileController::class, 'edit'])->name('perfil.edit');

// Guardar o actualizar el perfil
Route::middleware(['auth', 'verified'])->post('/perfil/save', [ProfileController::class, 'save'])->name('perfil.save');