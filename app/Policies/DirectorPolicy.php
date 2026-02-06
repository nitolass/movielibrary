<?php

namespace App\Policies;

use App\Models\Director;
use App\Models\User;

class DirectorPolicy
{
    public function before(User $user, string $ability)
    {
        if ($user->role && $user->role->name === 'admin') {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Director $director): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        // Solo Editor (Admin ya tiene permiso por before)
        return $user->role->name === 'editor';
    }

    public function update(User $user, Director $director): bool
    {
        return $user->role->name === 'editor';
    }

    public function delete(User $user, Director $director): bool
    {
        // Editor no puede borrar
        return false;
    }

    public function restore(User $user, Director $director): bool
    {
        return false;
    }

    public function forceDelete(User $user, Director $director): bool
    {
        return false;
    }
}
