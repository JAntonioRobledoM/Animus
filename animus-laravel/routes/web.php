<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RecuerdosController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rutas de autenticación
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Ruta para crear usuario (solo desarrollo - deberías eliminarla en producción)
Route::get('/create-user', [AuthController::class, 'createUser']);

// Rutas protegidas que requieren autenticación
Route::middleware(['auth'])->group(function () {
    // Dashboard principal
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Rutas para gestión de recuerdos
    Route::resource('recuerdos', RecuerdosController::class);
    
    // Ruta para visualizar un recuerdo específico (simulación del Animus)
    Route::get('/recuerdo/{slug}', [RecuerdosController::class, 'visualizar'])->name('recuerdos.visualizar');
});