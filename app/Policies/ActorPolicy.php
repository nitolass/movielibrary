<?php

namespace App\Policies;

use App\Models\Actor;
use App\Models\User;

class ActorPolicy
{
    /**
     * El Admin tiene permiso total antes de comprobar nada más.
     */
    public function before(User $user, string $ability)
    {
        if ($user->role && $user->role->name === 'admin') {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): bool
    {
        // Todos los usuarios registrados pueden ver la lista
        return true;
    }

    public function view(User $user, Actor $actor): bool
    {
        // Todos pueden ver el detalle
        return true;
    }

    public function create(User $user): bool
    {
        // Admin ya pasó por 'before'.
        // Aquí comprobamos si es Editor.
        return $user->role->name === 'editor';
    }

    public function update(User $user, Actor $actor): bool
    {
        // El editor puede actualizar
        return $user->role->name === 'editor';
    }

    public function delete(User $user, Actor $actor): bool
    {
        // El editor NO puede borrar. El admin ya pasó por 'before'.
        // Por tanto, aquí devolvemos false.
        return false;
    }

    public function restore(User $user, Actor $actor): bool
    {
        return false;
    }

    public function forceDelete(User $user, Actor $actor): bool
    {
        return false;
    }
}
