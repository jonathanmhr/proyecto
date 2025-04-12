<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Ruta para el Dashboard
Route::middleware(['auth', 'verified'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Ruta para ver el perfil (detalles del perfil)
Route::middleware(['auth', 'verified'])->get('/perfil', [ProfileController::class, 'show'])->name('perfil.show');

// Ruta para la edición del perfil (muestra el formulario de edición)
Route::middleware(['auth', 'verified'])->get('/perfil/edit', [ProfileController::class, 'edit'])->name('perfil.edit');

// Ruta para almacenar o actualizar el perfil
Route::middleware(['auth', 'verified'])->post('/perfil/store', [ProfileController::class, 'store'])->name('perfil.store');
Route::middleware(['auth', 'verified'])->put('/perfil/update', [ProfileController::class, 'update'])->name('perfil.update');