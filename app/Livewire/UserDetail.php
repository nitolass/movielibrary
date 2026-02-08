<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class UserDetail extends Component
{
    public User $user;

    public function mount(User $user)
    {
        Gate::authorize('view', $user);
        $this->user = $user->load('watchLater');
    }

    public function render()
    {
        return view('livewire.user-detail')->layout('layouts.panel');
    }
}
