<?php

namespace App\Services;

use App\Models\Banda;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class BandaService
{

    public function index(): JsonResponse
    {
        $bandas = Banda::paginate(10);
        if ($bandas->isEmpty()) {
            return response()->json([
                'mensaje' => 'No hay bandas'
            ]);
        }
        return response()->json($bandas);
    }

    public function store(array $data): Banda
    {
        return Banda::create($data);
    }
}
