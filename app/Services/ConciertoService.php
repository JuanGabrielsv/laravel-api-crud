<?php

namespace App\Services;

use App\Models\Concierto;
use Exception;
use Illuminate\Support\Facades\Log;

class ConciertoService
{
    /**
     * Create a new class instance.
     */
    public function create(array $data): Concierto
    {
        try {
            return Concierto::create($data);
        } catch (Exception $e){
            Log::error('Error al crear concierto: '.$e->getMessage());
            throw $e;
        }
    }
}
