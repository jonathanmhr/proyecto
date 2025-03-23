<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\ClientController;

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

// Solo usuarios con el rol 'admin' pueden acceder
Route::middleware(['role:admin'])->get('/dashboard', [AdminController::class, 'index']);

// Solo usuarios con el rol 'trainer' pueden acceder
Route::middleware(['role:trainer'])->get('/trainer-dashboard', [TrainerController::class, 'index']);

// Solo usuarios con el rol 'client' pueden acceder
Route::middleware(['role:client'])->get('/client-dashboard', [ClientController::class, 'index']);
