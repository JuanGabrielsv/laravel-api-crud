<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/conciertos', function () {
    return 'Obteniendo conciertos';
});

Route::get('/conciertos/{id}', function () {
    return 'Obteniendo un concierto';
});

Route::post('/conciertos', function () {
    return 'Creando concierto';
});

Route::put('/conciertos/{id}', function () {
    return 'Editando concierto';
});

Route::delete('/conciertos/{id}', function () {
    return 'Eliminando concierto';
});
