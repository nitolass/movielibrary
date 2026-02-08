<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Admin: Acceso total (God Mode).
     * Se ejecuta antes que cualquier otra validación.
     */
    public function before(User $user, string $ability)
    {
        if ($user->role && $user->role->name === 'admin') {
            return true;
        }

        return null; // Si no es admin, continúa abajo
    }

    public function viewAny(User $user): bool
    {
        // El test dice "regular user CANNOT manage users" -> viewAny debe ser False
        return false;
    }

    public function view(User $user, User $model): bool
    {
        // Un usuario puede ver su propio perfil
        return $user->id === $model->id;
    }

    public function create(User $user): bool
    {
        // Un usuario normal no puede crear otros usuarios
        return false;
    }

    public function update(User $user, User $model): bool
    {
        // Un usuario puede editar su propio perfil
        return $user->id === $model->id;
    }

    public function delete(User $user, User $model): bool
    {
        // Un usuario podría borrar su propia cuenta (si tu lógica de negocio lo permite)
        // Pero NO puede borrar la de otros ($targetUser), así que el test passará
        return $user->id === $model->id;
    }

    public function restore(User $user, User $model): bool
    {
        return false;
    }

    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
