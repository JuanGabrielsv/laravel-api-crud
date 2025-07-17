<?php

namespace App\Services;

use App\Models\Concierto;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class ConciertoService
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $conciertos = Concierto::all();
            if ($conciertos->isEmpty()) {
                return response()->json([
                    "mensaje" => "No hay ningún conciertos registrados",
                ]);
            }
            return response()->json($conciertos);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                "mensaje" => "Ha ocurrido un error",
                'error' => '¿No existe la columna en la bd o la misma bd tal vez?'
            ], 500);

        }

    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $concierto = Concierto::find($id);
            if (!$concierto) {
                return response()->json([
                    'mensaje' => 'No hay concierto con el id ' . $id
                ]);
            }
            return response()->json($concierto);
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return response()->json([
                'mensaje' => 'Ha ocurrido un error con la base de datos, inténtelo nuevamente mas tarde.'
            ], 500);
        }
    }

    /**
     * @param array $data
     * @return JsonResponse
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

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            $conciertoBorrar = Concierto::find($id);
            if (!$conciertoBorrar) {
                return response()->json([
                    'mensaje' => 'No hay concierto con el id ' . $id
                ]);
            }
            Concierto::destroy($id);
            return response()->json(['mensaje' => 'Concierto eliminado correctamente']);
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return response()->json([
                'mensaje' => 'Ha ocurrido un error con la base de datos, inténtelo más tarde.'
            ]);
        }
    }

    public function update($id, $data): JsonResponse
    {
        try {
            $concierto = Concierto::find($id);

            if (!$concierto) {
                return response()->json([
                    'mensaje' => "No se encontró el concierto con ID {$id}"
                ], 404);
            }

            $concierto->update($data);

            return response()->json([
                'mensaje' => 'Concierto actualizado correctamente',
                'concierto' => $concierto
            ]);
        } catch (QueryException $e) {
            Log::error($e->getMessage());

            return response()->json([
                'mensaje' => 'Ha ocurrido un error con la base de datos, inténtelo más tarde.'
            ], 500);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'mensaje' => 'Error inesperado al actualizar el concierto.'
            ], 500);
        }
    }

}
