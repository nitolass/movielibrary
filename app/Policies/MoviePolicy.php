<?php

namespace App\Policies;

use App\Models\Movie;
use App\Models\User;

class MoviePolicy
{
    /**
     * Admin: Acceso total a todo antes de verificar nada más.
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
        // Todo el mundo (registrado) puede ver el catálogo
        return true;
    }

    public function view(?User $user, Movie $movie): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        // Admin ya pasó por 'before'.
        // Editor: SÍ puede crear.
        // Moderador/Usuario: NO.
        return $user->role && $user->role->name === 'editor';
    }

    public function update(User $user, Movie $movie): bool
    {
        // Admin ya pasó por 'before'.
        // Editor: SÍ puede editar.
        return $user->role && $user->role->name === 'editor';
    }

    public function delete(User $user, Movie $movie): bool
    {
        // Admin ya pasó por 'before'.
        // Editor: NO puede borrar.
        // Por tanto, devolvemos false para todos los demás.
        return false;
    }

    public function restore(User $user, Movie $movie): bool
    {
        return false;
    }

    public function forceDelete(User $user, Movie $movie): bool
    {
        return false;
    }
}
