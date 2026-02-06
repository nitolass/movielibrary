<?php

namespace App\Policies;

use App\Models\Genre;
use App\Models\User;

class GenrePolicy
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

    public function view(User $user, Genre $genre): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->role->name === 'editor';
    }

    public function update(User $user, Genre $genre): bool
    {
        return $user->role->name === 'editor';
    }

    public function delete(User $user, Genre $genre): bool
    {
        return false;
    }

    public function restore(User $user, Genre $genre): bool
    {
        return false;
    }

    public function forceDelete(User $user, Genre $genre): bool
    {
        return false;
    }
}
