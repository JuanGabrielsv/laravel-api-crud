<?php

namespace App\Services;

use App\Models\Concierto;
use Exception;
use Illuminate\Support\Facades\Log;

class ConciertoService
{
    /**
     * Create a new class instance.
     * @throws Exception
     */
    public function create(array $data)
    {
        try {
            return Concierto::create($data);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Error al crear concierto',
                'error' => $e->getMessage()], 500);
        }
    }
}
