<?php

namespace App\Livewire;

use App\Events\ActorCreated;
use App\Jobs\AuditLogJob;
use App\Models\Actor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ActorManager extends Component
{
    use WithPagination, WithFileUploads;

    // Campos del Formulario
    public $name, $biography, $birth_year, $nationality;
    public $photo; // Nueva foto
    public $existingPhoto; // Foto actual
    public $actorId;

    // UI Control
    public $isModalOpen = false;
    public $search = '';

    // Reglas
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'biography' => 'nullable|string',
            'birth_year' => 'nullable|integer|min:1800|max:' . (date('Y')),
            'nationality' => 'nullable|string|max:100',
            'photo' => 'nullable|image|max:2048', // 2MB Max
        ];
    }

    public function mount()
    {
        Gate::authorize('viewAny', Actor::class);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $actors = Actor::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.actor-manager', [
            'actors' => $actors
        ])->layout('layouts.panel');
    }

    // --- ACCIONES CRUD ---

    public function create()
    {
        Gate::authorize('create', Actor::class);
        $this->resetInputFields();
        $this->openModal();
    }

    public function store()
    {
        Gate::authorize('create', Actor::class);
        $validatedData = $this->validate();

        if ($this->photo) {
            $validatedData['photo'] = $this->photo->store('actors', 'public');
        }

        $actor = Actor::create($validatedData);

        // Eventos y Jobs
        ActorCreated::dispatch($actor);
        AuditLogJob::dispatch("ACTOR: Se ha creado el actor '{$actor->name}' por " . Auth::user()->email);

        session()->flash('message', 'Actor creado correctamente.');
        $this->closeModal();
    }

    public function edit($id)
    {
        $actor = Actor::findOrFail($id);
        Gate::authorize('update', $actor);

        $this->actorId = $id;
        $this->name = $actor->name;
        $this->biography = $actor->biography;
        $this->birth_year = $actor->birth_year;
        $this->nationality = $actor->nationality;
        $this->existingPhoto = $actor->photo;

        $this->openModal();
    }

    public function update()
    {
        $actor = Actor::findOrFail($this->actorId);
        Gate::authorize('update', $actor);

        $this->validate();

        $data = [
            'name' => $this->name,
            'biography' => $this->biography,
            'birth_year' => $this->birth_year,
            'nationality' => $this->nationality,
        ];

        if ($this->photo) {
            if ($actor->photo) {
                Storage::disk('public')->delete($actor->photo);
            }
            $data['photo'] = $this->photo->store('actors', 'public');
        }

        $actor->update($data);

        AuditLogJob::dispatch("ACTOR: Se ha actualizado el actor '{$actor->name}' por " . Auth::user()->email);

        session()->flash('message', 'Actor actualizado correctamente.');
        $this->closeModal();
    }

    public function delete($id)
    {
        $actor = Actor::findOrFail($id);
        Gate::authorize('delete', $actor);

        if ($actor->photo) {
            Storage::disk('public')->delete($actor->photo);
        }

        $name = $actor->name;
        $actor->delete();

        AuditLogJob::dispatch("ACTOR: Se ha eliminado el actor '$name' por " . Auth::user()->email);

        session()->flash('message', 'Actor eliminado correctamente.');
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
        $this->biography = '';
        $this->birth_year = '';
        $this->nationality = '';
        $this->photo = null;
        $this->existingPhoto = null;
        $this->actorId = null;
    }
}
