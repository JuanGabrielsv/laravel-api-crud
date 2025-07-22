<?php

namespace App\Services;

use App\Http\Resources\BandaResource;
use App\Models\Banda;
use Illuminate\Http\JsonResponse;

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

    public function update(array $data, int $id): JsonResponse
    {
        return BandaResource::make(tap(Banda::findOrFail($id), fn($b) => $b->fill($data)->save()))->response();
    }

    public function destroy(int $id): JsonResponse
    {
        Banda::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
