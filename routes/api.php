<?php

use App\Http\Controllers\BandaController;
use App\Http\Controllers\ConciertoController;
use App\Http\Controllers\GeneroMusicalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/conciertos', [ConciertoController::class, 'index']);
Route::post('/conciertos', [ConciertoController::class, 'store']);
Route::get('/conciertos/{id}', [ConciertoController::class, 'show']);
Route::put('/conciertos/{id}', [ConciertoController::class, 'update']);
Route::patch('/conciertos/{id}', [ConciertoController::class, 'update']);
Route::delete('/conciertos/{id}', [ConciertoController::class, 'destroy']);

// Usando group, definimos primero la raiz de la ruta
Route::group(['prefix' => 'bandas'], function () {
    Route::get('/', [BandaController::class, 'index']);
    Route::post('/', [BandaController::class, 'store']);
    Route::get('/{id}', [BandaController::class, 'show']);
    Route::put('/{id}', [BandaController::class, 'update']);
    Route::patch('/{id}', [BandaController::class, 'update']);
    Route::delete('/{id}', [BandaController::class, 'destroy']);
});

Route::group(['prefix' => 'generos-musicales'], function () {
    Route::get('/', [GeneroMusicalController::class, 'index']);
    Route::post('/', [GeneroMusicalController::class, 'store']);
    Route::get('/{id}', [GeneroMusicalController::class, 'show']);
    Route::put('/{id}', [GeneroMusicalController::class, 'update']);
    Route::patch('/{id}', [GeneroMusicalController::class, 'update']);
    Route::delete('/{id}', [GeneroMusicalController::class, 'destroy']);
});
