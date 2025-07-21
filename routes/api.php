<?php

use App\Http\Controllers\BandaController;
use App\Http\Controllers\ConciertoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/conciertos', [ConciertoController::class, 'index']);
Route::get('/conciertos/{id}', [ConciertoController::class, 'show']);
Route::post('/conciertos', [ConciertoController::class, 'store']);
Route::put('/conciertos/{id}', [ConciertoController::class, 'update']);
Route::patch('/conciertos/{id}', [ConciertoController::class, 'updatePartial']);
Route::delete('/conciertos/{id}', [ConciertoController::class, 'destroy']);

Route::group(['prefix' => 'bandas'], function () {
    Route::get('/', [BandaController::class, 'index']);
    Route::post('/', [BandaController::class, 'store']);
    Route::get('/{id}', [BandaController::class, 'show']);
    Route::put('/{id}', [BandaController::class, 'update']);
    Route::patch('/{id}', [BandaController::class, 'updatePartial']);
    Route::delete('/{id}', [BandaController::class, 'destroy']);
});
