<?php

namespace App\Livewire;

use App\Events\GenreCreated;
use App\Jobs\AuditLogJob;
use App\Models\Genre;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class GenreManager extends Component
{
    use WithPagination;

    // Variables del Formulario
    public $name;
    public $description;
    public $genreId; // Para saber si estamos editando

    // Control de UI
    public $isModalOpen = false;
    public $search = '';

    // Reglas de validación (Dinámicas para el unique)
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:genres,name,' . $this->genreId,
            'description' => 'nullable|string|max:1000',
        ];
    }

    // Se ejecuta al cargar el componente
    public function mount()
    {
        Gate::authorize('viewAny', Genre::class);
    }

    // Resetear paginación si se busca algo
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $genres = Genre::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.genre-manager', [
            'genres' => $genres
        ])->layout('layouts.panel');
    }

    // --- ACCIONES DEL CRUD ---

    public function create()
    {
        Gate::authorize('create', Genre::class);
        $this->resetInputFields();
        $this->openModal();
    }

    public function store()
    {
        Gate::authorize('create', Genre::class);

        $validatedData = $this->validate();

        $genre = Genre::create($validatedData);

        // Lógica de Negocio Original
        Artisan::call('movies:stats');
        GenreCreated::dispatch($genre);
        AuditLogJob::dispatch("GÉNERO: El usuario " . Auth::user()->email . " creó el género '{$genre->name}'");

        session()->flash('message', 'Género creado correctamente.');
        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {

        $genre = Genre::findOrFail($id);

        // Verificamos permiso sobre el objeto específico
        Gate::authorize('update', $genre);

        $this->genreId = $id;
        $this->name = $genre->name;
        $this->description = $genre->description;

        $this->openModal();
    }

    public function update()
    {
        $validatedData = $this->validate();

        $genre = Genre::findOrFail($this->genreId);
        Gate::authorize('update', $genre);

        $genre->update($validatedData);

        // Lógica de Negocio
        AuditLogJob::dispatch("GÉNERO: El usuario " . Auth::user()->email . " actualizó el género '{$genre->name}'");

        session()->flash('message', 'Género actualizado correctamente.');
        $this->closeModal();
        $this->resetInputFields();
    }

    public function delete($id)
    {
        $genre = Genre::findOrFail($id);
        Gate::authorize('delete', $genre);

        $name = $genre->name;
        $genre->delete();

        AuditLogJob::dispatch("GÉNERO: El usuario " . Auth::user()->email . " eliminó el género '$name'");

        session()->flash('message', 'Género eliminado correctamente.');
    }

    // --- FUNCIONES AUXILIARES ---

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
        $this->description = '';
        $this->genreId = null;
    }
}
