<?php

namespace App\Policies;

use App\Models\Concierto;
use App\Models\User;

class ConciertoPolicy
{
    /**
     * Determine whether the user can view the list of their concerts.
     * La firma (User $user) sin '?' asegura que solo usuarios autenticados pueden pasar.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view a specific concert.
     * Solo permite la acción si el usuario es el propietario del concierto.
     */
    public function view(User $user, Concierto $concierto): bool
    {
        return $user->id === $concierto->user_id;
    }

    /**
     * Determine whether the user can create concerts.
     * Cualquier usuario autenticado puede crear.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the concert.
     * Solo permite la acción si el usuario es el propietario.
     */
    public function update(User $user, Concierto $concierto): bool
    {
        return $user->id === $concierto->user_id;
    }

    /**
     * Determine whether the user can delete the concert.
     * Solo permite la acción si el usuario es el propietario.
     */
    public function delete(User $user, Concierto $concierto): bool
    {
        return $user->id === $concierto->user_id;
    }
}
