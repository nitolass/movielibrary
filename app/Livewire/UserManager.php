<?php

namespace App\Livewire;

use App\Events\UserCreated;
use App\Jobs\AuditLogJob;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class UserManager extends Component
{
    use WithPagination;

    // Campos del Formulario
    public $name, $surname, $email, $role_id, $password, $password_confirmation;
    public $verified = false; // Checkbox para verificar email automáticamente
    public $userId;

    // Control de UI
    public $isModalOpen = false;
    public $search = '';

    protected function rules()
    {
        // Reglas dinámicas según si es crear o editar
        $passwordRule = $this->userId ? 'nullable|confirmed|min:8' : 'required|confirmed|min:8';

        return [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'role_id' => 'required|exists:roles,id',
            'password' => $passwordRule,
            'verified' => 'boolean'
        ];
    }

    public function mount()
    {
        Gate::authorize('viewAny', User::class);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::with('role')
            ->where(function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        $roles = Role::all();

        return view('livewire.user-manager', [
            'users' => $users,
            'roles' => $roles
        ])->layout('layouts.panel');
    }

    // --- ACCIONES ---

    public function create()
    {
        Gate::authorize('create', User::class);
        $this->resetInputFields();
        $this->openModal();
    }

    public function store()
    {
        Gate::authorize('create', User::class);
        $this->validate();

        $data = [
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'role_id' => $this->role_id,
            'password' => Hash::make($this->password),
        ];

        // Uso del Checkbox: Si está marcado, verificamos el email ya
        if ($this->verified) {
            $data['email_verified_at'] = now();
        }

        $user = User::create($data);

        AuditLogJob::dispatch("USUARIOS: Admin " . Auth::user()->email . " creó al usuario '{$user->email}'");
        UserCreated::dispatch($user);

        session()->flash('message', 'Usuario creado correctamente.');
        $this->closeModal();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        // Gate::authorize('update', $user); // Descomenta si tienes policy de update

        $this->userId = $id;
        $this->name = $user->name;
        $this->surname = $user->surname;
        $this->email = $user->email;
        $this->role_id = $user->role_id;
        $this->verified = $user->email_verified_at !== null;

        $this->openModal();
    }

    public function update()
    {
        $user = User::findOrFail($this->userId);
        // Gate::authorize('update', $user);

        $this->validate();

        $data = [
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'role_id' => $this->role_id,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->verified && !$user->email_verified_at) {
            $data['email_verified_at'] = now();
        } elseif (!$this->verified) {
            $data['email_verified_at'] = null;
        }

        $user->update($data);

        AuditLogJob::dispatch("USUARIOS: Admin " . Auth::user()->email . " editó al usuario '{$user->email}'");

        session()->flash('message', 'Usuario actualizado correctamente.');
        $this->closeModal();
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        // Gate::authorize('delete', $user);

        $email = $user->email;
        $user->delete();

        AuditLogJob::dispatch("USUARIOS: Admin " . Auth::user()->email . " eliminó al usuario '$email'");
        session()->flash('message', 'Usuario eliminado.');
    }

    // --- HELPERS ---

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputFields();
        $this->resetValidation();
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->surname = '';
        $this->email = '';
        $this->role_id = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->verified = false;
        $this->userId = null;
    }
}
