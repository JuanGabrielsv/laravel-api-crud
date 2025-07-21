<?php

namespace App\Services;

use App\Http\Resources\ConciertoResource;
use App\Models\Concierto;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

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

    public function destroy($id): JsonResponse
    {
        try {
            $conciertoBorrar = Concierto::find($id);
            if (!$conciertoBorrar) {
                return response()->json(['mensaje' => 'No hay concierto con el id ' . $id]);
            }
            Concierto::destroy($id);
            return response()->json(['mensaje' => 'Concierto eliminado correctamente']);
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return response()->json(['mensaje' => 'Ha ocurrido un error con la base de datos, inténtelo más tarde.']);
        }
    }
}
