<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBandaRequest;
use App\Services\BandaService;
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
        } catch (Exception $e) {
            Log::error('Error al guardar nueva banda (store)', ['error' => $e->getMessage()]);
            return response()->json('moco');
        }
    }


}
