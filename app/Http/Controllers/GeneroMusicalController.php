<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGeneroMusicalRequest;
use App\Http\Requests\UpdateGeneroMusicalRequest;
use App\Services\GeneroMusicalService;
use Illuminate\Http\JsonResponse;

class GeneroMusicalController extends Controller
{
    protected GeneroMusicalService $generoMusicalService;

    public function __construct(GeneroMusicalService $generoMusicalService)
    {
        $this->generoMusicalService = $generoMusicalService;
    }

    public function index(): JsonResponse
    {
        return $this->generoMusicalService->index();
    }

    public function store(StoreGeneroMusicalRequest $request): JsonResponse
    {
        return $this->generoMusicalService->store($request->validated());
    }

    public function show(int $id): JsonResponse
    {
        return $this->generoMusicalService->show($id);
    }

    public function update(UpdateGeneroMusicalRequest $request, int $id): JsonResponse
    {
        return $this->generoMusicalService->update($request->validated(), $id);
    }

    public function destroy(int $id): JsonResponse
    {
        return $this->generoMusicalService->destroy($id);
    }
}
