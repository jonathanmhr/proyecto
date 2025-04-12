<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Ruta para el Dashboard
Route::middleware(['auth', 'verified'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Ruta para el perfil (ver detalles)
Route::middleware(['auth', 'verified'])->get('/perfil', [ProfileController::class, 'show'])->name('perfil.show');

// Ruta para la creación del perfil (esto solo se usa si el perfil no existe)
Route::middleware(['auth', 'verified'])->get('/perfil/create', [ProfileController::class, 'create'])->name('perfil.create');

// Ruta para la edición del perfil
Route::middleware(['auth', 'verified'])->get('/perfil/edit', [ProfileController::class, 'edit'])->name('perfil.edit');

// Ruta para guardar o actualizar el perfil (POST para crear y PUT para actualizar)
Route::middleware(['auth', 'verified'])->post('/perfil/store', [ProfileController::class, 'store'])->name('perfil.store');
Route::middleware(['auth', 'verified'])->put('/perfil/update', [ProfileController::class, 'update'])->name('perfil.update');