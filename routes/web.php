<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Ruta para el Dashboard
Route::middleware(['auth', 'verified'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Añadir rutas para el perfil (opcional)
Route::middleware(['auth', 'verified'])->get('/perfil', [ProfileController::class, 'show'])->name('perfil.show');
Route::middleware(['auth', 'verified'])->get('/perfil/create', [ProfileController::class, 'create'])->name('perfil.create');
Route::middleware(['auth', 'verified'])->post('/perfil/store', [ProfileController::class, 'store'])->name('perfil.store');