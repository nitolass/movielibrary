<?php

namespace App\Livewire;

use App\Events\DirectorCreated;
use App\Jobs\AuditLogJob;
use App\Models\Director;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class DirectorManager extends Component
{
    use WithPagination, WithFileUploads;

    // Campos del Formulario
    public $name, $biography, $birth_year, $nationality;
    public $photo; // Para la nueva foto subida
    public $existingPhoto; // Para mostrar la foto actual al editar
    public $directorId;

    // Control de UI
    public $isModalOpen = false;
    public $search = '';

    // Reglas de validación
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'biography' => 'nullable|string',
            'birth_year' => 'nullable|integer|min:1800|max:' . (date('Y')),
            'nationality' => 'nullable|string|max:100',
            'photo' => 'nullable|image|max:2048', // Máx 2MB
        ];
    }

    public function mount()
    {
        Gate::authorize('viewAny', Director::class);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $directors = Director::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.director-manager', [
            'directors' => $directors
        ])->layout('layouts.panel');
    }

    // --- ACCIONES CRUD ---

    public function create()
    {
        Gate::authorize('create', Director::class);
        $this->resetInputFields();
        $this->openModal();
    }

    public function store()
    {
        Gate::authorize('create', Director::class);

        $validatedData = $this->validate();

        // Gestionar subida de foto
        if ($this->photo) {
            $validatedData['photo'] = $this->photo->store('directors', 'public');
        }

        $director = Director::create($validatedData);

        // Eventos y Jobs
        DirectorCreated::dispatch($director);
        AuditLogJob::dispatch("DIRECTOR: Se ha creado el director '{$director->name}' por " . Auth::user()->email);

        session()->flash('message', 'Director creado correctamente.');
        $this->closeModal();
    }

    public function edit($id)
    {
        $director = Director::findOrFail($id);
        Gate::authorize('update', $director);

        $this->directorId = $id;
        $this->name = $director->name;
        // Ojo: En tu vista usabas 'bio' o 'biography', asegúrate de usar el campo correcto de la BD
        $this->biography = $director->biography ?? $director->bio;
        $this->birth_year = $director->birth_year;
        $this->nationality = $director->nationality;
        $this->existingPhoto = $director->photo;

        $this->openModal();
    }

    public function update()
    {
        $director = Director::findOrFail($this->directorId);
        Gate::authorize('update', $director);

        // Validación específica (la foto es opcional al editar)
        $rules = $this->rules();
        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'biography' => $this->biography, // Asegúrate que en tu BD se llame 'biography' o 'bio'
            'birth_year' => $this->birth_year,
            'nationality' => $this->nationality,
        ];

        // Si suben nueva foto, borramos la vieja y guardamos la nueva
        if ($this->photo) {
            if ($director->photo) {
                Storage::disk('public')->delete($director->photo);
            }
            $data['photo'] = $this->photo->store('directors', 'public');
        }

        $director->update($data);

        AuditLogJob::dispatch("DIRECTOR: Se ha actualizado el director '{$director->name}' por " . Auth::user()->email);

        session()->flash('message', 'Director actualizado correctamente.');
        $this->closeModal();
    }

    public function delete($id)
    {
        $director = Director::findOrFail($id);
        Gate::authorize('delete', $director);

        if ($director->photo) {
            Storage::disk('public')->delete($director->photo);
        }

        $name = $director->name;
        $director->delete();

        AuditLogJob::dispatch("DIRECTOR: Se ha eliminado el director '$name' por " . Auth::user()->email);

        session()->flash('message', 'Director eliminado correctamente.');
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
        $this->directorId = null;
    }
}
