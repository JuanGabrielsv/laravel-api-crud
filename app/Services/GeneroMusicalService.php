<?php

namespace App\Services;

use App\Http\Requests\StoreGeneroMusicalRequest;
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
}
