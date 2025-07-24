<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConciertoRequest;
use App\Http\Requests\UpdateConciertoRequest;
use App\Http\Resources\ConciertoResource;
use App\Models\Concierto;
use App\Services\ConciertoService;
use Illuminate\Http\JsonResponse;

class ConciertoController extends Controller
{
    public function __construct(protected ConciertoService $conciertoService)
    {
    }

    /**
     * Muestra la lista de conciertos CREADOS POR EL USUARIO AUTENTICADO.
     */
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Concierto::class);

        $conciertos = $this->conciertoService->getConciertosForUser(auth()->user());

        return ConciertoResource::collection($conciertos)->response();
    }

    /**
     * Guarda un nuevo concierto en la base de datos.
     */
    public function store(StoreConciertoRequest $request): JsonResponse
    {
        $this->authorize('create', Concierto::class);

        $concierto = $this->conciertoService->createForUser(auth()->user(), $request->validated());

        return (new ConciertoResource($concierto))->response()->setStatusCode(201);
    }

    /**
     * Muestra un concierto específico, si el usuario tiene permiso.
     */
    public function show(Concierto $concierto): JsonResponse
    {
        $this->authorize('view', $concierto);

        return (new ConciertoResource($concierto))->response();
    }

    /**
     * Actualiza un concierto específico, si el usuario tiene permiso.
     */
    public function update(UpdateConciertoRequest $request, Concierto $concierto): JsonResponse
    {
        $this->authorize('update', $concierto);

        $conciertoActualizado = $this->conciertoService->update($concierto, $request->validated());

        return (new ConciertoResource($conciertoActualizado))->response();
    }

    /**
     * Borra un concierto específico, si el usuario tiene permiso.
     */
    public function destroy(Concierto $concierto): JsonResponse
    {
        $this->authorize('delete', $concierto);

        $this->conciertoService->delete($concierto);

        return response()->json(null, 204);
    }
}
