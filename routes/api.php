<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BandaController;
use App\Http\Controllers\ConciertoController;
use App\Http\Controllers\GeneroMusicalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS DE AUTENTICACIÓN
| Las únicas rutas accesibles sin un token.
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS
| TODAS las demás rutas requieren un token de autenticación válido.
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // --- Rutas de Usuario y Sesión ---
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Sesión cerrada correctamente']);
    });

    // --- Rutas de Conciertos (solo los del usuario) ---
    Route::get('/conciertos', [ConciertoController::class, 'index']);
    Route::post('/conciertos', [ConciertoController::class, 'store']);
    Route::get('/conciertos/{id}', [ConciertoController::class, 'show']);
    Route::put('/conciertos/{id}', [ConciertoController::class, 'update']);
    Route::delete('/conciertos/{id}', [ConciertoController::class, 'destroy']);

    // --- Rutas de Bandas (solo las del usuario) ---
    Route::get('/bandas', [BandaController::class, 'index']);
    Route::post('/bandas', [BandaController::class, 'store']);
    Route::get('/bandas/{banda}', [BandaController::class, 'show']);
    Route::put('/bandas/{banda}', [BandaController::class, 'update']);
    Route::delete('/bandas/{id}', [BandaController::class, 'destroy']);

    // --- Rutas de Géneros Musicales ---
    // Cualquier usuario logueado puede VER los géneros.
    Route::get('/generos-musicales', [GeneroMusicalController::class, 'index']);
    Route::get('/generos-musicales/{id}', [GeneroMusicalController::class, 'show']);

    // Las rutas para MODIFICAR géneros están en un sub-grupo de admin.
    Route::middleware('is.admin')->group(function () {
        Route::post('/generos-musicales', [GeneroMusicalController::class, 'store']);
        Route::put('/generos-musicales/{id}', [GeneroMusicalController::class, 'update']);
        Route::delete('/generos-musicales/{id}', [GeneroMusicalController::class, 'destroy']);
    });
});
