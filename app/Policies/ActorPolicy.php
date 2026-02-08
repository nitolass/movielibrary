<?php

namespace App\Policies;

use App\Models\Actor;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ActorPolicy
{
    // ?User significa que el usuario puede ser NULL (invitado)
    public function viewAny(?User $user): bool
    {
        return true; // Todo el mundo puede ver la lista
    }

    public function view(?User $user, Actor $actor): bool
    {
        return true; // Todo el mundo puede ver un actor
    }

    public function create(User $user): bool
    {
        // Solo Admin o Editor (ajusta tu lógica aquí)
        return $user->role->name === 'admin' || $user->role->name === 'editor';
    }

    public function update(User $user, Actor $actor): bool
    {
        return $user->role->name === 'admin' || $user->role->name === 'editor';
    }

    public function delete(User $user, Actor $actor): bool
    {
        return $user->role->name === 'admin';
    }
}
