<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Ruta para el Dashboard (con autenticación y verificación de correo)
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Añadir aquí las rutas para el perfil
Route::middleware(['auth', 'verified'])->get('/perfil/create', [ProfileController::class, 'create'])->name('perfil.create');
Route::middleware(['auth', 'verified'])->post('/perfil/store', [ProfileController::class, 'store'])->name('perfil.store');