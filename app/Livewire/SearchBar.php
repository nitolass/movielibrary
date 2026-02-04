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

        // Solo buscamos si hay 2 o más letras escritas
        if (strlen($this->search) >= 2) {
            $results = Movie::select('id', 'title', 'poster', 'year')
                ->where('title', 'like', '%' . $this->search . '%')
                ->take(5) // Limitamos a 5 resultados para no llenar la pantalla
                ->get();
        }

        return view('livewire.search-bar', [
            'results' => $results
        ]);
    }
}
