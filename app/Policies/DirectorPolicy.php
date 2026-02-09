<?php

namespace App\Policies;

use App\Models\Director;
use App\Models\User;

class DirectorPolicy
{
    // ?User permite invitados (null)
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Director $director): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->role->name === 'admin';
    }

    public function update(User $user, Director $director): bool
    {
        return $user->role->name === 'admin';
    }

    public function delete(User $user, Director $director): bool
    {
        return $user->role->name === 'admin';
    }
}
