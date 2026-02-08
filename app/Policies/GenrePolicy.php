<?php

namespace App\Policies;

use App\Models\Genre;
use App\Models\User;

class GenrePolicy
{
    public function viewAny(?User $user): bool
    {
        return true; // Público
    }

    public function view(?User $user, Genre $genre): bool
    {
        return true; // Público
    }

    public function create(User $user): bool
    {
        return $user->role->name === 'admin';
    }

    public function update(User $user, Genre $genre): bool
    {
        return $user->role->name === 'admin';
    }

    public function delete(User $user, Genre $genre): bool
    {
        return $user->role->name === 'admin';
    }
}
