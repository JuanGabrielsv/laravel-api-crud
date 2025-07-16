<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConciertoController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/conciertos', [ConciertoController::class, 'index']);

Route::get('/conciertos/{id}', [ConciertoController::class, 'show']);

Route::post('/conciertos', [ConciertoController::class, 'store']);

Route::put('/conciertos/{id}',[ConciertoController::class, 'update']);

Route::patch('/conciertos/{id}',[ConciertoController::class, 'updatePartial']);

Route::delete('/conciertos/{id}', [ConciertoController::class, 'destroy']);
