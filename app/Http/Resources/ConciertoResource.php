<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConciertoResource extends JsonResource
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
            'titulo' => $this->titulo,
            'lugar' => $this->lugar,
            'fecha_concierto' => $this->fecha_concierto,
            'precio_entrada' => $this->precio_entrada,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'Banda_nombre' => $this->banda->nombre,

            //'banda' => new BandaResource($this->whenLoaded('banda')),
        ];
    }
}
