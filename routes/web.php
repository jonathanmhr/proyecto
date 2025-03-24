<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas para el Dashboard (ya autenticadas)
Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
