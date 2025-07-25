<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BandaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'idioma' => $this->idioma,
            'generos_musicales' => $this->generos->pluck('nombre'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
