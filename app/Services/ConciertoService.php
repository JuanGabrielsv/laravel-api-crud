<?php

namespace App\Services;

use App\Http\Resources\ConciertoResource;
use App\Models\Concierto;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ConciertoService
{
    /**
     * Obtiene los conciertos paginados para un usuario específico.
     */
    public function getConciertosForUser(User $user): LengthAwarePaginator
    {
        return $user->conciertos()
            ->with('banda')
            ->paginate(request('per_page', 6));
    }

    /**
     * Crea un nuevo concierto para un usuario específico.
     */
    public function createForUser(User $user, array $data): Concierto
    {
        $concierto = $user->conciertos()->create($data);

        return $concierto->load('banda');
    }

    /**
     * Actualiza un concierto existente que ya ha sido verificado por la Policy.
     */
    public function update(Concierto $concierto, array $data): Concierto
    {
        $concierto->fill($data)->save();

        return $concierto->fresh('banda');
    }

    /**
     * Borra un concierto existente que ya ha sido verificado por la Policy.
     */
    public function delete(Concierto $concierto): void
    {
        $concierto->delete();
    }
}
