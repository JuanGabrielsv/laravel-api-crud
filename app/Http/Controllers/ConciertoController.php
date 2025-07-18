<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConciertoRequest;
use App\Http\Requests\UpdateConciertoRequest;
use App\Http\Requests\UpdatePartialConciertoRequest;
use App\Services\ConciertoService;
use Illuminate\Http\JsonResponse;

class ConciertoController extends Controller
{
    /**
     * @var ConciertoService
     */
    protected ConciertoService $conciertoService;

    /**
     * @param ConciertoService $conciertoService
     */
    public function __construct(ConciertoService $conciertoService)
    {
        $this->conciertoService = $conciertoService;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->conciertoService->index();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        return $this->conciertoService->show($id);
    }

    /**
     * @param StoreConciertoRequest $request
     * @return JsonResponse
     */
    public function store(StoreConciertoRequest $request): JsonResponse
    {
        return $this->conciertoService->create($request->validated());
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return $this->conciertoService->destroy($id);
    }

    /**
     * @param UpdateConciertoRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(UpdateConciertoRequest $request, $id): JsonResponse
    {
        return $this->conciertoService->update($id, $request->validated());
    }

    /**
     * @param UpdatePartialConciertoRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function updatePartial(UpdatePartialConciertoRequest $request, $id): JsonResponse
    {
        return $this->conciertoService->updatePartial($request->validated(), $id);
    }
}
