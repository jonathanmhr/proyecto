<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas para el Dashboard (ya autenticadas)
Route::middleware(['auth', 'verified'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Rutas para el admin
Route::middleware(['auth', 'role:admin'])->group(function() {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/admin/assign-role/{userId}', [AdminController::class, 'assignRole'])->name('admin.assignRole');
});

// Rutas para el trainer
Route::middleware(['auth', 'role:trainer'])->group(function() {
    Route::get('/trainer', [TrainerController::class, 'index']);
});

// Rutas para el client
Route::middleware(['auth', 'role:client'])->group(function() {
    Route::get('/client', [ClientController::class, 'index']);
});
