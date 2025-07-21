<?php

namespace App\Services;

use App\Http\Resources\ConciertoResource;
use App\Models\Concierto;
use Illuminate\Http\JsonResponse;

class ConciertoService
{
    public function index(): JsonResponse
    {
        return ConciertoResource::collection(Concierto::with('banda')->paginate(request('per_page', 6)))->response();
    }

    public function store(array $data): JsonResponse
    {
        return ConciertoResource::make(Concierto::create($data)->load('banda'))->response();
    }

    public function show(int $id): JsonResponse
    {
        return ConciertoResource::make(Concierto::with('banda')->findOrFail($id))->response();
    }

    public function update(array $data, int $id): JsonResponse
    {
        return ConciertoResource::make(tap(Concierto::with('banda')->findOrFail($id),
            fn($c) => $c->fill($data)->save())->fresh('banda'))->response();

        // OTRA FORMA DE HACERLO:
        // $concierto = Concierto::with('banda')->findOrFail($id);
        // $concierto->fill($data)->save();
        // $concierto->load('banda'); // Refresca relaciones
        // return ConciertoResource::make($concierto)->response();
    }

    public function destroy(int $id): JsonResponse
    {
        Concierto::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
