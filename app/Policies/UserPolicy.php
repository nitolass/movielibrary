<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Admin: Acceso total.
     */
    public function before(User $user, string $ability)
    {
        if ($user->role && $user->role->name === 'admin') {
            if ($ability === 'delete') {
                return null;
            }

            return true;
        }


        return null;
    }



    public function viewAny(User $user): bool
    {
        // Listado de usuarios: Solo Admin.
        // Editor/Moderador: False (retorna false por defecto si no es admin)
        return false;
    }

    public function view(User $user, User $model): bool
    {
        // Un usuario (sea editor, moderador o normal) solo puede ver SU perfil
        return $user->id === $model->id;
    }

    public function create(User $user): bool
    {
        // Solo Admin puede crear usuarios manualmente desde panel
        return false;
    }

    public function update(User $user, User $model): bool
    {
        // Un usuario solo puede editar SU perfil
        return $user->id === $model->id;
    }

    public function delete(User $user, User $model): bool
    {
        // Un usuario solo puede borrar SU cuenta
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
