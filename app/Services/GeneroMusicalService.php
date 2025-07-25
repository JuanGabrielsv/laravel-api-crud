<?php

namespace App\Services;

use App\Http\Resources\GeneroMusicalResource;
use App\Models\GeneroMusical;
use Illuminate\Http\JsonResponse;

class GeneroMusicalService
{
    public function index(): JsonResponse
    {
        return GeneroMusicalResource::collection(GeneroMusical::paginate(request('per_page', 6)))->response();
    }

    public function store(array $data): JsonResponse
    {
        return GeneroMusicalResource::make(GeneroMusical::create($data))->response();
    }

    public function show(int $id): JsonResponse
    {
        return GeneroMusicalResource::make(GeneroMusical::findOrFail($id))->response();
    }

    public function update(array $data, int $id): JsonResponse
    {
        return GeneroMusicalResource::make(tap(GeneroMusical::findOrFail($id), fn($g) => $g->fill($data)->save()))->response();
    }

    public function destroy(int $id): JsonResponse
    {
        GeneroMusical::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
