<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBandaRequest;
use App\Services\BandaService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class BandaController extends Controller
{
    protected BandaService $bandaService;

    public function __construct(BandaService $bandaServiceService)
    {
        $this->bandaService = $bandaServiceService;
    }

    public function index(): JsonResponse
    {
        return $this->bandaService->index();
    }

    public function store(StoreBandaRequest $request): JsonResponse
    {
        return $this->bandaService->store($request->validated());
    }

    public function show(int $id): JsonResponse
    {
        return $this->bandaService->show($id);
    }

    public function update(StoreBandaRequest $request, $id): JsonResponse
    {
        return $this->bandaService->update($request->validated(), $id);
    }

    public function destroy($id): JsonResponse
    {
        return $this->bandaService->destroy($id);
    }
}
