<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RecuerdosController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\SagaController;

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

    // Rutas para gestión de sagas
    Route::resource('sagas', SagaController::class);

    // Rutas para gestión de recuerdos
    Route::resource('recuerdos', RecuerdosController::class);

    // Ruta para visualizar un recuerdo específico (simulación del Animus)
    Route::get('/recuerdo/{slug}', [RecuerdosController::class, 'visualizar'])->name('recuerdos.visualizar');

    // Ruta para lanzar app externa de un recuerdo
    Route::post('/recuerdos/{recuerdo}/lanzar-app', [RecuerdosController::class, 'lanzarAppExterna'])->name('recuerdos.lanzar-app');

    // Ruta para el mapa de recuerdos
    Route::get('/map', [MapController::class, 'index'])->name('map.index');
});