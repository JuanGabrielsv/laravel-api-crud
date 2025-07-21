<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConciertoRequest;
use App\Http\Requests\UpdateConciertoRequest;
use App\Services\ConciertoService;
use Illuminate\Http\JsonResponse;

class ConciertoController extends Controller
{
    protected ConciertoService $conciertoService;

    public function __construct(ConciertoService $conciertoService)
    {
        $this->conciertoService = $conciertoService;
    }

    public function index(): JsonResponse
    {
        return $this->conciertoService->index();
    }

    public function store(StoreConciertoRequest $request): JsonResponse
    {
        return $this->conciertoService->store($request->validated());
    }

    public function show(int $id): JsonResponse
    {
        return $this->conciertoService->show($id);
    }

    public function update(UpdateConciertoRequest $request, int $id): JsonResponse
    {
        return $this->conciertoService->update($request->validated(),$id);
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->conciertoService->destroy($id);
    }
}
