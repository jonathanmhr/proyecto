<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

// Verificacion de correo
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

//Permisos de roles

Route::middleware(['auth', 'verified'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


Route::middleware(['role:admin'])->group(function() {
    Route::get('/admin', [AdminController::class, 'index']);
});

Route::middleware(['role:trainer'])->group(function() {
    Route::get('/trainer', [TrainerController::class, 'index']);
});

Route::middleware(['role:client'])->group(function() {
    Route::get('/client', [ClientController::class, 'index']);
});