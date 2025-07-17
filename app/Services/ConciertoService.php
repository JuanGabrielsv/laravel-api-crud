<?php

namespace App\Services;

use App\Models\Concierto;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ConciertoService
{
    public function index(): JsonResponse
    {
        try {
            $conciertos = Concierto::all();
            if ($conciertos->isEmpty()) {
                return response()->json([
                    "mensaje" => "No hay ningún conciertos registrados",
                ]);
            }
            return response()->json(Concierto::all());
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                "mensaje" => "Ha ocurrido un error",
                'error' => '¿No existe la columna en la bd o la misma bd tal vez?'
            ], 500);

        }

    }

    /**
     * Create a new class instance.
     * @throws Exception
     */
    public function create(array $data): JsonResponse
    {
        try {
            $concierto = Concierto::create($data);
            return response()->json([
                'mensaje' => 'Concierto creado correctamente',
                'concierto' => $concierto], 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'mensaje' => 'Error al crear concierto',
                'error' => '¿No existe la columna en la bd o la misma bd tal vez?'
                //'error' => $e->getMessage()
            ], 500);
        }
    }

}
