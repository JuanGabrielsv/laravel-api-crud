<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBandaRequest;
use App\Services\BandaService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class BandaController extends Controller
{

    protected BandaService $bandaService;

    public function __construct(BandaService $bandaServiceService)
    {
        $this->bandaService = $bandaServiceService;
    }

    public function index(): JsonResponse
    {
        try {
            return $this->bandaService->index();
        } catch (Exception $e) {
            Log::error('Error en obtener todas las bandas (index)', ['error' => $e->getMessage()]);
            return response()->json([
                'mensaje' => 'Ha ocurrido un error',
            ], $e->getCode());
        }
    }

    public function store(StoreBandaRequest $request): JsonResponse
    {
        try {
            $banda = $this->bandaService->store($request->validated());
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
            Log::error('Error al guardar nueva banda (store)', [$e->getMessage()]);
            return response()->json([
                'mensaje' => 'Ha ocurrido un error con la base de datos',
                'error' => '¿Existe la tabla?, ¿Existe la columna?, ¿Existe la base de datos?',
                'code' => $e->getCode(),
                'line' => $e->getLine(),
            ]);
        }
    }

    public function show($id): JsonResponse
    {
        return $this->bandaService->show($id);
    }

    public function update(StoreBandaRequest $request, $id): JsonResponse
    {
        return $this->bandaService->update($id, $request->validated());
    }

    public function destroy($id): JsonResponse
    {
        return $this->bandaService->destroy($id);
    }


}
