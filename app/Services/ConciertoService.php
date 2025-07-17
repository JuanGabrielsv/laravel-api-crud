<?php

namespace App\Services;

use App\Models\Concierto;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ConciertoService
{
    /**
     * Create a new class instance.
     * @throws Exception
     */
    public function create(array $data): JsonResponse
    {
        try {
            $concierto = Concierto::create($data);
            return response()->json([
                'Mensaje' => 'Concierto creado correctamente',
                'Concierto' => $concierto], 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'message' => 'Error al crear concierto',
                'error' => '¿No existe la columna en la bd o la misma bd tal vez?'
                //'error' => $e->getMessage()
            ], 500);
        }
    }
}
