<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BandaController;
use App\Http\Controllers\ConciertoController;
use App\Http\Controllers\GeneroMusicalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
| Accesibles para cualquiera (invitados).
|--------------------------------------------------------------------------
*/

// --- RUTA PÚBLICA DE LOGIN ---
Route::post('/login', [AuthController::class, 'login']);


// --- RUTAS PÚBLICAS DE LECTURA (GET) ---
Route::group(['prefix' => 'conciertos'], function () {
    Route::get('/', [ConciertoController::class, 'index']);
    Route::get('/{id}', [ConciertoController::class, 'show']);
});

Route::group(['prefix' => 'bandas'], function () {
    Route::get('/', [BandaController::class, 'index']);
    Route::get('/{id}', [BandaController::class, 'show']);
});

// ¡IMPORTANTE! Las rutas GET para géneros musicales siguen siendo públicas.
Route::group(['prefix' => 'generos-musicales'], function () {
    Route::get('/', [GeneroMusicalController::class, 'index']);
    Route::get('/{id}', [GeneroMusicalController::class, 'show']);
});


/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS PARA USUARIOS AUTENTICADOS
| Requieren un token válido.
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Sesión cerrada correctamente'], 200);
    });

    // --- Rutas de Conciertos y Bandas para usuarios logueados ---
    Route::post('/conciertos', [ConciertoController::class, 'store']);
    Route::put('/conciertos/{id}', [ConciertoController::class, 'update']);
    Route::delete('/conciertos/{id}', [ConciertoController::class, 'destroy']);

    Route::group(['prefix' => 'bandas'], function () {
        Route::post('/', [BandaController::class, 'store']);
        Route::put('/{id}', [BandaController::class, 'update']);
        Route::delete('/{id}', [BandaController::class, 'destroy']);
    });
});


/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS PARA ADMINISTRADORES
| Requieren un token válido Y el rol de 'admin'.
|--------------------------------------------------------------------------
*/
// ↓↓↓ ¡AQUÍ ESTÁ LA MAGIA! ↓↓↓
// Aplicamos ambos middlewares. Si 'auth:sanctum' falla, 'is.admin' ni se ejecuta.
Route::middleware(['auth:sanctum', 'is.admin'])->group(function () {

    // --- Rutas de Géneros Musicales para administradores ---
    Route::group(['prefix' => 'generos-musicales'], function () {
        Route::post('/', [GeneroMusicalController::class, 'store']);
        Route::put('/{id}', [GeneroMusicalController::class, 'update']);
        Route::delete('/{id}', [GeneroMusicalController::class, 'destroy']);
    });

});
