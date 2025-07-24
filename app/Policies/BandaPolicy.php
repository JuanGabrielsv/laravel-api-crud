<?php

namespace App\Policies;

use App\Models\Banda;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BandaPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Banda $banda): bool
    {
        return $user->id === $banda->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Banda $banda): bool
    {
        return $user->id === $banda->user_id;
    }

    public function delete(User $user, Banda $banda): bool
    {
        return $user->id === $banda->user_id;
    }
}
