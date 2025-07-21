<?php

namespace App\Services;

use App\Http\Resources\BandaResource;
use App\Models\Banda;
use App\Models\Concierto;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class BandaService
{

    public function index(): JsonResponse
    {
        return BandaResource::collection(Banda::paginate(request('per_page', 6)))->response();
    }

    public function store(array $data): JsonResponse
    {
        return BandaResource::make(Banda::create($data))->response();//
    }

    public function show(int $id): JsonResponse
    {
        return BandaResource::make(Banda::findOrFail($id))->response();
    }

    public function update($id, array $data): JsonResponse
    {
        try {
            $banda = Banda::find($id);
            if ($banda == null) {
                return response()->json([
                    'mensaje' => 'No hay ninguna banda con id ' . $id,
                ], 404);
            }
            $banda->update($data);
            return response()->json($banda);

        } catch (QueryException $e) {
            if ($e->getCode() == 2002) {
                Log::error('Error de conexión con la base de datos', ['error' => $e->getMessage()]);
                return response()->json([
                    'mensaje' => 'No hay conexión con la base de datos',
                    'error_code' => $e->getCode(),
                    'error_detail' => 'No se puede establecer una conexión ya que el equipo de destino denegó expresamente dicha conexión',
                ], 503);
            }
            Log::error('Error al actualizar banda (update)', [$e->getMessage()]);
            return response()->json([
                'mensaje' => 'Ha ocurrido un error con la base de datos',
                'error' => '¿Existe la tabla?, ¿Existe la columna?, ¿Existe la base de datos?',
                'code' => $e->getCode(),
                'line' => $e->getLine(),
            ]);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $banda = Banda::find($id);
            if ($banda == null) {
                return response()->json([
                    'mensaje' => 'No hay ninguna banda con id ' . $id,
                ], 404);
            }
            $banda->delete($id);
            return response()->json([], 204);

        } catch (QueryException $e) {
            if ($e->getCode() == 2002) {
                Log::error('Error de conexión con la base de datos', ['error' => $e->getMessage()]);
                return response()->json([
                    'mensaje' => 'No hay conexión con la base de datos',
                    'error_code' => $e->getCode(),
                    'error_detail' => 'No se puede establecer una conexión ya que el equipo de destino denegó expresamente dicha conexión',
                ], 503);
            }
            Log::error('Error al borrar banda (destroy)', [$e->getMessage()]);
            return response()->json([
                'mensaje' => 'Ha ocurrido un error con la base de datos',
                'error' => '¿Existe la tabla?, ¿Existe la columna?, ¿Existe la base de datos?',
                'code' => $e->getCode(),
                'line' => $e->getLine(),
            ]);
        }
    }
}
