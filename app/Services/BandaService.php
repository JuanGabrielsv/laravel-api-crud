<?php

namespace App\Services;

use App\Models\Banda;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class BandaService
{
    /**
     * Obtiene las bandas paginadas para un usuario específico.
     */
    public function getBandasForUser(User $user): LengthAwarePaginator
    {
        // Usamos la relación para obtener solo las bandas del usuario, con sus géneros.
        return $user->bandas()
            ->with('generos')
            ->paginate(request('per_page', 6));
    }

    /**
     * Crea una nueva banda para un usuario y sincroniza sus géneros musicales.
     */
    public function createForUser(User $user, array $data): Banda
    {
        // Mantenemos tu lógica para separar los géneros.
        $generos = $data['generos_musicales'] ?? [];
        unset($data['generos_musicales']);

        // Creamos la banda a través de la relación para asignar el user_id automáticamente.
        $banda = $user->bandas()->create($data);

        // Sincronizamos los géneros.
        $banda->generos()->sync($generos);

        // Devolvemos el modelo con la relación cargada.
        return $banda->load('generos');
    }

    /**
     * Actualiza una banda existente y sincroniza sus géneros.
     */
    public function update(Banda $banda, array $data): Banda
    {
        $generos = $data['generos_musicales'] ?? [];
        unset($data['generos_musicales']);

        // Actualizamos los datos principales de la banda.
        $banda->fill($data)->save();

        // Sincronizamos los géneros.
        $banda->generos()->sync($generos);

        // Devolvemos el modelo actualizado con sus relaciones.
        return $banda->fresh('generos');
    }

    /**
     * Borra una banda existente.
     */
    public function delete(Banda $banda): void
    {
        // Antes de borrar la banda, es buena práctica desvincular las relaciones
        // de la tabla pivote para mantener la base de datos limpia.
        $banda->generos()->detach();
        $banda->delete();
    }
}
