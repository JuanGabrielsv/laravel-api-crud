<?php

namespace App\Services;

use App\Models\Banda;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class BandaService
{

    public function index(): JsonResponse
    {
        $bandas = Banda::paginate(10);
        if ($bandas->isEmpty()) {
            return response()->json([
                'mensaje' => 'No hay bandas'
            ]);
        }
        return response()->json($bandas);
    }

    public function store(array $data): Banda
    {
        return Banda::create($data);
    }

    public function show($id): JsonResponse
    {
        try {
            $banda = Banda::find($id);
            if ($banda == null) {
                return response()->json([
                    'mensaje' => 'No hay ninguna banda con id ' . $id,
                ], 404);
            }
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
            Log::error('Error al buscar banda por id (show)', [$e->getMessage()]);
            return response()->json([
                'mensaje' => 'Ha ocurrido un error con la base de datos',
                'error' => '¿Existe la tabla?, ¿Existe la columna?, ¿Existe la base de datos?',
                'code' => $e->getCode(),
                'line' => $e->getLine(),
            ]);
        }
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

    public function updatePartial(array $data, $id): JsonResponse
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
            Log::error('Error al actualizar banda parcialmente (updatePartial)', [$e->getMessage()]);
            return response()->json([
                'mensaje' => 'Ha ocurrido un error con la base de datos',
                'error' => '¿Existe la tabla?, ¿Existe la columna?, ¿Existe la base de datos?',
                'code' => $e->getCode(),
                'line' => $e->getLine(),
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $banda = Banda::find($id);
            if ($banda == null) {
                return response()->json([
                    'mensaje' => 'No hay ninguna banda con id ' . $id,
                ], 404);
            }
            $banda->destroy($id);
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
