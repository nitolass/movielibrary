<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * El método 'before' se ejecuta antes que cualquier otro.
     * Si devuelve true, se permite la acción sin mirar más.
     */
    public function before(User $user, string $ability)
    {
        // CORREGIDO: Verificamos el ROL, no un email específico.
        // Así el test pasará porque crea un user con role 'admin'.
        if ($user->role->name === 'admin') {
            return true;
        }
    }

    public function viewAny(User $user): bool
    {
        // Si no es admin (pasó el before), es false.
        return false;
    }

    public function view(User $user, User $model): bool
    {
        // Un usuario puede ver su propio perfil
        return $user->id === $model->id;
    }

    public function create(User $user): bool
    {
        // Solo admins (gestionado por before)
        return false;
    }

    public function update(User $user, User $model): bool
    {
        // Un usuario puede editar su propio perfil
        return $user->id === $model->id;
    }

    public function delete(User $user, User $model): bool
    {
        // Un usuario puede borrar su propia cuenta
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
