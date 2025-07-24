<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBandaRequest;
use App\Http\Requests\UpdateBandaRequest;
use App\Http\Resources\BandaResource;
use App\Models\Banda;

// <-- ¡Importante!
use App\Services\BandaService;
use Illuminate\Http\JsonResponse;

class BandaController extends Controller
{
    // Corregí el nombre de la variable para que sea más limpio.
    public function __construct(protected BandaService $bandaService)
    {
    }

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Banda::class);

        $bandas = $this->bandaService->getBandasForUser(auth()->user());

        return BandaResource::collection($bandas)->response();
    }

    public function store(StoreBandaRequest $request): JsonResponse
    {
        $this->authorize('create', Banda::class);

        $banda = $this->bandaService->createForUser(auth()->user(), $request->validated());

        return (new BandaResource($banda))->response()->setStatusCode(201);
    }

    public function show(Banda $banda): JsonResponse
    {
        $this->authorize('view', $banda);

        return (new BandaResource($banda))->response();
    }

    public function update(UpdateBandaRequest $request, Banda $banda): JsonResponse
    {

        $this->authorize('update', $banda);

        $bandaActualizada = $this->bandaService->update($banda, $request->validated());

        return (new BandaResource($bandaActualizada))->response();
    }

    public function destroy(Banda $banda): JsonResponse
    {
        $this->authorize('delete', $banda);

        $this->bandaService->delete($banda);

        return response()->json(null, 204);
    }
}
