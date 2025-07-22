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
}
