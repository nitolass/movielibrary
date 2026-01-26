<?php

namespace App\Policies;

use App\Models\Movie;
use App\Models\User;

class MoviePolicy
{
    // este metodo esta para que compruebe de primeras que seamos admin,
    // si es admin le damos permiso a todo, si fuese false
    // la policy sigue comprobando
    public function before(User $user, string $ability)
    {
        if ($user->role && $user->role->name === 'admin') {
            return true;
        }

        if ($user->email === 'juan@admin.es') {
            return true;
        }

        return null;
    }


    public function viewAny(User $user): bool
    {
        // Cualquier usuario puede ver el catalogo.
        // Devolvemos true.
        return true;
    }


    public function view(?User $user, Movie $movie): bool
    {
        return true;
    }


    public function create(User $user): bool
    {
        // Aqui el usuario normal, por ejemplo pepe no puede crear pelis
        // por eso devolvemos false, para que no se cumpla.
        return false;
    }


    public function update(User $user, Movie $movie): bool
    {
        // Esto el usuario normal igual que con la creacion de pelis
        return false;
    }

    /**
     * ¿Puede borrar una película?
     */
    public function delete(User $user, Movie $movie): bool
    {
        // Igual que con create y update.
        return false;
    }


    public function restore(User $user, Movie $movie): bool
    {
        // Esto es para restaurar una pelicula,
        // y un usuario normal no puede hacer esto.
        return false;
    }


    public function forceDelete(User $user, Movie $movie): bool
    {
        // Borrar permanente es otra cosa que un usuario normal
        // no puede hacer. En cambio todos estos metodos se pondrian en true
        // si en la comprobacion del principio se devolviera y estuviesemos
        // lidiando con un administrador
        return false;
    }
}
