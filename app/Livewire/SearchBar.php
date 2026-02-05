<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Movie;

class SearchBar extends Component
{
    public $search = '';

    public function render()
    {
        $results = [];

        // Solo buscamos si escribe 2 o más letras
        if (strlen($this->search) >= 2) {

            // Usamos el Scope Search del modelo
            // Guardamos en $results (antes lo guardabas en $movies y por eso no salía)
            $results = Movie::search($this->search)
                ->with('director') // Optimización: carga el director de una vez
                ->take(5)
                ->get();
        }

        return view('livewire.search-bar', [
            'results' => $results
        ]);
    }
}
